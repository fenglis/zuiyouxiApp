<?php

use yii\db\Migration;
use app\models\User;

/**
 * 用户表
 *
 */
class m170623_051513_add_user_table_column_data extends Migration
{
	public $table = 'user';
    public function safeUp()
    {
    	$columns = ['id','username','auth_key','password_hash','password_reset_token','email', 'status', 'created_at','updated_at'];
    	$rows = array();
    	if(empty(User::findByUsername('machao'))) {
    		$rows[] = [1,'machao','W6vF49yWMuvpQOqCvEr-w96-hEsj4f2j','$2y$13$yYs5D9pkmsqsPC.MsiUv1uXSbwBwSRUtvjSEFlTjq2Nd6SJJaNJsO',NULL,'machao@babeltime.com',10,time(),time()];
    		$this->batchInsert($this->table, $columns, $rows);
    	}
    }

    public function safeDown()
    {
        echo "m170623_051513_add_user_table_column_data cannot be reverted.\n";
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
        echo "m170623_051513_add_user_table_column_data cannot be reverted.\n";

        return false;
    }
    */
}
