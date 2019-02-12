<?php

use yii\db\Migration;

/**
 * Class m180628_090155_status
 */
class m180628_090155_status extends Migration
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
        $this->createTable('{{%status}}', [
            'id'    => $this->primaryKey()->unsigned()->notNull(),
            'name'  => $this->string(255)->notNull()->comment('Название статуса')
        ], $tableOptions);

        $status = ['В ожидании', 'Оплачен', 'В обработке', 'Отправлен', 'Доставлен', 'Отменен', 'Готово'];
        foreach ($status as $item) {
            $this->insert('{{%status}}', [
                'name' => $item,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
