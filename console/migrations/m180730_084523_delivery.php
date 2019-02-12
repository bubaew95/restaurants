<?php

use yii\db\Migration;

/**
 * Class m180730_084523_delivery
 */
class m180730_084523_delivery extends Migration
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

        $this->createTable('{{%delivery}}', [
            'id'            => $this->primaryKey()->unsigned()->notNull(),
            'name'          => $this->string(255)->notNull()->comment('Название доставки'),
            'description'   => $this->string(512)->comment('Описание доставки'),
            'price'         => $this->decimal(8,2)->defaultValue(0)->comment('Цена доставки'),
            'not_csd_pr'    => $this->integer()->unsigned()->defaultValue(0)->comment('Не учитывать цену'),
        ], $tableOptions);

        $arrs = [
            [
                'name' => 'Самовызов',
                'description' => 'Вы должны явиться в наш ресторан',
                'price' => .00,
                'not_csd_pr' => 0
            ],
            [
                'name' => 'Курьером',
                'description' => 'Курьерская доставка',
                'price' => 450.00,
                'not_csd_pr' => 1500
            ],
        ];

        foreach ($arrs as $item) {
            $this->insert('{{%delivery}}', [
                'name' => $item['name'],
                'description' => $item['description'],
                'price' => $item['price'],
                'not_csd_pr' => $item['not_csd_pr']
            ]);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%delivery}}');
    }
}
