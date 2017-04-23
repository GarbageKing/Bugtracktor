<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Issues */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Issues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issues-view">

    <h1><?= Html::encode($this->title) ?></h1>

    
    
    <div id="issue-info" class="row">
        
        <div class="col-md-9">
        <p>Created: <?php echo $model->cr_date; ?></p>
        <p><?php echo $model->description; ?></p>
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
        <p><?= Html::a('Manage user connections', ['/users-issues/create'], ['class' => 'btn btn-success']) ?></p>
            <p><h3>Type</h3>
            <?php if($model->priority == 0)
                    $priority = 'Bug[Low]';
                 if($model->priority == 1)
                    $priority = 'Bug[Medium]';
                 if($model->priority == 2)
                    $priority = 'Bug[High]';
                 if($model->priority == 3)
                    $priority = 'Task[Low]';
                 if($model->priority == 4)
                    $priority = 'Task[Medium]';
                 if($model->priority == 5)
                    $priority = 'Task[High]';
                 echo $priority;
            ?>
            </p>
        <p><h3>Status</h3>
            <?php if($model->status == 0)
                    $status = 'Closed';
                 if($model->status == 1)
                    $status = 'Open';
                 echo $status;
            ?>
        </p>
        </div>
    </div>
    
  
<p>
    <h3>Attached users:</h3> <br>
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
