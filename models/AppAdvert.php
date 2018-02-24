<?php

namespace app\models;

use Yii;
use app\models\Project;

/**
 * This is the model class for table "app_advert".
 *
 * @property integer $id
 * @property string $title
 * @property string $remark
 * @property string $url
 * @property string $img
 * @property integer $status
 * @property integer $draworder
 * @property integer $project_id
 * @property integer $platform
 * @property integer $created
 */
class AppAdvert extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_advert';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url', 'img', 'project_id'], 'required'],
            [['status', 'draworder', 'project_id', 'platform', 'created'], 'integer'],
            [['title'], 'string', 'max' => 50],
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
            'title' => '名称',
            'remark' => 'Remark',
            'url' => '链接地址',
            'img' => '广告图片',
            'status' => '状态',
            'draworder' => '权重',
            'project_id' => '游戏项目',
            'platform' => '投放平台',
            'created' => '添加时间',
        ];
    }

    public function mySave(){
        if($this->validate()){
            if($this->img){
                $path = Yii::$app->params['attachPath'].Yii::$app->params['advertImage'].'/';
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
