<?php

use yii\db\Migration;

/**
 * Class m180808_102048_slider
 */
class m180808_102048_slider extends Migration
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

        $this->createTable('{{%slider_img}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'image' => $this->string(255)->notNull()->comment('путь к изобрежению'),
            'id_shop' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('ID ресторана'),
        ], $tableOptions);

        $this->createTable('{{%slider_text}}', [
            'id'                    => $this->primaryKey()->unsigned()->notNull(),
            'id_slider'             => $this->integer()->unsigned()->defaultValue(0)->comment('ID слайдера'),
            'blob'                  => $this->string(255)->notNull()->comment('Текст'),
            'type'                  => $this->integer(1)->defaultValue(0)->unsigned()->comment('Тип строки'),
            'data_x'                => $this->integer()->unsigned()->defaultValue(0)->comment('data x'),
            'data_y'                => $this->integer()->unsigned()->defaultValue(0)->comment('data y'),
            'data_splitin'          => $this->string(20)->comment('splitin'),
            'data_splitout'         => $this->string(20)->comment('splitout'),
            'data_elementdelay'     => $this->double()->defaultValue(0)->comment('elementdelay'),
            'data_start'            => $this->integer()->unsigned()->defaultValue(0)->comment('start'),
            'data_speed'            => $this->integer()->defaultValue(0)->comment('speed'),
            'data_easing'           => $this->string(20)->comment('easing'),
            'data_customin'         => $this->string(255)->comment('customin'),
            'data_customout'        => $this->string(255)->comment('customout'),
            'data_endspeed'         => $this->integer()->unsigned()->defaultValue(0)->comment('endspeed'),
            'data_endeasing'        => $this->string(20)->comment('endeasing'),
            'data_captionhidden'    => $this->string(255)->comment('captionhidden'),
            'style'                 => $this->string(100)->comment('style'),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_id_shop_key_1',
            '{{%slider_img}}',
            'id_shop',
            \common\models\Shops::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%slider_img}}');
        $this->dropTable('{{%slider_text}}');
    }
}
