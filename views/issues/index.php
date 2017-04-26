<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IssuesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Issues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issues-index">

    <h1>Issues creation page</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Issue', ['create'], ['class' => 'btn btn-success']) ?>        
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'id_project',
            
            'name',            
            [
                        'label' => 'Project',
                      'attribute' => 'id_project',                
                      
                      'value' => 'idProject.name',
            ],
            'description',
            [
            'attribute' => 'dl_date',  
            'format' => 'raw',
            'value'     => function ($model) {
                if ($model->dl_date != null) {
                    return $model->dl_date;               
                } else {
                    return '-';
                }
            },   
            'filter'=>false,
            ],
            //'dl_date',
            'priority' =>[
                'label' => 'Priority',
               'value' => function($model) {
        if($model->priority == 0)
                    $priority = 'Bug[Low]';
                 if($model->priority == 1)
                    $priority = 'Bug[Medium]';
                 if($model->priority == 2)
                    $priority = 'Bug[High]';
                 if($model->priority == 3)
                    $priority = 'Task[Low]';
                 if($model->priority == 4)
                    $priority = 'Task[Medium]';
                 if($model->priority == 5)
                    $priority = 'Task[High]';
                 return $priority;
},
            'attribute' => 'priority',
            'filter'=>false,
            ],
// => ['format' =>[0=>'Low', 1=>'Medium', 2=>'High']],
             'status'=>
            [
                'label' => 'Status',
                'value' => function($model) {
    return $model->status == 1 ? 'Open' : 'Closed';
},               'attribute' => 'status',
                'filter'=>false,
 
            ],
                      

            ['class' => 'yii\grid\ActionColumn', 'template'=>'{view}'],
        ],
    ]); ?>
</div>
