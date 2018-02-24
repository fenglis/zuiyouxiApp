<?php

use yii\db\Migration;

/**
 * Handles the creation of table `app_platform`.
 */
class m170718_001755_create_app_platform_table extends Migration
{
    public $table = 'app_platform';
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
                'id'        => $this->primaryKey(),
                'title'     => $this->char(40)->notNull()->comment("平台名称"),
                'status'    => $this->boolean()->notNull()->defaultValue(1)->comment('状态'),
                'content'   => $this->string(50)->notNull()->comment('提示语'),
                'comm'      => $this->string(50)->notNull()->comment('保留'),
                'device'    => $this->boolean()->notNull()->defaultValue(0)->comment('0:全平台 1:IOS 2:安卓'),
                'created'   => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('创建时间'),
            ], $tableOptions);

            $this->createIndex('device',$this->table, ['device','status'],false);
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
