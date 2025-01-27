  <?php 
  use yii\helpers\Html;
use yii\widgets\ActiveForm;
  $form = ActiveForm::begin(['enableClientValidation'=>false,'options' => ['class' => 'disable-submit-buttons','onSubmit'=> 'return false']]);
  ?>
<style type="text/css">
  td,th{
    font-size: 15px; 
}

</style>
  <div class="col-lg-12 name_input_field search_field" id='<?php echo "itemselection-item_name";?>'>
                      <div class="col-lg-2 form-group">
                                                
                            <?php

                               echo $form->field($modelItems, "item_category")->dropdownlist($cat_listAll, ['encode' => false,'onchange'=>'change_cat(this.value,this.id)'])->label(false); ?>
                                 </div>
                              <div class="col-lg-2 form-group">
                                <?php 
                                  $update_edit_flag=($modelItems->item_type!='')?0:1;
                                 ($modelItems->item_type!='')?'':$modelItems->item_type='1';
                                     // $modelItems->item_type_temp= ($modelItems->item_type!='')?$modelItems->item_type:'PART';
                                      // $modelItems->material_no_temp= ($modelItems->material_no);?>                     
                            <?php

                               echo $form->field($modelItems, "item_type")->dropdownlist($listAll, ['encode' => false,'onchange'=>'change_btn(this.value,this.id)'])->label(false); ?>
                                 </div>
                         

           

                     <!--  <label class=" control-label col-lg-1">  <?= 'Item '?></label> -->
                        <div class="col-lg-6 name_input_field " style="padding-right:0px"> 
                           <?= $form->field($modelItems, "description")->textInput([ 'placeholder'=>"Select Item",'style'=>'border:1px solid #eee !important','maxlength' => true,'class'=>'form-control txt auto_search', 'onkeyup' => 'changeitemdetails(this.value,this.id)', 'autocomplete'=>"off"])->label(false); ?>
                           <?= $form->field($modelItems, "item_id")->hiddenInput(['maxlength' => true,'autocomplete'=>"off"])->label(false); ?>
                          
                             <?= $form->field($modelItems, "rent_amount")->hiddenInput(['maxlength' => true,'autocomplete'=>"off"])->label(false); ?>
                               <?= $form->field($modelItems, "deposit_amount")->hiddenInput(['maxlength' => true,'autocomplete'=>"off"])->label(false); ?>
                   
                          <i class="glyphicon glyphicon-menu-down items-icon"  onclick="changeitemdetails('','itemselection-description')" style="font-size: 11px;padding:5px;position: absolute;right:0;margin: 3px 60px 0 0"></i>
                          <span class="item_error" style="color: red;float: left"></span>  
                         
                       <div class='item_autocomplete' id='<?php echo "itemselection-suggesstion-itemdetail-box";?>'></div>                       
                       </div>
                         
                 

                          <?php


                       

              if($modelItems->description!=''){
                $label= 'UPDATE';
              }else{
                  $label= 'ADD';
              }?>
                              <div class="col-lg-1">
                            <div class="btn-group add_button btn" ><button type="button"  class="btn btn-info" style="padding:5px 8px 4px 8px;font-size: 12px" onclick="addText('<?= $id;?>')" data-toggle ="tooltip" data-placement="bottom"  title=<?= $label?> > 
                             <?= $label?></a></div>
                            </div> 
                           
                            <span class="glyphicon glyphicon-remove slider-close cancel_button pull-right" style="margin:7px 0px 10px 10px;cursor:pointer;color: #000000"></span>

                            </div>

                 

                   </div>
                      <div class="col-lg-12" id='<?php echo "itemselection-quantity_details";?>' class="other_quantity"></div> 
                         <?php ActiveForm::end(); ?>

    <script type="text/javascript">
