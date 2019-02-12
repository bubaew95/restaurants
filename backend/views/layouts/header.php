<?php
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 25.06.2018
 * Time: 17:27
 */
?>
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
                        <img src="http://placehold.it/128x128" alt="">
                        <?= Yii::$app->user->identity->fullName?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?= \yii\helpers\Url::to(['profile/index'])?>">  Profile</a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <span class="badge bg-red pull-right">50%</span>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">Help</a>
                        </li>
                        <li>
                            <a href="<?= \yii\helpers\Url::to(['/site/logout'])?>"><i class="fa fa-sign-out pull-right"></i> Выход</a>
                        </li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
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
                </li>

            </ul>
        </nav>
    </div>

</div>
<!-- /top navigation -->
