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
        <?= Html::a('Create Issues', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_project',
            'name',
            'description',
            'priority',
            // 'status',
            // 'cr_date',
            'usersIssues.id_user',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
