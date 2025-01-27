 <?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FormulaMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Formula';
?>
<style type="text/css">
     
.form-group {
         margin-bottom: 0px;
     }
     
     .form-control {
         font-size: medium;
         font-weight: 500;
     }
     .control-label {
         font-size: small;
         font-weight: 500;
     }
  td,th{
    font-size: 15px; 
}

</style>
 <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?= Html::encode($this->title) ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Setting</a></li>
                <li class="breadcrumb-item active">Edit <?= Html::encode($this->title) ?></li>
            </ol>
        </div>
       
    </div>

    <div class="row">
                  
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Formula Table</h4>
                            
                                <div class="table-responsive">
                                    <table class="table color-bordered-table muted-bordered-table">
                                        <thead>
                                            <tr>
                                            	<th>Category</th>
                                            	<?php 
                                                $expense_per=0;
                                                $category_per=array();
                                                foreach ($model_reciver as $key => $value) {
                                                ?>
                                                
                                                <th><?= $value->name; ?></th>
                                                <?php } ?>
                                                
                                            </tr>
                                        </thead>
                                        <?php foreach ($model_category as $key_category => $value) {
                                               $category_per[$value->name]=0;
                                        	echo "<tr>";
                                        	echo '<td> '.$value->name.'</td>';
                                        	foreach ($model_reciver as $key_recv => $recv) {
                                        		# code...
                                                $rec_per=$recv->formula($value->id);
                                                if($recv->id==0){
                                                    $expense_per+=$rec_per;
                                                }else{
                                                 $category_per[$value->name]+=$rec_per;   
                                                }
                                                ?>
                                                <td>
                                                    <a style="color: #f62d51; text-decoration: underline;" onclick="open_update(<?= $recv->id; ?>,<?= $value->id; ?>)">
                                                    <?= $rec_per; ?></a>
                                                    <!-- <input type="text" id="customermaster-email_id" class="form-control text_first" name="formula[<?php // $key_recv; ?>][<?php // $key_category; ?>]" maxlength="150" placeholder="" autocomplete="off"> --> </td>
                                                <?php
                                        		
                                        	}
                                        	echo "</tr>";
                                        } ?>
                                    </table>
                                </div>
                                <hr>
                                         <div class="card-body m-b-20 m-t-10">
                                <div class="row">
                                    <div class="col-2">
                                        <h1><span id="turn_over_summary"><?= 100-$expense_per; ?> </span></h1>
                                        <h6 class="text-muted">Remaining Exp %</h6></div>
                                        <?php foreach($category_per as $key=> $category_per_total){
                                            ?>

                                        
                                    <div class="col-2">
                                        <h1><span id="expense_summary"><?= number_format(100-$category_per_total); ?> </span></h1>
                                        <h6 class="text-muted">Remaning <?= $key; ?></h6></div> 
                                  <?php  }  ?>
                                   <!--  <div class="col-3 align-self-center text-right">
                                        <button type="submit" class="btn btn-success">Post</button>
                                    </div> -->
                                </div>
                            </div>
                            <hr>
                            </div>
                        </div>
                    </div>
                </div>
<script type="text/javascript">
     function open_update(receiver_name,category_id) {
        $.ajax({
            url:"<?php echo \Yii::$app->getUrlManager()->createUrl('formula/update') ?>",
            type: 'get',
            data:{
                category_id:category_id,
                receiver_name:receiver_name

               },
            dataType:'html',
            beforeSend: function(){
                $(".overlay").show();
            },
            complete: function(){
                $(".overlay").hide();
            },
            success: function (data) {
                // console.log(data);
               
                $('#pModal').modal('show');
                $('#modalContent').html(data);

            },
            error: function(jqXhr, textStatus, errorThrown ){
                // alert(errorThrown);
                if(errorThrown=='Forbidden'){
                    alert(YOU_DONT_HAVE_ACCESS);
                }
            }
        });
    }
</script>