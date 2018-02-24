<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articles`.
 */
class m170724_013211_create_article_table extends Migration
{
    public $table = 'article';
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
                'id'           => $this->primaryKey()->unsigned(),
                'class_id'      => $this->integer(11)->notNull()->defaultValue(0)->comment('分类id'),
                'title'         => $this->string(255)->notNull()->comment('文章标题'),
                'content'       => $this->text()->comment('文章内容'),
                'remark'        => $this->string(255)->notNull()->comment('预留字段'),
                'img'           => $this->string(255)->notNull(),
                'created'       => $this->integer(10)->unsigned()->notNull()->defaultValue(0),
                'showtype'      => $this->boolean()->unsigned()->notNull()->defaultValue(0),
                'status'        => $this->boolean()->unsigned()->notNull()->defaultValue(1),
                'article_flag'  => $this->boolean()->unsigned()->notNull()->defaultValue(0)->comment('标识文章投票或阵容等'),
                'class_title'   => $this->string(50)->notNull()->comment('分类标题'),
                'comments'      => $this->integer(5)->unsigned()->notNull()->defaultValue(0)->comment('评论次数'),
                'supports'      => $this->integer(5)->unsigned()->notNull()->defaultValue(0)->comment('点赞次数'),
                'browses'       => $this->integer(5)->unsigned()->notNull()->defaultValue(0)->comment('浏览次数'),
                'project_id'    => $this->integer(10)->unsigned()->notNull()->defaultValue(0),
                'platform'      => $this->boolean()->unsigned()->notNull()->defaultValue(0)->comment('0:双平台1：ios2：安卓'),
                'no_comment'    => $this->boolean()->unsigned()->notNull()->defaultValue(0)->comment('0:可以评论1：不能评论'),
                'INDEX([[showtype]])'
            ], $tableOptions);

            $this->createIndex('sap',$this->table, ['status','project_id'],false);
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
