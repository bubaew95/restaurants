<?php

use yii\db\Migration;

/**
 * Class m180710_093203_add_column_orders
 */
class m180710_093203_add_column_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%orders}}',
            'id_user',
            $this->integer()->unsigned()->defaultValue(0)->comment('ID заказчика')
        );


        $this->addForeignKey(
            'FK_ID_USER',
            '{{%orders}}',
            'id_user',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'FK_ID_SHOPS',
            '{{%orders}}',
            'id_shop',
            '{{%shops}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'FK_ID_STATUS',
            '{{%orders}}',
            'id_status',
            '{{%status}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_ID_SHOPS', '{{%orders}}');
        $this->dropForeignKey('FK_ID_USER', '{{%orders}}');
        $this->dropForeignKey('FK_ID_STATUS', '{{%orders}}');
        $this->dropColumn('{{%orders}}', 'id_user');
    }
}
