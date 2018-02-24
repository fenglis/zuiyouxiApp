<?php

namespace app\models\api;

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


    public function  getProjectList()
    {
        return static::find()->asArray()->all();
    }
}
