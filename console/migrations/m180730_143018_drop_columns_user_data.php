<?php

use yii\db\Migration;

/**
 * Class m180730_143018_drop_columns_user_data
 */
class m180730_143018_drop_columns_user_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%user_data}}', 'id_country');
        $this->dropColumn('{{%user_data}}', 'id_region');
        $this->dropColumn('{{%user_data}}', 'id_city');
        $this->dropColumn('{{%user_data}}', 'address');
        $this->dropColumn('{{%user_data}}', 'index');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%user_data}}', 'id_country', $this->integer()->unsigned()->defaultValue(0)->comment('Страна'));
        $this->addColumn('{{%user_data}}', 'id_region', $this->integer()->unsigned()->defaultValue(0)->comment('Регион'));
        $this->addColumn('{{%user_data}}', 'id_city', $this->integer()->unsigned()->defaultValue(0)->comment('Город'));
        $this->addColumn('{{%user_data}}', 'address', $this->string(255)->comment('Адресс'));
        $this->addColumn('{{%user_data}}', 'index', $this->integer()->defaultValue(0)->comment('Индекс'));
    }
}
