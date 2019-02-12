<?php

use yii\db\Migration;

/**
 * Class m180802_150220_comments
 */
class m180802_150220_comments extends Migration
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

        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'id_user' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('ID пользователя'),
            'id_menu' => $this->integer()->unsigned()->defaultValue(0)->notNull()->comment('ID Меню'),
            'text' => $this->text()->notNull()->comment('Текст отзыва'),
            'raiting' => $this->double()->defaultValue(.0)->notNull()->comment('Рейтинг'),
            'created_at' => $this->integer()->unsigned()->defaultValue(0)->comment('Дата добавления'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments}}');
    }


}
