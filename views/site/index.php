<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Hi There, <?= (Yii::$app->user->getId() ? Yii::$app->user->identity->username : '%username%');  ?>!</h1>

        <p class="lead"><?= 'You may proceed to' . (Yii::$app->user->getId() ? ' your stuff' : ' LogIn or SignUp');  ?></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-sm-6">
                <h2><a  href="<?= (Yii::$app->user->getId() ? '?r=projects' : '?r=site%2Flogin');  ?>">
        <?= (Yii::$app->user->getId() ? 'Projects' : 'LogIn');  ?>
                </a></h2>            
            </div>
            <div class="col-sm-6">
                <h2><a href="<?= (Yii::$app->user->getId() ? '?r=issues' : '?r=users%2Fcreate');  ?>">
        <?= (Yii::$app->user->getId() ? 'Issues' : 'SignUp');  ?>
                </a></h2>
                
            </div>  
            <?php if(Yii::$app->user->getId()){ ?>
            <div class="col-sm-offset-3 col-sm-6">
                <h2><a href="<?= '?r=users%2Fupdate&id='.Yii::$app->user->getId();  ?>">
                Update Your Profile
                </a></h2>                
            </div>   
            <?php } ?>
        </div>

    </div>
</div>
