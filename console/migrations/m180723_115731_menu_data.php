<?php

use yii\db\Migration;
use common\models\category\Categories;

/**
 * Class m180723_115731_menu_data
 */
class m180723_115731_menu_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $arrs = [
            'Холодные закуски', 'Холодные закуски', 'Горячие закуски',
            'Первые блюда', 'Вторые горячие блюда', 'Гарниры', 'Десерты'
        ];
        foreach($arrs as $arr) {
            $this->insert(Categories::tableName(), [
                'name' => $arr,
                'tr_name' => ($arr)
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