var warehouse_val=$("#itemselection-warehouse").val();
function change_btn(value,id){
     
   var n = id.lastIndexOf('-');
   $("#"+id.substring(0,n+1)+'description').val('');
   $("#"+id.substring(0,n+1)+'material_no').val('');
      $("#"+id.substring(0,n+1)+'quantity_details').html('');

    var warehouse=("#"+id.substring(0,n+1)+'warehouse_div');
       $("#"+id.substring(0,n+1)+'tree_show').hide();
       $("#"+id.substring(0,n+1)+"service_code").val('');
       $("#"+id.substring(0,n+1)+"service_catelog_id").val('');
  // alert(id.substring(0,n+1)+'warehouse_div')
  if(value=='PART'){
    $(warehouse).show(); 
     $("#"+id.substring(0,n+1)+'warehouse').val(warehouse_val);
  }else{
     $(warehouse).hide();
      $("#"+id.substring(0,n+1)+'warehouse').val('');
  }
  // alert(value);
  if(value=='EXP'){
    $('.expense_category').show(); 
    $('#expense_des_div').addClass('col-lg-8 form-group'); 
    $('#expense_des_div').removeClass('col-lg-10 form-group');
  }else{
    $('.expense_category').hide();
    $('#expense_des_div').addClass('col-lg-10 form-group');
    $('#expense_des_div').removeClass('col-lg-8 form-group');       
  }
  if(value=='OTH' || value=='EXP'){
    $('.seach_button').hide();
    $('.add_button').show();
  }else{
    $('.seach_button').show();
      // changeitemdetails('',id);     
    }

  if($("#"+id.substring(0,n+1)+'item_type').val()=='SERV'){   
      $("#"+id.substring(0,n+1)+'tree_show').show();
  }  

  }

 function openDropdown(elementId) {
      var pos = $("#"+elementId).offset(); // remember position
            var len = $("#"+elementId).find("option").length;
                if(len > 20) {
                    len = 20;
                }
            $("#"+elementId).css("position", "absolute");
            $("#"+elementId).css("zIndex", 9999);
            $("#"+elementId).offset(pos);   // reset position
            $("#"+elementId).attr("size", len); // open dropdown
            // $("#"+elementId).unbind("focus", down);
            $("#"+elementId).focus();
 }
  $("#itemselection-item_type").change(function(){
     $(this).css("position", "static");
              $(this).attr("size", "1");  // close dropdown
   //            $(this).unbind("change", up);
   //            $(this).focus();

  });$("#itemselection-item_type").focusout(function(){
     $(this).css("position", "static");
              $(this).attr("size", "1");  // close dropdown
   //            $(this).unbind("change", up);
   //            $(this).focus();

  });
      $(document).ready(function(){
        // var event = new MouseEvent('mousedown');
        // if(<?php // $update_edit_flag;?>){
        //  openDropdown("itemselection-item_type");
        // }

        // $("#itemselection-item_type").simulate('mousedown');;
        if($('#itemselection-material_no').val()!=''){
        change_display_item_details();
      }
     $('.cancel_button').unbind().click(function(){
        $(".other_details_data").html('');
        $('.search_row').hide();
        $('.overlay-back').hide();
      });

      });

       function changeitemdetails(val,id_pass){
    var value = $("#itemselection-item_type").val();
    // $(label_name).find('.service_name').hide();
    // $(label_name).find('.'+value).show();

    if(value==''){
      alert("<?= 'PLEASE_SELECT_ITEM_TYPE';?>");

    }else{    
      

         $.ajax({
          url:"<?php echo \Yii::$app->getUrlManager()->createUrl('booking/item-details-autocomplete') ?>",
          dataType: 'json',
          type: 'get',
          data:{
            term:val,
            id:id_pass,
            type:value,
          },
          success: function( data, textStatus, jQxhr ){  
            var result1 =  "#itemselection-suggesstion-itemdetail-box";
            $(result1).show();
            var result2 = "#itemselection-description";
              var data_new= '<ul class="autocomplete add_new">';
              data_new+="<li value=''>"+'<?= 'SELECT'; ?>'+"</li>";

            //data_new+="<li value='Add New' onClick='opencreatepopup(\""+data['id_pass']+"\",\""+data['type']+"\")'><i class='fa fa-plus'></i> "+'<?php // 'ADD_NEW'; ?>'+"</li>";
           // console.log(data);
              for(i=0; i<data['item_details'].length; i++) {
                var image_name='img/no-image.jpg';
               // alert(data['item_details'][i]['images']!= '');
                if(data['item_details'][i]['images']!= ''){
                    image_name='uploads/'+data['item_details'][i]['images'];
                }
                
               var item_name = addslashes(data['item_details'][i]['name']);
                   data_new += '<li onClick="selectgoodservitem('+data['item_details'][i]['id']+',\''+item_name+'\',\''+id_pass+'\',\''+data['item_details'][i]['rent_amount']+'\',\''+data['item_details'][i]['deposit_amount']+'\',\''+data['item_details'][i]['category_id']+'\')"><img src="'+image_name+'" style="height: 70px;width: 70px;">'+data['item_details'][i]['id']+" - "+data['item_details'][i]['name']+'</li>';

              }
              data_new += '</ul>';     
       
             $(result1).html(data_new);
                // $(result2).prop('readonly',true);

             },
              error: function( jqXhr, textStatus, errorThrown ){
              //alert(errorThrown);
                   if(errorThrown=='Forbidden'){
                         alert("<?= 'YOU_DONT_HAVE_ACCESS';?>");
                        }
              //console.log( errorThrown );
              }
          });

      }
   
     
   }
  function change_cat(cat_id) {

        $.ajax({
            url:"<?php echo \Yii::$app->getUrlManager()->createUrl('booking/get-type') ?>",
            type: 'post',
         data:{
               cat_id:cat_id,
              },
            dataType:'json',
            beforeSend: function(){
                $(".overlay").show();
            },
            complete: function(){
                $(".overlay").hide();
            },
            success: function (data) {
                 console.log(data['options']);
                 $('#itemselection-item_type')
                  .empty()
                  .append(data['options']);
                  
                  change_btn($('#itemselection-item_type').val(),'itemselection-item_type');
            },
            error: function(jqXhr, textStatus, errorThrown ){
                // alert(errorThrown);
                if(errorThrown=='Forbidden'){
                    alert(YOU_DONT_HAVE_ACCESS);
                }
            }
        });
    }
    function opencreatepopup(id,val){
     // alert(val)
       $('.sidebar-modal .tab-content').html('');
            if (val=="PART"){
             var url= '<?php echo Yii::$app->request->baseUrl.'/index.php?r=material-goods-quick/create' ?>';
             var flag = 0;
            }
            else if(val=="SERV"){
              var url=  '<?php echo Yii::$app->request->baseUrl.'/index.php?r=material-service-quick/create' ?>';
              var flag = 0;
            }else if(val=="CONS"){
              var url=  '<?php echo Yii::$app->request->baseUrl.'/index.php?r=material-goods-quick/create' ?>';
              var flag = 1;
            }
        $.ajax({
             type: 'post',
              url:url,
              data:{
               mat_id:id,
               flag:flag,
               type:val,
              },
               success: function (data) {
                 // alert();
                  $('.sidebar-modal .tab-content').html(data);
                  $(".sidebar-modal").show('slide');            
                  $(".overlay-back").show(); 
               },
               error: function(jqXhr, textStatus, errorThrown ){
                          if(errorThrown=='Forbidden'){
                         alert("<?= 'YOU_DONT_HAVE_ACCESS';?>");
                        }
               }
            });
        }

 function selectgoodservitem(item_id,item_details,id,rent_amount,deposit_amount,item_category,flag=0) {



      $("#itemselection-description").val(item_details);     

 $('.item_error').html('');
      
      //var customer_id=$("#hidden_id").val();
       $("#itemselection-item_id").val(item_id);
        $("#itemselection-item_category").val(item_category);
       $("#itemselection-rent_amount").val(rent_amount);
       if(deposit_amount==null){
        $("#itemselection-deposit_amount").val("0");
       }
       $("#itemselection-deposit_amount").val(deposit_amount);
        var item_type=$("#itemselection-item_type").val();  
      // $(id).closest('.name_input_field').find('.item_error').html("");
  

      if(item_id==''){
        alert("PLEASE SELECT ITEM");
        return false;
      }
     var result1 =  "#itemselection-suggesstion-itemdetail-box";
     $(result1).hide();

 change_display_item_details();
 if(flag==1){
    $('.add_button').click();
 }
}

 function change_display_item_details(){

   
      var item_id= $("#itemselection-item_id").val();
      var item_type=$("#itemselection-item_type").val();
     // var plant=$("#itemselection-warehouse").val();

   var url='';

         url= '<?php echo Yii::$app->request->baseUrl.'/index.php?r=booking/item-booking-details' ?>';

   
     if(url!=''){
             $.ajax({
          url: url,
          type: 'post',  
          async:false, 
          data:{
              item_id:item_id,
           // plant:plant,
          },
            success: function (data) {                   

                     if(data!=null){                      
                        $("#itemselection-quantity_details").html(data);
                     }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                      if(errorThrown=='Forbidden'){
                         alert("<?= 'YOU_DONT_HAVE_ACCESS';?>");
                        }
            }

          });
       }
       return true;
}
       </script>