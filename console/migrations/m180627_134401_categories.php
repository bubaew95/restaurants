<?php

use yii\db\Migration;
use common\component\Constatnts;

/**
 * Class m180627_134401_categories
 */
class m180627_134401_categories extends Migration
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
        $this->createTable('{{%categories}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'name'          => $this->string(255)->notNull()->comment('Название категории'),
            'tr_name'       => $this->string(255)->notNull()->comment('Анг.название категории')
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
