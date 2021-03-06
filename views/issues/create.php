<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Issues */

$this->title = 'Create an Issue';
$this->params['breadcrumbs'][] = ['label' => 'Issues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issues-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'projects' => $projects
    ]) ?>

</div>
