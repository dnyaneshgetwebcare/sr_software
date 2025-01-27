  <?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
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
                <li class="breadcrumb-item active">Caculate <?= Html::encode($this->title) ?></li>
            </ol>
        </div>
           <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-l-10 hidden-md-down">
                                <div class="chart-text">
                                   <div class="col-md-12">
                                     <div class="form-group">
                                       <?php $month_array=array("01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"June","07"=>"July","08"=>"Aug","09"=>"Sept","10"=>"Oct","11"=>"Nov","12"=>"Dec",);
                                       $year_array= range(date('Y')-5,date('Y')+1,1);
                                       $select_month=isset($_GET['month'])?$_GET['month']:date('m');
                                      // echo $select_month;die;
                                       $select_year=isset($_GET['year'])?$_GET['year']:date('Y');
                                       ?>
                                        <label class="control-label text-right col-md-2"></label> 
                                <div class="col-md-3"> 
                                       <select name="month" id='month' class="form-control">
                                          <option>Select Month</option>
                                         <?php foreach ($month_array as $key => $month) {
                                              ?> 
                                      <option value="<?= $key; ?>" <?= ($key==$select_month)?'selected':''; ?>><?= $month; ?>
                                      </option>
                                              <?php 
                                            } ?>
                                            
                                        </select>
                                    </div>
                                      <div class="col-md-3"> 
                                  <select name="year" id='year' class="form-control">
                                          <option>Select Month</option>
                                         <?php foreach ($year_array as $key => $year) {
                                              ?> 
                                      <option value="<?= $year; ?>" <?= ($year==$select_year)?'selected':''; ?>><?= $year; ?>
                                      </option>
                                              <?php 
                                            } ?>
                                            
                                        </select>
                                      </div>
                                      <div class="col-md-2"> 
                                        <button type="button" onclick="set_month_filter()"; class="btn btn-inverse">Apply</button>
                                      </div>
                                     
                                  </div>
                                  </div>
                              </div>
                            </div>
                          
                            
                          
                        </div>
                    </div>
    </div>
    <div class="row">
                  
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <?php
$form = ActiveForm::begin(['enableClientValidation'=>false,'id'=>'booking_header_form','action'=>"index.php?r=formula/save-calculate", 'options' => ['class' => 'disable-submit-buttons']]);
?>
                                <div class="col-md-12">

<div class="col-md-6">
<div class="form-group row">
 <label class="control-label text-left col-md-3" style="padding-right: 0px !important;padding-top: 10px;">Total Expense</label>
            <div class="col-md-5">
               <div class="form-group field-customermaster-contact_nos required">

<input type="text" id="total_expense" class="form-control text_first" name="total_expense" onkeyup="recalculat()" value="<?= $total_expense; ?>"  placeholder="Expense" autocomplete="off" aria-required="true">

<div class="help-block"></div>
</div>
</div>
    </div>
    </div>

       </div>
       <div class="row"> </div>
           <hr>
                     <h4 class="card-title">Calculation Table</h4>
                        
                                <div class="table-responsive">
                                    <table class="table color-bordered-table muted-bordered-table">
                                        <thead>
                                            <tr>
                                            	<th>Category</th>
                                                <th>Turnover</th>
                                          <th>Cat. Expense</th>
                                            	<?php 
                                                $reviver_array=array();
                                                $reciver_count=0;
                                                $total_turn_over=0;
                                                $total_cat_expense=0;
                                               
                                                foreach ($model_reciver as $key => $value) {
                                                    $reciver_count++;
                                                    $reviver_array[$value->id]=0;
                                                ?>
                                                
                                                <th><?= $value->name; ?></th>
                                                <?php }
                                                 $reviver_array[6]=0;
                                                 ?>
                                                
                                            </tr>
                                        </thead>
                                        <?php 
                                      $category_count=0;
                                        foreach ($model_category as $key_category => $value) {
                                           $category_count++;
                                        	echo "<tr>";
                                            echo '<td> '.$value->name.'</td>';
                                           $category_turn_over= $value->earningByCategory($select_month."-".$select_year);
                                           $category_expense=0;
                                               $reviver_array[6] += $category_turn_over;
                                               $total_turn_over+=$category_turn_over;
                                               $total_cat_expense+=$category_expense;
                                            ?> 

                                        	<td> <input style="width: 100px" type="text" id="total_<?= $value->id;?>" class="form-control text_first" onkeyup="recalculat()" value="<?= $category_turn_over;?>" name="Total[<?= $value->id;?>]"  placeholder="" autocomplete="off" aria-required="true"> </td>
                                          <td> <input style="width: 100px" type="text" id="cat_vis_expense_<?= $value->id;?>" class="form-control text_first" onkeyup="recalculat()" value="<?= $category_expense;?>" name="Total[<?= $value->id;?>]"  placeholder="" autocomplete="off" aria-required="true"> </td>
                                        
                                        
                                         <?php	foreach ($model_reciver as $key_recv => $recv) {
                                             $expense = $total_expense*($value->formula(0)/100);
                                             $expense= $expense+$category_expense;
                                            if($recv->id==0){
                                                  $reviver_array[$recv->id] += $expense;
                                                ?> 
                                           <td> 
                                            
                                         <?= "<span id='expense_amount_".$value->id."_".$recv->id."'>".number_format($expense)."</span>"; ?>
                                          <input type="hidden" id="expense_per_<?= $value->id.'_'.$recv->id ;?>" class="form-control text_first"  value="<?= $recv->formula($value->id); ?>"  placeholder="Expense" autocomplete="off" aria-required="true">
                                           </td>
                                                <?php
                                            }else{
                                                ?>
                                                <td>
                                                    <?php 
                                                    $earning_cat=(($recv->formula($value->id))/100)*($category_turn_over-$expense);
                                                    //$reviver_array[$value->id]=0;
                                                    $reviver_array[$recv->id] += $earning_cat;
                                                    echo "<span id='reciver_amount_".$value->id."_".$recv->id."'>".number_format($earning_cat)."</span>"; ?>
                                                    <input type="hidden" id="reciver_per_<?= $value->id.'_'.$recv->id ;?>" class="form-control text_first"  value="<?= $recv->formula($value->id); ?>"  placeholder="Expense" autocomplete="off" aria-required="true">
                                                     </td>
                                                <?php }
                                        		
                                        	}
                                        	echo "</tr>";
                                        } ?>
                                        <tr class="table-warning"> 
                                            <td>Total</td>
                                            <th style="font-size: 20px;">₹ <?= "<span id='reciver_total_amount_6'>".number_format($reviver_array[6])."</span>"; ?></th>
                                            <th style="font-size: 20px;">₹ <?= "<span id='total_category_expense'>".number_format($total_cat_expense)."</span>"; ?></th>
                                            <?php 
                                              foreach ($model_reciver as $key => $value) {
                                                ?>
                                                
                                                <th style="font-size: 20px;"> ₹ <?= "<span id='reciver_total_amount_".$value->id."'>".number_format($reviver_array[$value->id])."</span>"; ?></th>
                                                <?php } ?>
                                        </tr>
                                    </table>
                                </div>
<div>
                                <hr> </div>
                                <div class="card-body m-b-20 m-t-10">
                                <div class="row">
                                    <div class="col-3">
                                        <h1><span id="turn_over_summary">₹ <?= number_format($total_turn_over); ?> </span></h1>
                                        <h6 class="text-muted">Total Turn Over</h6></div>
                                    <div class="col-3">
                                        <h1><span id="expense_summary">₹ <?= number_format($total_expense); ?> </span></h1>
                                        <h6 class="text-muted">Total Expense</h6></div> 
                                        <div class="col-3">
                                        <h1><span id="total_earning">₹ <?= number_format($total_turn_over - $total_expense); ?> </span></h1>
                                        <h6 class="text-muted">Total Earning</h6></div>
                                   <!--  <div class="col-3 align-self-center text-right">
                                        <button type="submit" class="btn btn-success">Post</button>
                                    </div> -->
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
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
    var category_count=<?= $category_count; ?>;
    var reciver_count=<?= $reciver_count; ?>;
    function recalculat() {
        var total_expense=$('#total_expense').val();
        var total_turn_over=0;
        var cat_vise_total_expense=0;
        var categ_array=[0,0,0,0,0];
        for(var category_iterator=1; category_iterator<=category_count; category_iterator++ ){
            var category_turn_over=$('#total_'+category_iterator).val();
            var category_expense=$('#cat_vis_expense_'+category_iterator).val();
           // console.log("Turn Around"+category_turn_over);

            if(category_turn_over==""){
                    category_turn_over=0;
                 }
                 if(category_expense==""){
                    category_expense=0;
                 }

                 cat_vise_total_expense = +cat_vise_total_expense + +category_expense;
           total_turn_over = +total_turn_over + +category_turn_over;
            var expense_per=$('#expense_per_'+category_iterator+'_0').val();
           
                 if(total_expense==""){
                    total_expense=0;
                 }

                 var cat_expense_amount=(total_expense*(expense_per/100)).toFixed(2);
                 cat_expense_amount= +cat_expense_amount+ +category_expense;
               var cat_earning=category_turn_over-cat_expense_amount;
                 $("#expense_amount_"+category_iterator+'_0').html(cat_expense_amount);
                 categ_array[0]=  +categ_array[0] + +cat_expense_amount;
             for(var reciver_iterator=1; reciver_iterator<=reciver_count; reciver_iterator++ ){
                 var reciver_per=$('#reciver_per_'+category_iterator+'_'+reciver_iterator).val();
                 var cat_reciver_amount=(cat_earning*(reciver_per/100)).toFixed(2);

                  $("#reciver_amount_"+category_iterator+'_'+reciver_iterator).html(numberWithCommas(cat_reciver_amount));
                categ_array[reciver_iterator]= +categ_array[reciver_iterator] + +cat_reciver_amount;
           }
        }
//console.log(categ_array);
          $("#turn_over_summary").html(numberWithCommas(total_turn_over));
          
          $("#reciver_total_amount_6").html( numberWithCommas(total_turn_over));
          $("#total_category_expense").html( numberWithCommas(cat_vise_total_expense));
        for(var reciver_iterator=0; reciver_iterator<=reciver_count; reciver_iterator++ ){
            if(reciver_iterator==0){
                $("#expense_summary").html("₹ "+numberWithCommas(categ_array[reciver_iterator]));
                $("#total_earning").html("₹ "+numberWithCommas(total_turn_over-categ_array[reciver_iterator]));

            }

             $("#reciver_total_amount_"+reciver_iterator).html(numberWithCommas(categ_array[reciver_iterator]));
        }

    }
    function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function set_month_filter() {
var month=$('#month').val();
var year=$('#year').val();

 window.location.href = "<?= Url::base(); ?>/index.php?r=formula/calculate&month="+month+"&year="+year;
}
</script>