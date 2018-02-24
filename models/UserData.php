<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_user_data".
 *
 * @property integer $user_id
 * @property string $data
 */
class UserData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['data'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'data' => 'Data',
        ];
    }

    /**
     * 向user_data数据库中写入或更新数据
     * @param $userId
     * @param array $value
     * @return mixed
     */
    public static function setData($userId,  array $value) {
        $model = new static();
        $data = $model->findOne($userId);
        if($data) {
            $data->data = json_encode($value);
            return $data->save();
        } else {
            $model->user_id = $userId;
            $model->data = json_encode($value);
            return $model->save();
        }
    }

    public static function getData($userId) {
        $model = static::findOne($userId);
        if($model !== null) {
            return json_decode($model->data, true);
        }
        return [];
    }



}
