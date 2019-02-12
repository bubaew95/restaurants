<?php

use yii\db\Migration;
use common\component\Constatnts;

/**
 * Class m180627_135603_shops
 */
class m180627_135603_shops extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=' . Constatnts::DB_ENGINE;
        }
        $this->createTable('{{%shops}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'id_manager'    => $this->integer()->unsigned()->notNull()->comment('ID менеджера'),
            'name'          => $this->string(255)->notNull()->comment('Название'),
            'tr_name'       => $this->string(255)->unique()->notNull()->comment('Анг.название'),
            'logo'          => $this->string(255)->defaultValue("no-logo.png")->comment('Логотип'),
            'created_at'    => $this->integer()->unsigned()->notNull()->comment('Дата создания'),
            'updated_at'    => $this->integer()->unsigned()->notNull()->comment('Дата изменения'),
            'published'     => $this->tinyInteger(2)->defaultValue(0)->notNull()->comment('Статус публикации'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shops}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180627_135603_shops cannot be reverted.\n";

        return false;
    }
    */
}
