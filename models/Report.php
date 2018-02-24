<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property integer $report_id
 * @property integer $project_id
 * @property integer $post_id
 * @property integer $type
 * @property string $info
 * @property integer $user_id
 * @property string $user_name
 * @property integer $status
 * @property integer $created
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'post_id', 'type', 'info', 'user_id', 'user_name', 'status'], 'required'],
            [['project_id', 'post_id', 'type', 'user_id', 'status', 'created'], 'integer'],
            [['info'], 'string'],
            [['user_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'report_id' => 'Report ID',
            'project_id' => 'Project ID',
            'post_id' => 'Post ID',
            'type' => 'Type',
            'info' => 'Info',
            'reply_msg' => 'reply_msg',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'status' => 'Status',
            'created' => 'Created',
        ];
    }
}
