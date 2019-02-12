<?php

use yii\db\Migration;
use common\models\menu\Menu;

/**
 * Class m180724_094037_rename_colum_menu
 */
class m180724_094037_rename_colum_menu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn(Menu::tableName(), 'portion', 'desc');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn(Menu::tableName(), 'desc', 'portion');
    }
}
