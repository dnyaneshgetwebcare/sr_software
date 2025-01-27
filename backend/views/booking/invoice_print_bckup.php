<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\CHtml;

?>
<style type="text/css">
  .main-header{
    display: none;
  }
  .main-sidebar{
    display: none;
  }
</style>

<div align="center" id="all_data" style="margin:0;padding:0;">
<div>
 
         <table style="width: 100%;vertical-align: top">
                <tr>     
                <td style="width: 50%">   
         <div>
          <?php //if($model_bill->cOMPANYCODE['COMPANY_LOGO']!=''){ ?>
             <span><img src="<?php echo 'img/logo.png' ?>" style="width: 150px"></span>
             <?php //} ?>
          <div> 
           <!--  <span style="font-size:24px;color: #272727 !important; font-family:'Arial Unicode MS, Sans-serif'">Panache Wears</span> -->
           </div>
         </div>
   
        </td>
          <td valign="center" style="width: 30%">
                    <span style="font-size: 15px; color:#98a9ad;text-transform: uppercase;font-family:'Arial Unicode MS, Sans-serif'"><strong>Invoice</strong></span>
                  </td>
        
                  <td  style="text-align: right; width: 20%"> 
                    <table style="width: 100%">
                      <tr>
                        <td ><strong style="font-size: 10px;font-family:'Verdana, Sans-serif';">Booking Date:</strong></td>
                        <td style=" text-align: left;"><span style="font-size: 10px;font-family:'Verdana, Sans-serif';"><?php echo Yii::$app->formatter->asDate($model['booking_date'], 'dd-MM-yyyy'); ?></span></td>
                          

                      </tr>  
                        <tr>
                        <td ><strong style="font-size: 10px;font-family:'Verdana, Sans-serif';">Pick Date:</strong></td>
                        <td style=" text-align: left;"><span style="font-size: 10px;font-family:'Verdana, Sans-serif';"><?php echo Yii::$app->formatter->asDate($model['pickup_date'], 'dd-MM-yyyy'); ?></span></td>
                      </tr> 
                       <tr>
                        <td ><strong style="font-size: 10px;font-family:'Verdana, Sans-serif';">Return Date:</strong></td>
                        <td style=" text-align: left;"><span style="font-size: 10px;font-family:'Verdana, Sans-serif';"><?php echo Yii::$app->formatter->asDate($model['return_date'], 'dd-MM-yyyy'); ?></span></td>
                          

                      </tr> 
                      <tr>
                        <td><strong style="font-size: 10px;font-family:'Verdana, Sans-serif';" align="right" >Invoice Nos.:</strong></td>
                        <td style="text-align: left;"> <span style="font-size: 10px;font-family:'Verdana, Sans-serif';"><?php echo "#".str_pad($model['booking_id'],10,"0",0);; ?></span>
                        </td>
                         
                      </tr>

                    </table>
                   </td>
                 </tr>
               </table>
     <span style="font-size: 12px">C-52, Navshantiniketan Hsg.Soc.,Sec. No. 29, Near D.Y. Patil College, Akurdi, Pune-411033.<br> Contact no: 9221414990/8237703030</span>
  <hr>

    <table>    
    <tr>
      <td colspan="10">&nbsp;</td>
    </tr>
  </table>
  <table style="width: 100%;vertical-align: top"> 
    <tr> 
      <td style="width: 100%;text-align: left;">
         <span style="font-size: 12px;font-family:'Arial Unicode MS, Sans-serif'"><b>Bill To:</b></span>
               <table style="border-collapse: collapse; text-align:left;width: 50%;margin-top: 10px;vertical-align: top;margin-bottom: 5px">                    
                    <tr>
                      <td style="border-bottom: 1px solid #ccc;padding:3px;border-right: 1px solid #ccc;border-left: 1px solid #ccc;border-top: 1px solid #ccc; "><strong style="font-size: 10px;font-family:'Verdana, Sans-serif';">Name</strong></td>
                      <td style="border-bottom: 1px solid #ccc;padding:3px;border-top: 1px solid #ccc;border-right: 1px solid #ccc;text-align: center;"><span style="font-size: 10px;font-family:'Verdana, Sans-serif';"><?php echo $business_partner['name'] ?></span></td>
                     
                       </tr>

                       <tr>
                      <td style="padding:3px;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;border-left: 1px solid #ccc;"><strong style="font-size: 10px;font-family:'Verdana, Sans-serif';">Contact:</strong></td>
                      <td style="padding:3px;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;text-align: center;"> <span style="font-size: 10px;font-family:'Verdana, Sans-serif';">
                    <?php echo $business_partner['contact_nos'];?> 

                     </span>
                  
                  </td>
                    </tr>
               
                   
           </table>
         
      </td>
