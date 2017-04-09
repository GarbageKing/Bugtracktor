<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersIssuesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Users Issues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-issues-index">

    <h1>Your issues</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Attach user to issue', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Issue', ['/issues/create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            //'id_user',
            //'id_issue',
            //'is_creator',
            
            [
                      'attribute' => 'id_issue',                
                      
                      'value' => 'idIssue.name',
            ],
            
            [
                      //'attribute' => 'id_project',                
                      
                      'value' => 'idIssue.description',
            ],
            
            [
                      //'attribute' => 'id_project',                
                      
                      'value' => 'idIssue.id_project',
            ],
            
            [
                      //'attribute' => 'id_project',                
                      
                      'value' => 'idIssue.priority',
            ],
            
            [
                      //'attribute' => 'id_project',                
                      
                      'value' => 'idIssue.status',
            ],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>