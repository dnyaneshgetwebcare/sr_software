<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */


?>
<style>
  .account-value {
    padding-left: 10px;
  }

  .pkg-link {
    text-decoration: underline;
    cursor: pointer;
  }

  .pkg-link:hover {
    text-decoration: underline;
  }

  .pay-now {
    font-size: 12px;
  }
</style>

<div class="row">
  <div class="col-lg-12">

    <table class="table table-bordered table-responsive">
      <tbody>
      <tr>
        <th class="account-heading control-label"><?= $model_labels->attributeLabels()['ACCOUNT_NAME'] ?></th>
        <td><span class="account-value"><?php echo $erp_company->company_name; ?></span></td>
      </tr>
      <tr>
        <th class="account-heading control-label"><?= $model_labels->attributeLabels()['PACKAGE_NAME'] ?>  </th>
        <td><span class="account-value"><?php echo $transaction->packageDetails->name; ?></span><a
            href="<?php echo Yii::getAlias('@web'); ?>/index.php?r=payment/payment" onclick="changePackage()"
            class="pull-right pkg-link"><?= $model_labels->attributeLabels()['CHANGE_PACKAGE'] ?></a></td>
      </tr>
      <tr>
        <th class="account-heading control-label"><?= $model_labels->attributeLabels()['ACCOUNT_STATUS'] ?> </th>
        <td><span
            class="account-value"><?php echo ($erp_company->subscription_status == 1) ? 'Active' : 'Deactive'; ?></span><a
            class="pull-right pkg-link"
            onclick="cancelSubscription('<?= $erp_company->subscription_status; ?>')"><?php echo ($erp_company->subscription_status == 1) ? $model_labels->attributeLabels()['DEACTIVE_SUBSCRIPTION'] : $model_labels->attributeLabels()['ACTIVE_SUBSCRIPTION']; ?></a>
        </td>
      </tr>
      <tr>
        <th class="account-heading control-label"> <?= $model_labels->attributeLabels()['NUMBER_OF_USERS'] ?>
        </th>
        <td><span class="account-value"><?php echo $user_config->user_limit; ?></span></td>
      </tr>
      <tr>
        <th class="account-heading control-label"> <?= $model_labels->attributeLabels()['COMPANY_LIMIT'] ?>
        </th>
        <td><span class="account-value"><?php echo $user_config->company_limit; ?></span></td>
      </tr>
      <tr>
        <th class="account-heading control-label"> <?= $model_labels->attributeLabels()['LAST_PAYMENT_DATE'] ?> </th>
        <td><span
            class="account-value"><?php echo date($this->context->date_format_php, strtotime($user_config->start_date)); ?></span>
        </td>
      </tr>
      <tr>
        <th
          class="account-heading control-label"> <?= $model_labels->attributeLabels()['NEXT_PAYMENT_DUE_DATE'] ?>  </th>
        <td><span
            class="account-value"><?php echo date($this->context->date_format_php, strtotime($user_config->end_date . ' +1 day')); ?></span>
        </td>
      </tr>
      <tr>
        <th class="account-heading control-label"><?= $model_labels->attributeLabels()['NEXT_PAYMENT_AMOUNT'] ?>
        </th>
        <td>
          <span class="account-value"><?php echo $transaction->packageDetails->amount; ?></span>
          <!-- <a href="<?php // echo Yii::getAlias('@web');?>/index.php?r=payment/payment"> -->
          <!-- <button type="button" class="btn btn-info pull-right pay-now"> -->
          <?php // $model_labels->attributeLabels()['PAY_NOW']?>
          <!-- </button>-->
          <!-- </a>  -->
        </td>
      </tr>
      </tbody>
    </table>

  </div>
</div>
<form action="index.php?r=payment/create-agreement" method="post" id="subscribe_form">
  <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
    <div class="row">
      <!-- Identify your business so that you can collect the payments. -->

      <input type="hidden" name="new_package_id" value="<?= $transaction->packageDetails->package_id ?>"
             id="new_package_id">
      <input type="hidden" name="id" value="<?= $transaction->packageDetails->paypal_id ?>" id="paypal_id">
      <input type="hidden" name="company_id" value="<?= $company_id; ?>" id="company_id">

    </div>
  </div>
  </div>

