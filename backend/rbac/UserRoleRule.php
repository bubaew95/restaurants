<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 06.07.2018
 * Time: 16:03
 */

namespace backend\rbac;


use common\models\User;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\rbac\Rule;

class UserRoleRule extends Rule
{
    public $name = 'userRole';

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\user::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        //$user = ArrayHelper::getValue($params, 'user', user::findOne($user));
        return $params['user'] == 1;
    }
}