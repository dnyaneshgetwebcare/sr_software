<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon.ico">
  <title>Soyara Rental Couture </title>
  <!-- Bootstrap Core CSS -->

  <!-- Custom CSS -->
  <link href="css/style.css" rel="stylesheet">
  <!-- You can change the theme colors from here -->
<link rel="stylesheet" href="kai-admin-assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="kai-admin-assets/css/plugins.min.css">
	<link rel="stylesheet" href="kai-admin-assets/css/kaiadmin.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="login" cz-shortcut-listen="true">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<!--<div class="preloader">
  <svg class="circular" viewBox="25 25 50 50">
    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
  </svg>
</div>-->
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div class="wrapper wrapper-login wrapper-login-full p-0">
  <div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center
  " style="background-color: #5C2431">
    <img src = "img/logo2.JPG" style="height: auto; width: 230px;" />
			<h3 class="title fw-bold text-white mb-3">Soyara Rental Couture</h3>
			<p class="subtitle text-white op-7">Rent. Rock. Return. Repeat the Style!</p>
		</div>

  <div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
    <div class="login-box card">
      <div class="container container-login container-transparent animated">
        <!--<form class="form-horizontal form-material" id="loginform" action="index.html">-->
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'class' => 'form-horizontal form-material']); ?>
        <h3 class="text-center">Sign In</h3>
        <div class="form-group ">
          <label for="username"><b>Username</b></label>
          <!--<div class="col-xs-12">
              <input class="form-control" type="text" required="" placeholder="Username"> </div>-->
          <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Username'])->label(false) ?>
        </div>
        <div class="form-group">
          <label for="username"><b>Password</b></label>
          <!-- <div class="col-xs-12">
               <input class="form-control" type="password" required="" placeholder="Password"> </div>-->
          <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <div class="checkbox checkbox-primary pull-left p-t-0">
              <!--<input id="checkbox-signup" type="checkbox">-->
              <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'deposite_applicable_class check', 'data-checkbox' => "icheckbox_square-red", "value" => 1])->label(false) ?>
              <!--<label for="checkbox-signup"> Remember me </label>-->
            </div>
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">

            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-info btn-lg btn-block text-uppercase waves-effect waves-light', 'name' => 'login-button']) ?>

            <!--<button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>-->
          </div>
        </div>


        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>

</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="js/waves.js"></script>
<!--Menu sidebar -->
<script src="js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!--Custom JavaScript -->
<script src="js/custom.min.js"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>



