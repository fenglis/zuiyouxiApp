<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m170803_002827_create_comment_table extends Migration
{
    public $table = 'comment';
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
                'userid'        => $this->integer()->unsigned()->notNull()->comment('评论用户id'),
                'username'      => $this->string(50)->notNull()->comment('评论用户名'),
                'userip'        => $this->string(50)->notNull()->comment('评论用户ip'),
                'dateline'      => $this->integer()->unsigned()->notNull()->comment('评论时间'),
                'title'         => $this->string(255)->notNull()->comment('评论文章标题'),
                'message'       => $this->text()->comment('评论内容'),
                'fid'           => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('标识父评论和子评论'),
                'tid'           => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('文章,投票等id'),
                'action'        => $this->integer()->unsigned()->notNull()->comment('区分文章或投票评论'),
                'class_id'      => $this->integer()->unsigned()->notNull()->comment('文章,投票,推荐分类'),
                'special'       => $this->boolean()->unsigned()->notNull()->comment('区分父评论和子评论'),
                'recv_userid'   => $this->integer()->unsigned()->notNull()->comment('回复评论用户id'),
                'recv_username' => $this->string(50)->notNull()->comment('回复评论用户名'),
                'voptid'        => $this->integer()->unsigned()->notNull()->comment('投票选项id'),
                'child_num'     => $this->smallInteger()->unsigned()->notNull()->comment('子评论数'),
                'position'      => $this->integer()->unsigned()->notNull()->defaultValue(1)->comment('评论楼层'),
                'project_id'    => $this->integer()->unsigned()->notNull()->defaultValue(1)->comment('项目id'),
                'status'        => $this->integer()->unsigned()->notNull()->defaultValue(1)->comment('状态'),
                'FULLTEXT INDEX([[message]])'
            ], $tableOptions);

            $this->createIndex('ftu',$this->table, ['fid','tid','userid'],false);
            $this->createIndex('action',$this->table, ['action'],false);
            $this->createIndex('ptf',$this->table, ['project_id', 'tid', 'fid'],false);
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
