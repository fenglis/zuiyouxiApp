<?php

use yii\db\Migration;

/**
 * Handles the creation of table `report`.
 */
class m170720_092315_create_report_table extends Migration
{
    public $table = 'report';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Check if the table exists
        if ($this->db->schema->getTableSchema($this->table, true) === null) {
            $this->createTable($this->table, [
                'report_id'     => $this->primaryKey(),
                'project_id'    => $this->integer()->unsigned()->notNull()->comment('项目id'),
                'post_id'       => $this->integer()->unsigned()->notNull()->comment('评论表id'),
                'type'          => $this->boolean()->notNull()->comment('举报类型'),
                'info'          => $this->text()->notNull()->comment("举报内容"),
                'reply_msg'     => $this->text()->notNull()->comment("回复举报内容"),
                'user_id'       => $this->integer()->unsigned()->notNull()->comment('举报用户id'),
                'user_name'     => $this->string(60)->notNull()->comment('举报用户名'),
                'status'        => $this->boolean()->unsigned()->notNull()->comment('状态'),
                'created'       => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('添加时间'),
            ], $tableOptions);

            $this->createIndex('status',$this->table, ['status'],false);
            $this->createIndex('post_id',$this->table, ['post_id'],false);
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
