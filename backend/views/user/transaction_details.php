<style type="text/css">
  .modal-dialog {
    width: 70%;
  }
</style>
<div class="row">
  <div class="col-lg-12">
    <div class="table-responsive" style="height:370px">
      <table id="" class="table table-bordered">
        <thead>
        <tr>
          <th class="account-heading"><?= $model_labels->attributeLabels()['TRANSACTION_ID'] ?> </th>
          <th class="account-heading"><?= $model_labels->attributeLabels()['PAYMENT_DATE'] ?> </th>
          <th class="account-heading"><?= $model_labels->attributeLabels()['PAYMENT_TIME'] ?> </th>
          <th class="account-heading"><?= $model_labels->attributeLabels()['PACKAGE_NAME'] ?>  </th>
          <th class="account-heading"><?= $model_labels->attributeLabels()['TRANSACTION_STATUS'] ?> </th>
          <th class="account-heading"><?= $model_labels->attributeLabels()['PAYMENT_STATUS'] ?> </th>
          <th class="account-heading"><?= $model_labels->attributeLabels()['NUMBER_OF_USERS'] ?>  </th>
          <th class="account-heading"><?= $model_labels->attributeLabels()['PAYMENT_AMOUNT'] ?>  </th>
          <th class="account-heading"><?= $model_labels->attributeLabels()['VALIDITY'] ?>  </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($transactions as $trans) { ?>
          <tr>
            <td><span
                class="account-value"><?php echo ($trans->transaction_id == 0) ? '' : $trans->transaction_id; ?></span>
            </td>
            <td><span
                class="account-value"><?php echo date($this->context->date_format_php, strtotime($trans->date_of_payment)); ?></span>
            </td>
            <td><span class="account-value"><?php echo date('h:i:s a', strtotime($trans->date_of_payment)); ?></span>
            </td>
            <td><span class="account-value"><?php echo $trans->packageDetails->name; ?></span></td>
            <td><span class="account-value"><?php echo($trans->payment_status); ?></span></td>
            <td><span class="account-value"><?php echo($trans->transaction_status); ?></span></td>
            <td><span class="account-value"><?php echo $trans->packageDetails->user_limit; ?></span></td>
            <td><span class="account-value"><?php echo $trans->packageDetails->amount; ?></span></td>
            <td><span
                class="account-value"><?php echo $trans->packageDetails->validity . ' in ' . $trans->packageDetails->type; ?></span>
            </td>
          </tr>
        <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {


    $('.modal-header').html("<span style='color:#3a3636;font-size:14px'><b>" + '<?=$model_labels->attributeLabels()['TRANSACTION_HISTORY']?> ' + "</b><button type='button' class='close' data-dismiss='modal' onclick='hide_footer()' aria-hidden='true'>×</button></span>");

  });

  function hide_footer() {
    $('#purchase_search').show();
  };

</script>