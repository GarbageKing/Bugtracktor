<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsersIssues;

/**
 * UsersIssuesSearch represents the model behind the search form about `app\models\UsersIssues`.
 */
class UsersIssuesSearch extends UsersIssues
{    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'is_creator'], 'integer'],
            [['id_issue', 'name'], 'safe'],            
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
        
        $query = UsersIssues::find();
        $query->joinWith(['idIssue'])
        
        ->join(	'JOIN',
                'projects',
				'projects.id = issues.id_project'
			);         
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {            
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => $this->id_user,            
            'is_creator' => $this->is_creator,
        ])
                
        ->andFilterWhere(['like', 'issues.name', $this->id_issue]);
        
        return $dataProvider;
    }
}