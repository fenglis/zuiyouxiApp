<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property integer $tid
 * @property integer $class_id
 * @property string $title
 * @property string $content
 * @property string $remark
 * @property string $img
 * @property integer $created
 * @property integer $is_use
 * @property integer $showtype
 * @property integer $status
 * @property integer $article_flag
 * @property string $class_title
 * @property integer $comments
 * @property integer $supports
 * @property integer $browses
 * @property integer $project
 * @property integer $platform
 * @property integer $no_comment
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['project_id','filter','filter'=>function(){return \Yii::$app->item->id;}],
            [['class_id', 'created', 'showtype', 'status'], 'integer'],
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['title', 'class_title'], 'string', 'max' => 50],
            ['created', 'default','value'=>time()],
            ['img', 'image'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_id' => '文章分类',
            'title' => '标题',
            'content' => '内容',
            'remark' => 'Remark',
            'img' => 'Img',
            'created' => 'Created',
            'showtype' => 'Showtype',
            'status' => '是否启用',
            'article_flag' => '文章标识',
            'class_title' => '分类标题',
            'comments' => '评论数',
            'supports' => 'Supports',
            'browses' => '浏览量',
            'project_id' => '游戏项目',
            'platform' => '投放平台',
            'no_comment' => '禁止评论和点赞',
        ];
    }

    public function mySave(){
        if($this->validate()){
            if($this->img){
                $path = Yii::$app->params['attachPath'].Yii::$app->params['articleImage'].'/';
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
