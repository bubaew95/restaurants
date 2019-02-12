<?php

use yii\db\Migration;

/**
 * Class m180730_093012_rename_order_column
 */
class m180730_093012_rename_order_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%orders}}', 'id_card', 'id_address_delivery');
        $this->addColumn(
            '{{%orders}}',
            'id_delivery',
            $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Способ доставки')
        );

        $this->addForeignKey(
            'FK_id_address_delivery_key_1',
            '{{%orders}}',
            'id_address_delivery',
            '{{%address_delivery}}',
            'id'
        );

        $this->addForeignKey(
            'FK_id_delivery_key_2',
            '{{%orders}}',
            'id_delivery',
            '{{%delivery}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%orders}}', 'id_address_delivery', 'id_card');
        $this->dropColumn('{{%orders}}', 'id_delivery');
        $this->dropForeignKey('FK_id_address_delivery_key_1', '{{%orders}}');
        $this->dropForeignKey('FK_id_delivery_key_2', '{{%orders}}');
    }
}
