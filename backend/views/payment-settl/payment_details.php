<?php



/* @var $this \yii\web\View */
?>

<div class="row" >
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <!--<select class="custom-select pull-right">
                    <option selected="">January</option>
                    <option value="1">February</option>
                    <option value="2">March</option>
                    <option value="3">April</option>
                </select>-->
                <h4 class="card-title">Invoice</h4>
                <div class="table-responsive m-t-20">
                    <table class="table stylish-table table-striped full-color-table full-info-table hover-table" id="inv_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Date</th>

                             <th>Rent</th>
                              <th>Deposite</th>
                              <th>Paid</th>
                              <th>Returned</th>
                              <th>Balance</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td colspan="5">No Data</td>

                            </tr>
                        <?php foreach ($booking_header as $booking){
                            ?>
                            <tr>

                                <td colspan="4">No Data</td>


                            </tr>
                        <?php
                        }
                        ?>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
