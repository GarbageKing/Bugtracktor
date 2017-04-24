<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Hi There, <?php echo (Yii::$app->user->getId() ? Yii::$app->user->identity->username : '%username%');  ?>!</h1>

        <p class="lead"><?php echo 'You may proceed to' . (Yii::$app->user->getId() ? ' your stuff' : ' LogIn or SignUp');  ?></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-sm-6">
                <h2><?php echo (Yii::$app->user->getId() ? 'Projects' : 'LogIn');  ?></h2>                

                <p><a class="btn btn-default" href="<?php echo (Yii::$app->user->getId() ? '?r=projects' : '?r=site%2Flogin');  ?>">Go</a></p>
            </div>
            <div class="col-sm-6">
                <h2><?php echo (Yii::$app->user->getId() ? 'Issues' : 'SignUp');  ?></h2>

                <p><a class="btn btn-default" href="<?php echo (Yii::$app->user->getId() ? '?r=issues' : '?r=site%2Fregister');  ?>">Go</a></p>
            </div>            
        </div>

    </div>
</div>
