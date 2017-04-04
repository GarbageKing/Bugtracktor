<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-projects-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Users Projects', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_user',
            'id_projects',
            'is_creator',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
