<?php

namespace backend\controllers;

use Yii;
use backend\models\ExpenseHeader;
use backend\models\ExpenseItem;
use backend\models\VendorMaster;
use backend\models\BookingSummary;
use backend\models\ExpsenseCategory;
use backend\models\DynamicFormsBookingItems;

use backend\models\ExpenseHeaderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * ExpenseController implements the CRUD actions for ExpenseHeader model.
 */
class ExpenseController extends Controller
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
     * Lists all ExpenseHeader models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExpenseHeaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ExpenseHeader model.
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

    /**
     * Creates a new ExpenseHeader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExpenseHeader();
        $expense_items = [new ExpenseItem()];
        $expense_category = ArrayHelper::map(ExpsenseCategory::find()->where(['items_status'=>1])->all(),'id','name');
        $vendor_model= new VendorMaster();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
             $vendor_model->load(Yii::$app->request->post()); 
             $expense_items = DynamicFormsBookingItems::createMultiple(ExpenseItem::classname());
            DynamicFormsBookingItems::loadMultiple($expense_items, Yii::$app->request->post());
                  array_shift($expense_items);
            $result= ActiveForm::validate($model);
            $result_vendor= ActiveForm::validate($vendor_model);
            $result_item=ActiveForm::validateMultiple($expense_items);
            $all_validate=array_merge($result,$result_item, $result_vendor);
           // return $this->redirect(['view', 'id' => $model->id]);
             if($all_validate!=null){
                return array('errors'=>$all_validate);
             }else{
                 $flag=true;
            $transaction = Yii::$app->db->beginTransaction();
           $vendor_model=$this->VendorSave($vendor_model);
            if(!$flag=$vendor_model->save()){
                $transaction->rollBack();
                return array('errors'=>$vendor_model->errors);
            }
            $model->expense_date=$this->dateFormat($model->expense_date);
             $model->vendor_id=$vendor_model->id;
             $path=realpath(dirname(__FILE__).'/../../expense');
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

                    $model->image_url= $rand_no.'.'.$id;
                    
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
            foreach ($expense_items as $key => $expense_item) {

                $expense_item->expense_id=$model->id;
                $expense_item->expense_category=$model->expense_category;
               // $purchase_item->item_no=$item_no;
                if(!$flag=$expense_item->save()){
                    return array('errors'=>$expense_item->errors);
                }
               /* $item_maste= ItemMaster::find()->where(['id'=>$expense_item->item_code])->one();
                $item_maste->purchase_date=$model->purchase_date;
                $item_maste->purchase_amount=$expense_item->net_value;
                $item_maste->purchase_id=$expense_item->purhcase_id;
               if(!$flag=$item_maste->save()){
                    return array('errors'=>$item_maste->errors);
                }*/
              //  $item_no+=10;
            }
        }
           if($flag){
                   $time=strtotime($model->expense_date);
                   $month=date("m",$time);
                   $year=date("Y",$time);
                    $update_summary=$this->updateSummary($month,$year);
                    //echo "success";die;
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
            'expense_category' => $expense_category,
            'expense_items' => $expense_items,
            'vendor_model' => $vendor_model,
        ]);
    }
public function updateSummary($month,$year)
     {
        //echo $month;die;
         $expense_header=ExpenseHeader::find()->select(['sum(expense_amount) as total_expense'])->where(['delete_status'=>0])->andWhere('DATE_FORMAT(expense_date, "%m-%Y") = "'.$month.'-'.$year.'"')->groupBy(["DATE_FORMAT(expense_date,'%m-%Y')"])->createCommand()->queryOne();
       //  $purchase_header_sub=PurchaseHeader::find()->select('id')->where(['status'=>0])->andWhere('DATE_FORMAT(purchase_date, "%m-%Y") = "'.$month.'-'.$year.'"');
       //  $purchase_header=PurchaseItem::find()->select(['count(*) as number_purchase'])->where(['purhcase_id'=>$purchase_header_sub])->groupBy(["DATE_FORMAT(purchase_date,'%m-%Y')"])->createCommand()->queryOne();

         $booking_summary=BookingSummary::find()->where(['month'=>$month,'year'=>$year])->one();
         if($booking_summary!=""){
            $booking_summary->total_expense=$expense_header['total_expense'];
           // $booking_summary->number_purchase=$purchase_header['number_purchase'];
            // $booking_summary->pending_amount=($purchase_header['total_pending'])*-1;
         }else{
            $booking_summary=new  BookingSummary();
             $booking_summary->total_expense=$expense_header['total_expense'];
           //  $booking_summary->number_purchase=$purchase_header['number_purchase'];
            // $booking_summary->pending_amount=($purchase_header['total_pending'])*-1;
              $booking_summary->month=$month;
             $booking_summary->year=$year;
         }
         $flag=$booking_summary->save();
         return array('errors'=>$booking_summary->errors,'flag'=>$flag);
     }
 public function dateFormat($request_date){
         return ($request_date!='')?date('Y-m-d',strtotime($request_date)):'';
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
    /**
     * Updates an existing ExpenseHeader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $expense_items =$model->expenseItem;
        $vendor_model =$model->vendor;
        $expense_category = ArrayHelper::map(ExpsenseCategory::find()->where(['items_status'=>1])->all(),'id','name');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'expense_category' => $expense_category,
            'expense_items' => $expense_items,
            'vendor_model' => $vendor_model,
        ]);
    }

    /**
     * Deletes an existing ExpenseHeader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ExpenseHeader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExpenseHeader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExpenseHeader::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
