<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_feedback".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $username
 * @property string $content
 * @property integer $created
 */
class UserFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'username', 'content', 'created'], 'required'],
            [['userid', 'username', 'created'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'username' => 'Username',
            'content' => 'Content',
            'created' => 'Created',
        ];
    }
}
