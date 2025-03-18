<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
  <link rel="icon" type="image/x-icon" href="../../img/favicon.ico">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">
  <!--<div class="main-header">
   <nav class="navbar navbar-expand-lg navbar-dark bg-warning" style ="background-color: #591f2d !important;">
  <div class="container-fluid">
     <img
            src="../../img/logo.PNG"
            alt="navbar brand"
            class="navbar-brand"
            height="20"
          />
    <span class="mb-3 " id = "vend_name"></span>

  </div>
</nav>
</div>-->
  <div class="main-panel">
    <div class="overlay bg-primary2" style="min-height: 120px !important; background-color: #5d2331 !important;"></div>
    <div class="container container-futuristic">

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
  </div>
</div>

<!--<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?php /*= Html::encode(Yii::$app->name) */?> <?php /*= date('Y') */?></p>

        <p class="pull-right"><?php /*= Yii::powered() */?></p>
    </div>
</footer>-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
