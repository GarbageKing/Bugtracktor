<?php

namespace app\controllers;

use Yii;
use app\models\Issues;
use app\models\IssuesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Projects;

use app\models\UsersProjects;
use app\models\UsersIssues;
use app\models\Users;
use yii\filters\AccessControl;

/**
 * IssuesController implements the CRUD actions for Issues model.
 */
class IssuesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Issues models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IssuesSearch();
        
           /* $UsersIssues = UsersIssues::find()->where(['id_user' => Yii::$app->user->getId()])->all();
            $ids = [];
            
            foreach($UsersIssues as $issue)
            {
                $ids[] = $issue['id_issue'];
            }
            
         if(!empty($ids))
         $searchModel->id = $ids;*/
        
        //$searchModel->is_creator = 1;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Issues model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        $usersAttached = UsersIssues::find()->where(['id_issue' => $id])->all();
        $users = [];
        $actualUsernames = [];
        
        foreach($usersAttached as $user)
            {
                $users[] = $user['id_user'];
            }
            
        foreach($users as $user)
        {
        $actualUsr = Users::find()->where(['id' => $user])->one();
        $actualUsernames[] = $actualUsr['username'];
        }
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'usernames' => $actualUsernames,
        ]);
    }

    /**
     * Creates a new Issues model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Issues();
        $model2 = new UsersIssues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $model2->id_issue = $model->id;
            $model2->id_user = Yii::$app->user->getId();
            $model2->is_creator = 1;
            $model2->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
                      
            $UsersProjects = UsersProjects::find()->where(['id_user' => Yii::$app->user->getId()])->all();
            $ids = [];
            
            foreach($UsersProjects as $project)
            {
                $ids[] = $project['id_projects'];
            }
            
            
            return $this->render('create', [
                'model' => $model,
                'projects' => Projects::find()->where(['id' => $ids])->all()
            ]);
        }
    }

    /**
     * Updates an existing Issues model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            
            $UsersProjects = UsersProjects::find()->where(['id_user' => Yii::$app->user->getId()])->all();
            $ids = [];
            
            foreach($UsersProjects as $project)
            {
                $ids[] = $project['id_projects'];
            }
            
            
            return $this->render('update', [
                'model' => $model,
                'projects' => Projects::find()->where(['id' => $ids])->all()
            ]);
        }
    }

    /**
     * Deletes an existing Issues model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Issues model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Issues the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $exists = UsersIssues::find()->where( [ 'id_issue' => $id, 'id_user' => Yii::$app->user->getId() ] )->exists();
        
        if (($model = Issues::findOne($id)) !== null && $exists) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
