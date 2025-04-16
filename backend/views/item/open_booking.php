<style>
  .modal-content{
      width: 600px;
      margin-top: 75px !important;
  }
   .booked {
        background-color: #7460ee;
    }

    .picked {
        background-color: #1e88e5;
    }

    .returned {
        background-color: #26c6da;
    }

    .cancelled {
        background-color: #ffb22b;
    }

    .deleted {
        background-color: #fc4b6c;
    }
</style>

<div class="card-body" style="overflow: auto; max-height: 450px">
                            <!--  <h4 class="card-title">Items Purchased History </h4> -->
                            <div class="table-responsive">
                                <table class="table color-table red-table">
                                    <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Pick Date</th>
                                        <th>Return Date</th>

                                        <th>Status</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $total_amount = 0;
                                    $month_year ="";
                                    foreach ($booking_items as $key => $booking_item) {
                                        # code...
                                        $total_amount += $booking_item->amount;
                                        $cur_month_year =  Yii::$app->formatter->asDate($booking_item->pickup_date,"MMM-yyyy");;
                                        if($month_year=="" || $cur_month_year != $month_year) {
                                          $month_year = $cur_month_year;
                                        ?>
                                          <tr ><td colspan="5" style="text-align: center; line-height:
                                          30px; background: antiquewhite; color: blue;"> <?= $cur_month_year; ?>
                                            </td> </tr>
                                          <?php
                                        }
                                        ?>

                                        <tr>
                                            <td><a target="_blank" rel="noopener noreferrer"
                                                   href="index.php?r=booking%2Fupdate&id=<?= $booking_item->booking_id; ?>">#<?= $booking_item->booking_id; ?></a>
                                            </td>

                                            <td><a target="_blank" rel="noopener noreferrer"
                                                   href="index.php?r=customer%2Fview&id=<?= $booking_item->booking['customer_id']; ?>"><?= $booking_item->booking->customer['name']; ?></a>
                                            </td>
                                            <td><span class="text"> <?= Yii::$app->formatter->asDate
                                                ($booking_item->pickup_date, 'dd-MM-yyyy'); ?></span>
                                            </td>
                                            <td ><span class="text"> <?= Yii::$app->formatter->asDate
                                                ($booking_item->return_date, 'dd-MM-yyyy'); ?></span>
                                            </td>

                                            <td>
                                                <div class="label label-table <?= strtolower($booking_item->item_status); ?>"><?= $booking_item->item_status; ?></div>
                                            </td>

                                        </tr>
                                    <?php }

                                    if ($booking_items == null) {
                                        ?>
                                        <tr>
                                            <td colspan="4">No Items booking yet</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>

                            </div>
                        </div>