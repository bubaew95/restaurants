<?php

use yii\db\Migration;

/**
 * Class m180814_130948_add_column_raiting_shop
 */
class m180814_130948_add_column_raiting_shop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Shops::tableName(),
    'raiting',
            $this->double()->defaultValue(0)->comment('Рейтинг магазина')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Shops::tableName(), 'raiting');
    }
}
