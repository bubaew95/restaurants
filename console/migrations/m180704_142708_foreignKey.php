<?php

use yii\db\Migration;

/**
 * Class m180704_142708_foreignKey
 */
class m180704_142708_foreignKey extends Migration
{
    public function safeUp()
    {
        /** menu
         * Внешний ключ для категорий
         */
        $this->addForeignKey(
            'FK_key_1',
            '{{%menu}}',
            'id_shop',
            '{{%shops}}',
            'id',
            'CASCADE'
        );

        /** composition
         * Внешний ключ для категорий
         */
        $this->addForeignKey(
            'FK_key_2',
            '{{%composition}}',
            'id_menu',
            '{{%menu}}',
            'id',
            'CASCADE'
        );

        /** card
         * Ключ связь с таблицей USER
         */
        $this->addForeignKey(
            'FK_key_3',
            '{{%card}}',
            'id_user',
            '{{%user}}',
            'id'
        );

        //card
        $this->addForeignKey(
            'FK_key_4',
            '{{%card}}',
            'id_shop',
            '{{%shops}}',
            'id'
        );

        //card
        $this->addForeignKey(
            'FK_key_5',
            '{{%card}}',
            'id_tranpor',
            '{{%user}}',
            'id'
        );

        //card
        $this->addForeignKey(
            'FK_key_6',
            '{{%card}}',
            'id_status',
            '{{%status}}',
            'id'
        );

        // Позже

        /** products
         * Внешний ключ для категорий
         */
        $this->addForeignKey(
            'FK_key_7',
            '{{%products}}',
            'id_cat',
            '{{%categories}}',
            'id'
        );

        /** products
         * Внешний ключ для менеджеров
         */
        $this->addForeignKey(
            'FK_key_8',
            '{{%products}}',
            'id_manager',
            '{{%user}}',
            'id'
        );

        /** products
         * Внешний ключ для менеджеров
         */
        $this->addForeignKey(
            'FK_key_9',
            '{{%products}}',
            'id_shop',
            '{{%shops}}',
            'id'
        );

        /** orders
         * Внешний ключ для продукта
         */
        $this->addForeignKey(
            'FK_key_10',
            '{{%orders}}',
            'id_menu',
            '{{%menu}}',
            'id',
            'CASCADE'
        );

        /** shops
         * Внешний ключ для категорий
         */
        $this->addForeignKey(
            'FK_key_11',
            '{{%shops}}',
            'id_manager',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        //menu
        $this->addForeignKey(
            'FK_key_12',
            '{{%menu}}',
            'id_cat',
            '{{%categories}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_key_1',       '{{%menu}}');
        $this->dropForeignKey('FK_key_2',       '{{%composition}}');
        $this->dropForeignKey('FK_key_3',       '{{%card}}');
        $this->dropForeignKey('FK_key_4',       '{{%card}}');
        $this->dropForeignKey('FK_key_5',       '{{%card}}');
        $this->dropForeignKey('FK_key_6',       '{{%card}}');
        $this->dropForeignKey('FK_key_7',       '{{%products}}');
        $this->dropForeignKey('FK_key_8',       '{{%products}}');
        $this->dropForeignKey('FK_key_9',       '{{%products}}');
        $this->dropForeignKey('FK_key_10',      '{{%orders}}');
        $this->dropForeignKey('FK_key_11',      '{{%shops}}');
        $this->dropForeignKey('FK_key_12',      '{{%menu}}');
    }
}
