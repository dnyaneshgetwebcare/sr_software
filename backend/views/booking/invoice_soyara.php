<html lang="zxx" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Soyara Rental Couture</title>
  <link href="print_assets/images/favicon/icon.png" rel="icon">
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&amp;display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="print_assets/css/custom.css">
  <link rel="stylesheet" href="print_assets/css/media-query.css">
</head>
<body>
<!--Invoice wrap start here -->
<div class="invoice_wrap rental-invoice">
  <div class="invoice-container">
    <div class="invoice-content-wrap" id="download_section">
      <!--Header start here -->
      <header class="invoice-header rental-header bg-black" id="invo_header">
        <div class="invoice-logo-content">
          <div class="invoice-logo">
             <img src="print_assets/symbol.png"   style="width: 100px" alt="this is a invoice logo">
            <img src="print_assets/logo_name.png" style="width: 230px" alt="this is a invoice logo">

          </div>
        </div>
      </header>
      <!--Header end here -->
      <!--Invoice content start here -->
      <section class="rental-service-content" id="rental_invoice">
        <div class="container">
          <!--Contact details start here -->
          <div class="rental-contact-wrap">
            <div class="rental-contact">
              <div class="rental-contact-details">
                <div class="invo-cont-wrap invo-contact-wrap">
                  <div class="invo-social-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g clip-path="url(#clip0_6_94)">
                        <path
                          d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 19.5304 19.7893 20.0391 19.4142 20.4142C19.0391 20.7893 18.5304 21 18 21C14.0993 20.763 10.4202 19.1065 7.65683 16.3432C4.8935 13.5798 3.23705 9.90074 3 6C3 5.46957 3.21071 4.96086 3.58579 4.58579C3.96086 4.21071 4.46957 4 5 4"
                          stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15 7C15.5304 7 16.0391 7.21071 16.4142 7.58579C16.7893 7.96086 17 8.46957 17 9"
                              stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15 3C16.5913 3 18.1174 3.63214 19.2426 4.75736C20.3679 5.88258 21 7.4087 21 9"
                              stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                      </g>
                      <defs>
                        <clipPath id="clip0_6_94">
                          <rect width="24" height="24" fill="#12151C"></rect>
                        </clipPath>
                      </defs>
                    </svg>
                  </div>
                  <div class="invo-social-name">
                    <a href="tel:+918237703030" class="font-sm color-grey">+91-8237703030</a>
                  </div>
                </div>
                <div class="invo-cont-wrap ">
                  <div class="invo-social-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g clip-path="url(#clip0_6_108)">
                        <path
                          d="M19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5Z"
                          stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M3 7L12 13L21 7" stroke="#12151C" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"></path>
                      </g>
                      <defs>
                        <clipPath id="clip0_6_108">
                          <rect width="24" height="24" fill="#12151C"></rect>
                        </clipPath>
                      </defs>
                    </svg>
                  </div>
                  <div class="invo-social-name">
                    <a href="#" class="font-sm color-grey">soyararental@gmail.com</a>
                  </div>
                </div>
              </div>
              <div class="invo-cont-wrap invo-contact-wrap">
                <div class="invo-social-name">
                  <p class="font-sm color-grey">Shop no 313, 3rd Floor, One Mall, BRT Link Rd, Ravet, Pune,
                    Maharashtra 412101</p>
                </div>
              </div>
            </div>
            <div class="rental-second">
              <div class="rental-green-box">
                <div><h1 class="rental-txt">INVOICE</h1></div>
              </div>
            </div>
          </div>
          <!--Contact details start here -->
          <!--Invoice owner name start here -->
          <div class="invoice-owner-conte-wrap pt-40">
            <div class="invo-to-wrap width-55">
              <div class="invoice-to-content">
                <p class="font-md color-light-black">Customer Info:</p>
                <h2 class="color-green-rental font-lg pt-10"><?php echo $business_partner['name'] ?></h2>
                <p class="font-md-grey color-grey pt-10">Phone: <?php echo $business_partner['contact_nos']; ?> <br>
                  Email id : <?php echo $business_partner['email_id']; ?></p>
              </div>
            </div>
            <div class="invo-pay-to-wrap width-45">
              <div class="">
                <div class="invo-head-wrap invo-head-wrap-rental">
                  <div class="color-light-black font-md">Invoice No:</div>
                  <div
                    class="font-md-grey color-grey "><?php echo "#" . str_pad($model['booking_id'], 6, "0", 0);; ?></div>
                </div>
                <div class="invo-head-wrap invo-head-wrap-rental">
                  <div class="color-light-black font-md">Booking Date:</div>
                  <div
                    class="font-md-grey color-grey "> <?php echo Yii::$app->formatter->asDate($model['booking_date'], 'dd-MM-yyyy'); ?></div>
                </div>
                <div class="invo-head-wrap invo-head-wrap-rental">
                  <div class="color-light-black font-md">Pickup Date:</div>
                  <div
                    class="font-md-grey color-grey "> <?php echo Yii::$app->formatter->asDate($model['pickup_date'], 'dd-MM-yyyy'); ?></div>
                </div>
                <div class="invo-head-wrap invo-head-wrap-rental">
                  <div class="color-light-black font-md">Return Date:</div>
                  <div
                    class="font-md-grey color-grey "> <?php echo Yii::$app->formatter->asDate($model['return_date'], 'dd-MM-yyyy'); ?></div>
                </div>
              </div>
            </div>
          </div>
          <!--Invoice owner name end here -->
          <!--Payment detail table start here -->

          <!--Payment detail table end here -->
          <!--Patient report info start here -->
          <div class="table-wrapper mt-40">
            <table class="invoice-table rental-table">
              <thead class="mt-40">
              <tr class="invo-tb-header bg-green-rental ">
                <th class="font-md color-light-black rental-wid1 pl-10 ">#</th>
                <th class="font-md color-light-black rental-wid2 " style="min-width: 250px">Description</th>
                <th class="font-md color-light-black rental-wid3 ">Rent Amount</th>
                <th class="font-md color-light-black rental-wid3 ">Deposit Amount</th>
                <th class="font-md color-light-black rental-wid5 ">Total Amount</th>
              </tr>
              </thead>
              <tbody class="invo-tb-body">
              <?php

              $grand_total = 0;
              $grand_deposite = 0;
              $grand_rent = 0;
              $grand_discount = 0;

              foreach ($item as $key => $data) {
                $grand_total += $data->net_value;
                $grand_deposite += $data->deposit_amount;
                $grand_discount += $data->discount;
                $grand_rent += $data->amount;
                $image_path = $data->item['imageurl'];
                ?>
                <tr class="invo-tb-row">
                  <td class="invo-tb-data font-sm"><?php echo $key + 1; ?></td>
                  <td class="invo-tb-data rate-data font-sm"><img src="<?= $image_path; ?>" style="height:80px">
                    <span
                      style="padding: 5px;position: absolute;width: 225px;text-wrap: auto;">
                      <?php echo $data->item['name']; ?> </span> </td>
                  <td class="invo-tb-data rate-data font-sm text-right"><?php echo number_format($data['amount']
                      -$data->discount, 2)
                    ; ?></td>
                  <td
                    class="invo-tb-data total-data font-sm text-right pr-10"><?php echo number_format($data['deposit_amount'], 2); ?></td>
                  <td class="invo-tb-data total-data font-sm text-right">
                    ₹ <?php echo number_format($data['net_value'], 2); ?></td>
                </tr>

                </tr>
                <?php
              } ?>
              </tbody>
            </table>
          </div>
          <!--Patient report info end here -->
          <!--Invoice additional info start here -->
          <div class="invo-addition-wrap pt-20 rental-rule">
            <div class="invo-add-info-content bus-term-cond-content">

              <div class="term-condi-list pt-10">

              </div>
            </div>
            <div class="invo-bill-total w-40">
              <table class="invo-total-table ">
                <tbody>

                 <?php if($grand_discount!=0 ){  ?>
                   <tr>
                  <td class="font-md color-light-black ">Sub Total:</td>
                  <td class="font-md-grey color-grey text-right pr-10">₹ <?= number_format($grand_rent, 2) ?></td>
                </tr>
                <tr>
                  <td class="font-md color-light-black  ">Discount</td>
                  <td class="font-md-grey color-grey text-right pr-10">₹ <?= number_format($grand_discount, 2) ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td class="font-md color-light-black ">Total Rent:</td>
                  <td class="font-md-grey color-grey text-right pr-10">₹ <?= number_format($grand_rent -$grand_discount, 2) ?></td>
                </tr>
                <tr>
                  <td class="font-md color-light-black ">Total Deposit:</td>
                  <td class="font-md-grey color-grey text-right pr-10">₹ <?= number_format($grand_deposite, 2) ?></td>
                </tr>

                <tr class="invo-grand-total">
                  <td class="color-green-rental  font-18-700 pt-10">Grand Total:</td>
                  <td class="font-18-500 color-light-black text-right pr-10 pt-10">
                    ₹ <?= number_format($grand_total, 2) ?></td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!--Invoice additional info end here -->
          <h3 class="addi-info-title font-md color-light-black" style="background-color: #d7cfb4; padding: 5px
          10px">Payment Details
            :-</h3>
          <div class="payment-table-wrap rental-table-wrap">
            <table class="invo-payment-table">
              <thead>
              <tr class="invo-tb-header">
                <th class="font-md date-wid font-md color-light-black">Date</th>
                <th class="font-md payment-wid font-md color-light-black">Mode</th>
                <th class="font-md trans-wid font-md color-light-black">Type</th>
                <th class="font-md amount-wid font-md color-light-black text-center ">Amount</th>
              </tr>
              </thead>
              <tbody>
              <?php foreach ($payments as $payment_item) {
                $type = "Received";
                $amount = $payment_item['amount'];
                if($payment_item['type'] == "Return-Deposit" || $payment_item['type'] == "Return-Payment"){
                  $amount = $amount * -1;
                  $type = $payment_item['type'];
                }
                if($payment_item['type'] == "Cancel-Charge" || $payment_item['type'] == "Other-Charges"){
                  $type = $payment_item['type'];
                }

                ?>
              <tr class="invo-paye-row">
                <td class="font-sm payment-desc"><?php echo Yii::$app->formatter->asDate($payment_item['date'], 'dd-MM-yyyy'); ?></td>
                <td class="font-sm payment-desc"><?= $payment_item['mode_of_payment']; ?></td>
                <td class="font-sm payment-desc"><?= $type; ?></td>
                <td class="font-sm payment-desc text-right"> <?= number_format($amount, 2) ?></td>
              </tr>
                <?php
              } ?>
              </tbody>
            </table>
          </div>
          <div class="invo-add-info-content bus-term-cond-content" style="margin-top: 20px">

            <h3 class="addi-info-title font-md color-light-black">Terms & Conditions :-</h3>
            <hr style="width:100%;text-align:left;margin-left:0">
            <div class="term-condi-list pt-10">
              <ul class="term-con-list">
                <li class="font-sm">All dress shall remain the property of Soyara and must be returned upon demand.</li>
                <li class="font-sm">Renter will return/ship dress(es) back to Soyara with No damage. Any damage to any rental dress(es)
                  will be charged to the Renter. Damage fees will be held from any deposit.
                </li>
                <li class="font-sm">Security Deposit :- Soyara dress rentals further stipulates that a security deposit equal to the
                  amount of the dress. And will be return in next 24 working hours through online process.
                </li>
                <li class="font-sm">ID proof :- ID proof with address is mandatory for booking the outfit/accesories.</li>
                <li class="font-sm">Appointment :- Prior Appointment is mandatory.Kindly follow office timings 11am to 8pm for pickup
                  and return. Also make confirmation call for availability of outfit/accesories the day you want to
                  visit.
                </li>
                <li class="font-sm">Dress(es) will not be altered by the Renter. Do not dry clean the dress for any reason .Professional
                  cleaning is included in the rental price and no additional cleaning charge will be assessed unless the
                  dress is returned damaged.
                </li>
                <li class="font-sm">Booking - Soyara will take 20% of rental amount as booking amount for online/offline bookings which
                  is non-refundable if cancelled.
                </li>
                <li class="font-sm">Fixed Rent :- Kindly Do not argue with staff members for price matters. Rent and Deposit amount is
                  fixed.
                </li>
                <li class="font-sm">Safety :- In terms of cleanliness regular drycleaning is placed, Also we have limited trails allowed
                  for maintaining purpose.
                </li>
                <li class="font-sm">Renter is responsible for the safe return of the dress(es). Renter is responsible for any theft/loss
                  of dress(es).Bill receipt is mandatory while returning the dress(es).
                </li>
                <li class="font-sm">Check your outfits/ accesories at the time of pickup. Soyara will not responsible for any
                  alterations/misplaced/finishing etc once handover to the client after his/her confirmation about
                  cross- check.
                </li>
                <li class="font-sm">Late fees - Dresses/accesories if not returned on or before the specified date 20% of the total rent
                  will be charged for delayed return per day basis. Amount will immediately deducted from any deposit
                  held.

                </li>
                <li class="font-sm">Cancellation charges :- Any cancellation after booking will have deduction of 20% of Total Rent</li>
                <li class="font-sm">Loss/Theft : Loss or Theft of any dress(es) will be charged the full purchase price of the
                  dress.<br><br>
                  I agree to all terms & conditions & agree to cover the cost of the dress(es) rental(s), shipping & any
                  damages/loss/theft or late charges
                </li>

              </ul>

            </div>
          </div>
        </div>
      </section>
      <section>
        <!--Print-download content start here -->
        <!-- 	<div class="invo-buttons-wrap">
            <div class="invo-print-btn invo-btns">
              <a href="javascript:window.print()" class="print-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <g clip-path="url(#clip0_10_61)">
                    <path d="M17 17H19C19.5304 17 20.0391 16.7893 20.4142 16.4142C20.7893 16.0391 21 15.5304 21 15V11C21 10.4696 20.7893 9.96086 20.4142 9.58579C20.0391 9.21071 19.5304 9 19 9H5C4.46957 9 3.96086 9.21071 3.58579 9.58579C3.21071 9.96086 3 10.4696 3 11V15C3 15.5304 3.21071 16.0391 3.58579 16.4142C3.96086 16.7893 4.46957 17 5 17H7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M17 9V5C17 4.46957 16.7893 3.96086 16.4142 3.58579C16.0391 3.21071 15.5304 3 15 3H9C8.46957 3 7.96086 3.21071 7.58579 3.58579C7.21071 3.96086 7 4.46957 7 5V9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M7 15C7 14.4696 7.21071 13.9609 7.58579 13.5858C7.96086 13.2107 8.46957 13 9 13H15C15.5304 13 16.0391 13.2107 16.4142 13.5858C16.7893 13.9609 17 14.4696 17 15V19C17 19.5304 16.7893 20.0391 16.4142 20.4142C16.0391 20.7893 15.5304 21 15 21H9C8.46957 21 7.96086 20.7893 7.58579 20.4142C7.21071 20.0391 7 19.5304 7 19V15Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  </g>
                  <defs>
                    <clipPath id="clip0_10_61">
                      <rect width="24" height="24" fill="white"></rect>
                    </clipPath>
                  </defs>
                </svg>
                <span class="inter-700 medium-font">Print</span>
              </a>
            </div>
            <div class="invo-down-btn invo-btns">
              <a class="download-btn" id="generatePDF">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_5_246)">
                  <path d="M4 17V19C4 19.5304 4.21071 20.0391 4.58579 20.4142C4.96086 20.7893 5.46957 21 6 21H18C18.5304 21 19.0391 20.7893 19.4142 20.4142C19.7893 20.0391 20 19.5304 20 19V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7 11L12 16L17 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 4V16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g><defs><clipPath id="clip0_5_246"><rect width="24" height="24" fill="white"></rect></clipPath></defs>
                </svg>
                <span class="inter-700 medium-font">Download</span>
              </a>
            </div>
          </div> -->
        <!--Print-download content end here -->
        <!--Note content start -->
        <div class="invo-note-wrap pt-30">
          <div class="note-title">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
              <g clip-path="url(#clip0_8_240)">
                <path d="M14 3V7C14 7.26522 14.1054 7.51957 14.2929 7.70711C14.4804 7.89464 14.7348 8 15 8H19"
                      stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path
                  d="M17 21H7C6.46957 21 5.96086 20.7893 5.58579 20.4142C5.21071 20.0391 5 19.5304 5 19V5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H14L19 8V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21Z"
                  stroke="#12151C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M9 7H10" stroke="#12151C" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round"></path>
                <path d="M9 13H15" stroke="#12151C" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round"></path>
                <path d="M13 17H15" stroke="#12151C" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round"></path>
              </g>
              <defs>
                <clipPath id="clip0_8_240">
                  <rect width="24" height="24" fill="white"></rect>
                </clipPath>
              </defs>
            </svg>
            <span class="font-md color-light-black">Note:</span>
          </div>

          <h3 class="font-md-grey color-grey note-desc ">This is computer generated receipt and does not require
            physical
            signature.</h3>
        </div>
        <!--Note content end -->
      </section>
      <!--Invoice content end here -->
    </div>
    <!--bottom content start here -->

  </div>
</div>
<!--Invoice wrap end here -->
<script src="print_assets/js/jquery.min.js"></script>
<!--<script src="print_assets/js/jspdf.min.js"></script>
<script src="print_assets/js/html2canvas.min.js"></script>
<script src="print_assets/js/custom.js"></script>-->

</body>
</html>