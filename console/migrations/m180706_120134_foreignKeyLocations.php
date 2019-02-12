<?php

use yii\db\Migration;

/**
 * Class m180706_120134_foreignKeyLocations
 */
class m180706_120134_foreignKeyLocations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try {
            $this->addForeignKey(
                'FK_id_location_country',
                '{{%location_regions}}',
                'id_country',
                '{{%location_countries}}',
                'id_country'
            );
            $this->addForeignKey(
                'FK_id_location_regions',
                '{{%location_cities}}',
                'id_region',
                '{{%location_regions}}',
                'id_region'
            );
        }catch (Exception $ex) {
            print ($ex->getMessage());
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_id_location_country', '{{%location_regions}}');
        $this->dropForeignKey('FK_id_location_regions', '{{%location_cities}}');
    }
}
