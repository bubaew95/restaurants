<?php

use yii\db\Migration;

/**
 * Class m180813_104336_add_column_created_at
 */
class m180813_104336_add_column_created_at extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            \common\models\Orders::tableName(),
            'created_at',
            $this->integer()->unsigned()->defaultValue(0)->comment('Дата заказа')
        );

        $this->addColumn(
            \common\models\Orders::tableName(),
            'updated_at',
            $this->integer()->unsigned()->defaultValue(0)->comment('Дата изменения')
        );

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=' . \common\component\Constatnts::DB_ENGINE;
        }
        $this->createTable('{{%statistic_menu}}', [
            'id'          => $this->primaryKey()->unsigned()->notNull(),
            'id_menu'     => $this->integer()->unsigned()->notNull()->comment('ID Блюда'),
            'raiting'      => $this->double()->notNull()->defaultValue(0.00)->comment('Рейтинг'),
            'count_comm'  => $this->integer()->unsigned()->defaultValue(0)->comment('кол-во отзывов'),
            'count_order' => $this->integer()->unsigned()->defaultValue(0)->comment('кол-во заказов'),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_statistic_key_one',
            '{{%statistic_menu}}',
            'id_menu',
            \common\models\Menu::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%statistic_menu}}');
        $this->dropColumn(\common\models\Orders::tableName(), 'created_at');
        $this->dropColumn(\common\models\Orders::tableName(), 'updated_at');
    }
}
