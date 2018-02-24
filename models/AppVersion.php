<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_version".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $version
 * @property string $os
 * @property string $content
 * @property string $url
 * @property integer $status
 * @property integer $created
 */
class AppVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_version';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['project_id','filter','filter'=>function(){return \Yii::$app->item->id;}],
            [['project_id', 'status', 'created'], 'integer'],
            [[ 'version','os', 'content'], 'required'],
            ['version', 'match', 'pattern'=>'/^([0-9]{1,}).([0-9]{1,}).([0-9]{1,})$/', 'message'=>'版本号格式错误,版本号格式为,三个整数字段以点为分隔,例如: 1.0.0'],
            [['content'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => '游戏项目',
            'version' => '版本号',
            'os' => '设备类型',
            'content' => '提示语',
            'url' => '版本下载路径',
            'status' => '使用状态',
            'is_update' => '是否强制更新',
            'created' => '创建时间',
        ];
    }

    public function  getMaxVersionByProject($os) {
        $models = static::find()->where(['os'=>$os])->max('version');
        return $models;
    }
}
