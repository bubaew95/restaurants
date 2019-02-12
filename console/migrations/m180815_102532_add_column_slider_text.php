<?php

use yii\db\Migration;

/**
 * Class m180815_102532_add_column_slider_text
 */
class m180815_102532_add_column_slider_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%slider_text}}',
            'classes',
            $this->string(512)->comment('Стили текста')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%slider_text}}', 'classes');
    }
}
