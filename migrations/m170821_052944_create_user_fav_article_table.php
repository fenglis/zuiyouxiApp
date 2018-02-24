<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_fav_article`.
 */
class m170821_052944_create_user_fav_article_table extends Migration
{
    public $table = 'user_fav_article';
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
                'tid'           => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("文章或投票id"),
                'userid'        => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("用户id"),
                'username'      => $this->string(100)->notNull()->comment("用户名称"),
                'action'        => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("标识文章或投票"),
                'status'        => $this->boolean()->notNull()->defaultValue(0)->comment('是否收藏 0 没有'),
                'created'      => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("收藏时间"),
            ], $tableOptions);

            $this->createIndex('tid',$this->table, ['tid'],false);
            $this->createIndex('action',$this->table, ['action'],false);
            $this->createIndex('us',$this->table, ['userid','status'],false);
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