</form>

<script type="text/javascript">
  $(document).ready(function () {
    $('.modal-header').html("<span style='color:#3a3636;font-size:14px'><b>" + '<?= $model_labels->attributeLabels()['ACCOUNT_DETAILS']?>' + "</b><span style='margin-left:227px;cursor: pointer;' class='trans-details' onclick='transactionDetails()'><i class='glyphicon glyphicon-list-alt'></i> &nbsp;<a class=''><b class='acc-history-label'>" + '<?= $model_labels->attributeLabels()['TRANSACTION_DETAILS']?>' + "</b></a></span><button type='button' class='close' data-dismiss='modal' onclick='hide_footer()' aria-hidden='true'>×</button></span>");

    $(document).on("click", "#btn-confirm-cancel", function () {
      $('#purchase_search').show();
    });
  });

  /*function changePackage(){
     
      $.ajax({
              'url' : "<?php // echo Yii::$app->request->baseUrl.'/index.php?r=user/change-package'; ?>",
            'dataType' : 'html',     
             beforeSend: function(){
                $(".overlay").show();
              },
         complete: function(){
          $(".overlay").hide();
         },  
            'success' : function(data){        
                //$('#create-detail').html(data);
               // $(#pModal1).show();
              $('#pModal').modal('show');
            $('#modalContent').html(data);

            },
          error: function( jqXhr, textStatus, errorThrown ){
            //alert(errorThrown);
          }
       });
      }*/

  function hide_footer() {
    $('#purchase_search').show();
  };

  /*$(document).click(".modal-backdrop",function() {
    backdrop: 'static',
      keyboard: false
  });*/


  function transactionDetails() {
    $.ajax({
      'url': "<?php echo Yii::$app->request->baseUrl . '/index.php?r=user/transaction-details'; ?>",
      'dataType': 'html',
      beforeSend: function () {
        $(".overlay").show();
      },
      complete: function () {
        $(".overlay").hide();
      },
      'success': function (data) {
        //$('#create-detail').html(data);
        // $(#pModal1).show();
        $('#pModal_search').modal('show');
        $('#modalContent_search').html(data);
        $('#purchase_search').hide();
      }
    });
  }

  function cancelSubscription(val) {
    // alert(val);
    if (val == 0) {
      // alert('<?php //echo $model_labels->attributeLabels()['PLEASE_CONTACT_FOR_ACTIVATE_ACCOUNT']?>');
      if (confirm('<?= $model_labels->attributeLabels()['ARE_SURE_YOU_WANT_ACTIVATE_ACCOUNT']?>')) {
        $.ajax({
          'url': "<?php echo Yii::$app->request->baseUrl . '/index.php?r=user/activate-subscription'; ?>",
          'dataType': 'json',
          beforeSend: function () {
            $(".overlay").show();
          },
          complete: function () {
            $(".overlay").hide();
          },
          'success': function (data) {
            if (data['error']) {
              // alert(data['error']);
              $("#subscribe_form").submit();
            } else if (data) {
              alert("Your account has been Activated!");
              $('#pModal_search').modal('hide');

            }
            //$('#create-detail').html(data);
            // $(#pModal1).show();


          }
        });
      }
    } else {

      if (confirm('<?= $model_labels->attributeLabels()['ARE_SURE_YOU_WANT_DEACTIVATE_ACCOUNT']?>')) {
        $.ajax({
          'url': "<?php echo Yii::$app->request->baseUrl . '/index.php?r=user/cancel-subscription'; ?>",
          'dataType': 'json',
          beforeSend: function () {
            $(".overlay").show();
          },
          complete: function () {
            $(".overlay").hide();
          },
          'success': function (data) {
            if (data['error']) {
              alert(data['error']);
            } else if (data) {
              alert("Your account has been deactivated!");
              $('#pModal_search').modal('hide');

            }
            //$('#create-detail').html(data);
            // $(#pModal1).show();


          }
        });
      }
    }
  }
</script>