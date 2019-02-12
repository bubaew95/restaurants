<?php

use yii\db\Migration;
use common\models\shops\Shops;
use common\models\location\LocationCities;
use common\models\location\LocationCountries;
use common\models\location\LocationRegions;

/**
 * Class m180725_131206_add_column_restaurant
 */
class m180725_131206_add_column_restaurant extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Shops::tableName(), 'id_country',  $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('Страна'));
        $this->addColumn(Shops::tableName(), 'id_region',   $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('Регион'));
        $this->addColumn(Shops::tableName(), 'id_city',     $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('Город'));
        $this->addColumn(Shops::tableName(), 'address',     $this->string(255)->comment('Адрес'));
        $this->addColumn(Shops::tableName(), 'index',       $this->integer()->defaultValue(0)->notNull()->comment('Индекс'));
        $this->addColumn(Shops::tableName(), 'phone',       $this->string(20)->defaultValue('(000) 000-00-00')->notNull()->comment('Телефон'));
        $this->addColumn(Shops::tableName(), 'email',       $this->string(50)->comment('Еmail'));

        $this->addForeignKey(
            'FK_country_key_1',
            Shops::tableName(),
            'id_country',
            LocationCountries::tableName(),
            'id_country'
        );

        $this->addForeignKey(
            'FK_region_key_2',
            Shops::tableName(),
            'id_region',
            LocationRegions::tableName(),
            'id_region'
        );

        $this->addForeignKey(
            'FK_city_key_3',
            Shops::tableName(),
            'id_city',
            LocationCities::tableName(),
            'id_cities'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Shops::tableName(), 'country');
        $this->dropColumn(Shops::tableName(), 'region');
        $this->dropColumn(Shops::tableName(), 'city');
        $this->dropColumn(Shops::tableName(), 'address');
        $this->dropColumn(Shops::tableName(), 'index');
        $this->dropColumn(Shops::tableName(), 'phone');
        $this->dropColumn(Shops::tableName(), 'email');

        $this->dropForeignKey('FK_country_key_1', Shops::tableName());
        $this->dropForeignKey('FK_region_key_2', Shops::tableName());
        $this->dropForeignKey('FK_city_key_3', Shops::tableName());
    }
}
