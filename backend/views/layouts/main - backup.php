<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$bundle = yiister\gentelella\assets\Asset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .overlay-back,
.overlay-back-new{z-index:1050;background:rgba(0,0,0,0.4);border-radius:3px;
position:absolute;top:0;left:0;width:100%;height:100%;
}
.overlay{z-index:1100;background:rgba(0,0,0,0.3);border-radius:3px;
position:absolute;top:0;left:0;width:100%;height:100%;
}
    </style>
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">
<?php if(isset(Yii::$app->user->identity->id) && Yii::$app->user->identity->id!="") { ?>
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="index.php?r=site%2Findex" class="site_title"><i class="fa fa-paw"></i> <span>Panache</span></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="img/logo3.png" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2><?php echo (isset(Yii::$app->user->identity->id) && Yii::$app->user->identity->id!="")?Yii::$app->user->identity->username:'';  ?></h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <h3>General</h3>
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => [
                                    ["label" => "Home", "url" => ["site/index"], "icon" => "home"],
                                    [
                                        "label" => "Order",
                                        "url" => "#",
                                        "icon" => "table",
                                        "items" => [
                                            [
                                                "label" => "Booking",
                                                "url" => ["booking/index"],
                                                //"badge" => "123",
                                            ],
                                            [
                                                "label" => "Pickup Item",
                                                "url" =>  ["booking-item/index"],
                                                //"badge" => "new",
                                                // "badgeOptions" => ["class" => "label-success"],
                                            ],
                                            [
                                                "label" => "Return Item",
                                                "url" =>  ["booking-item/index-return"],
                                                //"badge" => "new",
                                                // "badgeOptions" => ["class" => "label-success"],
                                            ],
                                            [
                                                "label" => "Payment",
                                                "url" =>["booking/index-payment"],
                                                // "badge" => "!",
                                                //  "badgeOptions" => ["class" => "label-danger"],
                                            ],
                                        ],
                                    ],
                                     ["label" => "Expense", "url" => "#", "icon" => "eur",
                                     "items" => [
                                            [
                                                "label" => "Expense",
                                                "url" => ["expense/index"],
                                                //"badge" => "123",
                                            ],
                                            [
                                                "label" => "Expense Category",
                                                "url" =>  ["expsense-category/index"],
                                                //"badge" => "new",
                                                // "badgeOptions" => ["class" => "label-success"],
                                            ],
                                        ],
                                    ],
                                    ["label" => "Item Master", "url" => ["item/index"], "icon" => "database"],
                                  /*  ["label" => "Category", "url" => ["cater/index"], "icon" => "clone"],
                                    ["label" => "Type", "url" => ["type/index"], "icon" => "files-o"],*/
                                    ["label" => "Vendor", "url" => ["vendor/index"], "icon" => "user-o"],
                                    ["label" => "Customer", "url" => ["customer/index"], "icon" => "user"],
                                       [
                                        "label" => "Settings",
                                        "url" => "#",
                                        "icon" => "wrench",
                                        "items" => [
                                            [
                                                "label" => "Item",
                                                "url" => "#",
                                                "items" => [ 
                                                    [
                                                "label" => "Item Type",
                                                "url" => ["type/index"],
                                                //"badge" => "123",
                                            ],
                                            [
                                                "label" => "Item Category",
                                                "url" =>  ["cater/index"],
                                                //"badge" => "new",
                                                // "badgeOptions" => ["class" => "label-success"],
                                            ],
                                            [
                                                "label" => "Colors",
                                                "url" =>  ["color-master/index"],
                                                //"badge" => "new",
                                                // "badgeOptions" => ["class" => "label-success"],
                                            ],
                                            ],
                                            ],

                                           
                                            [
                                                "label" => "Expense Category",
                                                "url" =>["booking/index-payment"],
                                                // "badge" => "!",
                                                //  "badgeOptions" => ["class" => "label-danger"],
                                            ],
                                        ],
                                    ],
                                 /*   [
                                        "label" => "Widgets",
                                        "icon" => "th",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Menu", "url" => ["site/menu"]],
                                            ["label" => "Panel", "url" => ["site/panel"]],
                                        ],
                                    ],
*/
                                    [
                                        "label" => "Reports",
                                        "url" => "#",
                                        "icon" => "bar-chart",
                                        "items" => [
                                            [
                                                "label" => "Item",
                                                "url" => ["reports/index-item-master"],
                                            ],
                                            [
                                                "label" => "Booking",
                                                "url" => "#",
                                                "items" => [
                                                    [
                                                        "label" => "Booking Orders",
                                                        "url" => ["reports/index"]
                                                    ],
                                                    [
                                                        "label" => "Booking Item Report",
                                                        "url" => ["reports/index-item"],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        )
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <!-- <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a> -->
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>
<?php } ?>
        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <?php echo (isset(Yii::$app->user->identity->id) && Yii::$app->user->identity->id!="")?'<img src="http://placehold.it/128x128" alt="">'.Yii::$app->user->identity->username:'';  ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                               
                                <li>  <div class="">
                    <?php $form = ActiveForm::begin(['action'=>'index.php?r=site/logout','id'=>'logout_form','options' => ['method' => 'post']]); ?>
                     
                  <button href="#" class="btn btn-default btn-flat pull-right"  type="submit" ><?=Yii::t('yii', 'Sign out')?></button>
                    <?php  ActiveForm::end(); ?>
                </div>
                                </li>
                            </ul>
                        </li>

                        <!-- <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">6</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image" />
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image" />
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image" />
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                      <span class="image">
                                        <img src="http://placehold.it/128x128" alt="Profile Image" />
                                    </span>
                                        <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                                        <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a href="/">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li> -->

                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main" style="background-color: white">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>
            <div class="overlay" style="display:none;position: fixed">
                <center> <img src="img/loader.gif" style="height:100px;"></center>
                <center style="font-size: 20px;color: #3c60b5;margin-top: 30px"><b id="data_progress_bar" style="background-color: #ffffff"></b></center>
            </div>
            <div class="overlay-back" style="display:none" >

            </div>
            <?= $content ?>
        </div>
        <?php
        yii\bootstrap\Modal::begin([
            'id'=>'pModal',
        ]);
        echo "<div id='modalContent' ></div>";
        yii\bootstrap\Modal::end();

        ?>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">
               Panache Wears 
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
<script type="text/javascript">
    function addslashes( str ) {
        return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0').replace(/"/g, '&quot;');
    }
    function isNumberCheck(evt) {

        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=46) {
            return false;
        }
        return true;
    }
</script>