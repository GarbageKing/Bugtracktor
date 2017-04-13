<?php

namespace app\controllers;

use Yii;
use app\models\Projects;
use app\models\ProjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UsersProjects;
use yii\filters\AccessControl;

use app\models\Users;
use app\models\Issues;
/**
 * ProjectsController implements the CRUD actions for Projects model.
 */
class ProjectsController extends Controller
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
     * Lists all Projects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Projects model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        $usersAttached = UsersProjects::find()->where(['id_projects' => $id])->all();
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
     * Creates a new Projects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Projects();  
        $model2 = new UsersProjects();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                       
            //print_r($model->id); die;
            
            $model2->id_projects = $model->id;
            $model2->id_user = Yii::$app->user->getId();
            $model2->is_creator = 1;
            $model2->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model                
            ]);
        }
    }

    /**
     * Updates an existing Projects model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Projects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->db->createCommand()->delete('users_projects', ['id_projects' => $id, 'id_user' => Yii::$app->user->getId(), 'is_creator' => 1])->execute()){
            
            Yii::$app->db->createCommand()->delete('users_projects', ['id_projects' => $id])->execute(); 
            
            $Issues = Issues::find()->where(['id_project' => $id])->all();
                        
            foreach($Issues as $issue)
            {
                Yii::$app->db->createCommand()->delete('users_issues', ['id_issue' => $issue['id']])->execute();               
            }
            
                Yii::$app->db->createCommand()->delete('issues', ['id_project' => $id])->execute();
                                                                                       
                Yii::$app->db->createCommand()->delete('projects', ['id' => $id])->execute(); 
        
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Projects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Projects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $exists = UsersProjects::find()->where( [ 'id_projects' => $id, 'id_user' => Yii::$app->user->getId() ] )->exists();
        
        if (($model = Projects::findOne($id)) !== null && $exists) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
