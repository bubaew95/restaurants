<?php

use yii\db\Migration;
use common\models\users\UserData;

/**
 * Class m180727_143653_add_column_index_user_data
 */
class m180727_143653_add_column_index_user_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            UserData::tableName(),
            'index',
            $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('Почтовый индекс')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(UserData::tableName(), 'index');
    }
}
