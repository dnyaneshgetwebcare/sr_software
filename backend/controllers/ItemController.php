<?php

namespace backend\controllers;

use app\models\ItemMasterImg;
use backend\models\CategoryMaster;
use backend\models\DisplayType;
use backend\models\OccationMaster;
use backend\models\TypeMaster;
use backend\models\VendorMaster;
use Yii;
use backend\models\ItemMaster;
use backend\models\BookingItem;
use backend\models\ColorMaster;
use backend\models\ItemMasterSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;

/**
 * ItemController implements the CRUD actions for ItemMaster model.
 * ALTER TABLE `item_master` ADD `occcasion_master` VARCHAR(500) NULL AFTER `nos_dry_cleaning`;
 * ALTER TABLE `item_master` ADD `display_type` VARCHAR(500) NULL AFTER `occasion_master`;
 */
class ItemController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'getimage-list', 'img-status', 'upload-mul', 'index', 'view', 'create', 'update', 'delete', 'vendor-list', 'get-type', 'file-upload', 'upload', 'remove', 'create-popup'],
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

    public function actionRemove()
    {

        /*if(!Yii::$app->user->can("create_company")){
            return array('errors'=>array($model_labels->attributeLabels()["NOT_ALLOW_TO_PERFORM_ACTION"]));
        }*/

        $rand_no = $_POST['logo'];


        $path = realpath(dirname(__FILE__) . '/../../img');


        if (file_exists($path . "\\" . $rand_no)) { //If File Exist at the path enter in loop
            unlink($path . "\\" . $rand_no); //Delete File
        }


    }


    public function actionUploadMul()
    {
        //print_r($_POST['']);die;
        // $json = file_get_contents('php://input');
// Converts it into a PHP object
        $data = $_POST;
        $item_id = $data['item_id'];
        $prev_nos_of_images = $data['nos_of_images'];
        //$data = json_decode($json, true);
        $file_name = $this->base64_to_jpeg($data['image_data'], $item_id);
        $item_imgs = new ItemMasterImg();
        $item_imgs->item_id = $item_id;
        $item_imgs->img_name = $file_name;
        $item_imgs->default_image =($prev_nos_of_images==0)?1:0;
        $item_imgs->save();
        if($prev_nos_of_images==0){
            ItemMaster::updateAll(['images'=>$file_name],['id'=>$item_id]);
        }
        return true;
    }

    function base64_to_jpeg($base64_string, $item_id)
    {
        $output_file = $item_id . '/';
        $output_path = '/uploads/' . $item_id . '/';
        //$output_file = Yii::getAlias('@web') . '\uploads';
        // open the output file for writing
        $data = explode(',', $base64_string);
        $file_ext_arr = explode('/', explode(';', $data[0])[0]);
        $file_ext = $file_ext_arr[1];
//print_r($file_ext);die;
        if (!file_exists(Yii::getAlias('@webroot') . $output_path)) {  // '/uploads/'
            mkdir(Yii::getAlias('@webroot') . $output_path, 0777, true);
        }
        $path = realpath(dirname(__FILE__) . '/../..' . $output_path);
        $get_next_imageno = true;
        while ($get_next_imageno) {
            $rand_no = rand(1, 99999);
            $get_next_imageno = file_exists($path . "\\" . $rand_no . "." . $file_ext);
            // $get_next_imageno=$this->getnext_img_id($rand_no);

        }

        $ifp = fopen($path . "\\" . $rand_no . "." . $file_ext, 'wb');
        $output_file .=  $rand_no . "." . $file_ext;
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>


        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, base64_decode($data[1]));

        // clean up the file resource
        fclose($ifp);

        return $output_file;
    }

    function actionGetimageList()
    {
        $item_id = $_POST['item_id'];
        $img_list = ItemMasterImg::find()->where(['item_id' => $item_id])->all();
        return $this->renderPartial('img_list', [
            'img_list' => $img_list
        ]);
    }

    public function actionImgStatus()
    {
        $flag = $_POST['req_flag'];  // delete || change status
        $item_id = $_POST['item_id'];
        $img_id = $_POST['img_id'];
        $item_images = ItemMasterImg::find()->where(['id' => $img_id])->one();
        $item_master = ItemMaster::find()->where(['id' => $item_id])->one();
        if ($flag == 'delete') {
            if ($item_images->default_image == 1) {
                $new_default = ItemMasterImg::find()->where(['!=', 'id', $img_id])->andWhere(['item_id' => $item_id])->one();
                if ($new_default != null) {
                    $item_master->images = $new_default->img_name;
                    $new_default->default_image = 1;
                    $new_default->save();
                } else {
                    $item_master->images = null;
                }
                $item_master->save();
            }
            $path = realpath(dirname(__FILE__) . '/../../uploads');
            $item_images->delete();
            if (file_exists($path . "\\" . $item_images->img_name)) {
                unlink($path . "\\" . $item_images->img_name);
            }
        } elseif ($flag == 'change') {
            $item_master->images = $item_images->img_name;
            $item_master->save();
            ItemMasterImg::updateAll(['default_image' => 0], ['item_id' => $item_id]);
            $item_images->default_image = 1;
            $item_images->save();
        }
        return true;
    }

    public function actionUpload()
    {

        /*if(!Yii::$app->user->can("create_company")){
            return array('errors'=>array($model_labels->attributeLabels()["NOT_ALLOW_TO_PERFORM_ACTION"]));
        }*/

        //define('SITE_ROOT', realpath(dirname(__FILE__)));
        $flag = isset($_POST['flag']) ? $_POST['flag'] : '';
        $path = realpath(dirname(__FILE__) . '/../../uploads');
        // print_r($path);
        if ((isset($_POST['old_file']) && $_POST['old_file'] != '') && file_exists($path . "\\" . $_POST['old_file'])) {
            unlink($path . "\\" . $_POST['old_file']);
        }

        $asset_path = realpath(dirname(__FILE__) . '/../../uploads');
        if (!file_exists(Yii::getAlias('@webroot') . '/uploads/')) {
            mkdir(Yii::getAlias('@webroot') . '/uploads/', 0777, true);
        }


        if ($flag == 1) {

            if (is_array($_FILES)) {
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $id = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1);
                    $sourcePath = $_FILES['file']['tmp_name'];
                    $get_next_imageno = true;
                    while ($get_next_imageno) {
                        $rand_no = rand(1, 99999);
                        $get_next_imageno = file_exists($path . "\\" . $rand_no . "." . $id);
                        // $get_next_imageno=$this->getnext_img_id($rand_no);

                    }

                    $targetPath = $asset_path . "\\" . $rand_no . '.' . $id;
                    // echo move_uploaded_file($sourcePath, $targetPath); die;
                    // echo $targetPath;die;
                    if (move_uploaded_file($sourcePath, $targetPath)) {
                        return $rand_no . '.' . $id;
                        //print_r($targetPath);
                    }
                }
            }
        } else {
            if (is_array($_FILES)) {
                //echo $_FILES['file']['tmp_name'];die;
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $id = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1);
                    $sourcePath = $_FILES['file']['tmp_name'];
                    $get_next_imageno = true;
                    while ($get_next_imageno) {
                        $rand_no = rand(1, 99999);
                        $get_next_imageno = file_exists($path . "\\" . $rand_no . "." . $id);
                        // $get_next_imageno=$this->getnext_img_id($rand_no);

                    }

                    $targetPath = $path . "/" . $rand_no . '.' . $id;

                    if (move_uploaded_file($sourcePath, $targetPath)) {

                        return $rand_no . '.' . $id;

                    }
                }
            }
        }
    }

    /**
     * Lists all ItemMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $type_master = ArrayHelper::map(TypeMaster::find()->all(), 'id', 'name');
        $model_category = ArrayHelper::map(CategoryMaster::find()->all(), 'id', 'name');
        $searchModel = new ItemMasterSearch();
        $searchModel->delete_status = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->pagination=false;
        $item_summary = ItemMaster::find()->select(['type_id', 'count(*) total_items'])->where(['scrab_status' => 'No', 'delete_status' => 0])->groupBy('type_id')->orderBy(['total_items' => SORT_DESC])->limit(10)->asArray()->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'type_master' => $type_master,
            'model_category' => $model_category,
            'dataProvider' => $dataProvider,
            'item_summary' => $item_summary,
        ]);
    }

    /**
     * Displays a single ItemMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $booking_items = BookingItem::find()->where(['product_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'booking_items' => $booking_items,
        ]);
    }

    public function actionFileUpload($value = '')
    {
        $target_dir = "uploads/" . $_POST['item_id'] . "/";
        //print_r($_FILES);die;
        $target_file = $target_dir . basename($_FILES["ItemMaster"]["name"]['images'][0]);
        $return_array = array();
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        if (move_uploaded_file($_FILES["ItemMaster"]["tmp_name"]['images'][0], $target_file)) {
            $return_array = array();
        } else {
            $return_array = array('error' => "Sorry, there was an error uploading your file.");
        }
        return json_encode($return_array);

    }

    /**
     * Creates a new ItemMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function dateFormat($request_date)
    {
        return ($request_date != '') ? date('Y-m-d', strtotime($request_date)) : '';
    }

    public function actionCreate()
    {
         //print_r($_POST['ItemMaster']['occcasion_master']);die;
        $model = new ItemMaster();
        $img_list = [new ItemMasterImg()];
        $model_category = ArrayHelper::map(CategoryMaster::find()->all(), 'id', 'name');
        // $model_type= ArrayHelper::map(TypeMaster::find()->all(),'id','name');

        $model_vendor = ArrayHelper::map(VendorMaster::find()->all(), 'id', 'name');
        $color_model = ArrayHelper::map(ColorMaster::find()->all(), 'id', 'name');
        $occasion_master = ArrayHelper::map(OccationMaster::find()->all(), 'id',function($model) { return $model['name'].' ('.$model['details_occ'].')';} );
        $display_type = ArrayHelper::map(DisplayType::find()->all(), 'id',function($model) { return $model['name'].' ('.$model['deatils_type'].')';} );
        $model->setScenario('create_new');
        if ($model->load(Yii::$app->request->post())) {
//rint_r($model);die;
            $path = realpath(dirname(__FILE__) . '/../../uploads');

            if ($_POST["delete_status"] == "1") {
                $model->images = "";
            }
            if (is_array($_FILES)) {
                if (isset($_FILES['fileToUpload'])) {
                    if (is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
                        $id = substr($_FILES['fileToUpload']['name'], strrpos($_FILES['fileToUpload']['name'], '.') + 1);
                        $sourcePath = $_FILES['fileToUpload']['tmp_name'];
                        $get_next_imageno = true;
                        while ($get_next_imageno) {
                            $rand_no = rand(1, 99999);
                            $get_next_imageno = file_exists($path . "\\" . $rand_no . "." . $id);
                            // $get_next_imageno=$this->getnext_img_id($rand_no);

                        }
                        //die;
                        $targetPath = $path . "/" . $rand_no . '.' . $id;

                        if (move_uploaded_file($sourcePath, $targetPath)) {

                            $model->images = $rand_no . '.' . $id;

                        }
                    }
                }
                //=$targetPath;
            }
            if($model->occasion_master!=''){
               $occ_str=  implode(',', $model->occasion_master);
               $model->occasion_master=$occ_str;
            }else{
                $model->occasion_master=null;
            }
             if($model->display_type!=''){
               $dis_str=  implode(',', $model->display_type);
               $model->display_type=$dis_str;
            }else{
                $model->display_type=null;
            }
            $model->item_code = $model->getNextCode();
            //print_r($model);die;
            $model->purchase_date = $this->dateFormat($model->purchase_date);
            if ($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'model_category' => $model_category,
            'model_vendor' => $model_vendor,
            'color_model' => $color_model,
            'occasion_master' => $occasion_master,
            'display_type' => $display_type,
            'img_list' => $img_list

        ]);
    }

    public function actionCreatePopup()
    {
        $model = new ItemMaster();
        $model_category = ArrayHelper::map(CategoryMaster::find()->all(), 'id', 'name');
        // $model_type= ArrayHelper::map(TypeMaster::find()->all(),'id','name');

        $model_vendor = ArrayHelper::map(VendorMaster::find()->all(), 'id', 'name');
        $color_model = ArrayHelper::map(ColorMaster::find()->all(), 'id', 'name');
        $id_pass = isset($_POST['id']) ? $_POST['id'] : null;
        if ($model->load(Yii::$app->request->post())) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validate($model);
            $all_validate = array_merge($result);
            if ($all_validate != null) {
                //echo "<pre>";print_r( array('errors'=>$all_validate));die;
                return array('errors' => $all_validate);
            } else {
                $path = realpath(dirname(__FILE__) . '/../../uploads');

                if ($_POST["delete_status"] == "1") {
                    $model->images = "";
                }
                if (is_array($_FILES)) {
                    if (isset($_FILES['fileToUpload'])) {
                        if (is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
                            $id = substr($_FILES['fileToUpload']['name'], strrpos($_FILES['fileToUpload']['name'], '.') + 1);
                            $sourcePath = $_FILES['fileToUpload']['tmp_name'];
                            $get_next_imageno = true;
                            while ($get_next_imageno) {
                                $rand_no = rand(1, 99999);
                                $get_next_imageno = file_exists($path . "\\" . $rand_no . "." . $id);
                                // $get_next_imageno=$this->getnext_img_id($rand_no);

                            }

                            $targetPath = $path . "/" . $rand_no . '.' . $id;

                            if (move_uploaded_file($sourcePath, $targetPath)) {

                                $model->images = $rand_no . '.' . $id;

                            }
                        }
                    }
                    //=$targetPath;
                }

                $model->item_code = $model->getNextCode();
                //print_r($model);die;
                $model->purchase_date = $this->dateFormat($model->purchase_date);
                if ($model->save()) {
                    if ($model['images']) {
                        $image_path = Yii::getAlias('@web') . '/uploads/' . $model['images'];


                    } else {
                        $image_path = Yii::getAlias('@web') . '/img/no-image.jpg';
                    }
                    return array(['flag' => true, 'item_id' => $model->id, 'id' => $id_pass, 'item_details' => $model->name, 'item_category' => $model->category_id, 'item_type' => $model->type_id, 'purchase_amount' => $model->purchase_amount, 'img_path' => $image_path]);
                } else {
                    return array(['flag' => fasle, 'id' => 0]);
                }
            }
        }

        return $this->renderPartial('create_popup', [
            'model' => $model,
            'model_category' => $model_category,
            'model_vendor' => $model_vendor,
            'color_model' => $color_model,
            'id_pass' => $id_pass,

        ]);
    }

    public function actionVendorList($q = null)
    {
        $query = VendorMaster::find()->where('name LIKE "%' . $q . '%"')
            ->orderBy('name');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['name']];
        }
        echo Json::encode($out);
    }

    /**
     * Updates an existing ItemMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_category = ArrayHelper::map(CategoryMaster::find()->all(), 'id', 'name');
        $img_list = ItemMasterImg::find()->where(['item_id' => $id, 'status' => 1])->all();
        // $model_type= ArrayHelper::map(TypeMaster::find()->all(),'id','name');
        $color_model = ArrayHelper::map(ColorMaster::find()->all(), 'id', 'name');
        $model_vendor = ArrayHelper::map(VendorMaster::find()->all(), 'id', 'name');
        $occasion_master = ArrayHelper::map(OccationMaster::find()->all(), 'id',function($model) { return $model['name'].' ('.$model['details_occ'].')';});
        $display_type = ArrayHelper::map(DisplayType::find()->all(), 'id',function($model) { return $model['name'].' ('.$model['deatils_type'].')';});
        if ($model->load(Yii::$app->request->post())) {
            $post_occ=isset($_POST['ItemMaster']['occasion_master'])?$_POST['ItemMaster']['occasion_master']:'';
            $post_dis=isset($_POST['ItemMaster']['display_type'])?$_POST['ItemMaster']['display_type']:'';
            $path = realpath(dirname(__FILE__) . '/../../uploads');

            if ($_POST["delete_status"] == "1") {
                $model->images = "";
            }
            if (is_array($_FILES)) {
                if(isset($_FILES['fileToUpload'])) {
                    if (is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
                        $id = substr($_FILES['fileToUpload']['name'], strrpos($_FILES['fileToUpload']['name'], '.') + 1);
                        $sourcePath = $_FILES['fileToUpload']['tmp_name'];
                        $get_next_imageno = true;
                        while ($get_next_imageno) {
                            $rand_no = rand(1, 99999);
                            $get_next_imageno = file_exists($path . "\\" . $rand_no . "." . $id);
                            // $get_next_imageno=$this->getnext_img_id($rand_no);

                        }

                        $targetPath = $path . "/" . $rand_no . '.' . $id;

                        if (move_uploaded_file($sourcePath, $targetPath)) {

                            $model->images = $rand_no . '.' . $id;

                        }

                    }
                }
            }
            //print_r($model);die;
              if($post_occ!=''){
               $occ_str=  implode(',', $model->occasion_master);
               $model->occasion_master=$occ_str;
            }else{
                $model->occasion_master=null;
            }
              if($post_dis!=''){
               $dis_str=  implode(',', $model->display_type);
               $model->display_type=$dis_str;
            }else{
                $model->display_type=null;
            }
            $model->purchase_date = $this->dateFormat($model->purchase_date);
            if ($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_category' => $model_category,
            'model_vendor' => $model_vendor,
            'color_model' => $color_model,
            'img_list' => $img_list,
            'occasion_master' => $occasion_master,
            'display_type' => $display_type,
        ]);
    }

    /**
     * Deletes an existing ItemMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete_status = 1;
        $model->save();
        return $this->redirect(['index']);
    }

    public function actionGetType()
    {
        $out = [];
//print_r($_POST);die;
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];

                $out = TypeMaster::find()->select(['id', 'name'])->where(['category_id' => $cat_id])->all();
                //  print_r($out);die;
// the getSubCatList function will query the database based on the
// cat_id and return an array like below:
// [
// ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
// ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
// ]
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    /**
     * Finds the ItemMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
