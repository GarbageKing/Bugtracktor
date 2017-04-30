<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\UsersIssues */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-issues-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Attach' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::submitButton('Detach', ['class' => 'btn btn-danger',  'name' => 'delete-linking']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
