<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `app\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'fid', 'tid', 'special', 'recv_userid', 'voptid', 'child_num', 'position', 'project_id', 'status','class_id'], 'integer'],
            [['username', 'userip', 'message', 'action', 'recv_username', 'title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if(empty($params)) {
            $comArr = [];
        } else {
            $comArr = $params['CommentSearch'];
        }

        $query = Comment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        //var_dump($comArr); die;
        if(!empty($comArr['username'])) {
            $query->andFilterWhere(['like', 'username', $comArr['username']]);
        }

        if(!empty($comArr['message'])) {
            $query->andFilterWhere(['like', 'message', $comArr['message']]);
        }
        //var_dump($comArr); die;
        if(!empty($comArr['class_id']) && $comArr['class_id'] != 0 ) {
            $query->andFilterWhere(['class_id'=>$comArr['class_id']]);
        }

        if(!empty($comArr['dateline']) && !empty($comArr['userip'])) {
            $startTime = strtotime($comArr['dateline']);
            $endTime = strtotime($comArr['userip']);
            $query->andFilterWhere(['between','dateline', $startTime, $endTime]);
        }

        $query->andFilterWhere(['project_id'=>\Yii::$app->item->id]);

        // grid filtering conditions
        $query->andFilterWhere([
            'status' => \Yii::$app->params['status']['ok'],
        ]);

        return $dataProvider;
    }
}
