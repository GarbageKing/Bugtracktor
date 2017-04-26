<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

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

    <?= $form->field($model, 'description')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'priority')->dropDownList([
    '0' => 'Bug[Low]',
    '1' => 'Bug[Medium]',
    '2' => 'Bug[High]',
    '3' => 'Task[Low]',
    '4' => 'Task[Medium]',
    '5' => 'Task[High]'
]) ?>

    <?= $model->isNewRecord ? ''   :        
    $form->field($model, 'status')->dropDownList([
    '1' => 'Open',
    '0' => 'Closed'        
])   
?>
    
    <?= $form->field($model, 'dl_date')->widget(DatePicker::className(),['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
