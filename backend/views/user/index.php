<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'USERS';
// $this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .summary{
      display: none;
    }
    .grid-view td:nth-child(2) 
    {
      text-align: center;
      max-width:30px !important;
    }
</style>
<div class="user-index">
 <h5 class="page-header"><?= Html::encode($this->title) ?></h5>
<div class="tool" style="position: absolute;right:0;top:0;margin-right:20px;">
<div class="input-group input-group-lg">
  <div class="input-group-btn">   
      <li class="dropdown-hover">
    <a class="btn btn-warning dropdown-toggle pull-right hover-dropdown" data-toggle="dropdown"> <?= 'ACTION' ?>
    <span class="fa fa-caret-down"></span></a>
    <ul class="dropdown-menu pull-right">
      <li style="cursor: pointer;" onclick="create_user()"><a><img src="img/icons/plus.png" style="height:8px;margin-right:3px"> <?= 'ADD_USER'; ?></a></li>
    </ul>
  </li>
  </div>
</div>
</div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
    <div class="col-lg-12">
    <?php
    $view='VIEW_DOC';
    $change_pwd='CHANGE_PASSWORD';
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            /*[
              'label'=>'ADMIN',
              'attribute' =>'role',
              'filter'=>false,
              'format'=>'html', 
              'value' => function($model, $key, $index, $grid){
                if($model->role=='super_admin'){
                 return '<img src="img/icons/checked.png" style="height:18px">';
                }
              },   
              
            ],*/
            [
                'attribute'=>'username',
                'format' => 'raw',
                'value' => function($model, $key, $index, $grid)use($view){
                                return Html::a($model->username, ['user/update','id' =>$model->id], ['title' => $view,'class'=>'link_cust','oncontextmenu' => 'return false']);
                              },  

            
            ],
            'name',
            [
              'attribute' =>'email',
              'label'=> 'EMAIL',
          ],

            [
               'class' => 'yii\grid\CheckboxColumn',
               'header' => 'INACTIVE',
               'checkboxOptions' => function($model) {               
                 if($model->status != 10){
                   return ['value' => $model->id, 'class' => 'checkbox', 'onclick' => 'js:deleteItems(this.value, this.checked)', 'checked' => true];
                 }else{
                   return ['value' => $model->id, 'class' => 'checkbox', 'onclick' => 'js:deleteItems(this.value, this.checked)'];
                 }
                },
          ],
             [
                // 'label' => '',
                'format' => 'raw',
                'value' => function($model, $key, $index, $grid) use($view,$change_pwd){
                                return Html::a($change_pwd, ['user/change-password','id' =>$model->id], ['title' => $view,'class'=>'link_password','oncontextmenu' => 'return false']);
                              },  
            ],
            [
                'label' =>'MANAGE',
                'format' => 'raw',
                'value' => function($model, $key, $index, $grid) use($view){
                                return Html::a('Manage', ['authentication/access','user_id' =>$model->id], ['title' => $view,'oncontextmenu' => 'return false']);
                              },  
            ],
            [
                'label' =>'DEFAULT',
                'format' => 'raw',
                'value' => function($model, $key, $index, $grid) use($view){
                                return Html::a('Default', ['user-default-config/user-config','user_id' =>$model->id], ['title' => 'User Config','oncontextmenu' => 'return false']);
                              },  
            ]
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'email:email',
            //'status',
            //'login_status',
            //'created_at',
            //'updated_at',
            //'company_setup',
            //'lang',
            //'date_format_pp',
            //'date_format_js',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
  </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('.link_cust').click(function(e){
         // $('.modal-footer').html('');
      e.preventDefault();   
           $.ajax({
        'type' : 'get',
        'url' : ($(this).attr('href')),
        'dataType' : 'html',       
        'success' : function(data){ 
         // var footer= $('.modal-footer').html();
         // $('.modal-footer').html(footer+'<button type="button" id="btn-confirm-change_password" class="btn btn-info confirm_save">Change Password</button>');
          $('#pModal_search').modal('show');
          $('#modalContent_search').html(data);

        },
               error: function( jqXhr, textStatus, errorThrown ){
                   if(errorThrown=='Forbidden'){
                       alert("<?= 'YOU_DONT_HAVE_ACCESS'; ?>");
                   }
               },
       });

      }); 
       $('.link_password').click(function(e){
        //alert();
        flag = 1;
        // alert($(this).attr('href'));
      e.preventDefault();   
           $.ajax({
        'type' : 'get',
        'url' : ($(this).attr('href')),
        'dataType' : 'html',       
        'success' : function(data){ 
      // $('#pModal').modal('');
            //$('#create-detail').html(data);
           // $(#pModal1).show();
        $('#pModal_search').modal('show');
        $('#modalContent_search').html(data);

        },
               error: function( jqXhr, textStatus, errorThrown ){
                   form_submit=false;
                   if(errorThrown=='Forbidden'){
                       alert("<?= 'YOU_DONT_HAVE_ACCESS'; ?>");
                   }
               },
       });
  
      }); 
});

  $('.hover-dropdown').on('click',function() {
        $('.dropdown-hover .dropdown-menu').toggle();
      });

function create_user(){
  $.ajax({
    url: '<?php echo Yii::$app->request->baseUrl.'/index.php?r=user/signup' ?>',
    type: 'post',
    // data:{
    //   temp_units_id:id,
    // },
    
      success: function (data) {
        $('#pModal_search').modal('show');
        $('#modalContent_search').html(data);
      },
      error: function( jqXhr, textStatus, errorThrown ){
                  // alert(errorThrown);
                    if(errorThrown=='Forbidden'){
                         alert("<?= 'YOU_DONT_HAVE_ACCESS' ?>");
                        }
      }
    });
        // window.location.href='<?php echo(Yii::$app->request->baseUrl.'/index.php?r=user/signup') ?>';
}
function deleteItems(id, checked){
  var message;
  if(checked==true){
    message = "<?= 'DO_YOU_WANT_TO_INACTIVE_USER' ?>";
  }else{
    message = "<?= 'DO_YOU_WANT_TO_ACTIVE_USER' ?>";
  }
  var r = confirm(message);
  if (r == true) {
    $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl.'/index.php?r=user/delete' ?>',
        type: 'GET',
        data:{
          id:id,
          checked:Number(checked),
        },
        success: function( data, textStatus, jQxhr ){ 
            location.reload();  
        },
        error: function( jqXhr, textStatus, errorThrown ){
        }
      });
   }
   else{
     location.reload(); 
   }
  } 
</script>