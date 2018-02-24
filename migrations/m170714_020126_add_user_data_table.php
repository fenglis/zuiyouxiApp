<?php

use yii\db\Migration;

class m170714_020126_add_user_data_table extends Migration
{
    public $table = 'user_data';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Check if the table exists
        if ($this->db->schema->getTableSchema($this->table, true) === null) {
            $this->createTable($this->table, [
                'user_id'       => $this->primaryKey()->unsigned(),
                'data'          => $this->text()->comment('用户选择的项目'),
            ], $tableOptions);
        }
    }

    public function safeDown()
    {
        echo "m170714_020126_add_user_data_table cannot be reverted.\n";
        $this->dropTable($this->table);
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170714_020126_add_user_data_table cannot be reverted.\n";

        return false;
    }
    */
}
