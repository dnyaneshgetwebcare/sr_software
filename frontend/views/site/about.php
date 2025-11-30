<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Soyara Rental Couture';

?>
<style>
    .card-profile .card-body {
        padding-top: 20px !important;
    }

    .container-fluid {
        padding: 0 30px 0px 30px !important;
    }
</style>

<div class="d-flex align-items-center py-4 text-white" style="padding-top: 5.5rem !important; padding-bottom: 0 !important;">
					<div class="me-3">
                        <img src="../../img/logo.PNG" style="width: 172px"/>

					</div>
    <div class="me-3">
        <h2 class="mb-3" style="color: #fff;"><?= $vendor_name ?> </h2>

    </div>
					<div class="ms-auto">

					</div>
				</div>

<div class="site-about page-inner">

    <div class="row ">
      <div class="col-6 col-sm-4 col-lg-2">
							<div class="card">
								<div class="card-body p-3 text-center">

									<div class="h1 m-0"><?= $women; ?></div>
									<div class="text-muted mb-3">Women</div>
								</div>
							</div>
						</div>
  <div class="col-6 col-sm-4 col-lg-2">
							<div class="card">
								<div class="card-body p-3 text-center">

									<div class="h1 m-0"><?= $mens; ?></div>
									<div class="text-muted mb-3">Men</div>
								</div>
							</div>
						</div>
        <div class="col-6 col-sm-4 col-lg-2">
							<div class="card">
								<div class="card-body p-3 text-center">

									<div class="h1 m-0"><?= $jewellary; ?></div>
									<div class="text-muted mb-3">Jewellary</div>
								</div>
							</div>
						</div>



    </div>

    <div class="row">
        <?php


        foreach ($item_master as $item) {
            $rent_amount = 0;
            $number_of_times = 0;
            $upcoming_booking = 0;
            $upcoming_booking_times = 0;
            $img =  '../../img/no-image.jpg';
            if ($item['images'] != '') {
                $img =  '../../uploads/' . $item['images'];
            }
            ?>
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-header" style="background-image: url(<?= $img; ?>); background-repeat: no-repeat; background-position: center center;">
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name"> <?php echo $item['name']; ?></div>
                        </div>

                        <div class="title">Booking</div>
                        <div class="card-list py-4" style="overflow: auto;max-height: 300px; min-height: 300px">

                            <?php
                            if (isset($booking_details[$item['id']])) {
                                $product_bookings = $booking_details[$item['id']];
                                //  echo "<pre>"; print_r($booking_details);die;

                                foreach ($product_bookings as $booking) {
                                    $status_class = 'primary';
                                     $actual_rent = $booking['earning_amount'];
                                     $earn_actual_rent = $actual_rent*60/100;
                                    if ($booking['status'] == 'Returned') {
                                        $rent_amount += $earn_actual_rent;
                                        $number_of_times++;
                                        $status_class = 'success';
                                    } else {
                                        $upcoming_booking += $earn_actual_rent;
                                        $upcoming_booking_times++;
                                    }

                                    ?>
                                    <div class="item-list">
                                        <div class="avatar">
												<span class="round"
                                                      style="width: 55px"><?= Yii::$app->formatter->asDate($booking['pickup_date'], 'dd/MMM');
                                                    ?></span>
                                        </div>
                                        <div class="info-user ms-3">
                                            <div class="username"><?= $booking['customer_name']; ?></div>
                                            <div class="status"><span
                                                        class="badge badge-<?= $status_class ?>"><?= $booking['status']; ?></span>
                                                <?php /*= Yii::$app->formatter->asDate($booking['pickup_date'],'d-MM-yy');
                          */ ?><!-- >>  --><?php /*= Yii::$app->formatter->asDate($booking['pickup_date'],'d-MM-yy');
                          */ ?></div>
                                        </div>
                                        <span class="number"> <?= number_format($earn_actual_rent, 0) ?> </span>
                                    </div>
                                <?php }
                            } else {
                                echo "<center> No Booking </center>";
                            }
                            ?>


                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row user-stats text-center">
                            <div class="col">
                                <div class="number"><?= $number_of_times ?></div>
                                <div class="title">Nos Times</div>
                            </div>
                            <div class="col">
                                <div class="number"><?= number_format($rent_amount) ?></div>
                                <div class="title">Total Earned</div>
                            </div>
                            <div class="col">
                                <div class="number"><?= number_format($upcoming_booking)."(".$upcoming_booking_times.")" ?></div>
                                <div class="title">Upcoming</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php function thousandsCurrencyFormat($num)
{

    if ($num > 1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int)$x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

    }

    return $num;
} ?>
