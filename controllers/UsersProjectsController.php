<?php

namespace app\controllers;

use Yii;
use app\models\UsersProjects;
use app\models\UsersProjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Projects;
use app\models\Users;

/**
 * UsersProjectsController implements the CRUD actions for UsersProjects model.
 */
class UsersProjectsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UsersProjects models.
     * @return mixed
     */
   /* public function actionIndex()
    {
        $searchModel = new UsersProjectsSearch();
        
        $searchModel->id_user = Yii::$app->user->getId();
        
        $searchModel->is_creator = 1;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,            
        ]);
    }*/

    /**
     * Displays a single UsersProjects model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UsersProjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UsersProjects();
        
        if($model->load(Yii::$app->request->post()) && array_key_exists('delete-linking', Yii::$app->request->post())){            
            
            $userid = Users::find()->where(['username' => $model->id_user])->one()['id'];
            
            Yii::$app->db->createCommand()
                    ->delete('users_projects', ['id_projects' => $model->id_projects, 'id_user' => $userid, 'is_creator' => 0])
                    ->execute();     
            
            return $this->goBack();
        }
        
        else {
        if ($model->load(Yii::$app->request->post())) {
            
            if(Yii::$app->session['idproject'])
            {$model->id_projects = Yii::$app->session['idproject'];}
            else 
            {$model->id_projects = '';}
            $model->is_creator = 0;
            
            $model->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {    
            
            $arr = explode('id=', Yii::$app->request->referrer);
            $ids = $arr[1];
            Yii::$app->session['idproject'] = $ids;
            
            $exists = UsersProjects::find()->where( [ 'id_projects' => $ids, 'id_user' => Yii::$app->user->getId(), 'is_creator' => 1 ] )->exists();
            
            if($exists){
            return $this->render('create', [
                'model' => $model,
                'projects' => $ids,                
            ]);
            }
            else 
                {return $this->goBack();}
        }
        }
    }

    /**
     * Updates an existing UsersProjects model.
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
            
            $UsersProjects = UsersProjects::find()->where(['id_user' => Yii::$app->user->getId(), 'is_creator' => 1])->all();
            $ids = [];
            
            foreach($UsersProjects as $project)
            {
                $ids[] = $project['id_projects'];
            }
            
            return $this->render('update', [
                'model' => $model,
                'projects' => Projects::find()->where(['id' => $ids])->all(),
            ]);
        }
    }

    /**
     * Deletes an existing UsersProjects model.
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
     * Finds the UsersProjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UsersProjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersProjects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}