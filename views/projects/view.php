<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div id="issue-info" class="row">
    <div class="col-md-9">
        <p>Created: <?php echo $model->cr_date; ?></p>
    </div>
    <div class="col-md-3">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    </div>
</div>
        
    <p>
    Attached users: <br>
    <?php 
        
        $namesToShow = '';
        foreach ($usernames as $username)
        {           
        $namesToShow .= $username . ', ';    
        }
        echo substr($namesToShow, 0, -2);
        ?>
    </p>
    </div>
    
</div>
