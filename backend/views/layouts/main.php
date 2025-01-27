<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\bootstrap\Modal;
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

use yii\widgets\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage();
$user = Yii::$app->user->identity;
$is_admin = ($user->user_type == "admin") ? true : false;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <?php $this->head() ?>
  <link
    rel="icon"
    href="img/favicon.ico"
    type="image/x-icon"
  />
  <script src="kai-admin-assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {families: ["Public Sans:300,400,500,600,700"]},
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["kai-admin-assets/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>
</head>
<!-- <body> -->


<style type="text/css">
    .overlay-back,
    .overlay-back-new {
        z-index: 1050;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 3px;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .overlay {
        z-index: 1100;
        background: rgba(0, 0, 0, 0.3);
        border-radius: 3px;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
<style>
    .slimScrollDiv {
        height: auto !important;
    }

    .modal-content {
        margin-top: 200px;
    }

    #pModal.fade.show {
        opacity: 1;
    }
</style>
<?php $this->beginBody() ?>

<div class="wrapper">


  <!-- ============================================================== -->
  <div class="sidebar sidebar-style-2" data-background-color="dark">
    <div class="sidebar-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="index.php" class="logo">
          <img
            src="img/logo.PNG"
            alt="navbar brand"
            class="navbar-brand"
            height="20"
          />
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content">
        <ul class="nav nav-secondary">
          <li class="nav-item">
            <a href="index.php?r=site/index">
              <i class="fas fa-home"></i>
              <p>Home</p>

            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?r=customer/index">
              <i class="fas fa-user-alt"></i>
              <p>Customer</p>

            </a>
          </li>
          <li class="nav-item">
            <a
              data-bs-toggle="collapse"
              href="#booking-menu"
              class="collapsed"
              aria-expanded="false"
            >
              <i class="fas fa-dollar-sign"></i>
              <p>Booking</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="booking-menu">
              <ul class="nav nav-collapse">
                <li>
                  <a href="index.php?r=booking/create">
                    <span class="sub-item">New Booking
                    </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=booking/index">
                    <span class="sub-item">Booking
                    </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=booking-item/index-return">
                        <span class="sub-item">Return Item
                        </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=booking/pending-deposite">
                     <span class="sub-item">Return Deposite Pending
                     </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=booking/index-payment">
                     <span class="sub-item">Pending Payment
                     </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=payment/index">
                     <span class="sub-item">Transaction
                     </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=booking/index-sales">
                     <span class="sub-item">Total Sales
                     </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=booking-item/sales-item">
                     <span class="sub-item">Total Item Sales
                     </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <?php if ($is_admin) { ?>
            <li class="nav-item">
              <a
                data-bs-toggle="collapse"
                href="#purchase-menu"
                class="collapsed"
                aria-expanded="false"
              >
                <i class="fas fa-truck"></i>
                <p>Purchase</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="purchase-menu">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="index.php?r=purchase/create">
                    <span class="sub-item">
                      Create Purchase Order
                    </span>
                    </a>
                  </li>
                  <li>
                    <a href="index.php?r=purchase/index">
                    <span class="sub-item">
                      Purchase Order
                    </span>
                    </a>
                  </li>
                  <li>
                    <a href="index.php?r=purchase/items-report">
                    <span class="sub-item">
                      Item Report
                    </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          <?php } ?>
          <li class="nav-item">
            <a
              data-bs-toggle="collapse"
              href="#expense-menu"
              class="collapsed"
              aria-expanded="false"
            >
              <i class="fas fa-money-bill"></i>
              <p>Expense</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="expense-menu">
              <ul class="nav nav-collapse">
                <li>
                  <a href="index.php?r=expense/create">
                    <span class="sub-item">
                      Create Expense
                    </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=expense/index">
                    <span class="sub-item">
                      Expense
                    </span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=expense-category/index">
                    <span class="sub-item">
                      Expense Category
                    </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a href="index.php?r=item/index">
              <i class="fas fa-tshirt"></i>
              <p>Item Master</p>

            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?r=vendor/index">
              <i class="fas fa-users"></i>
              <p>Vendor</p>

            </a>
          </li>
          <li class="nav-item">
            <a href="index.php?r=formula/calculate">
              <i class="fas fa-calculator"></i>
              <p>Run Split</p>

            </a>
          </li>
          <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-file-archive"></i>
                </span>
            <h4 class="text-section">Report</h4>
          </li>
          <?php
          if ($is_admin) {
            ?>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#salesreport-menu">
                <i class="fas fa-layer-group"></i>
                <p>Sales Reports</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="salesreport-menu">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="index.php?r=item-wise-report/item-filter">
                      <span class="sub-item">Item</span>
                    </a>
                  </li>
                  <li>
                    <a href="index.php?r=index.php?r=reports/index">
                      <span class="sub-item">Booking Orders</span>
                    </a>
                  </li>
                  <li>
                    <a href="index.php?r=reports/index-item">
                      <span class="sub-item">Booking Item Report</span>
                    </a>
                  </li>

                </ul>
              </div>
            </li>
          <?php } ?>

          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#paymentreport-menu">
              <i class="fas fa-wallet"></i>
              <p>Payment Reports</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="paymentreport-menu">
              <ul class="nav nav-collapse">
                <li>
                  <a href="index.php?r=payment/payment-search">
                    <span class="sub-item">Payment</span>
                  </a>
                </li>


              </ul>
            </div>
          </li>

          <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
            <h4 class="text-section">Setting</h4>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#itemmaster-menu">
              <i class="fas fa-layer-group"></i>
              <p>Item master</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="itemmaster-menu">
              <ul class="nav nav-collapse">
                <li>
                  <a href="index.php?r=type/index">
                    <span class="sub-item">Item Type</span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=cater/index">
                    <span class="sub-item">Item Category</span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=color-master/index">
                    <span class="sub-item">Color</span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=occation-master/index">
                    <span class="sub-item">Occasion</span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=display-type/index">
                    <span class="sub-item">Display Type</span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#other-menu">
              <i class="fas fa-layer-group"></i>
              <p>Other</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="other-menu">
              <ul class="nav nav-collapse">
                <li>
                  <a href="index.php?r=expsense-category/index">
                    <span class="sub-item">Expense Category</span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=address-group/index">
                    <span class="sub-item">Address Group</span>
                  </a>
                </li>
                <li>
                  <a href="index.php?r=formula/create">
                    <span class="sub-item">Split Formula</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

        </ul>
      </div>
      </li>
      </ul>
    </div>
  </div>


  <!-- End Left Sidebar - style you can find in sidebar.scss  -->


  <!-- Page wrapper  -->
  <!-- ============================================================== -->
  <div class="overlay" style="position: fixed">
    <center><img src="img/loader.gif" style="height:100px;"></center>
    <center style="font-size: 20px;color: #3c60b5;margin-top: 30px"><b id="data_progress_bar"
                                                                       style="background-color: #ffffff"></b></center>
  </div>
  <div class="overlay-back" style="display:none">

  </div>
  <div class="main-panel">
    <div class="main-header">
      <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.html" class="logo">
            <img
              src="img/logo.PNG"
              alt="navbar brand"
              class="navbar-brand"
              height="20"
            />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <!-- Navbar Header -->
      <nav
        class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
      >

        <div class="container-fluid">
          <nav
            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
          >
            <div class="input-group">
              <div class="input-group-prepend">
                <button type="submit" class="btn btn-search pe-1">
                  <i class="fa fa-search search-icon"></i>
                </button>
              </div>
              <input
                type="text"
                placeholder="Search ..."
                class="form-control"
              />
            </div>
          </nav>

          <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li
              class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
            >
              <a
                class="nav-link dropdown-toggle"
                data-bs-toggle="dropdown"
                href="#"
                role="button"
                aria-expanded="false"
                aria-haspopup="true"
              >
                <i class="fa fa-search"></i>
              </a>
              <ul class="dropdown-menu dropdown-search animated fadeIn">
                <form class="navbar-left navbar-form nav-search">
                  <div class="input-group">
                    <input
                      type="text"
                      placeholder="Search ..."
                      class="form-control"
                    />
                  </div>
                </form>
              </ul>
            </li>
            <!--<li class="nav-item topbar-icon dropdown hidden-caret">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="messageDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="fa fa-envelope"></i>
              </a>
              <ul
                class="dropdown-menu messages-notif-box animated fadeIn"
                aria-labelledby="messageDropdown"
              >
                <li>
                  <div
                    class="dropdown-title d-flex justify-content-between align-items-center"
                  >
                    Messages
                    <a href="#" class="small">Mark all as read</a>
                  </div>
                </li>
                <li>
                  <div class="message-notif-scroll scrollbar-outer">
                    <div class="notif-center">
                      <a href="#">
                        <div class="notif-img">
                          <img
                            src="kai-admin-assets/img/jm_denis.jpg"
                            alt="Img Profile"
                          />
                        </div>
                        <div class="notif-content">
                          <span class="subject">Jimmy Denis</span>
                          <span class="block"> How are you ? </span>
                          <span class="time">5 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-img">
                          <img
                            src="kai-admin-assets/img/chadengle.jpg"
                            alt="Img Profile"
                          />
                        </div>
                        <div class="notif-content">
                          <span class="subject">Chad</span>
                          <span class="block"> Ok, Thanks ! </span>
                          <span class="time">12 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-img">
                          <img
                            src="kai-admin-assets/img/mlane.jpg"
                            alt="Img Profile"
                          />
                        </div>
                        <div class="notif-content">
                          <span class="subject">Jhon Doe</span>
                          <span class="block">
                                Ready for the meeting today...
                              </span>
                          <span class="time">12 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-img">
                          <img
                            src="kai-admin-assets/img/talha.jpg"
                            alt="Img Profile"
                          />
                        </div>
                        <div class="notif-content">
                          <span class="subject">Talha</span>
                          <span class="block"> Hi, Apa Kabar ? </span>
                          <span class="time">17 minutes ago</span>
                        </div>
                      </a>
                    </div>
                  </div>
                </li>
                <li>
                  <a class="see-all" href="javascript:void(0);"
                  >See all messages<i class="fa fa-angle-right"></i>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="notifDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="fa fa-bell"></i>
                <span class="notification">4</span>
              </a>
              <ul
                class="dropdown-menu notif-box animated fadeIn"
                aria-labelledby="notifDropdown"
              >
                <li>
                  <div class="dropdown-title">
                    You have 4 new notification
                  </div>
                </li>
                <li>
                  <div class="notif-scroll scrollbar-outer">
                    <div class="notif-center">
                      <a href="#">
                        <div class="notif-icon notif-primary">
                          <i class="fa fa-user-plus"></i>
                        </div>
                        <div class="notif-content">
                          <span class="block"> New user registered </span>
                          <span class="time">5 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-icon notif-success">
                          <i class="fa fa-comment"></i>
                        </div>
                        <div class="notif-content">
                              <span class="block">
                                Rahmad commented on Admin
                              </span>
                          <span class="time">12 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-img">
                          <img
                            src="kai-admin-assets/img/profile2.jpg"
                            alt="Img Profile"
                          />
                        </div>
                        <div class="notif-content">
                              <span class="block">
                                Reza send messages to you
                              </span>
                          <span class="time">12 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-icon notif-danger">
                          <i class="fa fa-heart"></i>
                        </div>
                        <div class="notif-content">
                          <span class="block"> Farrah liked Admin </span>
                          <span class="time">17 minutes ago</span>
                        </div>
                      </a>
                    </div>
                  </div>
                </li>
                <li>
                  <a class="see-all" href="javascript:void(0);"
                  >See all notifications<i class="fa fa-angle-right"></i>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item topbar-icon dropdown hidden-caret">
              <a
                class="nav-link"
                data-bs-toggle="dropdown"
                href="#"
                aria-expanded="false"
              >
                <i class="fas fa-layer-group"></i>
              </a>
              <div class="dropdown-menu quick-actions animated fadeIn">
                <div class="quick-actions-header">
                  <span class="title mb-1">Quick Actions</span>
                  <span class="subtitle op-7">Shortcuts</span>
                </div>
                <div class="quick-actions-scroll scrollbar-outer">
                  <div class="quick-actions-items">
                    <div class="row m-0">
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <div class="avatar-item bg-danger rounded-circle">
                            <i class="far fa-calendar-alt"></i>
                          </div>
                          <span class="text">Calendar</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <div
                            class="avatar-item bg-warning rounded-circle"
                          >
                            <i class="fas fa-map"></i>
                          </div>
                          <span class="text">Maps</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <div class="avatar-item bg-info rounded-circle">
                            <i class="fas fa-file-excel"></i>
                          </div>
                          <span class="text">Reports</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <div
                            class="avatar-item bg-success rounded-circle"
                          >
                            <i class="fas fa-envelope"></i>
                          </div>
                          <span class="text">Emails</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <div
                            class="avatar-item bg-primary rounded-circle"
                          >
                            <i class="fas fa-file-invoice-dollar"></i>
                          </div>
                          <span class="text">Invoice</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <div
                            class="avatar-item bg-secondary rounded-circle"
                          >
                            <i class="fas fa-credit-card"></i>
                          </div>
                          <span class="text">Payments</span>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </li>-->

            <li class="nav-item topbar-user dropdown hidden-caret">


                <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold"><?= Yii::$app->user->identity->username;;  ?></span>

                    </span>

              </li>
<li class="nav-item topbar-icon dropdown hidden-caret">
                 <?php $form = ActiveForm::begin(['action' => 'index.php?r=site/logout', 'id' => 'logout_form', 'options' => ['method' => 'post']]); ?>

                    <button href="#" class="btn btn-danger" type="submit"
                            style="height: -webkit-fill-available;background: none; border: none;"><i
                        class="fa fa-power-off"></i>
                    </button>
                    <?php ActiveForm::end(); ?>
            </li>

        </ul>

    </div>
    </nav>
    <!-- End Navbar -->
  </div>

  <div class="container">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="page-inner">
      <?= Alert::widget() ?>
      <?= $content ?>
    </div>

    <?php
    yii\bootstrap\Modal::begin([
      'id' => 'pModal',
    ]);
    echo "<div id='modalContent' ></div>";
    yii\bootstrap\Modal::end();

    ?>
    <div class="modal fade bs-example-modal-lg" id="big_modal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">Create Item</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body" id="bigmodalContent">


          </div>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </div>
</div>
</div>


<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>
<script type="text/javascript">
  $(window).on('load', function () {
    $('.overlay').hide();
  });

  function addslashes(str) {
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0').replace(/"/g, '&quot;');
  }

  function isNumberCheck(evt) {

    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46) {
      return false;
    }
    return true;
  }

  function checkitembooking(val) {
    $.ajax({
      url: "<?php echo \Yii::$app->getUrlManager()->createUrl('booking/item-check-autocomplete') ?>",
      dataType: 'json',
      type: 'get',
      data: {
        term: val,
        /* id:id_pass,
         type:value,*/
      },
      success: function (data, textStatus, jQxhr) {
        var result1 = "#itemselection-suggesstion-check-box";
        $(result1).show();
        var result2 = "#itemselection-description";
        var data_new = '<ul class="autocomplete add_new" style="min-height: 350px!important;">';
        data_new += "<li value=''>" + '<?= 'SELECT'; ?>' + "</li>";

        for (i = 0; i < data['item_details'].length; i++) {
          var image_name = 'img/no-image.jpg';
          // alert(data['item_details'][i]['images']!= '');
          if (data['item_details'][i]['images'] != '') {
            image_name = 'uploads/' + data['item_details'][i]['images'];
          }

          var item_name = addslashes(data['item_details'][i]['name']);
          data_new += '<li onClick="selectcheck(' + data['item_details'][i]['id'] + ')"><img src="' + image_name + '" style="height: 70px;width: 70px;">' + data['item_details'][i]['id'] + " - " + data['item_details'][i]['name'] + '</li>';

        }
        data_new += '</ul>';

        $(result1).html(data_new);
        // $(result2).prop('readonly',true);

      },
      error: function (jqXhr, textStatus, errorThrown) {
        //alert(errorThrown);
        if (errorThrown == 'Forbidden') {
          alert("<?= 'YOU_DONT_HAVE_ACCESS';?>");
        }
        //console.log( errorThrown );
      }
    });
  }

  function selectcheck(item_id) {
    url = '<?php echo Yii::$app->request->baseUrl . '/index.php?r=booking/item-booking-check' ?>';
    var result1 = "#itemselection-suggesstion-check-box";
    $(result1).hide();

    if (url != '') {
      $.ajax({
        url: url,
        type: 'post',
        async: false,
        data: {
          item_id: item_id,
          // plant:plant,
        },
        success: function (data) {

          if (data != null) {
            $("#itemselection-check").html(data);
          }
        },
        error: function (jqXhr, textStatus, errorThrown) {
          if (errorThrown == 'Forbidden') {
            alert("<?= 'YOU_DONT_HAVE_ACCESS';?>");
          }
        }

      });
    }
  }

  //$('#mdate').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
</script>
