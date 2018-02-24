<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Poll;

/**
 * VoteThemeSearch represents the model behind the search form about `app\models\Poll`.
 */
class PollSearch extends Poll
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pollid', 'project_id', 'browses', 'comments', 'status', 'created'], 'integer'],
            [['content', 'img'], 'safe'],
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
        $query = Poll::find()->orderBy(['created'=>SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if($this->project_id == null){
            $this->project_id = \Yii::$app->item->id;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pollid' => $this->pollid,
            'project_id' => $this->project_id,
            'browses' => $this->browses,
            'comments' => $this->comments,
            'status' => $this->status,
            'platform' => $this->platform,
            'no_comment' => $this->no_comment,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
