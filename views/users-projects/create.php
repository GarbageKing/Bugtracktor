<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UsersProjects */

$this->title = 'Create Users Projects';
$this->params['breadcrumbs'][] = ['label' => 'Users Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-projects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'projects' => $projects,
        //'users' => $users
    ]) ?>

</div>
