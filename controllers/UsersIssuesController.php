<?php

namespace app\controllers;

use Yii;
use app\models\UsersIssues;
use app\models\UsersIssuesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Issues;
use app\models\UsersProjects;
/**
 * UsersIssuesController implements the CRUD actions for UsersIssues model.
 */
class UsersIssuesController extends Controller
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
     * Lists all UsersIssues models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersIssuesSearch();
        
        $searchModel->id_user = Yii::$app->user->getId();
        
        $searchModel->is_creator = 1;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsersIssues model.
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
     * Creates a new UsersIssues model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UsersIssues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $id_user_issue = $model->id_issue;
            $issue = Issues::find()->where(['id' => $id_user_issue])->one();
            $id_project = $issue['id_project'];
            
            $model2 = new UsersProjects();
            $model2->id_projects = $id_project;
            $model2->id_user = $model->id_user;
            $model2->is_creator = 0;
            $model2->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {            
            
            $UsersIssues = UsersIssues::find()->where(['id_user' => Yii::$app->user->getId(), 'is_creator' => 1])->all();
            $ids = [];
            
            foreach($UsersIssues as $issue)
            {
                $ids[] = $issue['id_issue'];
            }
            
            return $this->render('create', [
                'model' => $model,
                'issues' => Issues::find()->where(['id' => $ids])->all(),
            ]);
        }
    }

    /**
     * Updates an existing UsersIssues model.
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
     * Deletes an existing UsersIssues model.
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
     * Finds the UsersIssues model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UsersIssues the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersIssues::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
