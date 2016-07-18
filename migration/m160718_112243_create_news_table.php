<?php

use yii\db\Migration;

/**
 * Handles the creation for table `news`.
 */
class m160718_112243_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mail_list', [
            'id'            => $this->primaryKey(),
            'email'         => $this->string()->notNull(),
            'special_id'    => $this->integer(),
            'template'      => $this->string(),
            'json_values'   => $this->string(),
            'create_date'   => $this->string(),
        ]);

        $this->createTable('mail_status', [
            'id'            => $this->primaryKey(),
            'mail_list_id'  => $this->integer(),
            'email'         => $this->string()->notNull(),
            'status'        => $this->smallInteger(),
            'send_date'     => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('news');
    }
}
