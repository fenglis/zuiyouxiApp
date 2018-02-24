<?php

use yii\db\Migration;

class m170713_034113_add_project_table extends Migration
{
    public $table = 'project';

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
                'id'            => $this->primaryKey(),
                'location_id'   => $this->boolean()->unsigned()->notNull()->defaultValue(0),
                'zone_id'       => $this->boolean()->unsigned()->notNull()->defaultValue(0),
                'title'         => $this->string(50)->notNull()->defaultValue('')->comment('项目名称'),
                'remark'        => $this->string(255)->notNull()->defaultValue('')->comment('可做预留字段'),
                'url'           => $this->string(255)->notNull()->defaultValue('')->comment('链接地址'),
                'img'           => $this->string(255)->notNull()->defaultValue('')->comment('图片'),
                'img2'          => $this->string(255)->notNull()->defaultValue('')->comment('子区图片'),
                'status'        => $this->boolean()->unsigned()->notNull()->defaultValue(1)->comment('状态'),
                'draworder'     => $this->smallInteger()->unsigned()->notNull()->defaultValue(1)->comment('权重'),
            ], $tableOptions);
        }
    }

    public function safeDown()
    {
        echo "m170713_034113_add_project_table cannot be reverted.\n";
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
        echo "m170713_034109_add_project_table cannot be reverted.\n";

        return false;
    }
    */
}
