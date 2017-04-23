<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-projects-index">

    <h1>Your Projects</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Attach User to Project', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Project', ['/projects/create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'id_user',
            //'id_projects',             
            [
                      'attribute' => 'id_projects',                
                      
                      'value' => 'idProjects.name',
            ],
            //'is_creator',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
