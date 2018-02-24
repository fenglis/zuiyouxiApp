<?php

use yii\db\Migration;

/**
 * Handles the creation of table `app_advert`.
 */
class m170719_004309_create_app_advert_table extends Migration
{
    public $table = 'app_advert';
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
                'title'     => $this->string(50)->notNull()->comment("广告标题"),
                'remark'    => $this->string(255)->notNull()->comment("预留"),
                'url'       => $this->string(255)->notNull()->comment("广告链接"),
                'img'       => $this->string(255)->notNull()->comment("广告图片地址"),
                'status'    => $this->boolean()->notNull()->defaultValue(1)->comment('状态'),
                'draworder' => $this->integer()->notNull()->defaultValue(0)->comment('权重'),
                'project_id'=> $this->integer()->unsigned()->notNull()->comment('所属项目'),
                'platform'  => $this->boolean()->notNull()->defaultValue(0)->comment('投放平台'),
                'created'   => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('添加时间'),
            ], $tableOptions);

            $this->createIndex('platform',$this->table, ['platform','status'],false);
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
