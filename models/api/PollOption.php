<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "vote_option".
 *
 * @property integer $id
 * @property integer $vtid
 * @property integer $votes
 * @property string $content
 * @property integer $draworder
 * @property string $voterids
 */
class PollOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poll_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pollid'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pollid' => 'pollid',
            'votes' => 'Votes',
            'content' => 'Content',
            'voterids' => 'Voterids',
        ];
    }

    public static function getPollOptionByPollid($pollid)
    {
        //asArray函数将查询的对象转化成数组形式
        return static::find()->where(['pollid'=>$pollid])->asArray()->all();
    }

    public static function increasePolloption($type, $id)
    {
        $model = PollOption::findOne($id);
        $model->$type += 1;

        if($model->save()) {
            return true;
        } else {
            throw new \Exception("update polloption table is error id = {$id} type={$type}");
        }
    }
}
