<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vote_theme".
 *
 * @property integer $vtid
 * @property integer $project_id
 * @property string $content
 * @property string $img
 * @property integer $browses
 * @property integer $comments
 * @property integer $status
 * @property integer $created
 */
class Poll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poll';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['project_id','filter','filter'=>function(){return \Yii::$app->item->id;}],
            [['project_id', 'browses', 'comments', 'status', 'platform', 'no_comment','created'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pollid' => '投票主题id',
            'project_id' => '项目id',
            'content' => '主题内容',
            'img' => '主题图片',
            'browses' => '浏览数',
            'comments' => '评论数',
            'status' => '是否使用',
            'platform' => '投放平台',
            'no_comment' => '是否禁止评论点赞',
            'created' => '添加时间',
        ];
    }

    public function mySave(){
        if($this->validate()){
            if($this->img){
                $path = Yii::$app->params['attachPath'].Yii::$app->params['pollImage'].'/';
                $savePath = date("Ym").'/';
                if(!file_exists($path.$savePath) && !mkdir($path.$savePath, 0777,true)){
                    $this->addError('img', '创建文件夹失败');
                    return false;
                }
                $fileName = time(). mt_rand(1,999999).'.'.$this->img->extension;
                $this->img->saveAs($path.$savePath.$fileName);
                $this->setAttribute('img', $savePath.$fileName);
            }
            return $this->save(false);
        }
        return false;
    }
}
