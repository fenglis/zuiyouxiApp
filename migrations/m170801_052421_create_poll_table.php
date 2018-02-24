<?php

use yii\db\Migration;

/**
 * Handles the creation of table `poll`.
 */
class m170801_052421_create_poll_table extends Migration
{
    public $table = 'poll';
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
                'pollid'        => $this->primaryKey()->unsigned(),
                'project_id'    => $this->integer()->unsigned()->notNull()->defaultValue(1)->comment("项目id"),
                'content'       => $this->string(255)->notNull()->comment('投票主题内容'),
                'img'           => $this->string(255)->notNull()->comment('主题图片'),
                'browses'       => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("浏览数"),
                'comments'      => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("评论数"),
                'status'        => $this->boolean()->notNull()->defaultValue(1)->comment('是否开启'),
                'no_comment'    => $this->boolean()->unsigned()->notNull()->defaultValue(0)->comment('0:可以评论1：不能评论'),
                'platform'      => $this->boolean()->unsigned()->notNull()->defaultValue(0)->comment('0:双平台1：ios2：安卓'),
                'created'       => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            ], $tableOptions);

            $this->createIndex('ps',$this->table, ['project_id','status'],false);
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
