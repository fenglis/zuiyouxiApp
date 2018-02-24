<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_class`.
 */
class m170721_022923_create_article_class_table extends Migration
{
    public $table = 'article_class';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=100';
        }

        // Check if the table exists
        if ($this->db->schema->getTableSchema($this->table, true) === null) {
            $this->createTable($this->table, [
                'id'        => $this->primaryKey(),
                'project_id'=> $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('游戏项目'),
                'up_id'     => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('父类'),
                'title'     => $this->string(40)->notNull()->comment('分类名称'),
                'remark'    => $this->string(200)->notNull()->comment('保留'),
                'status'    => $this->boolean()->unsigned()->notNull()->defaultValue(1)->comment('状态'),
                'draworder' => $this->smallInteger()->unsigned()->notNull()->comment('权重'),
            ], $tableOptions);
        }

        $columns = ['parent', 'child'];
        $rows = array();
        $rows[] = ['管理员','/*'];
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->table);
    }
}
