<?php
$this->title = 'Packing';
?>

<div>
<table class="table table-head-bg-primary mt-4">
										<thead>
											<tr>
												<th scope="col">#</th>
												<th scope="col">Image</th>
												<th scope="col">Details</th>
												<th scope="col">Measurment</th>
												<th scope="col">Notes</th>
											</tr>
										</thead>
										<tbody>
                    <?php

                    use yii\helpers\Html;

                    $cur_customer = null;
                    $cur_booking_id = null;

                    foreach ($booking_details as $booking_detail) {
                      $img_url = Yii::$app->helpercomponent->getImageurl($booking_detail['images']);
                      if($cur_booking_id != $booking_detail['booking_id']){
                        $cur_booking_id = $booking_detail['booking_id'];
                      ?>
                      <tr>
                        <td>
                          <input type="checkbox"  name="selected_header[]" value="<?=
                          $booking_detail['booking_id'];
                        ?>" class="<?= 'all_'.$booking_detail['booking_id']; ?> check">
                        </td>
                        <td><?= date('d-m-Y', strtotime($booking_detail['pickup_date'])); ?></td>
                        <td><?= $booking_detail['customer_name']; ?></td>
                        <td colspan="2"><?= $booking_detail['remark']; ?></td>
                      </tr>
                        <?php } ?>
                      <tr>
                        <td><input type="checkbox"  name="selected_item['<?= $booking_detail['booking_id'];
                        ?>'][]"
                                   value="<?= $booking_detail['booking_id'];
                        ?>" class="<?= 'all_'.$booking_detail['item_no']; ?> check"></td>
                        <td <a class="image-popup-vertical-fit" href="<?= $img_url ?>"> <?= Html::img
                          ($img_url, ['width' => '100', 'height' => '80']) ?> </a></td>
                        <td><?= $booking_detail['description']; ?></td>
                        <td><?= $booking_detail['note']; ?></td>
                        <td></td>
                      </tr>


                    <?php
                    } ?>

										</tbody>
									</table>
<button type="button" class="btn btn-info" id="submit_pickup()" style="" >Submit</button>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script></script>


