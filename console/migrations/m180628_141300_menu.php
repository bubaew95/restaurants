<?php

use yii\db\Migration;

/**
 * Class m180628_141300_menu
 */
class m180628_141300_menu extends Migration
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
        $this->createTable('{{%menu}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'name'          => $this->string(255)->notNull()->comment('Название категории'),
            'id_shop'       => $this->integer()->unsigned()->notNull()->comment('ID магазина'),
            'portion'       => $this->string(1024)->comment('Порция'),
            'created_at'    => $this->integer()->notNull()->defaultValue(0)->comment('Дата создания'),
            'updated_at'    => $this->integer()->notNull()->defaultValue(0)->comment('Дата изменения'),
        ], $tableOptions);

        $this->createTable('{{%composition}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'key'           => $this->string(255)->notNull()->comment('Название состава'),
            'value'         => $this->string(255)->notNull()->comment('Свойство состава'),
            'id_menu'       => $this->integer()->unsigned()->notNull()->comment('ID меню'),
            'created_at'    => $this->integer()->notNull()->defaultValue(0)->comment('Дата создания'),
            'updated_at'    => $this->integer()->notNull()->defaultValue(0)->comment('Дата изменения'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_id_menu','{{%composition}}');
        $this->dropTable('{{%menu}}');
        $this->dropTable('{{%composition}}');
    }
}
