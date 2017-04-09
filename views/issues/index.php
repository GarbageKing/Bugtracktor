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
        <?= Html::a('Attach user to an issue', ['/users-issues/create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'id_project',
            
            'name',
            'description',
            [
                        'label' => 'Project',
                      'attribute' => 'id_project',                
                      
                      'value' => 'idProject.name',
            ],
            
            'priority' =>[
                'label' => 'Priority',
               'value' => function($model) {
        $pr = '';
        if($model->priority == 0)
        { $pr = 'Low'; }
        if($model->priority == 1)
        { $pr = 'Medium'; }
        if($model->priority == 2)
        { $pr = 'High'; }
            
    return $pr;
},
 
            ],
// => ['format' =>[0=>'Low', 1=>'Medium', 2=>'High']],
             'status'=>
            [
                'label' => 'Status',
               'value' => function($model) {
    return $model->status == 1 ? 'Open' : 'Closed';
}
 
            ],
                      

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
