<?php

use yii\db\Migration;

/**
 * Class m180730_091805_address_delivery
 */
class m180730_091805_address_delivery extends Migration
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

        $this->createTable('{{%address_delivery}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'id_user'       => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Пользователь'),
            'id_country'    => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('Страна'),
            'id_region'     => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('Регион'),
            'id_city'       => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Город'),
            'address'       => $this->string(255)->notNull()->comment('Адрес'),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_id_user_key_1',
            '{{%address_delivery}}',
            'id_user',
            '{{%user}}',
            'id'
        );

        $this->addForeignKey(
            'FK_id_country_key_2',
            '{{%address_delivery}}',
            'id_country',
            '{{%location_countries}}',
            'id_country'
        );

        $this->addForeignKey(
            'FK_id_region_key_3',
            '{{%address_delivery}}',
            'id_region',
            '{{%location_regions}}',
            'id_region'
        );

        $this->addForeignKey(
            'FK_id_city_key_4',
            '{{%address_delivery}}',
            'id_city',
            '{{%location_cities}}',
            'id_cities'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address_delivery}}');
    }

}
