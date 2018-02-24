<?php

use yii\db\Migration;

/**
 * Handles the creation of table `poll_option`.
 */
class m170801_053813_create_poll_option_table extends Migration
{
    public $table = 'poll_option';
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
                'pollid'        => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("投票主题id"),
                'votes'         => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment("此选项的投票数"),
                'content'       => $this->string(255)->notNull()->comment('投票选项内容'),
                'voterids'      => $this->text()->notNull()->comment("此投票选项所有用户id"),
            ], $tableOptions);

            $this->createIndex('pollid',$this->table, ['pollid'],false);
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
