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

    <div class="row">
    <div class="col-sm-12">
    <h1>Issues attached to you</h1>    
        <?= Html::a('Create New', ['create'], ['class' => 'btn btn-success']) ?>     
    </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
        'tableOptions' => [
            'class' => 'table table-bordered'
        ],
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
            //'description',
            [
                'attribute' => 'description',
                'value'     => function ($model) {
                if(mb_strlen($model->description)>=50)
                return substr($model->description, 0, 50).'...';
                return $model->description;
                }
            ],
            [
            'attribute' => 'dl_date',  
            'format' => 'raw',
            'value'     => function ($model) {
                if ($model->dl_date != null) {
                    if(strtotime(date("Y-m-d", strtotime("+3 days"))) > strtotime($model->dl_date) &&
                            $model->status==1) { 
                        return '<span style="color:red">' . $model->dl_date . '</span>';  
                    }  
                    else {
                        return $model->dl_date;  
                    }
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
