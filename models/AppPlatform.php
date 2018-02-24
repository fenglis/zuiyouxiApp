<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_platform".
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property string $content
 * @property string $comm
 * @property integer $device
 * @property integer $created
 */
class AppPlatform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_platform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status', 'device', 'created'], 'integer'],
            [['title'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '序号',
            'title' => '设备名称',
            'status' => '状态',
            'content' => 'Content',
            'comm' => 'Comm',
            'device' => '设备标识',
            'created' => '添加时间',
        ];
    }
}
