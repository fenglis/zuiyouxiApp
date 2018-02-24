<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment_position`.
 */
class m170816_105718_create_comment_position_table extends Migration
{
    public $table = 'comment_position';
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
                'position'      => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("楼层"),
                'comment_id'    => $this->string(255)->notNull()->comment('评论id'),
            ], $tableOptions);

            $this->createIndex('tid',$this->table, ['tid'],false);
            $this->createIndex('comment_id',$this->table, ['comment_id'],false);
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
