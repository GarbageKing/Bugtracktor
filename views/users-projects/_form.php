<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\UsersProjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-projects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->textInput(['maxlength' => true]) 
    
    //$form->field($model, 'id_user')->textInput(['value' => Users::findOne(['username' => ]['id'])])
    ?>

    <?= $form->field($model, 'id_projects')->dropDownList(
        ArrayHelper::map($projects, 'id', 'name')
    )  ?>

    <?= $form->field($model, 'is_creator')->hiddenInput(['value' => '0']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
