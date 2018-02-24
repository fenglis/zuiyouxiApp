<?php

use yii\db\Migration;

/**
 * 权限
 *
 */
class m170623_053300_add_auth_item_child_table_column_data extends Migration
{
	public $table = 'auth_item_child';
	
    public function safeUp()
    {
    	$columns = ['parent', 'child'];
    	$rows = array();
    	$rows[] = ['管理员','/*'];
    	$rows[] = ['管理员','/admin/*'];
    	$rows[] = ['管理员','/admin/assignment/*'];
    	$rows[] = ['管理员','/admin/assignment/assign'];
    	$rows[] = ['管理员','/admin/assignment/index'];
    	$rows[] = ['管理员','/admin/assignment/revoke'];
    	$rows[] = ['管理员','/admin/assignment/view'];
    	$rows[] = ['管理员','/admin/default/*'];
    	$rows[] = ['管理员','/admin/default/index'];
    	$rows[] = ['管理员','/admin/menu/*'];
    	$rows[] = ['管理员','/admin/menu/create'];
    	$rows[] = ['管理员','/admin/menu/delete'];
    	$rows[] = ['管理员','/admin/menu/index'];
    	$rows[] = ['管理员','/admin/menu/update'];
    	$rows[] = ['管理员','/admin/menu/view'];
    	$rows[] = ['管理员','/admin/permission/*'];
    	$rows[] = ['管理员','/admin/permission/assign'];
    	$rows[] = ['管理员','/admin/permission/create'];
    	$rows[] = ['管理员','/admin/permission/delete'];
    	$rows[] = ['管理员','/admin/permission/index'];
    	$rows[] = ['管理员','/admin/permission/remove'];
    	$rows[] = ['管理员','/admin/permission/update'];
    	$rows[] = ['管理员','/admin/permission/view'];
    	$rows[] = ['管理员','/admin/role/*'];
    	$rows[] = ['管理员','/admin/role/assign'];
    	$rows[] = ['管理员','/admin/role/create'];
    	$rows[] = ['管理员','/admin/role/delete'];
    	$rows[] = ['管理员','/admin/role/index'];
    	$rows[] = ['管理员','/admin/role/remove'];
    	$rows[] = ['管理员','/admin/role/update'];
    	$rows[] = ['管理员','/admin/role/view'];
    	$rows[] = ['管理员','/admin/route/*'];
    	$rows[] = ['管理员','/admin/route/assign'];
    	$rows[] = ['管理员','/admin/route/create'];
    	$rows[] = ['管理员','/admin/route/index'];
    	$rows[] = ['管理员','/admin/route/refresh'];
    	$rows[] = ['管理员','/admin/route/remove'];
    	$rows[] = ['管理员','/admin/rule/*'];
    	$rows[] = ['管理员','/admin/rule/create'];
    	$rows[] = ['管理员','/admin/rule/delete'];
    	$rows[] = ['管理员','/admin/rule/index'];
    	$rows[] = ['管理员','/admin/rule/update'];
    	$rows[] = ['管理员','/admin/rule/view'];
    	$rows[] = ['管理员','/admin/user/*'];
    	$rows[] = ['管理员','/admin/user/activate'];
    	$rows[] = ['管理员','/admin/user/change-password'];
    	$rows[] = ['管理员','/admin/user/delete'];
    	$rows[] = ['管理员','/admin/user/index'];
    	$rows[] = ['guest','/admin/user/login'];
    	$rows[] = ['管理员','/admin/user/login'];
    	$rows[] = ['guest','/admin/user/logout'];
    	$rows[] = ['管理员','/admin/user/logout'];
    	$rows[] = ['管理员','/admin/user/request-password-reset'];
    	$rows[] = ['管理员','/admin/user/reset-password'];
    	$rows[] = ['guest','/admin/user/signup'];
    	$rows[] = ['管理员','/admin/user/signup'];
    	$rows[] = ['管理员','/admin/user/view'];
    	$rows[] = ['管理员','/debug/*'];
    	$rows[] = ['管理员','/debug/default/*'];
    	$rows[] = ['管理员','/debug/default/db-explain'];
    	$rows[] = ['管理员','/debug/default/download-mail'];
    	$rows[] = ['管理员','/debug/default/index'];
    	$rows[] = ['管理员','/debug/default/toolbar'];
    	$rows[] = ['管理员','/debug/default/view'];
    	$rows[] = ['管理员','/gii/*'];
    	$rows[] = ['管理员','/gii/default/*'];
    	$rows[] = ['管理员','/gii/default/action'];
    	$rows[] = ['管理员','/gii/default/diff'];
    	$rows[] = ['管理员','/gii/default/index'];
    	$rows[] = ['管理员','/gii/default/preview'];
    	$rows[] = ['管理员','/gii/default/view'];
    	$rows[] = ['guest','/site/*'];
    	$rows[] = ['管理员','/site/*'];
    	$rows[] = ['guest','/site/about'];
    	$rows[] = ['管理员','/site/about'];
    	$rows[] = ['guest','/site/captcha'];
    	$rows[] = ['管理员','/site/captcha'];
    	$rows[] = ['guest','/site/contact'];
    	$rows[] = ['管理员','/site/contact'];
    	$rows[] = ['guest','/site/error'];
    	$rows[] = ['管理员','/site/error'];
    	$rows[] = ['guest','/site/index'];
    	$rows[] = ['管理员','/site/index'];
    	$rows[] = ['guest','/site/login'];
    	$rows[] = ['管理员','/site/login'];
    	$rows[] = ['guest','/site/logout'];
    	$rows[] = ['管理员','/site/logout'];
    	
    	$this->db->createCommand('set names utf8')->query();
    	$this->batchInsert($this->table, $columns, $rows);
    }

    public function safeDown()
    {
        echo "m170623_053300_add_auth_item_child_table_column_data cannot be reverted.\n";
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
        echo "m170623_053300_add_auth_item_child_table_column_data cannot be reverted.\n";

        return false;
    }
    */
}
