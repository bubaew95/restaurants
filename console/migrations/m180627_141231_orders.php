<?php

use yii\db\Migration;

/**
 * Class m180627_141231_orders
 */
class m180627_141231_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=' . \common\component\Constatnts::DB_ENGINE;
        }

        $this->createTable('{{%orders}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'id_menu'       => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('ID продукта'),
            'id_card'       => $this->integer()->unsigned()->defaultValue(0)->comment('ID заказа'),
            'qty'           => $this->integer()->defaultValue(0)->comment('Кол-во'),
            'id_shop'       => $this->integer()->unsigned()->defaultValue(0)->comment('ID Магазина'),
            'id_status'     => $this->integer()->unsigned()->defaultValue(0)->comment('ID статус'),
            'id_transport'  => $this->integer()->unsigned()->defaultValue(0)->comment('ID транпорта'),
            'price'         => $this->decimal(8,2)->defaultValue(.00)->comment('Цена'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
