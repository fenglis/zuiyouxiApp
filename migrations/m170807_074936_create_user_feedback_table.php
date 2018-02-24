<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_feedback`.
 */
class m170807_074936_create_user_feedback_table extends Migration
{
    public $table = 'user_feedback';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=MyISAM';
        }

        // Check if the table exists
        if ($this->db->schema->getTableSchema($this->table, true) === null) {
            $this->createTable($this->table, [
                'id'            => $this->primaryKey()->unsigned(),
                'userid'        => $this->integer()->unsigned()->notNull()->comment("用户id"),
                'username'      => $this->integer()->unsigned()->notNull()->comment("用户名"),
                'content'       => $this->text()->notNull()->comment('用户反馈内容'),
                'created'       => $this->integer()->unsigned()->notNull()->comment("反馈时间"),
            ], $tableOptions);

            $this->createIndex('userid',$this->table, ['userid'],false);
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->table);
    }
}
