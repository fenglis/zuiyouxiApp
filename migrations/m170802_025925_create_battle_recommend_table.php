<?php

use yii\db\Migration;

/**
 * Handles the creation of table `battle_recommend`.
 */
class m170802_025925_create_battle_recommend_table extends Migration
{
    public $table = 'battle_recommend';
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
                'id'            => $this->primaryKey()->unsigned(),
                'project_id'    => $this->integer()->unsigned()->notNull()->defaultValue(1)->comment("项目id"),
                'title'         => $this->string(100)->notNull()->comment('推荐标题'),
                'content'       => $this->text()->notNull()->comment('推荐内容'),
                'generals'      => $this->string(500)->notNull()->comment('推荐武奖头像列表'),
                'referrer'      => $this->string(100)->notNull()->comment('推荐人'),
                'difficulty'    => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("推荐难度"),
                'screenshot'    => $this->string(500)->notNull()->comment('推荐阵容图片列表'),
                'status'        => $this->boolean()->notNull()->defaultValue(1)->comment('是否使用'),
                'platform'      => $this->boolean()->unsigned()->notNull()->defaultValue(0)->comment('0:双平台1：ios2：安卓'),
                'no_comment'    => $this->boolean()->unsigned()->notNull()->defaultValue(0)->comment('0:可以评论1：不能评论'),
                'created'       => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            ], $tableOptions);

            $this->createIndex('pps',$this->table, ['project_id','platform','status'],false);
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
