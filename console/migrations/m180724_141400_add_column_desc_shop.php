<?php

use yii\db\Migration;
use common\models\shops\Shops;

/**
 * Class m180724_141400_add_column_desc_shop
 */
class m180724_141400_add_column_desc_shop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Shops::tableName(), 'description', $this->text()->comment('Описание магазина'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Shops::tableName(), 'description');
    }
}
