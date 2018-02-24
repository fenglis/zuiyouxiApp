<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "battle_recommend".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $title
 * @property string $content
 * @property string $generals
 * @property string $referrer
 * @property integer $difficulty
 * @property string $screenshot
 * @property integer $status
 * @property integer $platform
 * @property integer $no_comment
 * @property integer $created
 */
class BattleRecommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'battle_recommend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['project_id','filter','filter'=>function(){return \Yii::$app->item->id;}],
            [['project_id', 'difficulty', 'status', 'platform', 'no_comment', 'created'], 'integer'],
            [['title', 'referrer'], 'required'],
            [['content', 'generals', 'screenshot'], 'string'],
            [['title', 'referrer'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'title' => '推荐标题 : ',
            'content' => '推荐内容 : ',
            'generals' => '武将列表 : ',
            'referrer' => '推荐人 : ',
            'difficulty' => '推荐难度 : ',
            'screenshot' => '游戏截图 : ',
            'status' => '是否使用 : ',
            'platform' => '投放平台 : ',
            'no_comment' => '是否禁止评论点赞 : ',
            'created' => 'Created',
        ];
    }
}
