<?php

use yii\db\Migration;

/**
 * Handles the creation of table `app_version`.
 */
class m170828_020808_create_app_version_table extends Migration
{
    public $table = 'app_version';
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
                'id'        => $this->primaryKey()->unsigned(),
                'project_id'=> $this->integer()->unsigned()->notNull()->defaultValue(1)->comment("项目id"),
                'version'   => $this->string(50)->notNull()->comment('版本号'),
                'os'        => $this->boolean()->notNull()->defaultValue(1)->comment('设备类型: 1 ios 2 android'),
                'title'     => $this->string(100)->notNull()->comment('标题'),
                'content'   => $this->string(100)->notNull()->comment('更新提示语'),
                'url'       => $this->string(255)->notNull()->comment('新版本下载地址'),
                'status'    => $this->boolean()->notNull()->defaultValue(1)->comment('是否开启'),
                'is_update' => $this->boolean()->notNull()->defaultValue(0)->comment('是否强制更新'),
                'created'   => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            ], $tableOptions);

            $this->createIndex('pvo',$this->table, ['project_id','os', 'version'],false);
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
