<?php

use yii\db\Migration;

/**
 * Class m180704_131742_table_card
 */
class m180704_131742_table_card extends Migration
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
        $this->createTable('{{%card}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'total_sum'     => $this->string(255)->notNull()->comment('Название категории'),
            'total_qty'     => $this->integer()->notNull()->comment('ID магазина'),
            'id_user'       => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('ID заказчика'),
            'id_shop'       => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('ID магазина'),
            'id_tranpor'    => $this->integer()->unsigned()->defaultValue(0)->comment('ID доставщика'),
            'id_status'     => $this->integer()->unsigned()->unsigned()->defaultValue(0)->notNull()->comment('Статус заказа'),
            'created_at'    => $this->integer()->notNull()->defaultValue(0)->comment('Дата создания'),
            'updated_at'    => $this->integer()->notNull()->defaultValue(0)->comment('Дата изменения'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%card}}');
        $this->dropForeignKey('FK_id_user', '{{%card}}');
        $this->dropForeignKey('FK_id_shop', '{{%card}}');
        $this->dropForeignKey('FK_id_tranpor', '{{%card}}');
        $this->dropForeignKey('FK_id_status', '{{%card}}');
    }
}
