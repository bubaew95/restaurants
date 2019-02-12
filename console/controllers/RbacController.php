<?php

namespace console\controllers;

use backend\rbac\UserRoleRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли админа и редактора новостей
        $admin      = $auth->createRole('admin');
//        $admin->description = "Роль администратора";
//        $admin->ruleName = $rule->name;

        $manager    = $auth->createRole('manager');
//        $manager->description = "Роль менеджера";
//        $manager->ruleName = $rule->name;

        $transport  = $auth->createRole('transport');
//        $transport->description = "Роль развозчика";
//        $transport->ruleName = $rule->name;

        // запишем их в БД
        $auth->add($admin);
        $auth->add($manager);
        $auth->add($transport);

//        $rule = new UserRoleRule();
//        $auth->add($rule);

        // Создаем разрешения. Например, просмотр админки viewAdminPage и редактирование новости updateNews
        $viewAdminPage = $auth->createPermission('isAdminEnter');
        $viewAdminPage->description = 'Вход в админку';
        //$viewAdminPage->ruleName = $rule->name;
        // Запишем эти разрешения в БД
        $auth->add($viewAdminPage);

        $auth->addChild($admin,     $transport);
        $auth->addChild($admin,     $manager);
        $auth->addChild($transport, $viewAdminPage);
        $auth->addChild($manager,   $viewAdminPage);
        $auth->addChild($admin,     $viewAdminPage);


        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);
        $auth->assign($manager, 2);
        $auth->assign($transport, 3);
    }

}
