<?php

use yii\db\Migration;

/**
 * Class m180816_130042_table_pages
 */
class m180816_130042_table_pages extends Migration
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
        $this->createTable('{{%pages}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'name'          => $this->string(255)->notNull()->comment('Название страницы'),
            'tr_name'       => $this->string(255)->notNull()->comment('Название на латинице'),
            'text'          => $this->text()->comment('Текст'),
            'created_at'    => $this->integer()->unsigned()->defaultValue(0)->comment('Дата создания'),
            'updated_at'    => $this->integer()->unsigned()->defaultValue(0)->comment('Дата изменения'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pages}}');
    }
}
