<?php

use yii\db\Migration;

/**
 * 路由表
 *
 */
class m170623_051522_add_auth_item_table_column_data extends Migration
{
	public $table = 'auth_item';
    public function safeUp()
    {
    	$columns = ['name', 'type', 'description', 'rule_name', 'data', 'created_at','updated_at'];
    	$rows = array();
    	$rows[] = ['/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/assignment/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/assignment/assign',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/assignment/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/assignment/revoke',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/assignment/view',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/default/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/default/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/menu/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/menu/create',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/menu/delete',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/menu/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/menu/update',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/menu/view',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/permission/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/permission/assign',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/permission/create',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/permission/delete',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/permission/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/permission/remove',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/permission/update',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/permission/view',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/role/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/role/assign',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/role/create',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/role/delete',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/role/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/role/remove',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/role/update',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/role/view',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/route/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/route/assign',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/route/create',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/route/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/route/refresh',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/route/remove',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/rule/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/rule/create',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/rule/delete',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/rule/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/rule/update',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/rule/view',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/activate',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/change-password',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/delete',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/login',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/logout',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/request-password-reset',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/reset-password',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/signup',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/admin/user/view',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/debug/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/debug/default/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/debug/default/db-explain',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/debug/default/download-mail',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/debug/default/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/debug/default/toolbar',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/debug/default/view',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/gii/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/gii/default/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/gii/default/action',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/gii/default/diff',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/gii/default/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/gii/default/preview',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/gii/default/view',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/site/*',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/site/about',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/site/captcha',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/site/contact',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/site/error',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/site/index',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/site/login',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['/site/logout',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['管理员',2,NULL,NULL,NULL,time(),time()];
    	$rows[] = ['guest',2,NULL,NULL,NULL,time(),time()];
    	
    	$this->batchInsert($this->table, $columns, $rows);
    }

    public function safeDown()
    {
        echo "m170623_051522_add_auth_item_table_column_data cannot be reverted.\n";
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
        echo "m170623_051522_add_auth_item_table_column_data cannot be reverted.\n";

        return false;
    }
    */
}
