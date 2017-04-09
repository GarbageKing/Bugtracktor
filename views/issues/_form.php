<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Issues */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issues-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= //$form->field($model, 'id_project')->textInput(['maxlength' => true]) 
    
     $form->field($model, 'id_project')->dropDownList(
        ArrayHelper::map($projects, 'id', 'name')
    ) 
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'priority')->dropDownList([
    '0' => 'Low',
    '1' => 'Medium',
    '2'=>'High'
]) ?>

    <?= $form->field($model, 'status')->dropDownList([
    '0' => 'Closed',
    '1' => 'Open'    
]) ?>

    
    
    <?= $form->field($model, 'cr_date')->hiddenInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
