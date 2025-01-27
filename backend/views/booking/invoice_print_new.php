<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="css/style_print.css" media="all" />
  </head>
  <body>
    <header class="clearfix" style="background-color: #EEEEEE">
      <div id="logo">
        <img src="img/logo.png">
      </div>
      <div id="company">
        <h2 class="name">Soyara Rental Couture</h2>
        <div>C-52, Navshantiniketan Hsg.Soc., Akurdi, Pune</div>
        <div>+91 84446287792</div>
        <div><a href="www.thesoyara.com">www.thesoyara.com</a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">INVOICE TO:</div>
          <h2 class="name"><?php echo $business_partner['name'] ?></h2>
          <div class="address"><?php echo $business_partner['contact_nos'];?></div>
          <div class="email"><a href=""><?php echo $business_partner['email_id'];?></a></div>
        </div>
        <div id="invoice">
          <h1>INVOICE <?php echo "#".str_pad($model['booking_id'],6,"0",0);; ?></h1>
          <div class="date">Booking Date: <?php echo Yii::$app->formatter->asDate($model['booking_date'], 'dd-MM-yyyy'); ?></div>
          <div class="date">Delivery Date: <?php echo Yii::$app->formatter->asDate($model['pickup_date'], 'dd-MM-yyyy'); ?></div>
          <div class="date">Return Date: <?php echo Yii::$app->formatter->asDate($model['return_date'], 'dd-MM-yyyy'); ?></div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc" style="min-width: 250px" colspan="2">Item Details</th>
            <th class="unit">Rent Amount</th>
            <th class="qty">Deposite Amount</th> 
            <th class="qty">Discount</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
         <?php 

              $grand_total=0;
              $grand_deposite=0;
              $grand_rent=0;
              $grand_discount=0;
          
          foreach($item as $key => $data){ 
       
           
            $grand_total+=$data->net_value;
            $grand_deposite+=$data->deposit_amount;
            $grand_discount+=$data->discount;
            $grand_rent+=$data->amount;
            $image_path=$data->item['imageurl'];
            ?>
          <tr>
            <td class="no"><?php echo $key+1; ?></td>
            <!-- <td class="desc"><h3>Website Design</h3>Creating a recognizable design solution based on the company's existing visual identity</td> -->
            <td class="desc"><img src="<?= $image_path; ?>" style="height:80px" ></td>
            <td class="desc"> <?php echo  $data->item['name']; ?> </td>
            <td class="unit"><?php echo  number_format($data['amount'],2); ?></td>
            <td class="qty"><?php  echo number_format($data['deposit_amount'],2); ?></td>
            <td class="qty"><?php  echo number_format($data['discount'],2); ?></td>
            <td class="total">₹ <?php  echo number_format($data['net_value'],2); ?></td>
          </tr>
        <?php 
    } ?> 
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4"></td>
            <td colspan="2">Total Rent</td>
            <td>₹ <?=number_format($grand_rent,2)?></td>
          </tr>
          <tr>
            <td colspan="4"></td>
            <td colspan="2">Deposite(Refundable)</td>
            <td>₹ <?=number_format($grand_deposite,2)?></td>
          </tr>
          <tr>
            <td colspan="4"></td>
            <td colspan="2">Total Discount</td>
            <td>₹ <?=number_format($grand_discount,2)?></td>
          </tr>
          <!-- <tr>
            <td colspan="3"></td>
            <td colspan="2">TAX 25%</td>
            <td>$1,300.00</td>
          </tr> -->
          <tr>
            <td colspan="4"></td>
            <td colspan="2">GRAND TOTAL</td>
            <td>₹ <?= number_format($grand_total,2) ?></td>
          </tr>
        </tfoot>
      </table>
      <div id="thanks">Thank you!</div>
      <div id="notices">
          <div><b>Terms & Conditions :-</b></div>
        <div class="notice"><br>
By making payment. you agree to the following Terms and Conditions :-<br>
            <ul><li>All dress shall remain the property of Soyara and must be returned upon demand.</li>
            <li>Renter will return/ship dress(es) back to Soyara with No damage. Any damage to any rental dress(es) will be charged to the Renter. Damage fees will be  held from any deposit.</li>
            <li>Security Deposit :- Soyara dress rentals further stipulates that a security deposit equal to the amount of the dress. And will be return in next 24 working hours through online process.</li>
            <li>ID proof :-  ID proof with address is mandatory for booking the outfit/accesories.</li>
            <li>Appointment :- Prior Appointment is mandatory.Kindly follow office timings 11am to 8pm for pickup and return. Also  make confirmation call for availability of outfit/accesories the day you want to visit.</li>
                <li>Dress(es) will not be altered by the Renter. Do not dry clean the dress for any reason .Professional cleaning is included in the rental price and no additional cleaning charge will be assessed unless the dress is returned damaged.</li>
                <li>.Booking - Soyara will take 20% of rental amount as booking amount for online/offline bookings which is non-refundable if cancelled.</li>
                <li>Fixed Rent :- Kindly Do not argue with staff members for price matters. Rent and Deposit amount is fixed.</li>
                <li>Safety :- In terms of cleanliness regular drycleaning is placed, Also we have limited trails allowed for maintaining purpose.</li>
                <li>Renter is responsible for the safe return of the dress(es). Renter is responsible for any theft/loss of dress(es).Bill receipt is mandatory while returning the dress(es).</li>
            <li>Check your outfits/ accesories at the time of pickup. Soyara will not responsible for any alterations/misplaced/finishing etc once handover to the client after his/her confirmation about cross- check.</li>
                <li>Late fees - Dresses/accesories if not returned on or before the specified date 20% of the total rent will be charged for delayed return per day basis. Amount will immediately deducted from any deposit held.

                </li>
                <li>Cancellation charges :- Any cancellation after booking will have deduction of 20% of Total Rent</li>
                <li>.Loss/Theft : Loss or Theft of any dress(es) will be charged the full purchase price of the dress.<br><br>
I agree to all terms & conditions & agree to cover the cost of the dress(es) rental(s), shipping & any damages/loss/theft or late charges</li>
            </ul>
 </div>
      </div>
    </main>
    <footer>
        <b>Invoice was created on a computer and is valid without the signature and seal.</b>
    </footer>
  </body>
</html>