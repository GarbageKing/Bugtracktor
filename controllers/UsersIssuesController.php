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
use app\models\Users;
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
    /*public function actionIndex()
    {
        $searchModel = new UsersIssuesSearch();
        
        $searchModel->id_user = Yii::$app->user->getId();
        
        $searchModel->is_creator = 1;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

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
        
        if($model->load(Yii::$app->request->post()) && array_key_exists('delete-linking', Yii::$app->request->post())){            
            
            $userid = Users::find()->where(['username' => $model->id_user])->one()['id'];
            
            Yii::$app->db->createCommand()
                    ->delete('users_issues', ['id_issue' => Yii::$app->session['idissue'], 'id_user' => $userid, 'is_creator' => 0])
                    ->execute();     
            
            return '<script>alert("User has been detached!"); window.location.href="?r=issues";</script>';
        }
        
        else {             
            
        if ($model->load(Yii::$app->request->post())) {   
                       
            
            if(Yii::$app->session['idissue'])
            {$model->id_issue = Yii::$app->session['idissue'];}
            else 
            {$model->id_issue = '';}
            $model->is_creator = 0;
            
            $model->save();
            
            $id_user_issue = $model->id_issue;
            $issue = Issues::find()->where(['id' => $id_user_issue])->one();
            $id_project = $issue['id_project'];
            
            $model2 = new UsersProjects();
            $model2->id_projects = $id_project;
            $model2->id_user = $model->id_user;
            $model2->is_creator = 0;
            $model2->save();
            
            return $this->redirect(Yii::$app->session['prevurl']);
        } else {            
                       
            Yii::$app->session['prevurl'] = Yii::$app->request->referrer;
            $arr = explode('id=', Yii::$app->request->referrer); 
            if(count($arr)<2)
            {return;}
            $ids = $arr[1]; 
            Yii::$app->session['idissue'] = $ids;            
            
            $exists = UsersIssues::find()->where( [ 'id_issue' => $ids, 'id_user' => Yii::$app->user->getId(), 'is_creator' => 1 ] )->exists();
            
            if($exists){
            return $this->render('create', [
                'model' => $model,
                'issues' => $ids,
            ]);}
            else 
            {return '<script>alert("Only a creator of an issue can manage connections!"); window.location.href=document.referrer;</script>'; }  
        }
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
