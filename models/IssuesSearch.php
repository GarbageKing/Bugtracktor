<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Issues;

/**
 * IssuesSearch represents the model behind the search form about `app\models\Issues`.
 */
class IssuesSearch extends Issues
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', /*'id_project',*/ 'priority', 'status'], 'integer'],
            [['name', 'description', 'cr_date', 'id_project'], 'safe'],
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
        $query = Issues::find();
        
        $query->joinWith(['idProject'])
                ->join('JOIN',
                'users_issues as uu',
				'uu.id_issue = issues.id')
                ->where('uu.id_user='.Yii::$app->user->getId());

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'issues.id' => $this->id,
            //'id_project' => $this->id_project,
            'priority' => $this->priority,
            'status' => $this->status,
            'cr_date' => $this->cr_date,
        ]);

        $query->andFilterWhere(['like', 'issues.name', $this->name])
            ->andFilterWhere(['like', 'issues.description', $this->description])
                ->andFilterWhere(['like', 'projects.name', $this->id_project]);

        return $dataProvider;
    }
}
