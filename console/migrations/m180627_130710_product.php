<?php

use yii\db\Migration;
use common\component\Constatnts;

/**
 * Class m180627_130710_product
 */
class m180627_130710_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE='. Constatnts::DB_ENGINE;
        }

        $this->createTable('{{%products}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'name'          => $this->string(255)->notNull(),
            'id_cat'        => $this->integer()->unsigned()->defaultValue(0)->comment('ID категории'),
            'id_manager'    => $this->integer()->unsigned()->defaultValue(0)->comment('ID Менеджера'),
            'id_shop'       => $this->integer()->unsigned()->defaultValue(0)->comment('ID Магазина'),
            'price'         => $this->decimal(8,2)->defaultValue(0.00)->comment('Цена продукта'),
            'salePercent'   => $this->integer()->unsigned()->defaultValue(0)->comment('Скидка'),
            'created_at'    => $this->integer()->notNull()->defaultValue(0)->comment('Дата создания'),
            'updated_at'    => $this->integer()->notNull()->defaultValue(0)->comment('Дата изменения'),
            'published'     => $this->tinyInteger(2)->defaultValue(0)->notNull()->comment('Статус публикации'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
