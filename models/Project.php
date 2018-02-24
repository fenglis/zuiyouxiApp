<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property integer $location_id
 * @property integer $zone_id
 * @property string $title
 * @property string $remark
 * @property string $url
 * @property string $img
 * @property string $img2
 * @property integer $status
 * @property integer $draworder
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'draworder'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['remark', 'url'], 'string', 'max' => 255],
            [['img','img2'], 'image'],
        ];
    }

    // [['remark', 'url', 'img', 'img2'], 'string', 'max' => 255], img代表图片放在string检测中会出现错误

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_id' => 'Location ID',
            'zone_id' => 'Zone ID',
            'title' => '游戏名称',
            'remark' => 'Remark',
            'url' => '链接地址',
            'img' => '图片',
            'img2' => '子区图片',
            'status' => '是否启用',
            'draworder' => '权重',
        ];
    }


    public function mySave() {
        if($this->validate()){

            if($this->img && $this->img2){
                $path = Yii::$app->params['attachPath'].Yii::$app->params['projectImage'].'/';
                $savePath = date("Ym").'/';
                if(!file_exists($path.$savePath) && !mkdir($path.$savePath, 0777,true)){
                    $this->addError('img', '创建文件夹失败');
                    return false;
                }
                $fileName = time(). mt_rand(1,999999).'.'.$this->img->extension;
                $fileName2 = time(). mt_rand(1,999999).'.'.$this->img2->extension;
                $this->img->saveAs($path.$savePath.$fileName);
                $this->img2->saveAs($path.$savePath.$fileName2);
                $this->setAttribute('img', $savePath.$fileName);
                $this->setAttribute('img2', $savePath.$fileName2);
            }
            return $this->save(false);
        }
        return false;
    }


    public function  getAllProject() {
        $arr = [];
        $models = static::find()->all();
        foreach($models as $model) {
            $arr[$model->id] = $model->title;
        }

        return $arr;
    }
}