</tr>
</table> 


  <table style=" border-collapse: collapse; width: 100%;border-top: 1px solid #ccc">
     <thead style="display: table-header-group;">
    <tr>
      <td style="background: #EFEFEF;color:#181818;padding:10px 5 5 10px;border-right: 1px solid #ccc; border-left: 1px solid #ccc"><strong style="font-size: 10px;font-family:'Times New Roman,Arial Unicode MS, Sans-serif';">#</strong></td>
      <td style="width: 250px;background: #EFEFEF;color:#181818;padding:10px 5 5 10px;border-right: 1px solid #ccc"><strong style="font-size: 10px;font-family:'Arial Unicode MS, Sans-serif';">Item Details</strong></td>
     
      <td style="width: 80px;background: #EFEFEF;color:#181818;padding:10px 5 5 10px;border-right: 1px solid #ccc"><strong style="font-size: 10px;font-family:'Arial Unicode MS, Sans-serif';">Rent Amount</strong></td>
      <td style="background: #EFEFEF;color:#181818;padding:10px 5 5 10px;border-right: 1px solid #ccc"><strong style="font-size: 10px;font-family:'Arial Unicode MS, Sans-serif';">Deposite Amount</strong></td>
      <td style="background: #EFEFEF;color:#181818;padding:10px 5 5 10px;border-right: 1px solid #ccc"><strong style="font-size: 10px;font-family:'Arial Unicode MS, Sans-serif';">Discount</strong></td>
      <td style="width: 80px;background: #EFEFEF;color:#181818;padding:10px 5 5 10px;border-right: 1px solid #ccc"><strong style="font-size: 10px;font-family:'Arial Unicode MS, Sans-serif';">Net Value</strong></td>
    </tr>
  </thead>
        <?php //$grand_subtotal=0;
              $grand_total=0;
              $grand_deposite=0;
              $grand_rent=0;
              $grand_discount=0;
          //  echo"<pre>"; print_r($item);
          foreach($item as $key => $data){ 
        // print_r($data->materialDetails);
            //$grand_subtotal+=$data->NET_PRICE*$data->QUANTITY;
            $grand_total+=$data->net_value;
            $grand_deposite+=$data->deposit_amount;
            $grand_discount+=$data->discount;
            $grand_rent+=$data->amount;
           // if($key%2==0) { ?>
    <tr>
      <td style="background:  #FFF;padding:10px 5 5 10px;font-size: 10px;border-right: 1px solid #ccc ; border-left: 1px solid #ccc;border-bottom: 1px solid #ccc; ">
        <?php echo $key+1; ?>
      </td>
      <td style="width: 100px;background: #FFF;padding:10px 5 5 10px;font-size: 10px;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;">
        <?php echo  $data->item['name']; ?>
  
     
      </td>
      <td style="width: 80px;background: #FFF;padding:10px 5 5 10px;font-size: 10px;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc; font-family:'Verdana, Sans-serif';">
        <?php echo  number_format($data['amount'],2); ?>
      </td>
      <td style="width: 80px;background: #FFF;padding:10px 5 5 10px;font-size: 10px;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;">
        <?php  echo number_format($data['deposit_amount'],2); ?>
      </td>
      <td style="background: #FFF;padding:10px 5 5 10px;font-size: 10px;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;">
        <?php echo  number_format($data['discount'],2); ?>
      </td>
     
      <td style="width: 80px;background: #FFF;padding:10px 5 5 10px;font-size: 10px;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;">
        <?php echo number_format($data['net_value'],2) ?>
      </td>
    </tr>
       
        <?php 
    } ?>   
  </table>
 <!--  <table style="width: 100%;margin-top: 10px;border-collapse: collapse;vertical-align: top;margin-bottom: 5px">
    <tr>
      <td colspan="7" style="width: 100%">
      </td>
      <td colspan="2" style="width: 50%;text-align: right;"> -->
        <br>
                  <table style="width: 30%;border: 1px solid #ccc;padding:0px;border-collapse: collapse;" align="right" >
     <tr>
      <td style="background: #EFEFEF;color:#181818;font-size: 10px;font-family:'Arial,Arial Unicode MS, Sans-serif';padding:5px;border-bottom:  1px solid #ccc"><strong style="font-size: 10px;">Rent Amount: </strong></td>
      <td style="background: #EFEFEF;color:#181818;font-size: 10px;font-family:'Arial';padding:5px;border-bottom:  1px solid #ccc"><?=number_format($grand_rent,2)?></td>
      
    </tr>
    <tr>
     <td style="color:#181818;font-size: 10px;font-family:'Arial,Arial Unicode MS, Sans-serif';padding:5px;border-bottom:  1px solid #ccc"><strong style="font-size: 10px;">Deposite</strong></td>
      <td style="color:#181818;font-size: 10px;font-family:'Arial';padding:5px;border-bottom:  1px solid #ccc"><?=number_format($grand_deposite,2)?></td>
      
    </tr>
        <tr>
     <td style="background: #EFEFEF;color:#181818;font-size: 10px;font-family:'Arial,Arial Unicode MS, Sans-serif';padding:5px;border-bottom:  1px solid #ccc"><strong style="font-size: 10px;">Discount</strong></td>
      <td style="background: #EFEFEF;color:#181818;font-size: 10px;font-family:'Arial';padding:5px;border-bottom:  1px solid #ccc"><?= number_format($grand_discount,2) ?></td>
       
    </tr>
        <tr>
     <td  style="color:#181818;font-size: 10px;font-family:'Arial,Arial Unicode MS, Sans-serif';padding:5px;border-bottom:  1px solid #ccc"><strong style="font-size: 10px;">UnPaid</strong></td>
      <td style="color:#181818;font-size: 10px;font-family:'Arial,Arial Unicode MS, Sans-serif';padding:5px;border-bottom:  1px solid #ccc"><?=number_format(0,2) ?></td>
       
    </tr>
    <tr>
      <td style="background: #C4ECBA;color:#181818;font-size: 10px;font-family:'Arial,Arial Unicode MS, Sans-serif';padding:5px;border-bottom:  1px solid #ccc"><strong style="font-size: 10px;">Total</strong></td>
       <td style="background: #C4ECBA;color:#181818;font-size: 10px;font-family:'Arial,Arial Unicode MS, Sans-serif';padding:5px;border-bottom:  1px solid #ccc"><?= number_format($grand_total,2) ?></td>
        
    </tr>
  </table>

<!-- </td>
</tr>
  </table> -->
  <table style="width: 100%">
    <tr>
      <td>
        Terms And Conditions
      </td>
    </tr>
    <tr>
      <td style="">
        <span style="font-size: 10px">
          
          </span>
      </td>
    </tr>
  </table>
    <table> 
    <tr>
      <td colspan="10">&nbsp;</td>
    </tr>   
  </table>

</div>
</div>
<div style='position: absolute; bottom:0;right:0;'>
  <table style="width: 100%">
    <tr>
      <td></td>
      <td></td>
      <td colspan="5" style=" margin-top: 1px;margin-left: 20px"><span style="font-size: 10px;font-family:'Verdana, Sans-serif';"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span>
      </td>
      <td colspan="5"><span style="font-size: 10px;font-family:'Verdana, Sans-serif';text-align:right;margin-left: 20px"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Signature</strong></span></td>
    </tr>
  </table>
  <hr style="width: 90%">
  <table style="width: 100%">   
    <tr>
      <td colspan="10" style="text-align:center">
      <span style="font-size: 14px;color:#2A6578;font-weight: 600;font-family:'Verdana, Sans-serif'">Thank You</span>
      </td>
    </tr>
  </table> 
</div>
