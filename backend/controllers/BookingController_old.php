<?php

namespace backend\controllers;

use backend\models\BookingItem;
use backend\models\CustomerMaster;
use backend\models\DynamicFormsBookingItems;
use backend\models\ItemMaster;
use backend\models\ItemSelection;
use backend\models\TypeMaster;
use backend\models\PaymentMaster;
use backend\models\DynamicFormsPaymentItems;
use Yii;
use yii\helpers\ArrayHelper;
use backend\models\BookingHeader;
use backend\models\BookingHeaderSearch;
use backend\models\BookingItemSearch;
use yii\rbac\Item;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * BookingController implements the CRUD actions for BookingHeader model.
 */
class BookingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
             'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','view','create','update','delete','customer-autocomplete','item-details-popup','item-details-autocomplete','item-booking-details','customer-details','invoice-view','delivery','delivery-item','return-item','index-payment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BookingHeader models.
     * @return mixed
     */
    public function actionIndex()
    {
       
        $searchModel = new BookingHeaderSearch();
        $searchModel->order_status='Open';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndexPayment()
    {
        $searchModel = new BookingHeaderSearch();
        $searchModel->payment_status=0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    /**
     * Displays a single BookingHeader model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

function short_url($booking_id) {
    $appkey='R_e74b011fabe44b52a45c406d087dda35';
    $login='o_523d7el29b';
    $url=$_SERVER['DOCUMENT_ROOT'].''.Yii::$app->request->baseUrl.'/index.php?r=booking/invoice-view&id='.$booking_id;
    
    $format='txt';
    $connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
    return $this->curl_get_result($connectURL);
}
  public  function curl_get_result($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionInvoiceViewOld($id){
        $model= BookingHeader::find()->where(['encryted_id'=>$id])->one();
        $business_partner=$model->customer;
        $item=$model->bookingItems;
         return $this->renderPartial('invoice_print', [
            'model' =>$model,
            'business_partner'=>$business_partner,
            'item'=>$item
        ]);
    }
       public function actionInvoiceView($id){
        $model= BookingHeader::find()->where(['encryted_id'=>$id])->one();
        $business_partner=$model->customer;
        $item=$model->bookingItems;
         return $this->renderPartial('invoice_print_new', [
            'model' =>$model,
            'business_partner'=>$business_partner,
            'item'=>$item
        ]);
    }

    public function sendSMS($mobile_number,$message)
    {
        $authKey = "278929AwbPkmj0W5cef7a5f";

//Multiple mobiles numbers separated by comma
$mobileNumber = $mobile_number;

//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "PANACH";

//Your message to send, Add URL encoding here.
$message = urlencode($message);

//Define route 
$route = "4";
//Prepare you post parameters
$postData = array(
    'authkey' => $authKey,
    'mobiles' => $mobileNumber,
    'message' => $message,
    'sender' => $senderId,
    'route' => $route
);

//API URL
$url="http://api.msg91.com/api/sendhttp.php";

// init the resource
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData
    //,CURLOPT_FOLLOWLOCATION => true
));


//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
$output = curl_exec($ch);

//Print error if any
if(curl_errno($ch))
{
    echo 'error:' . curl_error($ch);
}

curl_close($ch);

echo $output;
  }
    public function actionDelivery($id)
    {
        # code...
          $searchModel = new BookingItemSearch();
          $searchModel->booking_id=$id;
          $searchModel->item_status='Booked';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('delivery_item', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'item_status'=>'Picked',
            'booking_id'=>$id
        ]);
       
    }
    public function actionReturnItem($id)
    {
        # code...
          $searchModel = new BookingItemSearch();
          $searchModel->booking_id=$id;
          $searchModel->item_status='Picked';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('delivery_item', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'item_status'=>'Returned',
            'booking_id'=>$id
        ]);
       
    }


    public function sendModelmaildeafultattch($model)
         {   
               $sendGrid = Yii::$app->sendGrid;               
               $message = $sendGrid->compose();                 
               $message->setHtmlBody($model['message']);               
              // print_r($sendGrid);die;
               //print_r(Yii::getAlias('@webroot/').'..'.$model->attachmentFile);die;
                   //echo "<pre>";print_r($filename);die;
              /*  $filename = Yii::getAlias('@webroot/').''.$model['attachmentFile'];
            
                if(file_exists($filename)){
                  chmod($filename, 0777);
                }
                $target_path=dirname(__DIR__)."/".$filename; 
                $message->attach($filename);*/

                $message->setFrom($model['from_email'])
                    ->setTo($model['to_email'])
                    ->setSubject($model['subject']);                   
                $result = $message->send($sendGrid); 
                return $result;             
        }
    /**
     * Creates a new BookingHeader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
    public function dateFormat($request_date){
         return ($request_date!='')?date('Y-m-d',strtotime($request_date)):'';
    }
    public function actionCreate()
    {
        //$short_url = $this->get_bitly_short_url(,'o_523d7el29b','R_e74b011fabe44b52a45c406d087dda35');
        echo $this->short_url("gasts");die;
      //$this->sendModelmaildeafultattch(array('message'=>'Test','from_email'=>'dnyaneshwareh@gmail.com','to_email'=>'dnyaneshwareh@gmail.com','subject'=>'Hello'));
     // $this->sendSMS();
        $model = new BookingHeader();
        $booking_items=[new BookingItem()];
        $customer_model=new CustomerMaster();
        $payment_models=[new PaymentMaster()];
        $send_invoice=0;
        if ($model->load(Yii::$app->request->post())) {
            $send_invoice=$_POST['booking_sms'];
           $picked_status=$model->picked_up;
             Yii::$app->response->format = Response::FORMAT_JSON;
            $customer_model->load(Yii::$app->request->post());
            $booking_items = DynamicFormsBookingItems::createMultiple(BookingItem::classname());
            DynamicFormsBookingItems::loadMultiple($booking_items, Yii::$app->request->post());
                  array_shift($booking_items);
            $payment_models = DynamicFormsPaymentItems::createMultiple(PaymentMaster::classname());
            DynamicFormsPaymentItems::loadMultiple($payment_models, Yii::$app->request->post());
                  array_shift($payment_models);
                  $result_payment_item=array();
                  $no_payment=false;
                  if((sizeof($payment_models) == 1) && ($model->paid_amount!='' && $model->paid_amount!='0')){
                     $result_payment_item=ActiveForm::validateMultiple($payment_models);
                    $no_payment=true;
                  }
                  if(sizeof($payment_models) > 1){
                     $result_payment_item=ActiveForm::validateMultiple($payment_models);
                    $no_payment=true;
                  }
                 
                 $result= ActiveForm::validate($model);
                 $result_cust= ActiveForm::validate($customer_model);
                 $result_item=ActiveForm::validateMultiple($booking_items);
                 
            $all_validate=array_merge($result,$result_item,$result_cust,$result_payment_item);
            if($all_validate!=null){
            //echo "<pre>";print_r( array('errors'=>$all_validate));die;
                return array('errors'=>$all_validate);
           }else{
            $flag=true;
            $transaction = Yii::$app->db->beginTransaction();
            $customer_model=$this->CustomerSave($customer_model);
             if(!$flag=$customer_model->save()){
                $transaction->rollBack();
                return array('errors'=>$customer_model->errors);
            }
            if($picked_status){
                 $model->status='Picked';

            }
            $model->customer_id=$customer_model->id;
             $model->encryted_id=$this->generateRandomString();
            $model->booking_date=$this->dateFormat($model->booking_date);
            $model->pickup_date=$this->dateFormat($model->pickup_date);
            $model->return_date=$this->dateFormat($model->return_date);
            $model->payment_status=(($model->net_value-$model->paid_amount)==0);
            if(!$flag=$model->save()){
                $transaction->rollBack();
                return array('errors'=>$model->errors);
            }
            $item_no=10;
            foreach ($booking_items as $key => $booking_item) {
                   $booking_item->booking_id=$model->booking_id;
                   $booking_item->item_no=$item_no;
                   $booking_item->pickup_date=$model->pickup_date;
                   $booking_item->return_date=$model->return_date;
                   if($picked_status){
                     $booking_item->picked_date=date('Y-m-d');
                      $booking_item->item_status='Picked';
                      //$this->updateRentCount($booking_item->product_id);
                   }
                    if(!$flag=$booking_item->save()){
                        $transaction->rollBack();
                return array('errors'=>$booking_item->errors);
                   }
                  /* $summary=$this->bookingSummary($booking_item,$model->pickup_date);
                   if(!$flag=$summary->save()){
                        $transaction->rollBack();
                      return array('errors'=>$summary->errors);
                   }*/
                   $item_no+=10;
               }   
              // echo $no_payment;
              // print_r($payment_models);die;
               if($no_payment){
                    foreach ($payment_models as $key => $payment_item) {
                        if($payment_item->payment_id!=""){
                         $payment_retr=PaymentMaster::find()->where(['payment_id'=>$payment_item->payment_id])->one();
                         $payment_retr->date=$payment_item->date;
                         $payment_retr->type=$payment_item->type;
                        $payment_retr->mode_of_payment=$payment_item->mode_of_payment;
                        $payment_retr->received_by=$payment_item->received_by;
                        $payment_retr->received_during=$payment_item->received_during;
                        $payment_retr->dom=$payment_item->dom;
                        $payment_retr->amount=$payment_item->amount;
                        $payment_retr->booking_id=$model->booking_id;
                        $payment_retr->sendto=$payment_item->sendto;
                        if(!$flag=$payment_retr->save()){
                             $transaction->rollBack();
                            return array('errors'=>$payment_retr->errors);
                        }
                        }else{
                           $payment_item->booking_id=$model->booking_id;
                                  // $payment_item->item_no=$item_no;
                                        //print_r($payment_item);die;
                        if(!$flag=$payment_item->save()){
                             $transaction->rollBack();
                             return array('errors'=>$payment_item->errors);
                         }
                     }
                    // print_r($payment_item);die;
                    } 
                }

               if($flag){
                 $transaction->commit();
                 Yii::$app->session->setFlash('success', "Your message to display.");
               }else{
                 $transaction->rollBack();
                 Yii::$app->session->setFlash('error', "faild to save.");
               }
               if($send_invoice==1){
                $this->sendInvoice($model);
               }
            return $this->redirect(['update','id'=> $model->booking_id]);
           }
            
        }

        return $this->render('create', [
            'model' => $model,
            'booking_items' => $booking_items,
            'customer_model' => $customer_model,
            'payment_models'=>$payment_models
        ]);
    }
    public function updateRentCount($item_id){
        $item_master=ItemMaster::find()->where(['id'=>$item_id])->one();
        //print_r($item_master);die;
        $item_master->rent_times+=1;
        $item_master->save();
    }
     public function sendInvoice($booking_header)
     {
         $customer_model=$booking_header->customer;
         if($customer_model!=null){
            if($customer_model->email_id!=''){
                //$this->sendemail($booking_header);
            }
            if($customer_model->contact_nos!=''){
               // $message="Thanks ".$customer_model->name." for shopping with Panache Rental Boutique. Your order of Rs.".round($booking_header->net_value)."\nRent-Rs.".round($booking_header->rent_amount)."\nDeposit-Rs.".round($booking_header->deposite_amount)."";
        $message="Thanks ".$customer_model->name." for shopping with Panache Rental Boutique. Your order of Rs.".round($booking_header->net_value)." Booked.\n For invoice please check ".$this->short_url($booking_header->encryted_id)." ";
               /* if($booking_header->discount!=0){
                $message.="\nDiscount-Rs.".round($booking_header->discount);
            }*/
           // $message.="\nPaid-Rs.".round($booking_header->paid_amount)."\nReturn date: ".date_format(date_create($booking_header->return_date),'d-m-y')."\nNote:Please Return on given date or you will be charged extra per day.\n\n";
            $message.="\nPaid-Rs.".round($booking_header->paid_amount)."\nReturn date: ".date_format(date_create($booking_header->return_date),'d-m-y')."\nNote:Please Return on given date or you will be charged extra per day.\n\n";
           
            $this->sendSMS($customer_model->contact_nos,$message);

            }
         }
     }

    public function actionDeliveryItem()
    {
        # code...
        Yii::$app->response->format = Response::FORMAT_JSON;
        $transaction = Yii::$app->db->beginTransaction();
        if(!isset($_POST['selection'])){
            return array("errors"=>array("No Item Selected."));
        }
        $selected_items=$_POST['selection'];
        $pickup_date=$_POST['delivery_date'];
        $status=$_POST['item_status'];
         $booking_id=$_POST['booking_id'];
        // $booking_items=BookingItem::find()->where(['item_id'=>$selected_items])->all();
         //print_r($booking_item);die;
         BookingItem::updateAll(['picked_date' => $this->dateFormat($pickup_date),'item_status'=>$status], [ 'item_id'=> $selected_items]);
          /* $transaction = Yii::$app->db->beginTransaction();
        foreach ($booking_items as $key => $item) {
            $item->picked_date=$this->dateFormat($pickup_date);
            $item->item_status='Picked';
             if(!$flag=$item->save()){
                $transaction->rollBack();
             return array('errors'=>$item->errors);
            }
        }*/
        //print_r($selected_items);die;
        if($status!='Picked'){
          $booking_items=BookingItem::find()->where(['!=','item_status','Returned'])->all();
          if($booking_items==null){
            BookingHeader::updateAll(['order_status'=>'Closed','status'=>'Returned'],['booking_id'=>$booking_id]);
            foreach ($booking_items as $key => $booking_item) {
               $this->updateRentCount($booking_item->product_id);
            }
          }
        }else{
            $booking_items=BookingItem::find()->where(['!=','item_status','Picked'])->all();
            
             if($booking_items==null){
            BookingHeader::updateAll(['status'=>'Picked'],['booking_id'=>$booking_id]);
          }
        }
        $transaction->commit();

        return true;
    }
    public function CustomerSave($customer='')
    {
        $customer_old=null;
       if($customer->id!=''){
        $customer_old=CustomerMaster::find()->where(['id'=>$customer->id])->one();
        $customer_old->reference=$customer_old->reference;
        $customer_old->cust_group=$customer->cust_group;
       }else if($customer->contact_nos!=''){
        $customer_old=CustomerMaster::find()->where(['contact_nos'=>$customer->contact_nos])->one();
        }
        if($customer_old==null){
            return $customer;
        }
        $customer_old->contact_nos=$customer_old->contact_nos;
        $customer_old->name=$customer->name;
        return $customer_old;
    }
    public function actionCustomerAutocomplete(){
        if(isset($_GET['term'])){
            $id=$_GET['id'];
            $customer_data = CustomerMaster::find()->select(['id','name','contact_nos','email_id'])->where(['like', 'id', $_GET['term']])->orWhere(['like', 'name',  $_GET['term']])->orWhere(['like', 'contact_nos',  $_GET['term']])->asArray()->limit(25)->all();
            $return_array = array();
            $return_array['id_pass']=$id;
            $return_array['customer_data']=$customer_data;
            echo json_encode($return_array);
        }
    }

    public function actionItemDetailsPopup(){

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        if (isset($_POST['item_type'])) {
            $item_type = $_POST['item_type'];
        }
        // print_r( $_POST['id']);die;
        $item_catgory=isset($_POST['item_catgory'])?$_POST['item_catgory']:'';

        $sales_items = new ItemSelection();
        if (isset($_POST['description']) && $_POST['description']!='') {
            $sales_items->item_id=$_POST['item_id'];
            /*$sales_items->item_type=$_POST['item_type'];
            $sales_items->item_category=$_POST['item_category'];*/
            $sales_items->description=$_POST['description'];
          //  $sales_items->SERVICE_CATELOG_ID=isset($_POST['service_catelog_id'])?$_POST['service_catelog_id']:'';

        }
        $data=TypeMaster::find()->all();
        $listAll=(\yii\helpers\ArrayHelper::map($data,'id','name'));
        // print_r( $_POST['id']);die;
        return $this->renderAjax('centralize_form', ['modelItems'=>$sales_items,'listAll'=>$listAll,'id'=>$id]);

    }
    public function actionItemDetailsAutocomplete(){

            $id=$_GET['id'];
            $type=$_GET['type'];

            Yii::$app->response->format = Response::FORMAT_JSON;
            $item_details = ItemMaster::find()->select(['id','name','details','rent_amount','deposit_amount','category_id','images'])->where(['like', 'id', $_GET['term']])->orWhere(['like', 'name',  $_GET['term']])->andWhere(['type_id'=>$type])->asArray()->limit(25)->all();


            $return_array = array();
            $return_array['id_pass']=$id;
            $return_array['type']=$type;
            $return_array['item_details']=$item_details;

            return $return_array;

    }
    /**
     * Updates an existing BookingHeader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionItemBookingDetails(){

        $model_attrib = new ItemMaster();


        if (isset($_POST['item_id'])) {
            $item_id = $_POST['item_id'];
        } else {
            $item_id = '';
        }


        //$storage_location = StorageLocation::find()->select(['STORAGE_LOCATION'])->where(['COMPANY_CODE' => $company_code,'Plant' => $plant])->asArray()->one();
        $item_data= ItemMaster::find()->where(['id' => $item_id])->one();
        // echo "<pre>";
        //print_r($company_code);die;

        $booking_item=BookingItem::find()->where(['product_id' => $item_id])->andWhere(['IN','item_status',array('Booked','Picked')])->all();
        $flag = 1;
        /*foreach ($booking_item as $key => $booking_im) {
            # code...
        }*/
       //echo "<pre>";print_r($booking_item);die;
        //$product_category = ($material_data['PRODUCT_CATEGORY']!='')?$this->gettreevalupdate($material_data['PRODUCT_CATEGORY']):'';
        return $this->renderAjax('non_stockable', ['model_attrib'=>$model_attrib,'item_data'=>$item_data, 'flag' => $flag,'booking_item'=>$booking_item]);
    }
    public function actionCustomerDetails($id){
        if(isset($_GET['id'])) {
            $id=$_GET['id'];
            $customer_data = CustomerMaster::find()->where([ 'id'=>$_GET['id']])->asArray()->one();
            echo json_encode($customer_data);
        }
    }

    public function bookingSummary($booking_item,$cal_date){
       
         $date= date_create($cal_date);
         $month =date_format($date,'m');
          $year =date_format($date,'Y');
        $bookingSummary=BookingSummary::find()->where(['item_type'=>$booking_item->item_type,'item_category'=>$booking_item->item_category,'month'=>$month,'year'=>$year])->one();
        if($bookingSummary!=null){
            $bookingSummary->amount+=$booking_item->amount;
        }else{
            $bookingSummary=new BookingSummary();
            $bookingSummary->item_category=$booking_item->item_category;
            $bookingSummary->item_type=$booking_item->item_type;
            $bookingSummary->amount=$booking_item->amount;
            $bookingSummary->month=$month;
            $bookingSummary->year=$year;

        }
        return $bookingSummary;
    }
    public function actionUpdate($id)
    {
       //$this->getattachmentPath("Test");
        $model = $this->findModel($id);
        //$this->sendInvoice($model);die;
        $booking_items=$model->bookingItems;
        $customer_model=$model->customer;
        $payment_models=$model->payment;
        $model->picked_up=($model->status=='Picked')?1:0;
        if($payment_models==null){
            $payment_models=[new PaymentMaster()];
        }
        if ($model->load(Yii::$app->request->post())) {
           // print_r($model);die;
            $send_invoice=$_POST['booking_sms'];
           $picked_status=$model->picked_up;
               Yii::$app->response->format = Response::FORMAT_JSON;
            $customer_model->load(Yii::$app->request->post());
            $oldIDs = ArrayHelper::map($booking_items, 'item_id', 'item_id');
            $oldIDs_payment = ArrayHelper::map($payment_models, 'payment_id', 'payment_id');
            //print_r($oldIDs_payment);die;
            $booking_items = DynamicFormsBookingItems::createMultiple(BookingItem::classname());
            DynamicFormsBookingItems::loadMultiple($booking_items, Yii::$app->request->post());
                  array_shift($booking_items);
            $payment_models = DynamicFormsPaymentItems::createMultiple(PaymentMaster::classname());
            DynamicFormsPaymentItems::loadMultiple($payment_models, Yii::$app->request->post());
                  array_shift($payment_models);
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($booking_items, 'item_id', 'item_id')));
        $deletedIDs_payment = array_diff($oldIDs_payment, array_filter(ArrayHelper::map($payment_models, 'payment_id', 'payment_id')));
        $result_payment_item=array();
                  $no_payment=false;
                  if((sizeof($payment_models) == 1) && ($model->paid_amount!='' && $model->paid_amount!='0')){
                     $result_payment_item=ActiveForm::validateMultiple($payment_models);
                    $no_payment=true;
                  }
                  if(sizeof($payment_models) > 1){
                     $result_payment_item=ActiveForm::validateMultiple($payment_models);
                    $no_payment=true;
                  }
        //print_r($customer_model);die;
                 $result= ActiveForm::validate($model);
                 $result_cust= ActiveForm::validate($customer_model);
                 $result_item=ActiveForm::validateMultiple($booking_items);
            $all_validate=array_merge($result,$result_item,$result_cust,$result_payment_item);
            if($all_validate!=null){
            //echo "<pre>";print_r( array('errors'=>$all_validate));die;
                return array('errors'=>$all_validate);
           }else{
            $flag=true;
            $transaction = Yii::$app->db->beginTransaction();
            $customer_model=$this->CustomerSave($customer_model);
             if(!$flag=$customer_model->save()){
                $transaction->rollBack();
                return array('errors'=>$customer_model->errors);
            }
            if($picked_status){
                 $model->status='Picked';
            }else{
                 $model->status='Booked';
            }
            $model->customer_id=$customer_model->id;
            $model->booking_date=$this->dateFormat($model->booking_date);
            $model->pickup_date=$this->dateFormat($model->pickup_date);
            $model->return_date=$this->dateFormat($model->return_date);
             $model->payment_status=(($model->net_value-$model->paid_amount)==0);
            if(!$flag=$model->save()){
                $transaction->rollBack();
                return array('errors'=>$model->errors);
            }

       if (! empty($deletedIDs)) {
       // $this->unbookingSummary($deletedIDs);
          BookingItem::deleteAll(['item_id' => $deletedIDs]);
        }   
       if (! empty($deletedIDs_payment)) {
          PaymentMaster::deleteAll(['payment_id' => $deletedIDs_payment]);
        } 
            $item_no=10;
            foreach ($booking_items as $key => $booking_item) {

                if($booking_item->item_id==''){
                    $booking_item->booking_id=$model->booking_id;
                   $booking_item->item_no=$item_no;
                   $booking_item->pickup_date=$model->pickup_date;
                   $booking_item->return_date=$model->return_date;
                    if($picked_status){
                     $booking_item->picked_date=date('Y-m-d');
                     $booking_item->item_status='Picked';
                     // $this->updateRentCount($booking_item->product_id);
                   }
                    if(!$flag=$booking_item->save()){
                        $transaction->rollBack();
                return array('errors'=>$model->errors);
                   }
                }else{
                     
                    BookingItem::updateAll([
                    'booking_id' =>$model->booking_id,
                    'item_no' =>$item_no,
                    'product_id' =>$booking_item->product_id,
                    'net_value' =>$booking_item->net_value,
                    'item_category' =>$booking_item->item_category,
                      'item_type' =>$booking_item->item_type,
                    'amount' =>$booking_item->amount,
                    'deposit_amount' =>$booking_item->deposit_amount,
                    'deposite_charge_status' =>$booking_item->deposite_charge_status,
                    'pickup_date' =>$booking_item->pickup_date,
                    'picked_date' =>($picked_status)?date('Y-m-d'):null,
                    'item_status' =>($picked_status)?'Picked':'Booked',
                    'return_date' =>$booking_item->return_date,
                    //'returned_date' =>$booking_item->,
                    //'item_status' =>$booking_item->,
                    'note' =>$booking_item->note,
                    'discount'=>$booking_item->discount],
                   // 'deposite_status' =>$booking_item->,
                    //'payment_status' =>$booking_item->,
                     ['item_id' => $booking_item->item_id]);

                }
                  /*$summary=$this->bookingSummary($booking_item,$model->pickup_date);
                   if(!$flag=$summary->save()){
                        $transaction->rollBack();
                      return array('errors'=>$summary->errors);
                   }*/
                   $item_no+=10;
               }   

               
                   if($no_payment){
                    foreach ($payment_models as $key => $payment_item) {
                        if($payment_item->payment_id!=""){
                         $payment_retr=PaymentMaster::find()->where(['payment_id'=>$payment_item->payment_id])->one();
                         $payment_retr->date=$payment_item->date;
                         $payment_retr->type=$payment_item->type;
                        $payment_retr->mode_of_payment=$payment_item->mode_of_payment;
                        $payment_retr->received_by=$payment_item->received_by;
                        $payment_retr->received_during=$payment_item->received_during;
                        $payment_retr->dom=$payment_item->dom;
                        $payment_retr->amount=$payment_item->amount;
                        $payment_retr->booking_id=$model->booking_id;
                        $payment_retr->sendto=$payment_item->sendto;
                        if(!$flag=$payment_retr->save()){
                             $transaction->rollBack();
                            return array('errors'=>$payment_retr->errors);
                        }
                        }else{
                           $payment_item->booking_id=$model->booking_id;
                                  // $payment_item->item_no=$item_no;
                                        //print_r($payment_item);die;
                        if(!$flag=$payment_item->save()){
                             $transaction->rollBack();
                             return array('errors'=>$payment_item->errors);
                         }
                     }
                    // print_r($payment_item);die;
                    } 
                }

               if($flag){
                 $transaction->commit();
                 Yii::$app->session->setFlash('success', "Your message to display.");
               }else{
                 $transaction->rollBack();
                 Yii::$app->session->setFlash('error', "faild to save.");
               }
               if($send_invoice==1){
                $this->sendInvoice($model);
               }
            return $this->redirect(['update','id'=> $model->booking_id]);
           }
        }

        return $this->render('update', [
            'model' => $model,
            'booking_items' => $booking_items,
            'customer_model' => $customer_model,
            'payment_models'=>$payment_models
        ]);
    }
   
    /**
     * Deletes an existing BookingHeader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       $model= $this->findModel($id);
       $model->order_status='Deleted';
       $model->save();
        return $this->redirect(['index']);
    }
    public function getattachmentPath($html) {
   
     // $html = $_POST['html'];
        // $html = "<html><body><h1>Testing Printing</h1></body></html>";
        // echo $html;die;
      //  $filename="output.pdf";
        if(!is_dir("attatchment/prints")) {
           // $object_key= Yii::$app->request->post('Attatchment')['object_key'];
           $path = "attatchment/prints";
            \yii\helpers\FileHelper::createDirectory($path, $mode = 0777, $recursive = true);
    
         }

            $date=date('Y-m-d-h-i-s');
            $filename=(rand(10,1000)).$date.".pdf";            
          Yii::$app->html2pdf->convert($html)->saveAs("attatchment/prints/".$filename);
        // print_r($filename);die;
          return "attatchment/prints/".$filename;
        }

    /**
     * Finds the BookingHeader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BookingHeader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookingHeader::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findModelenc($id)
    {
        if (($model = BookingHeader::find()->where(['encryted_id'=>$id]))->one() !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
