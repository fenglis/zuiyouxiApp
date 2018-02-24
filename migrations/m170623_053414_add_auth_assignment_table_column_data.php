<?php

use yii\db\Migration;

/**
 * 用户认证表
 *
 */
class m170623_053414_add_auth_assignment_table_column_data extends Migration
{
	public $table = 'auth_assignment';
    public function safeUp()
    {
    	$columns = ['item_name','user_id', 'created_at'];
    	$rows = array();
    	$rows[] = ['管理员', '1', time()];
    	
    	$this->batchInsert($this->table, $columns, $rows);
    }

    public function safeDown()
    {
        echo "m170623_053414_add_auth_assignment_table_column_data cannot be reverted.\n";
		$this->truncateTable($this->table);
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170623_053414_add_auth_assignment_table_column_data cannot be reverted.\n";

        return false;
    }
    */
}
