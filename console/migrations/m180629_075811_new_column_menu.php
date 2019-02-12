<?php

use yii\db\Migration;

/**
 * Class m180629_075811_new_column_menu
 */
class m180629_075811_new_column_menu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%menu}}', 'isToday', $this->tinyInteger(1)->defaultValue(0)->comment('Меню на сегодня'));
        $this->addColumn('{{%menu}}', 'img', $this->string()->defaultValue('no-image.png')->comment('Изображение'));
        $this->addColumn('{{%menu}}', 'price', $this->decimal(8,2)->defaultValue(0.00)->comment('Цена'));
        $this->addColumn('{{%menu}}', 'id_cat', $this->integer()->unsigned()->defaultValue(0)->comment('Категория'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%menu}}', 'isToday');
        $this->dropColumn('{{%menu}}', 'img');
        $this->dropColumn('{{%menu}}', 'price');
        $this->dropColumn('{{%menu}}', 'id_cat');
        $this->dropColumn('{{%orders}}', 'id_menu');
    }
}
