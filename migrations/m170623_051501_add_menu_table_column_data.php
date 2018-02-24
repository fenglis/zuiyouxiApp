<?php

use yii\db\Migration;

/**
 * 菜单表
 *
 */
class m170623_051501_add_menu_table_column_data extends Migration
{
	public $table = 'menu';
	
    public function safeUp()
    {
    	$columns= ['id', 'name', 'parent', 'route'];
    	$rows= array();
    	$rows[] = [1, '后台管理', NULL, '/admin'];
    	$rows[] = [2, '用户管理', 1, '/admin/user/index'];
    	$rows[] = [3, '菜单管理', 1, '/admin/menu/index'];
    	$rows[] = [4, '权限组配置', 1, '/admin/permission/index'];
    	$rows[] = [5, '规则管理', 1, '/admin/rule/index'];
    	$rows[] = [6, '用户角色', 1, '/admin/role/index'];
    	$rows[] = [7, '用户列表', 2, '/admin/user/index'];
    	$rows[] = [8, '分配用户权限', 2, '/admin/assignment/index'];
    	
    	$this->batchInsert($this->table, $columns, $rows);
    }

    public function safeDown()
    {
        echo "m170623_051501_add_menu_table_column_data cannot be reverted.\n";
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
        echo "m170623_051501_add_menu_table_column_data cannot be reverted.\n";

        return false;
    }
    */
}
