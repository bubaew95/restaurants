<?php

use yii\db\Migration;

/**
 * Class m180802_154830_Ingredients
 */
class m180802_154830_Ingredients extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            \common\models\Menu::tableName(),
            'ingredients',
            $this->string(1024)->comment('Ингедиенты')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Menu::tableName(), 'ingredients');
    }

}
