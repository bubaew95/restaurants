<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 27.06.2018
 * Time: 16:52
 */
namespace common\component;

class Constatnts
{
    const RBACK_ADMIN           = 'admin';          //Роль админа
    const RBACK_MANAGER         = 'manager';        // роль менеджера ресторана
    const RBACK_TRANSPORT       = 'transport';      //роль доставщика
    const RBACK_IS_VIEW_ADMIN   = 'isAdminEnter';   //доступ в админку

    const DB_ENGINE = 'InnoDB';

    //Селектор цвета текста
    const COLOR_STATUS = [
        1 => [
            'class' => 'bg-info'
        ],
        2 => [
            'class' => 'bg-warning'
        ],
        3 => [
            'class' => 'bg-primary'
        ],
        4 => [
            'class' => 'bg-secondary'
        ],
        5 => [
            'class' => 'bg-success'
        ],
        6 => [
            'class' => 'bg-danger'
        ],
        7 => [
            'class' => 'bg-success'
        ],
    ];

    const COLOR_PUBLISH = [
        0 => [
            'class' => 'bg-danger'
        ],
        1 => [
            'class' => 'bg-success'
        ],
    ];

}