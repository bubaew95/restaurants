<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 25.06.2018
 * Time: 17:28
 */
use yii\helpers\Url;
use common\component\Constatnts;

if(Yii::$app->user->can(\common\component\Constatnts::RBACK_TRANSPORT)) {
    $countOrders = \common\models\Orders::find()->where(['id_status' => 1])->andWhere(['id_delivery' => 2])->count();
} else {
    $countOrders = \common\models\Orders::find()->innerJoinWith('userShop')->count();
}

?>

<div class="col-md-3 left_col">
    <div class="left_col scroll-view">

        <div class="navbar nav_title" style="border: 0;">
            <a href="/admin" class="site_title"><i class="fa fa-paw"></i> <span>Админка</span></a>
        </div>
        <div class="clearfix"></div>

        <!-- menu prile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="http://placehold.it/128x128" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Добро пожаловать</span>
                <h2><?= Yii::$app->user->identity->fullName?></h2>
            </div>
        </div>
        <!-- /menu prile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
                <h3>Навигация</h3>

                <?php
                    $items['home']      = ["label" => "Главная",    "url" => "/", "icon" => "home"];

                    if (\Yii::$app->user->can(\common\component\Constatnts::RBACK_MANAGER))
                    {
                        $items['menu']      = ["label" => "Меню",       "url" => Url::to(['menu/index']),       "icon" => "home"];
                        //$items['products']  = ["label" => "Продукты",   "url" => Url::to(['products/index']),   "icon" => "home"];
                        $items['shops']     = ["label" => "Рестораны",  "url" => Url::to(['shops/index']),      "icon" => "home"];
                    }
                    //<small class="label-success label pull-right">2</small>
                    $items['card'] = ["label" => "Заказы", "url" => Url::to(['orders/index']), "icon" => "home",];

                    if($countOrders > 0) :
                        $items['card']['badge'] = $countOrders;
                        $items['card']['badgeOptions'] = ["class" => "label-success"];
                    endif;

                    if(\Yii::$app->user->can(Constatnts::RBACK_ADMIN))
                    {
                        $items['category']  = ["label" => "Категории",      "url" => Url::to(['category/index']),   "icon" => "home"];
                        $items['status']    = ["label" => "Статус",         "url" => Url::to(['status/index']),     "icon" => "home"];
                        $items['users']     = ["label" => "Пользователи",   "url" => Url::to(['users/index']),      "icon" => "home"];
                        $items['users']     = ["label" => "Страницы",       "url" => Url::to(['pages/index']),      "icon" => "home"];
                    }

                    if(\Yii::$app->user->can(Constatnts::RBACK_MANAGER)) {
                        $items['slider'] = ["label" => "Слайдер", "url" => Url::to(['slider/index']), "icon" => "home"];
                    }

                    if(1 != 1) :

                        $items['layout']    = ["label"  => "Layout",        "url" => ["site/layout"],       "icon" => "files-o"];
                        $items['error-page'] = ["label" => "Error page",    "url" => ["site/error-page"],   "icon" => "close"];
                        $items['widgets'] = [
                                "label" => "Widgets",
                                "icon" => "th",
                                "url" => "#",
                                "items" => [
                                    ["label" => "Menu", "url" => ["site/menu"]],
                                    ["label" => "Panel", "url" => ["site/panel"]],
                                ],
                            ];
                        $items['badges'] = [
                                "label" => "Badges",
                                "url" => "#",
                                "icon" => "table",
                                "items" => [
                                    [
                                        "label" => "Default",
                                        "url" => "#",
                                        "badge" => "123",
                                    ],
                                    [
                                        "label" => "Success",
                                        "url" => "#",
                                        "badge" => "new",
                                        "badgeOptions" => ["class" => "label-success"],
                                    ],
                                    [
                                        "label" => "Danger",
                                        "url" => "#",
                                        "badge" => "!",
                                        "badgeOptions" => ["class" => "label-danger"],
                                    ],
                                ],
                            ];
                        $items['multilevel'] = [
                                "label" => "Multilevel",
                                "url" => "#",
                                "icon" => "table",
                                "items" => [
                                    [
                                        "label" => "Second level 1",
                                        "url" => "#",
                                    ],
                                    [
                                        "label" => "Second level 2",
                                        "url" => "#",
                                        "items" => [
                                            [
                                                "label" => "Third level 1",
                                                "url" => "#",
                                            ],
                                            [
                                                "label" => "Third level 2",
                                                "url" => "#",
                                            ],
                                        ],
                                    ],
                                ],
                            ];
                    endif;
                ?>
                <?= \yiister\gentelella\widgets\Menu::widget(
                    [
                        "items" => $items
                    ]
                ) ?>
            </div>

        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
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
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
