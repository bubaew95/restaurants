<?php

use yii\db\Migration;

/**
 * Class m180706_111734_user_data
 */
class m180706_111734_user_data extends Migration
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

        $this->createTable('{{%user_data}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'fio'           => $this->string(255)->notNull()->comment('ФИО'),
            'phone'         => $this->string(20)->defaultValue("0")->comment('Номер телефона'),
            'id_user'       => $this->integer()->unsigned()->notNull()->comment('ID пользователя'),
            'birthday'      => $this->date()->comment('Дата рождения'),
            'id_country'    => $this->integer()->unsigned()->defaultValue(0)->comment('Страна'),
            'id_region'     => $this->integer()->unsigned()->defaultValue(0)->comment('Регион'),
            'id_city'       => $this->integer()->unsigned()->defaultValue(0)->comment('Город'),
            'address'       => $this->string(255)->comment('Адресс'),
            'ip_address'    => $this->integer()->defaultValue(0)->unsigned()->comment('IP адрес'),
            'user_agent'    => $this->string(255)->defaultValue('')->comment('Браузер пользователя'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_data}}');
    }
}
