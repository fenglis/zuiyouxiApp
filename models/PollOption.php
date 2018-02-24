<?php

namespace app\models;

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

    public function getPollOptionByPollid($pollid){
        //return static::find()->where(['vtid'=>$vtid])->asArray()->all();
        //asArray函数将查询的对象转化成数组形式
        return static::find()->where(['pollid'=>$pollid])->all();
    }
}
