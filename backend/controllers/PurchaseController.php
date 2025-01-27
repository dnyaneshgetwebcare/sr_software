<?php

namespace backend\controllers;

use Yii;
use backend\models\PurchaseHeader;
use backend\models\VendorMaster;
use backend\models\PurchaseItem;
use backend\models\DynamicFormsBookingItems;
use backend\models\PurchaseHeaderSearch;
use backend\models\PurchaseItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\CategoryMaster;
use backend\models\TypeMaster;
use backend\models\BookingSummary;
use backend\models\ItemMaster;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * PurchaseController implements the CRUD actions for PurchaseHeader model.
 */
class PurchaseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PurchaseHeader models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseHeaderSearch();
        $searchModel->status='0';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionItemsReport()
    {
        $searchModel = new PurchaseItemSearch();
   $type_master = ArrayHelper::map(TypeMaster::find()->all(),'id','name');
        $model_category = ArrayHelper::map(CategoryMaster::find()->all(),'id','name');
        $dataProvider = $searchModel->searchReport(Yii::$app->request->queryParams);

        return $this->render('index_item', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type_master'=>$type_master,
            'model_category'=>$model_category,
        ]);
    }

    /**
     * Displays a single PurchaseHeader model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
  public function actionVendorDetails($id){
        if(isset($_GET['id'])) {
            $id=$_GET['id'];
            $customer_data = VendorMaster::find()->where([ 'id'=>$_GET['id']])->asArray()->one();
            echo json_encode($customer_data);
        }
    }
    /**
     * Creates a new PurchaseHeader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PurchaseHeader();
        $vendor_model = new VendorMaster();
        $purchase_items=[new PurchaseItem()];
        //$model_category = ArrayHelper::map(CategoryMaster::find()->all(),'id','name');
       // $model_type= ArrayHelper::map(TypeMaster::find()->all(),'id','name');
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $vendor_model->load(Yii::$app->request->post()); 
            $purchase_items = DynamicFormsBookingItems::createMultiple(PurchaseItem::classname());
            DynamicFormsBookingItems::loadMultiple($purchase_items, Yii::$app->request->post());
                  array_shift($purchase_items);
            $result= ActiveForm::validate($model);
            $result_vendor= ActiveForm::validate($vendor_model);
            $result_item=ActiveForm::validateMultiple($purchase_items);
            $all_validate=array_merge($result,$result_item, $result_vendor);
           // return $this->redirect(['view', 'id' => $model->id]);
             if($all_validate!=null){
            //echo "<pre>";print_r( array('errors'=>$all_validate));die;
                return array('errors'=>$all_validate);
           }else{
             $flag=true;
            $transaction = Yii::$app->db->beginTransaction();
            $vendor_model=$this->VendorSave($vendor_model);
             if(!$flag=$vendor_model->save()){
                $transaction->rollBack();
                return array('errors'=>$vendor_model->errors);
            }
            $model->purchase_date=$this->dateFormat($model->purchase_date);
             $model->vendor_id=$vendor_model->id;
             $path=realpath(dirname(__FILE__).'/../../purchase');
            $rand_no = rand(1000, 9999);
              if(file_exists($path."\\".$rand_no)){
                $rand_no = rand(1000, 9999);
               }
                 if(is_array($_FILES)) {
                   
                    if(is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
                   $id = substr($_FILES['fileToUpload']['name'], strrpos($_FILES['fileToUpload']['name'], '.') + 1);
                   $sourcePath = $_FILES['fileToUpload']['tmp_name'];

                   $targetPath = $path."/".$rand_no.'.'.$id;
                   
                   if(move_uploaded_file($sourcePath, $targetPath)) {

                    $model->image= $rand_no.'.'.$id;
                    
                    }
                  }
                  //=$targetPath;
                 }
           if(!$flag=$model->save()){
                $transaction->rollBack();
                return array('errors'=>$model->errors);
            }
//print_r($model);die;
         if($flag){
            //$item_no=10;
            foreach ($purchase_items as $key => $purchase_item) {

                $purchase_item->purhcase_id=$model->id;
               // $purchase_item->item_no=$item_no;
                if(!$flag=$purchase_item->save()){
                    return array('errors'=>$purchase_item->errors);
                }
                $item_maste= ItemMaster::find()->where(['id'=>$purchase_item->item_code])->one();
                $item_maste->purchase_date=$model->purchase_date;
                $item_maste->purchase_amount=$purchase_item->net_value;
                $item_maste->purchase_id=$purchase_item->purhcase_id;
               if(!$flag=$item_maste->save()){
                    return array('errors'=>$item_maste->errors);
                }
              //  $item_no+=10;
            }
        }
           if($flag){
                   $time=strtotime($model->purchase_date);
                   $month=date("m",$time);
                   $year=date("Y",$time);
                    $update_summary=$this->updateSummary($month,$year);
                 $transaction->commit();
                 Yii::$app->session->setFlash('success', "Your message to display.");
               }else{
                 $transaction->rollBack();
                 Yii::$app->session->setFlash('error', "faild to save.");
               }
                return $this->redirect(['update','id'=> $model->id]);
           }

        }

        return $this->render('create', [
            'model' => $model,
            'vendor_model' => $vendor_model,
            'purchase_items' => $purchase_items,
            //'model_category'=>$model_category,
            //'model_category'=>$model_type,
        ]);
    }
 public function dateFormat($request_date){
         return ($request_date!='')?date('Y-m-d',strtotime($request_date)):'';
    }
    public function actionItemDetailsAutocomplete(){

            $id=$_GET['id'];
           // $type=$_GET['type'];

            Yii::$app->response->format = Response::FORMAT_JSON;
            $item_details = ItemMaster::find()->select(['id','name','details','purchase_amount','type_id','category_id','images'])->where(['purchase_id'=>null])->andWhere(['or',['like', 'id', $_GET['term']],['like', 'name',  $_GET['term']]])->asArray()->limit(25)->all();


            $return_array = array();
            $return_array['id_pass']=$id;
         //   $return_array['type']=$type;
            $return_array['item_details']=$item_details;

            return $return_array;

    }
        public function actionItemDetailsPurchase(){

            $id=$_GET['id'];
           // $type=$_GET['type'];

            Yii::$app->response->format = Response::FORMAT_JSON;
            $item_details = ItemMaster::find()->select(['id','name','details','purchase_amount','type_id','category_id','images'])->andWhere(['or',['like', 'id', $_GET['term']],['like', 'name',  $_GET['term']]])->asArray()->limit(25)->all();


            $return_array = array();
            $return_array['id_pass']=$id;
         //   $return_array['type']=$type;
            $return_array['item_details']=$item_details;

            return $return_array;

    }
public function updateSummary($month,$year)
     {
        //echo $month;die;
         $purchase_header=PurchaseHeader::find()->select(['sum(purchase_amount) as total_purchase'])->where(['status'=>0])->andWhere('DATE_FORMAT(purchase_date, "%m-%Y") = "'.$month.'-'.$year.'"')->groupBy(["DATE_FORMAT(purchase_date,'%m-%Y')"])->createCommand()->queryOne();
       //  $purchase_header_sub=PurchaseHeader::find()->select('id')->where(['status'=>0])->andWhere('DATE_FORMAT(purchase_date, "%m-%Y") = "'.$month.'-'.$year.'"');
       //  $purchase_header=PurchaseItem::find()->select(['count(*) as number_purchase'])->where(['purhcase_id'=>$purchase_header_sub])->groupBy(["DATE_FORMAT(purchase_date,'%m-%Y')"])->createCommand()->queryOne();

         $booking_summary=BookingSummary::find()->where(['month'=>$month,'year'=>$year])->one();
         if($booking_summary!=""){
            $booking_summary->total_purchase=$purchase_header['total_purchase'];
           // $booking_summary->number_purchase=$purchase_header['number_purchase'];
            // $booking_summary->pending_amount=($purchase_header['total_pending'])*-1;
         }else{
            $booking_summary=new  BookingSummary();
             $booking_summary->total_purchase=$purchase_header['total_purchase'];
           //  $booking_summary->number_purchase=$purchase_header['number_purchase'];
            // $booking_summary->pending_amount=($purchase_header['total_pending'])*-1;
              $booking_summary->month=$month;
             $booking_summary->year=$year;
         }
         $flag=$booking_summary->save();
         return array('errors'=>$booking_summary->errors,'flag'=>$flag);
     }


    public function VendorSave($vendor='')
    {
        $vendor_old=null;
       if($vendor->id!=''){
        $vendor_old=VendorMaster::find()->where(['id'=>$vendor->id])->one();
        
       }else if($vendor->contact_nos!=''){
        $vendor_old=VendorMaster::find()->where(['contact_nos'=>$vendor->contact_nos])->one();
        }
        if($vendor_old==null){
         // $vendor->created_on=$this->dateFormat($created_on);
            return $vendor;
        }
       // $vendor_old->reference=$vendor_old->reference;
        $vendor_old->email_id=$vendor->email_id;
        $vendor_old->contact_nos=$vendor->contact_nos;
        $vendor_old->group_id=$vendor->group_id;
        $vendor_old->address=$vendor->address;
        $vendor_old->name=$vendor->name;
        return $vendor_old;
    }

  public function actionVendorAutocomplete(){
        if(isset($_GET['term'])){
            $id=$_GET['id'];
            $vendor_data = VendorMaster::find()->select(['id','name','contact_nos','email_id','group_id','address'])->where(['like', 'id', $_GET['term']])->orWhere(['like', 'name',  $_GET['term']])->orWhere(['like', 'contact_nos',  $_GET['term']])->asArray()->limit(25)->all();
            $return_array = array();
            $return_array['id_pass']=$id;
            $return_array['vendor_data']=$vendor_data;
            echo json_encode($return_array);
        }
    }
    /**
     * Updates an existing PurchaseHeader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $vendor_model = $model->vendor;
        $purchase_items=$model->purchaseItems;
        if ($model->load(Yii::$app->request->post())) {
           Yii::$app->response->format = Response::FORMAT_JSON;
            $vendor_model->load(Yii::$app->request->post()); 
             $oldIDs = ArrayHelper::map($purchase_items, 'item_no', 'item_no');
            $purchase_items = DynamicFormsBookingItems::createMultiple(PurchaseItem::classname());
            DynamicFormsBookingItems::loadMultiple($purchase_items, Yii::$app->request->post());
                  array_shift($purchase_items);

             $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($purchase_items, 'item_no', 'item_no')));
            $result= ActiveForm::validate($model);
            $result_vendor= ActiveForm::validate($vendor_model);
            $result_item=ActiveForm::validateMultiple($purchase_items);
            $all_validate=array_merge($result,$result_item, $result_vendor);
           // return $this->redirect(['view', 'id' => $model->id]);
             if($all_validate!=null){
            //echo "<pre>";print_r( array('errors'=>$all_validate));die;
                return array('errors'=>$all_validate);
           }else{
             $flag=true;
            $transaction = Yii::$app->db->beginTransaction();
            $vendor_model=$this->VendorSave($vendor_model);
             if(!$flag=$vendor_model->save()){
                $transaction->rollBack();
                return array('errors'=>$vendor_model->errors);
            }
            $model->purchase_date=$this->dateFormat($model->purchase_date);
             

             $path=realpath(dirname(__FILE__).'/../../purchase');
            $rand_no = rand(1000, 9999);
              if(file_exists($path."\\".$rand_no)){
                $rand_no = rand(1000, 9999);
               }
                 if(is_array($_FILES)) {
                   
                    if(is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
                   $id = substr($_FILES['fileToUpload']['name'], strrpos($_FILES['fileToUpload']['name'], '.') + 1);
                   $sourcePath = $_FILES['fileToUpload']['tmp_name'];

                   $targetPath = $path."/".$rand_no.'.'.$id;
                   
                   if(move_uploaded_file($sourcePath, $targetPath)) {

                    $model->image= $rand_no.'.'.$id;
                    
                    }
                  }
                  //=$targetPath;
                 }
           if(!$flag=$model->save()){
                $transaction->rollBack();
                return array('errors'=>$model->errors);
            }
//print_r($model);die;
         if($flag){
             if (! empty($deletedIDs)) {
       // $this->unbookingSummary($deletedIDs);
          PurchaseItem::deleteAll(['item_no' => $deletedIDs]);
        }
            //$item_no=10;
        ItemMaster::updateAll([
                    'purchase_date' =>null,
                    'purchase_amount' => 0,
                    'purchase_id' => null,
                ],[
                'purchase_id'=>$model->id]);
            foreach ($purchase_items as $key => $purchase_item) {
                if($purchase_item->item_no==""){
                $purchase_item->purhcase_id=$model->id;
               // $purchase_item->item_no=$item_no;
                if(!$flag=$purchase_item->save()){
                    return array('errors'=>$purchase_item->errors);
                }
               
            }else{

                PurchaseItem::updateAll([
                    //'item_no' => 
                    //'image' => 
                    'purhcase_id' =>$model->id,
                    'item_code' => $purchase_item->item_code,
                    'net_value' => $purchase_item->net_value,
                    'item_type' => $purchase_item->item_type,
                    'item_category'=>$purchase_item->item_category,
                    
                ],[
                'item_no'=>$purchase_item->item_no]);
              
            }
             $item_maste= ItemMaster::find()->where(['id'=>$purchase_item->item_code])->one();
                $item_maste->purchase_date=$model->purchase_date;
                $item_maste->purchase_amount=$purchase_item->net_value;
                $item_maste->purchase_id=$purchase_item->purhcase_id;
               if(!$flag=$item_maste->save()){
                    return array('errors'=>$item_maste->errors);
                }
            }
        }
           if($flag){
             $time=strtotime($model->purchase_date);
                   $month=date("m",$time);
                   $year=date("Y",$time);
                    $update_summary=$this->updateSummary($month,$year);
                 $transaction->commit();
                 Yii::$app->session->setFlash('success', "Your message to display.");
               }else{
                 $transaction->rollBack();
                 Yii::$app->session->setFlash('error', "faild to save.");
               }
                return $this->redirect(['update','id'=> $model->id]);
           }
        }

        return $this->render('update', [
            'model' => $model,
            'vendor_model' => $vendor_model,
            'purchase_items' => $purchase_items,
        ]);
    }
    /**
     * Deletes an existing PurchaseHeader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       $model= $this->findModel($id);
       $model->status =1;
       $model->save();
       ItemMaster::updateAll([
                    'purchase_date' =>null,
                    'purchase_amount' => 0,
                    'purchase_id' => null,
                ],[
                'purchase_id'=>$model->id]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the PurchaseHeader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurchaseHeader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurchaseHeader::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
