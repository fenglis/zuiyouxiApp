<?php

use yii\db\Migration;

/**
 * Handles the creation of table `support`.
 */
class m170817_055517_create_support_table extends Migration
{
    public $table = 'support';
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
                'tid'           => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("文章或投票id"),
                'userid'        => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("用户id"),
                'username'      => $this->string(100)->notNull()->comment("用户名称"),
                'action'        => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("标识文章或投票"),
                'dateline'      => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("点赞时间"),
            ], $tableOptions);

            $this->createIndex('tid',$this->table, ['tid'],false);
            $this->createIndex('action',$this->table, ['action'],false);
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
