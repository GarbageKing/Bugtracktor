<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UsersIssues */

$this->title = 'Attach or Detach User to an Issue';
$this->params['breadcrumbs'][] = ['label' => 'Users Issues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-issues-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'issues' => $issues,
    ]) ?>

</div>
