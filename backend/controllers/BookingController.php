<?php

namespace backend\controllers;

use backend\models\BookingCarryFrd;
use backend\models\AddressGroup;
use backend\models\BookingItem;
use backend\models\CustomerMaster;
use backend\models\DynamicFormsBookingItems;
use backend\models\ItemMaster;
use backend\models\ItemSelection;
use backend\models\TypeMaster;
use backend\models\PaymentMaster;
use backend\models\ItemSummary;
use backend\models\CategoryMaster;
use backend\models\DynamicFormsPaymentItems;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\models\BookingHeader;
use backend\models\BookingSummary;
use backend\models\BookingHeaderSearch;
use backend\models\BookingItemSearch;
use yii\rbac\Item;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/*CREATE TABLE IF NOT EXISTS `booking_carry_frd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `carry_return` decimal(10,2) NOT NULL DEFAULT '0.00',
  `carry_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_bal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '0',
  `created_by` varchar(50) NOT NULL,
  `created_at` date NOT NULL,
  `entry_time` time NOT NULL,
  `settle_with` int(11) DEFAULT NULL,
  `settle_with_booking_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;*/

/**
 * BookingController implements the CRUD actions for BookingHeader model.
 * ALTER TABLE `booking_header` ADD `carry_frwd_app` INT NOT NULL DEFAULT '0' AFTER `payment_status`;
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
                        'actions' => ['login', 'error', 'invoice-view', 'get-type'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'view', 'create', 'update', 'delete', 'customer-autocomplete', 'item-details-popup', 'item-details-autocomplete', 'item-booking-details', 'customer-details', 'delivery', 'delivery-item', 'return-item', 'index-payment', 'index-sales', 'item-check-autocomplete', 'item-booking-details', 'item-booking-check', 'cancel-delivery', 'pending-deposite', 'get-whatsapp', 'carry-frd'],
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

        $searchModel->order_status = 'Open';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        $date = date('m-Y');


        $booking_header_summmary = BookingHeader::find()->select(['sum(net_value) as total_rent', 'sum((paid_amount-net_value-refunded)) as total_pending', 'count(*) as number_invoice', 'sum(paid_amount) total_paid', 'sum(deposite_amount) total_deposite_amount', 'sum(net_value) total_net_value', 'sum(extra_amount) total_extra_amount'])->where(['order_status' => array('Open')])->createCommand()->queryOne();
        $user = Yii::$app->user->identity;
        $is_admin = ($user->user_type == "admin") ? true : false;
//->andWhere('DATE_FORMAT(pickup_date, "%m-%Y") = "'. $date.'"')
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'booking_header_summmary' => $booking_header_summmary,
            'title' => "Open Booking",
            'is_admin' => $is_admin,
        ]);
    }

    public function actionCancelDelivery()
    {
        $booking_id = $_POST['booking_id'];
        $booking_item = $_POST['booking_item'];
        Yii::$app->response->format = Response::FORMAT_JSON;
        BookingItem::updateAll(['item_status' => 'Booked'], ['item_id' => $booking_item, 'booking_id' => $booking_id]);
        BookingHeader::updateAll(['status' => 'Booked'], ['booking_id' => $booking_id]);
        return array(true);
    }

    public function checkBooking($product_id, $pickup_date, $return_date, $booking_id = null)
    {
        $where_booking = ($booking_id == null) ? 1 : ['!=', 'booking_id', $booking_id];
        $booking_items = BookingItem::find()->select(['item_id', 'booking_id', 'product_id', 'item_no', 'pickup_date', 'return_date'])->where(['product_id' => $product_id])->andWhere("`pickup_date` <= '$return_date' and `return_date` >= '$pickup_date'")->andWhere(['item_status' => ['Booked', 'Picked']])->andWhere($where_booking)->asArray()->all();
        //
        $flag = 0;
        $message = "";
        // print_r($booking_items);die;
        if ($booking_items != null || sizeOf($booking_items)) {
            $flag = 1;
            $message = "Booking for Items exist. Booking Dates: ";
            //print_r($booking_items);
            foreach ($booking_items as $booking_item) {
                $message .= " [" . $this->dateFormat($booking_item['pickup_date'], 'd-m-Y') . " -> " . $this->dateFormat($booking_item['return_date'], 'd-m-Y') . "] ";
            }
        }
        //return array('status'=>$flag,'errors'=>array($message));


        return array('flag' => $flag, 'errors' => array($message));
    }

    public function actionIndexSales()
    {
        //$date=date('m-Y');
        $date = (isset($_GET['month']) && isset($_GET['year'])) ? $_GET['month'] . '-' . $_GET['year'] : date('m-Y');
        $searchModel = new BookingHeaderSearch();
        $searchModel->order_status = array('Open', 'Closed', 'Cancelled');
        $searchModel->month_year_filter = $date;
        $dataProvider = $searchModel->search_category(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;

        $booking_header_summmary = BookingHeader::find()->select(['sum(earning_amount) as total_rent', 'sum((paid_amount-net_value -refunded)) as total_pending', 'count(*) as number_invoice', 'sum(paid_amount) total_paid', 'sum(deposite_amount) total_deposite_amount', 'sum(net_value) total_net_value', 'sum(extra_amount) total_extra_amount'])->where(['order_status' => array('Open', 'Closed', 'Cancelled')])->andWhere('DATE_FORMAT(pickup_date, "%m-%Y") = "' . $date . '"')->createCommand()->queryOne();
        $user = Yii::$app->user->identity;
        $is_admin = ($user->user_type == "admin") ? true : false;

        return $this->render('index_total_sales', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'booking_header_summmary' => $booking_header_summmary,
            'title' => "Total Sales",
            'is_admin' => $is_admin,
        ]);
    }

    public function actionItemBookingCheck()
    {

        $model_attrib = new ItemMaster();


        if (isset($_POST['item_id'])) {
            $item_id = $_POST['item_id'];
        } else {
            $item_id = '';
        }


        //$storage_location = StorageLocation::find()->select(['STORAGE_LOCATION'])->where(['COMPANY_CODE' => $company_code,'Plant' => $plant])->asArray()->one();
        $item_data = ItemMaster::find()->where(['id' => $item_id])->one();
        // echo "<pre>";
        //print_r($company_code);die;

        $booking_item = BookingItem::find()->where(['product_id' => $item_id])->andWhere(['IN', 'item_status', array('Booked', 'Picked')])->all();
        $flag = 1;
        /*foreach ($booking_item as $key => $booking_im) {
            # code...
        }*/
        //echo "<pre>";print_r($booking_item);die;
        //$product_category = ($material_data['PRODUCT_CATEGORY']!='')?$this->gettreevalupdate($material_data['PRODUCT_CATEGORY']):'';
        return $this->renderAjax('check_item', ['booking_item' => $booking_item, 'item_data' => $item_data]);
    }

    public function actionIndexPayment()
    {
        $searchModel = new BookingHeaderSearch();
        $searchModel->payment_status = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $date = date('m-Y');
        $booking_header_summmary = BookingHeader::find()->select(['sum(net_value) as total_rent', 'sum((paid_amount-net_value -refunded)) as total_pending', 'count(*) as number_invoice', 'sum(paid_amount) total_paid', 'sum(deposite_amount) total_deposite_amount', 'sum(net_value) total_net_value', 'sum(extra_amount) total_extra_amount'])->where(['order_status' => array('Open', 'Closed', 'Cancelled')])->andWhere('DATE_FORMAT(pickup_date, "%m-%Y") = "' . $date . '"')->createCommand()->queryOne();
        $user = Yii::$app->user->identity;
        $is_admin = ($user->user_type == "admin") ? true : false;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'booking_header_summmary' => $booking_header_summmary,
            'title' => "Payment",
            'is_admin' => $is_admin,
        ]);
    }

    public function actionPendingDeposite()
    {
        $searchModel = new BookingHeaderSearch();
        $searchModel->payment_status = 1;
        $searchModel->status = 'Returned';
        $searchModel->order_status = 'Open';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $date = date('m-Y');
        $booking_header_summmary = BookingHeader::find()->select(['sum(net_value) as total_rent', 'sum((paid_amount-net_value -refunded)) as total_pending', 'count(*) as number_invoice', 'sum(paid_amount) total_paid', 'sum(deposite_amount) total_deposite_amount', 'sum(net_value) total_net_value', 'sum(extra_amount) total_extra_amount'])->where(['order_status' => array('Open', 'Closed', 'Cancelled')])->andWhere('DATE_FORMAT(pickup_date, "%m-%Y") = "' . $date . '"')->createCommand()->queryOne();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'booking_header_summmary' => $booking_header_summmary,
            'title' => "Return Deposte Pending",
        ]);
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Displays a single BookingHeader model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    function short_url($booking_id)
    {
        return "http://inv.panachewears.in/?" . $booking_id;
        $appkey = 'R_e74b011fabe44b52a45c406d087dda35';
        $login = 'o_523d7el29b';
        $url = Url::base(true) . '' . Yii::$app->request->baseUrl . '/index.php?r=booking/invoice-view&id=' . $booking_id;
        //echo $url;die;
        //$url="https://www.google.com";
        $format = 'txt';
        $connectURL = 'http://api.bit.ly/v3/shorten?login=' . $login . '&apiKey=' . $appkey . '&uri=' . urlencode($url) . '&format=' . $format;
        return $this->curl_get_result($connectURL);
    }

    public function CompressURL($url)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://to.ly/api.php?longurl=' . urlencode($url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $html = curl_exec($ch);
        curl_close($ch);

        return $html;

    }

    public function curl_get_result($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
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

    public function actionInvoiceViewOld($id)
    {
        $model = BookingHeader::find()->where(['encryted_id' => $id])->one();
        $business_partner = $model->customer;
        $item = $model->bookingItems;
        return $this->renderPartial('invoice_print', [
            'model' => $model,
            'business_partner' => $business_partner,
            'item' => $item
        ]);
    }

    public function actionInvoiceView()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            echo "No data Found";
            die;
        }
        $model = BookingHeader::find()->where(['encryted_id' => $id])->one();
        if ($model == null || $model == '') {
            echo "No data Found";
            die;
        }
        $business_partner = $model->customer;
        $item = $model->bookingItems;
        return $this->renderPartial('invoice_print_new', [
            'model' => $model,
            'business_partner' => $business_partner,
            'item' => $item
        ]);
    }

    public function sendSMS($mobile_number, $message)
    {
        $authKey = "278929ADj7q9eBs5e5e5968P1";

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
        $url = "http://api.msg91.com/api/sendhttp.php";

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
        if (curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);

        echo $output;
    }

    public function actionDelivery($id)
    {
        # code...
        $searchModel = new BookingItemSearch();
        $searchModel->booking_id = $id;
        $searchModel->item_status = 'Booked';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $this->findModel($id);
        $payment_models = $model->payment;

        if ($payment_models == null) {
            $payment_models = [new PaymentMaster()];
        }
        return $this->render('delivery_item', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'item_status' => 'Picked',
            'booking_id' => $id,
            'payment_models' => $payment_models,
            'model' => $model
        ]);

    }

    public function actionReturnItem($id)
    {
        # code...
        $searchModel = new BookingItemSearch();
        $searchModel->booking_id = $id;
        $searchModel->item_status = 'Picked';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = $this->findModel($id);
        $payment_models = $model->payment;

        if ($payment_models == null) {
            $payment_models = [new PaymentMaster()];
        }


        return $this->render('delivery_item', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'item_status' => 'Returned',
            'booking_id' => $id,
            'payment_models' => $payment_models,
            'model' => $model
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

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function dateFormat($request_date, $req_format = null)
    {
        $req_format = ($req_format == null) ? 'Y-m-d' : $req_format;
        return ($request_date != '') ? date($req_format, strtotime($request_date)) : '';
    }

    public function actionCreate()
    {
        //$short_url = $this->get_bitly_short_url(,'o_523d7el29b','R_e74b011fabe44b52a45c406d087dda35');
        //echo $this->short_url("gasts");die;
        //$this->sendModelmaildeafultattch(array('message'=>'Test','from_email'=>'dnyaneshwareh@gmail.com','to_email'=>'dnyaneshwareh@gmail.com','subject'=>'Hello'));
        // $this->sendSMS();
        $model = new BookingHeader();
        $model->order_status = 'Open';
        $model->status = 'Booked';

        $booking_items = [new BookingItem()];
        $customer_model = new CustomerMaster();
        $payment_models = [new PaymentMaster()];
        $address_grup = ArrayHelper::map(AddressGroup::find()->all(), 'id', 'name');
        $send_invoice = 0;
        if ($model->load(Yii::$app->request->post())) {
            $send_invoice = $_POST['booking_sms'];
            $picked_status = $model->picked_up;
            $complete_order = $model->complete_order;
            Yii::$app->response->format = Response::FORMAT_JSON;
            $customer_model->load(Yii::$app->request->post());
            $booking_items = DynamicFormsBookingItems::createMultiple(BookingItem::classname());
            DynamicFormsBookingItems::loadMultiple($booking_items, Yii::$app->request->post());
            array_shift($booking_items);
            $payment_models = DynamicFormsPaymentItems::createMultiple(PaymentMaster::classname());
            DynamicFormsPaymentItems::loadMultiple($payment_models, Yii::$app->request->post());
            array_shift($payment_models);
            $result_payment_item = array();
            $no_payment = false;
            if ((sizeof($payment_models) == 1) && ($payment_models[0]['amount'] != '')) {
                $result_payment_item = ActiveForm::validateMultiple($payment_models);
                $no_payment = true;
            }
            if (sizeof($payment_models) > 1) {
                $result_payment_item = ActiveForm::validateMultiple($payment_models);
                $no_payment = true;
            }

            $result = ActiveForm::validate($model);
            $result_cust = ActiveForm::validate($customer_model);
            $result_item = ActiveForm::validateMultiple($booking_items);

            $all_validate = array_merge($result, $result_item, $result_cust, $result_payment_item);
            if ($all_validate != null) {
                //echo "<pre>";print_r( array('errors'=>$all_validate));die;
                return array('errors' => $all_validate);
            } else {
                $flag = true;
                $transaction = Yii::$app->db->beginTransaction();
                $customer_model = $this->CustomerSave($customer_model, $model->booking_date);
                if (!$flag = $customer_model->save()) {
                    $transaction->rollBack();
                    return array('errors' => $customer_model->errors);
                }
                $model->status = 'Booked';
                if ($picked_status) {
                    $model->status = 'Picked';

                }
                if ($complete_order) {
                    $model->status = 'Returned';
                    $model->order_status = 'Closed';
                    //print_r($model);die;
                    if (($model->pending_amount) != 0) {
                        return array('errors' => array('Payment not completed. Please complete Payment'));
                    }
                    if (($model->deposite_amount - ($model->refunded + $model->other_charges + $model->cancellation_charges)) != 0) {
                        return array('errors' => array('Refund not completed. Please make refund'));
                    }
                    $model->picked_up = 1;
                }
                $model->customer_id = $customer_model->id;
                $model->encryted_id = $this->generateRandomString();
                $model->booking_date = $this->dateFormat($model->booking_date);
                $model->pickup_date = ($model->pickup_date != '') ? $this->dateFormat($model->pickup_date) : null;
                $model->return_date = ($model->return_date != '') ? $this->dateFormat($model->return_date) : null;
                $model->payment_status = (($model->net_value - $model->paid_amount) == 0);
                $model->earning_amount = $model->net_value - $model->deposite_amount;
                // print_r($model);die;
                if (!$flag = $model->save()) {
                    $transaction->rollBack();
                    return array('errors' => $model->errors);
                }
                $item_no = 10;
                foreach ($booking_items as $key => $booking_item) {
                    $booking_item->booking_id = $model->booking_id;
                    $booking_item->item_no = $item_no;
                    $booking_item->pickup_date = $model->pickup_date;
                    $booking_item->return_date = $model->return_date;
                    $booking_item->earning_amount = $booking_item->net_value - $booking_item->deposit_amount;
                    if ($picked_status) {
                        $booking_item->pickup_date = date('Y-m-d');
                        $booking_item->item_status = 'Picked';
                        //$this->updateRentCount($booking_item->product_id);
                    }
                    if ($complete_order) {
                        $booking_item->return_date = date('Y-m-d');
                        $booking_item->item_status = 'Returned';
                        //$this->updateRentCount($booking_item->product_id);
                    }
                    $check_booking_status = $this->checkBooking($booking_item->product_id, $booking_item->pickup_date, $booking_item->return_date);
                    //print_r($check_booking_status);die;
                    if ($check_booking_status['flag']) {
                        return array('errors' => $check_booking_status['errors']);
                    }
                    if (!$flag = $booking_item->save()) {
                        $transaction->rollBack();
                        return array('errors' => $booking_item->errors);
                    }

                    /* $summary=$this->bookingSummary($booking_item,$model->pickup_date);
                     if(!$flag=$summary->save()){
                          $transaction->rollBack();
                        return array('errors'=>$summary->errors);
                     }*/
                    $item_no += 10;
                }
                // echo $no_payment;
                // print_r($payment_models);die;
                if ($no_payment) {
                    foreach ($payment_models as $key => $payment_item) {
                        if ($payment_item->payment_id != "") {
                            $payment_retr = PaymentMaster::find()->where(['payment_id' => $payment_item->payment_id])->one();
                            $payment_retr->date = $payment_item->date;
                            $payment_retr->type = $payment_item->type;
                            $payment_retr->mode_of_payment = $payment_item->mode_of_payment;
                            $payment_retr->received_by = $payment_item->received_by;
                            $payment_retr->received_during = $payment_item->received_during;
                            $payment_retr->dom = $payment_item->dom;
                            $payment_retr->amount = $payment_item->amount;
                            $payment_retr->remark = $payment_item->remark;
                            $payment_retr->booking_id = $model->booking_id;
                            $payment_retr->sendto = $payment_item->sendto;
                            if (!$flag = $payment_retr->save()) {
                                $transaction->rollBack();
                                return array('errors' => $payment_retr->errors);
                            }
                        } else {
                            $payment_item->booking_id = $model->booking_id;
                            // $payment_item->item_no=$item_no;
                            //print_r($payment_item);die;
                            if (!$flag = $payment_item->save()) {
                                $transaction->rollBack();
                                return array('errors' => $payment_item->errors);
                            }
                        }
                        // print_r($payment_item);die;
                    }
                }
                if ($flag) {

                    $update_summary = $this->updateSummary($model->pickup_date);
                    if (!$flag = $update_summary['flag']) {
                        return array('errors' => $update_summary['errors']);
                    }
                    $update_summary_item = $this->updateItemSummary($model->pickup_date);
                    if (!$flag = $update_summary_item['flag']) {
                        return array('errors' => $update_summary_item['errors']);
                    }
                }
                if ($flag) {
                    //  print_r(array()); echo "success";die;
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Your message to display.");
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "faild to save.");
                }
                if ($send_invoice == 1) {
                    $this->sendInvoice($model);
                }
                return $this->redirect(['update', 'id' => $model->booking_id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'address_grup' => $address_grup,
            'booking_items' => $booking_items,
            'customer_model' => $customer_model,
            'payment_models' => $payment_models,

        ]);
    }

    public function actionGetWhatsapp()
    {
        $booking_id = $_POST['booking_id'];
        $booking_header = BookingHeader::find()->where(['booking_id' => $booking_id])->one();
        $customer_model = $booking_header->customer;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($customer_model != null) {
            if ($customer_model->email_id != '') {
                //$this->sendemail($booking_header);
            }
            if ($customer_model->contact_nos != '') {
                // $message="Thanks ".$customer_model->name." for shopping with Panache Rental Boutique. Your order of Rs.".round($booking_header->net_value)."\nRent-Rs.".round($booking_header->rent_amount)."\nDeposit-Rs.".round($booking_header->deposite_amount)."";
                $message = "Thanks " . $customer_model->name . " for shopping with Panache Rental Boutique. Your order of Rs." . round($booking_header->net_value) . " Booked.\n For invoice please check " . $this->short_url($booking_header->encryted_id) . " ";
                /* if($booking_header->discount!=0){
                 $message.="\nDiscount-Rs.".round($booking_header->discount);
             }*/
                // $message.="\nPaid-Rs.".round($booking_header->paid_amount)."\nReturn date: ".date_format(date_create($booking_header->return_date),'d-m-y')."\nNote:Please Return on given date or you will be charged extra per day.\n\n";
                $message .= "\nPaid-Rs." . round($booking_header->paid_amount) . "\nReturn date: " . date_format(date_create($booking_header->return_date), 'd-m-y') . "\nNote:Please Return on given date or you will be charged extra per day.\n\n";
                // echo $this->short_url($booking_header->encryted_id);die;
                // $this->sendSMS($customer_model->contact_nos,$message);
                return array('message' => $message, 'contact_nos' => "91" . $customer_model->contact_nos);
            }
        }
    }

    public function updateRentCount($item_id)
    {
        $item_master = ItemMaster::find()->where(['id' => $item_id])->one();
        //print_r($item_master);die;
        $item_master->rent_times += 1;
        $item_master->save();
    }

    public function sendInvoice($booking_header)
    {
        $customer_model = $booking_header->customer;
        if ($customer_model != null) {
            if ($customer_model->email_id != '') {
                //$this->sendemail($booking_header);
            }
            if ($customer_model->contact_nos != '') {
                // $message="Thanks ".$customer_model->name." for shopping with Panache Rental Boutique. Your order of Rs.".round($booking_header->net_value)."\nRent-Rs.".round($booking_header->rent_amount)."\nDeposit-Rs.".round($booking_header->deposite_amount)."";
                $message = "Thanks " . $customer_model->name . " for shopping with Panache Rental Boutique. Your order of Rs." . round($booking_header->net_value) . " Booked.\n For invoice please check " . $this->short_url($booking_header->encryted_id) . " ";
                /* if($booking_header->discount!=0){
                 $message.="\nDiscount-Rs.".round($booking_header->discount);
             }*/
                // $message.="\nPaid-Rs.".round($booking_header->paid_amount)."\nReturn date: ".date_format(date_create($booking_header->return_date),'d-m-y')."\nNote:Please Return on given date or you will be charged extra per day.\n\n";
                $message .= "\nPaid-Rs." . round($booking_header->paid_amount) . "\nReturn date: " . date_format(date_create($booking_header->return_date), 'd-m-y') . "\nNote:Please Return on given date or you will be charged extra per day.\n\n";
                // echo $this->short_url($booking_header->encryted_id);die;
                $this->sendSMS($customer_model->contact_nos, $message);

            }
        }
    }

    public function updateSummary($pickup_date)
    {
        //echo $month;die;
        $time = strtotime($pickup_date);
        $month = date("m", $time);
        $year = date("Y", $time);
        $booking_header = BookingHeader::find()->select(['sum(rent_amount) as total_rent', 'sum((paid_amount-rent_amount -refunded)) as total_pending', 'count(*) as number_invoice'])->where(['order_status' => array('Open', 'Closed', 'Cancelled')])->andWhere('DATE_FORMAT(pickup_date, "%m-%Y") = "' . $month . '-' . $year . '"')->andWhere(['IS NOT', 'pickup_date', null])->groupBy(["DATE_FORMAT(pickup_date,'%m-%Y')"])->createCommand()->queryOne();
        //print_r($booking_header);die;
        if ($booking_header != null) {
            $booking_summary = BookingSummary::find()->where(['month' => $month, 'year' => $year])->one();
            if ($booking_summary != "") {
                $booking_summary->amount = $booking_header['total_rent'];
                $booking_summary->number_invoice = $booking_header['number_invoice'];
                $booking_summary->pending_amount = ($booking_header['total_pending']) * -1;
            } else {
                $booking_summary = new  BookingSummary();
                $booking_summary->amount = $booking_header['total_rent'];
                $booking_summary->number_invoice = $booking_header['number_invoice'];
                $booking_summary->pending_amount = ($booking_header['total_pending']) * -1;
                $booking_summary->month = $month;
                $booking_summary->year = $year;
            }
            $flag = $booking_summary->save();


            return array('errors' => $booking_summary->errors, 'flag' => $flag);
        } else {
            return array('errors' => array(), 'flag' => true);
        }
    }

    public function updateItemSummary($pickup_date)
    {
        //echo $month;die;
        $time = strtotime($pickup_date);
        $month = date("m", $time);
        $year = date("Y", $time);
        $booking_items = BookingItem::find()->select(['sum(amount) as total_rent', 'count(*) as number_of_time_rented', 'item_category', 'item_type'])->where(['item_status' => array('Booked', 'Picked', 'Returned')])->andWhere('DATE_FORMAT(pickup_date, "%m-%Y") = "' . $month . '-' . $year . '"')->groupBy(["item_category", "item_type", "DATE_FORMAT(pickup_date,'%m-%Y')"])->createCommand()->queryAll();
        $flag = true;
        ItemSummary::deleteAll(['month' => $month, 'year' => $year]);
        foreach ($booking_items as $booking_item) {
            $item_summary = ItemSummary::find()->where(['month' => $month, 'year' => $year, 'item_type' => $booking_item['item_type'], 'item_category' => $booking_item['item_category']])->one();
            if ($item_summary != "") {
                $item_summary->rent_amount = $booking_item['total_rent'];

                $item_summary->number_of_time_rented = ($booking_item['number_of_time_rented']);
            } else {
                $item_summary = new  ItemSummary();
                $item_summary->item_type = $booking_item['item_type'];
                $item_summary->item_category = $booking_item['item_category'];
                $item_summary->rent_amount = $booking_item['total_rent'];

                $item_summary->number_of_time_rented = ($booking_item['number_of_time_rented']);
                $item_summary->month = $month;
                $item_summary->year = $year;
            }
            if (!$flag = $item_summary->save()) {
                return array('errors' => $item_summary->errors, 'flag' => $flag);
            }
        }

        return array('errors' => array("Failed to entry of item summary"), 'flag' => $flag);


    }


    public function actionDeliveryItem()
    {
        # code...
        Yii::$app->response->format = Response::FORMAT_JSON;
        $transaction = Yii::$app->db->beginTransaction();
        if (!isset($_POST['selection'])) {
            return array("errors" => array("No Item Selected."));
        }
        if (!isset($_POST['delivery_date']) || $_POST['delivery_date'] == "") {
            return array("errors" => array("Please Select date."));
        }
        $selected_items = $_POST['selection'];
        $pickup_date = $_POST['delivery_date'];
        $status = $_POST['item_status'];
        $booking_id = $_POST['booking_id'];
        $paid_amount = $_POST['BookingHeader']['paid_amount'];
        $refunded = $_POST['BookingHeader']['refunded'];
        $cancellation_charges = $_POST['BookingHeader']['cancellation_charges'];
        $other_charges = $_POST['BookingHeader']['other_charges'];
        $pending_amount = $_POST['BookingHeader']['pending_amount'];
        $model = $this->findModel($booking_id);
        $payment_models = $model->payment;
        $old_pick_up = $model->pickup_date;
        $payment_status = (($model->net_value - $paid_amount) == 0);
        if ($payment_models == null) {
            $payment_models = [new PaymentMaster()];
        }

        $oldIDs_payment = ArrayHelper::map($payment_models, 'payment_id', 'payment_id');
        $payment_models = DynamicFormsPaymentItems::createMultiple(PaymentMaster::classname());
        DynamicFormsPaymentItems::loadMultiple($payment_models, Yii::$app->request->post());
        array_shift($payment_models);
        $deletedIDs_payment = array_diff($oldIDs_payment, array_filter(ArrayHelper::map($payment_models, 'payment_id', 'payment_id')));
        $result_payment_item = array();
        $no_payment = false;

        if ((sizeof($payment_models) == 1) && ($payment_models[0]['amount'] != '')) {
            $result_payment_item = ActiveForm::validateMultiple($payment_models);
            $no_payment = true;
        }
        if (sizeof($payment_models) > 1) {
            $result_payment_item = ActiveForm::validateMultiple($payment_models);
            $no_payment = true;
        }

        // $all_validate=array_merge($result,$result_item,$result_cust,$result_payment_item);
        if ($result_payment_item != null) {
            //echo "<pre>";print_r( array('errors'=>$all_validate));die;
            return array('errors' => $result_payment_item);
        }
        if ($no_payment) {
            foreach ($payment_models as $key => $payment_item) {
                if ($payment_item->payment_id != "") {
                    $payment_retr = PaymentMaster::find()->where(['payment_id' => $payment_item->payment_id])->one();
                    $payment_retr->date = $payment_item->date;
                    $payment_retr->type = $payment_item->type;
                    $payment_retr->mode_of_payment = $payment_item->mode_of_payment;
                    $payment_retr->received_by = $payment_item->received_by;
                    $payment_retr->received_during = $payment_item->received_during;
                    $payment_retr->dom = $payment_item->dom;
                    $payment_retr->amount = $payment_item->amount;
                    $payment_retr->remark = $payment_item->remark;
                    $payment_retr->booking_id = $model->booking_id;
                    $payment_retr->sendto = $payment_item->sendto;
                    if (!$flag = $payment_retr->save()) {
                        $transaction->rollBack();
                        return array('errors' => $payment_retr->errors);
                    }
                } else {
                    $payment_item->booking_id = $model->booking_id;
                    // $payment_item->item_no=$item_no;
                    //print_r($payment_item);die;
                    if (!$flag = $payment_item->save()) {
                        $transaction->rollBack();
                        return array('errors' => $payment_item->errors);
                    }
                }
                // print_r($payment_item);die;
            }
        }
        //  print_r($_POST);die;
        // $booking_items=BookingItem::find()->where(['item_id'=>$selected_items])->all();
        // print_r($selected_items);die;
        if ($status != 'Picked') {
            BookingItem::updateAll(['return_date' => $this->dateFormat($pickup_date), 'item_status' => $status], ['item_id' => $selected_items, 'booking_id' => $booking_id]);
        } else {
            BookingItem::updateAll(['pickup_date' => $this->dateFormat($pickup_date), 'item_status' => $status], ['item_id' => $selected_items, 'booking_id' => $booking_id]);
        }
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
        $model->paid_amount = $paid_amount;
        $model->refunded = $refunded;
        $model->payment_status = $payment_status;
        $model->cancellation_charges = $cancellation_charges;
        $model->other_charges = $other_charges;
        $model->pending_amount = $pending_amount;
        if ($status != 'Picked') {
            $booking_items = BookingItem::find()->where(['booking_id' => $booking_id])->andWhere(['!=', 'item_status', 'Returned'])->all();
            //print_r($booking_items);die;
            if ($booking_items == null) {
                $temp_pay_status = true;
                if (($model->pending_amount) != 0) {
                    $temp_pay_status = false;
                    //return array('errors'=>array('Payment not completed. Please complete Payment'));
                }
                if (($model->deposite_amount - ($model->refunded + $model->other_charges + $model->cancellation_charges)) != 0) {
                    $temp_pay_status = false;
                    // return array('errors'=>array('Refund not completed. Please make refund'));
                }
                $model->status = 'Returned';
                $model->return_date = $this->dateFormat($pickup_date);
                if ($temp_pay_status) {
                    $model->order_status = 'Closed';
                }
                /*BookingHeader::updateAll(['order_status'=>'Closed',
                    'status'=>'Returned',
                    'payment_status'=>$payment_status,
                    'paid_amount'=>$paid_amount,
                    'returned_date'=>$this->dateFormat($pickup_date),
                    'refunded'=>$refunded],['booking_id'=>$booking_id]);*/
                foreach ($booking_items as $key => $booking_item) {
                    $this->updateRentCount($booking_item->product_id);
                }


            }
        } else {
            $booking_items = BookingItem::find()->where(['booking_id' => $booking_id])->andWhere(['!=', 'item_status', 'Picked'])->all();

            if ($booking_items == null) {
                $model->status = 'Picked';
                $model->picked_up = 1;
                $model->pickup_date = $this->dateFormat($pickup_date);
                /*  BookingHeader::updateAll(['status'=>'Picked',
                      'payment_status'=>$payment_status,
                  'paid_amount'=>$paid_amount,
                      'picked_date'=>$this->dateFormat($pickup_date),
                      'refunded'=>$refunded],['booking_id'=>$booking_id]);*/
            }
        }
        if (!$flag = $model->save()) {
            return array('errors' => $model->errors);
        }
        if ($flag) {

            $update_summary = $this->updateSummary($model->pickup_date);
            if (!$flag = $update_summary['flag']) {
                return array('errors' => $update_summary['errors']);
            }
            $update_summary_item = $this->updateItemSummary($model->pickup_date);
            if (!$flag = $update_summary_item['flag']) {
                return array('errors' => $update_summary_item['errors']);
            }

            if ($this->checkPickupChange($model->pickup_date, $old_pick_up)) {
                // echo $old_pick_up;die;
                $update_summary = $this->updateSummary($old_pick_up);
                if (!$flag = $update_summary['flag']) {
                    return array('errors' => $update_summary['errors']);
                }
                $update_summary_item = $this->updateItemSummary($old_pick_up);
                if (!$flag = $update_summary_item['flag']) {
                    return array('errors' => $update_summary_item['errors']);
                }
            }


        }


        if ($flag) {
            $transaction->commit();
        } else {
            return array('errors' => array('Failed to save'));
        }


        return true;
    }

    public function CustomerSave($customer = '', $created_on = '')
    {
        $customer_old = null;
        if ($customer->id != '') {
            $customer_old = CustomerMaster::find()->where(['id' => $customer->id, 'status' => 0])->one();

        }

        /* else if($customer->contact_nos!=''){
          $customer_old=CustomerMaster::find()->where(['contact_nos'=>$customer->contact_nos])->one();
          }*/
        if ($customer_old == null) {
            $customer->created_on = $this->dateFormat($created_on);
            return $customer;
        }
        $customer_old->reference = $customer_old->reference;
        $customer_old->cust_group = $customer->cust_group;
        $customer_old->address_group = $customer->address_group;
        $customer_old->contact_nos = $customer->contact_nos;
        $customer_old->email_id = $customer->email_id;
        $customer_old->name = $customer->name;
        return $customer_old;
    }

    public function actionCustomerAutocomplete()
    {
        if (isset($_GET['term'])) {
            $id = $_GET['id'];
            $customer_data = CustomerMaster::find()->select(['id', 'name', 'contact_nos', 'email_id', 'cust_group', 'address_group', 'reference'])->where(['like', 'id', $_GET['term']])->orWhere(['like', 'name', $_GET['term']])->orWhere(['like', 'contact_nos', $_GET['term']])->asArray()->limit(25)->all();
            $return_array = array();
            $return_array['id_pass'] = $id;
            $return_array['customer_data'] = $customer_data;
            echo json_encode($return_array);
        }
    }

    public function actionItemDetailsPopup()
    {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        if (isset($_POST['item_type'])) {
            $item_type = $_POST['item_type'];
        }
        //print_r( $_POST);die;
        $item_catgory = isset($_POST['item_catgory']) ? $_POST['item_catgory'] : '';

        $sales_items = new ItemSelection();
        if (isset($_POST['description']) && $_POST['description'] != '') {
            $sales_items->item_id = $_POST['item_id'];
            $sales_items->item_type = $_POST['item_type'];
            $sales_items->item_category = $_POST['item_category'];
            $sales_items->description = $_POST['description'];
            //  $sales_items->SERVICE_CATELOG_ID=isset($_POST['service_catelog_id'])?$_POST['service_catelog_id']:'';
            $cat_data = CategoryMaster::find()->all();
            $data = TypeMaster::find()->where(['category_id' => $sales_items->item_category])->all();
        } else {
            $sales_items->item_category = 2;
            $cat_data = CategoryMaster::find()->all();
            $data = TypeMaster::find()->where(['category_id' => $cat_data[1]])->all();
        }

        $listAll = (\yii\helpers\ArrayHelper::map($data, 'id', 'name'));
        $cat_listAll = (\yii\helpers\ArrayHelper::map($cat_data, 'id', 'name'));
        // print_r( $_POST['id']);die;
        return $this->renderAjax('centralize_form', ['modelItems' => $sales_items, 'listAll' => $listAll, 'id' => $id, 'cat_listAll' => $cat_listAll]);

    }

    public function actionGetType()
    {
        $out = [];
//print_r($_POST);die;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($_POST['cat_id'])) {

            // if ($parents != null) {
            $cat_id = $_POST['cat_id'];

            $out = TypeMaster::find()->select(['id', 'name'])->where(['category_id' => $cat_id])->all();
            $options = "";
            foreach ($out as $item_out) {
                $val = $item_out['id'];
                $options .= "<option value='" . $val . "'>" . $item_out['name'] . "</option>";

            }
            //  print_r($out);die;
// the getSubCatList function will query the database based on the
// cat_id and return an array like below:
// [
// ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
// ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
// ]
            return array('options' => $options, 'selected' => '');

            //  }
        }
        echo Json::encode(['options' => '', 'selected' => '']);
    }

    public function actionItemDetailsAutocomplete()
    {

        $id = $_GET['id'];
        $type = $_GET['type'];

        Yii::$app->response->format = Response::FORMAT_JSON;
        $item_details = ItemMaster::find()->select(['id', 'name', 'details', 'rent_amount', 'deposit_amount', 'category_id', 'images'])->where(['like', 'id', $_GET['term']])->orWhere(['like', 'name', $_GET['term']])->andWhere(['type_id' => $type, 'scrab_status' => 'No', 'delete_status' => 0])->asArray()->limit(25)->all();


        $return_array = array();
        $return_array['id_pass'] = $id;
        $return_array['type'] = $type;
        $return_array['item_details'] = $item_details;

        return $return_array;

    }

    /**
     * Updates an existing BookingHeader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionItemBookingDetails()
    {

        $model_attrib = new ItemMaster();


        if (isset($_POST['item_id'])) {
            $item_id = $_POST['item_id'];
        } else {
            $item_id = '';
        }


        //$storage_location = StorageLocation::find()->select(['STORAGE_LOCATION'])->where(['COMPANY_CODE' => $company_code,'Plant' => $plant])->asArray()->one();
        $item_data = ItemMaster::find()->where(['id' => $item_id])->one();
        // echo "<pre>";
        //print_r($company_code);die;

        $booking_item = BookingItem::find()->where(['product_id' => $item_id])->andWhere(['IN', 'item_status', array('Booked', 'Picked')])->all();
        $flag = 1;
        /*foreach ($booking_item as $key => $booking_im) {
            # code...
        }*/
        //echo "<pre>";print_r($booking_item);die;
        //$product_category = ($material_data['PRODUCT_CATEGORY']!='')?$this->gettreevalupdate($material_data['PRODUCT_CATEGORY']):'';
        return $this->renderAjax('non_stockable', ['model_attrib' => $model_attrib, 'item_data' => $item_data, 'flag' => $flag, 'booking_item' => $booking_item]);
    }

    public function actionCustomerDetails()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $customer_data = CustomerMaster::find()->where(['id' => $_GET['id']])->asArray()->one();
            /*  $booking_ids=BookingHeader::find()->select(['booking_id'])->where(['customer_id'=>$id])->asArray()->all();
              $bal_amount=PaymentMaster::find()->select(['sum(case when type="Return-Deposit" then amount else 0 end) as deposite_carry','sum(case when type="Return-Deposit" then 0 else amount end) as settled_carry'])->where(['mode_of_payment'=>'Carry_Frwd','booking_id'=>$booking_ids])->asArray()->one();*/
            //$final_amount=$this->getCustomerBal($id);
            $final_amount = 0;
            $customer_data['bal'] = $final_amount;
            echo json_encode($customer_data);
        }
    }

    public function bookingSummary($booking_item, $cal_date)
    {

        $date = date_create($cal_date);
        $month = date_format($date, 'm');
        $year = date_format($date, 'Y');
        $bookingSummary = BookingSummary::find()->where(['item_type' => $booking_item->item_type, 'item_category' => $booking_item->item_category, 'month' => $month, 'year' => $year])->one();
        if ($bookingSummary != null) {
            $bookingSummary->amount += $booking_item->amount;
        } else {
            $bookingSummary = new BookingSummary();
            $bookingSummary->item_category = $booking_item->item_category;
            $bookingSummary->item_type = $booking_item->item_type;
            $bookingSummary->amount = $booking_item->amount;
            $bookingSummary->month = $month;
            $bookingSummary->year = $year;

        }
        return $bookingSummary;
    }

    public function actionUpdate($id)
    {
        //$this->getattachmentPath("Test");
        $model = $this->findModel($id);
        //$this->sendInvoice($model);die;
        //print_r($_POST);die;
        $address_grup = ArrayHelper::map(AddressGroup::find()->all(), 'id', 'name');
        $booking_items = $model->bookingItems;
        $customer_model = $model->customer;
        $bal_amount = 0;
        $where_carry = ($model->order_status == 'Open') ? ['status' => 0] : ['settle_with_booking_id' => $model->booking_id];
        $payment_carry_frd = BookingCarryFrd::find()->select(['id', 'carry_return', 'carry_balance', 'total_bal'])->where(['customer_id' => $model->customer_id])->andWhere($where_carry)->asArray()->all();
        if ($model->order_status == 'Closed') {
            $model->open_balance = ($payment_carry_frd != null) ? $payment_carry_frd[0] : '';
        }
        $settle_carry_frd = BookingCarryFrd::find()->select(['id', 'carry_return', 'carry_balance', 'total_bal'])->where(['customer_id' => $model->customer_id, 'booking_id' => $model->booking_id])->asArray()->one();
        // $bal_amount=($model->order_status!='Closed')?$this->getCustomerBal($customer_model->id):0;
        $payment_models = $model->payment;
        $old_pick_up = $model->pickup_date;
        $model->cancel_flag = ($model->order_status == "Cancelled") ? 1 : 0;
        $model->picked_up = ($model->status == 'Picked') ? 1 : 0;
        if ($payment_models == null) {
            $payment_models = [new PaymentMaster()];
        }
        if ($model->load(Yii::$app->request->post())) {
            //print_r($model);die;
            $send_invoice = $_POST['booking_sms'];
            $picked_status = $model->picked_up;
            $complete_order = $model->complete_order;
            Yii::$app->response->format = Response::FORMAT_JSON;

            $cancel_status = $model->cancel_flag;
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
            $result_payment_item = array();
            $no_payment = false;
            if ((sizeof($payment_models) == 1) && ($payment_models[0]['amount'] != '')) {
                $result_payment_item = ActiveForm::validateMultiple($payment_models);
                $no_payment = true;
            }
            if (sizeof($payment_models) > 1) {
                $result_payment_item = ActiveForm::validateMultiple($payment_models);
                $no_payment = true;
            }
            //print_r($customer_model);die;
            $result = ActiveForm::validate($model);
            $result_cust = ActiveForm::validate($customer_model);
            $result_item = ActiveForm::validateMultiple($booking_items);
            $all_validate = array_merge($result, $result_item, $result_cust, $result_payment_item);
            if ($all_validate != null) {
                //echo "<pre>";print_r( array('errors'=>$all_validate));die;
                return array('errors' => $all_validate);
            } else {
                $flag = true;
                $transaction = Yii::$app->db->beginTransaction();
                $customer_model = $this->CustomerSave($customer_model, $model->booking_date);
                if (!$flag = $customer_model->save()) {
                    $transaction->rollBack();
                    return array('errors' => $customer_model->errors);
                }
                if ($picked_status) {
                    $model->status = 'Picked';
                }
                if ($complete_order) {
                    // print_r($model);die;
                    $model->status = 'Returned';
                    $model->order_status = 'Closed';
                    if (($model->pending_amount) != 0) {  // Old Logic ($model->net_value-$model->paid_amount)
                        return array('errors' => array('Payment not completed. Please complete Payment'));
                    }
                    if (($model->deposite_amount - ($model->refunded + $model->other_charges + $model->cancellation_charges)) != 0) {
                        return array('errors' => array('Refund not completed. Please make refund'));
                    }
                    $model->picked_up = 1;
                }
                $model->customer_id = $customer_model->id;
                $model->booking_date = $this->dateFormat($model->booking_date);
                $model->pickup_date = ($model->pickup_date != '') ? $this->dateFormat($model->pickup_date) : null;
                $model->return_date = ($model->return_date != '') ? $this->dateFormat($model->return_date) : null;
                $model->payment_status = (($model->net_value - $model->paid_amount) == 0);
                $model->earning_amount = $model->net_value - $model->deposite_amount;
                // print_r($model);die;
                if (!$flag = $model->save()) {
                    $transaction->rollBack();
                    return array('errors' => $model->errors);
                }
//print_r($model);die;
                if (!empty($deletedIDs)) {
                    // $this->unbookingSummary($deletedIDs);
                    BookingItem::deleteAll(['item_id' => $deletedIDs]);
                }
                if (!empty($deletedIDs_payment)) {
                    PaymentMaster::deleteAll(['payment_id' => $deletedIDs_payment]);
                }
                $item_no = 10;
                foreach ($booking_items as $key => $booking_item) {
                    $booking_item->deposite_charge_status = ($booking_item->deposite_charge_status == null) ? 0 : $booking_item->deposite_charge_status;
                    $booking_item->earning_amount = $booking_item->net_value - $booking_item->deposit_amount;
                    if ($booking_item->item_id == '') {
                        $booking_item->booking_id = $model->booking_id;
                        $booking_item->item_no = $item_no;
                        $booking_item->pickup_date = $model->pickup_date;
                        $booking_item->return_date = $model->return_date;
                        if ($picked_status) {
                            $booking_item->pickup_date = date('Y-m-d');
                            $booking_item->item_status = 'Picked';
                            // $this->updateRentCount($booking_item->product_id);
                        }
                        if ($complete_order) {
                            $booking_item->return_date = date('Y-m-d');
                            $booking_item->pickup_date = date('Y-m-d');
                            $booking_item->item_status = 'Returned';
                            //$this->updateRentCount($booking_item->product_id);
                        }
                        $check_booking_status = $this->checkBooking($booking_item->product_id, $booking_item->pickup_date, $booking_item->return_date, $model->booking_id);
                        //print_r($check_booking_status);die;
                        if ($check_booking_status['flag']) {
                            return array('errors' => $check_booking_status['errors']);
                        }

                        if (!$flag = $booking_item->save()) {
                            $transaction->rollBack();
                            return array('errors' => $model->errors);
                        }
                    } else {
                        if ($complete_order) {
                            $item_status = 'Returned';
                        } else {

                            $item_status = ($picked_status) ? 'Picked' : $booking_item->item_status;
                        }
                        $check_booking_status = $this->checkBooking($booking_item->product_id, $model->pickup_date, $model->return_date, $model->booking_id);
                        //print_r($check_booking_status);die;
                        if ($check_booking_status['flag']) {
                            return array('errors' => $check_booking_status['errors']);
                        }
                        BookingItem::updateAll([
                            'booking_id' => $model->booking_id,
                            'item_no' => $item_no,
                            'product_id' => $booking_item->product_id,
                            'net_value' => $booking_item->net_value,
                            'item_category' => $booking_item->item_category,
                            'item_type' => $booking_item->item_type,
                            'amount' => $booking_item->amount,
                            'earning_amount' => $booking_item->earning_amount,
                            'deposit_amount' => $booking_item->deposit_amount,
                            'deposite_charge_status' => $booking_item->deposite_charge_status,
                            'extra_per' => $booking_item->extra_per,
                            'pickup_date' => ($picked_status) ? date('Y-m-d') : $model->pickup_date,
                            'return_date' => ($complete_order) ? date('Y-m-d') : $model->return_date,
                            'item_status' => $item_status,
                            //'return_date' =>$booking_item->return_date,
                            //'returned_date' =>$booking_item->,
                            //'item_status' =>$booking_item->,
                            'note' => $booking_item->note,
                            'discount' => $booking_item->discount],
                            // 'deposite_status' =>$booking_item->,
                            //'payment_status' =>$booking_item->,
                            ['item_id' => $booking_item->item_id]);

                    }
                    /*$summary=$this->bookingSummary($booking_item,$model->pickup_date);
                     if(!$flag=$summary->save()){
                          $transaction->rollBack();
                        return array('errors'=>$summary->errors);
                     }*/
                    $item_no += 10;
                }


                if ($no_payment) {
                    foreach ($payment_models as $key => $payment_item) {
                        if ($payment_item->payment_id != "") {
                            $payment_retr = PaymentMaster::find()->where(['payment_id' => $payment_item->payment_id])->one();
                            $payment_retr->date = $payment_item->date;
                            $payment_retr->type = $payment_item->type;
                            $payment_retr->mode_of_payment = $payment_item->mode_of_payment;
                            $payment_retr->received_by = $payment_item->received_by;
                            $payment_retr->received_during = $payment_item->received_during;
                            $payment_retr->dom = $payment_item->dom;
                            $payment_retr->amount = $payment_item->amount;
                            $payment_retr->remark = $payment_item->remark;
                            $payment_retr->booking_id = $model->booking_id;
                            $payment_retr->sendto = $payment_item->sendto;
                            if (!$flag = $payment_retr->save()) {
                                $transaction->rollBack();
                                return array('errors' => $payment_retr->errors);
                            }
                        } else {
                            $payment_item->booking_id = $model->booking_id;
                            // $payment_item->item_no=$item_no;
                            //print_r($payment_item);die;
                            if (!$flag = $payment_item->save()) {
                                $transaction->rollBack();
                                return array('errors' => $payment_item->errors);
                            }
                        }
                        // print_r($payment_item);die;
                    }
                }
                if ($flag && $cancel_status) {


                    if ($model->status != 'Booked') {
                        return array('errors' => array('Booking is not available to cancel.'));
                    }
                    /*  if($model->order_status!='Open'){
                          return array('errors'=>array('Booking is not open to cancel.'));
                        }*/
                    $order_status = 'Cancelled';
                    $model->status = 'Returned';
                    $model->cancellation_charges = $model->paid_amount;
                    $model->order_status = $order_status;
                    $model->net_value = 0;
                    $model->extra_amount = 0;
                    $model->earning_amount = $model->cancellation_charges;
                    $model->rent_amount = 0;
                    $model->discount = 0;
                    // $model->deposite_amount=0;
                    // $model->order_status=$order_status;
                    //$model->reason= $reason;

                    if (!$flag = $model->save()) {
                        return array('errors' => $model['errors']);
                    }
                    BookingItem::updateAll(['item_status' => $order_status, 'net_value' => 0, 'earning_amount' => 0, 'amount' => 0, 'deposit_amount' => 0, 'discount' => 0, 'extra_per' => 0], ['booking_id' => $model->booking_id]);
                }

                if ($flag) {

                    $update_summary = $this->updateSummary($model->pickup_date);
                    if (!$flag = $update_summary['flag']) {
                        return array('errors' => $update_summary['errors']);
                    }
                    $update_summary_item = $this->updateItemSummary($model->pickup_date);
                    if (!$flag = $update_summary_item['flag']) {
                        return array('errors' => $update_summary_item['errors']);
                    }

                    if ($this->checkPickupChange($model->pickup_date, $old_pick_up)) {
                        // echo $old_pick_up;die;
                        $update_summary = $this->updateSummary($old_pick_up);
                        if (!$flag = $update_summary['flag']) {
                            return array('errors' => $update_summary['errors']);
                        }
                        $update_summary_item = $this->updateItemSummary($old_pick_up);
                        if (!$flag = $update_summary_item['flag']) {
                            return array('errors' => $update_summary_item['errors']);
                        }
                    }


                }


                if ($flag) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', "Your message to display.");
                    //Yii::$app->session->addFlash('success');
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', "faild to save.");
                }
                if ($send_invoice == 1) {
                    $this->sendInvoice($model);
                }
                return $this->redirect(['update', 'id' => $model->booking_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'booking_items' => $booking_items,
            'customer_model' => $customer_model,
            'payment_models' => $payment_models,
            'address_grup' => $address_grup,
            'bal_amount' => $bal_amount,
            'settle_carry_frd' => $settle_carry_frd,
            'payment_carry_frd' => $payment_carry_frd
        ]);
    }

    public function actionCarryFrd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : '';
        $carry_frd_id = isset($_GET['carry_frd_id']) ? $_GET['carry_frd_id'] : '';
        $carry_return_amt = 0;
        $bal_carry = 0;
        $total_bal = 0;
        $prev_bal = 0;
        $booking_header = BookingHeader::find()->where(['order_status' => 'Open', 'booking_id' => $booking_id])->one();
        if ($booking_header == null) {
            return array('errors' => ["Booking alreay settle please check"]);
        }
        if ($booking_header->status != 'Returned') {
            return array('errors' => ["Please complete return"]);
        }
        $carry_frd_details = BookingCarryFrd::find()->where(['status' => 0, 'id' => $carry_frd_id])->one();
        $transaction = Yii::$app->db->beginTransaction();
        if ($carry_frd_details != '') {
            $prev_bal = $carry_frd_details['total_bal'];
        }
        $payment_items = PaymentMaster::find()->select(["sum(case when (type='Return-Deposit'|| type='Return-Payment' || type='Cancel-Charge' || type='Other-Charges') then 0 else amount end) as paid", "sum(case when (type='Return-Deposit'|| type='Return-Payment') then amount else 0 end) as retrn_dep"])->where(['booking_id' => $booking_id])->createCommand()->queryOne();
        $carry_return_amt = $booking_header->deposite_amount - $payment_items['retrn_dep'];
        $bal_carry = $prev_bal + (($payment_items['paid'] - $booking_header->deposite_amount) - $booking_header->rent_amount);
        $total_bal = $bal_carry + $carry_return_amt;
        $forwrd_model = new BookingCarryFrd();
        $forwrd_model->booking_id = $booking_id;
        $forwrd_model->customer_id = $booking_header->customer_id;
        $forwrd_model->status = ($carry_return_amt == 0 && $bal_carry == 0 && $total_bal == 0) ? 1 : 0;
        $forwrd_model->carry_return = $carry_return_amt;
        $forwrd_model->carry_balance = $bal_carry;
        $forwrd_model->total_bal = $total_bal;
        $forwrd_model->created_at = date('Y-m-d');
        $forwrd_model->entry_time = date('h:m');
        $forwrd_model->created_by = '';
        $forwrd_model->settle_with = ($carry_frd_details != '') ? $carry_frd_details->id : null;
        if (!$forwrd_model->save()) {
            return array('errors' => $forwrd_model->errors);
        }

        if ($carry_frd_details != '') {
            $carry_frd_details->status = 1;
            $carry_frd_details->settle_with_booking_id = $booking_id;
            if (!$carry_frd_details->save()) {
                $transaction->rollBack();
                return array('errors' => $carry_frd_details->errors);
            }
        }
        $booking_header->order_status = 'Closed';
        $booking_header->payment_status = 1;
        $booking_header->carry_frwd_app = 1;
        if (!$booking_header->save()) {
            $transaction->rollBack();
            return array('errors' => $booking_header->errors);
        }
        $transaction->commit();
        return array('status' => 1);

    }

    public function actionGetBalance()
    {
        $customer_id = $_POST['customer_id'];
        $pending_bookings = BookingHeader::find()->where(['order_status' => 'Open', 'customer_id' => $customer_id])->all();
        $pending_amount_array = array();
        foreach ($pending_bookings as $key => $pending_booking) {
            # code...
            $payment_details = PaymentMaster::find()->where(['carry_frwd_bid' => $pending_booking->booking_id])->all();
            foreach ($payment_details as $key => $payment_detail) {
                # code...

            }
        }
    }

    public function getCustomerBal($id)
    {
        $prevoius_bal_list = BookingCarryFrd::find()->select(['carry_return', 'carry_balance', 'total_bal'])->where(['customer_id' => $id, 'status' => 0])->asArray()->all();


        $booking_headers = BookingHeader::find()->select(['booking_id'])->where(['customer_id' => $id])->asArray()->all();

        $credit_bal = 0;
        $deposit_balance = 0;
        foreach ($booking_headers as $booking_header) {
            $payment_details = PaymentMaster::find()->select(["booking_id", "sum(case when (type='Return-Deposit'|| type='Return-Payment' || type='Cancel-Charge' || type='Other-Charges') then 0 else amount end) as rec", "sum(case when (type='Return-Deposit'|| type='Return-Payment') then amount else 0 end) as rtn"])->where(['booking_id' => $booking_header->booking_id])->groupBy(["booking_id"])->createCommand()->queryAll();
            $credit_bal = $payment_details['rec'];
            $deposit_balance = $payment_details['rtn'];
            /* foreach ($payment_details as $payment){

             }*/
        }
        /* $bal_amount=PaymentMaster::find()->select(['sum(case when type="Return-Deposit" then amount else 0 end) as deposite_carry','sum(case when type="Return-Deposit" then 0 else amount end) as settled_carry'])->where(['mode_of_payment'=>'Carry_Frwd','booking_id'=>$booking_ids])->asArray()->one();
         $final_amount=$bal_amount['deposite_carry']-$bal_amount['settled_carry'];*/
        return $final_amount;
    }

    public function actionItemCheckAutocomplete()
    {

        //$id=$_GET['id'];
        // $type=$_GET['type'];

        Yii::$app->response->format = Response::FORMAT_JSON;
        $item_details = ItemMaster::find()->select(['id', 'name', 'details', 'rent_amount', 'deposit_amount', 'category_id', 'images'])->where(['like', 'id', $_GET['term']])->orWhere(['like', 'name', $_GET['term']])->asArray()->limit(25)->all();


        $return_array = array();

        $return_array['item_details'] = $item_details;

        return $return_array;

    }

    /**
     * Deletes an existing BookingHeader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function checkPickupChange($pickup_date, $old_pickup)
    {
        # code...
        $time = strtotime($pickup_date);
        $old_month_year = date("m-Y", $time);
        // $year=date("Y",$time);

        $time = strtotime($old_pickup);
        $month_year = date("m-Y", $time);
        //$year=date("Y",$time);

        return $old_month_year != $month_year;
    }

    public function actionDelete()
    {
        $id = $_POST['id'];
        $reason = $_POST['reason'];
        $flag = $_POST['flag'];
        $model = $this->findModel($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $transaction = Yii::$app->db->beginTransaction();
        $order_status = 'Deleted';
        if ($flag == 0) {

            if ($model->status != 'Booked') {
                return array('errors' => array('Booking is not available to cancel.'));
            }
            /*if($model->paid_amount!=0){
               return array('errors'=>array('Booking recived amount is not zero.'));
             }*/
            $order_status = 'Cancelled';
            $model->status = 'Returned';
            $model->cancellation_charges = $model->paid_amount;
        }
        if ($model->order_status != 'Open') {
            return array('errors' => array('Booking is not open to Delete.'));
        }


        $model->order_status = $order_status;
        $model->net_value = 0;
        $model->extra_amount = 0;
        $model->earning_amount = $model->cancellation_charges;
        $model->rent_amount = 0;
        $model->discount = 0;
        // $model->deposite_amount=0;
        // $model->order_status=$order_status;
        $model->reason = $reason;

        if (!$flag = $model->save()) {
            return array('errors' => $model['errors']);
        }
        BookingItem::updateAll(['item_status' => $order_status, 'net_value' => 0, 'amount' => 0, 'deposit_amount' => 0, 'discount' => 0, 'earning_amount' => 0, 'extra_per' => 0], ['booking_id' => $model->booking_id]);
        $update_summary = $this->updateSummary($model->pickup_date);
        if (!$flag = $update_summary['flag']) {
            return array('errors' => $update_summary['errors']);
        }
        $update_summary_item = $this->updateItemSummary($model->pickup_date);
        if (!$flag = $update_summary_item['flag']) {
            return array('errors' => $update_summary_item['errors']);
        }
        $transaction->commit();

        return $this->redirect(['index']);
    }

    public function getattachmentPath($html)
    {

        // $html = $_POST['html'];
        // $html = "<html><body><h1>Testing Printing</h1></body></html>";
        // echo $html;die;
        //  $filename="output.pdf";
        if (!is_dir("attatchment/prints")) {
            // $object_key= Yii::$app->request->post('Attatchment')['object_key'];
            $path = "attatchment/prints";
            \yii\helpers\FileHelper::createDirectory($path, $mode = 0777, $recursive = true);

        }

        $date = date('Y-m-d-h-i-s');
        $filename = (rand(10, 1000)) . $date . ".pdf";
        Yii::$app->html2pdf->convert($html)->saveAs("attatchment/prints/" . $filename);
        // print_r($filename);die;
        return "attatchment/prints/" . $filename;
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
        if (($model = BookingHeader::find()->where(['encryted_id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
