<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_projects".
 *
 * @property string $id
 * @property string $id_user
 * @property string $id_projects
 * @property integer $is_creator
 *
 * @property Users $idUser
 * @property Projects $idProjects
 */
class UsersProjects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_projects', 'is_creator'], 'required'],
            [['id_projects', 'is_creator'], 'integer'],            
            [['id_projects'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['id_projects' => 'id']],            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Username',
            'id_projects' => 'Id Projects',
            'is_creator' => 'Is Creator',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProjects()
    {
        return $this->hasOne(Projects::className(), ['id' => 'id_projects']);
    }
   
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord && preg_match("/[а-яёa-z]/i", $this->id_user))
            { 
                
            $Users = Users::find()->where(['username' => $this->id_user])->all();
            
            if(!$Users)
                die( '<script>alert("There is no user with this username!"); window.location.href="?r=issues";</script>');
            
            $ids = [];
            
            foreach($Users as $user)
            {
                $ids[] = $user['id'];
            }
                
            $this->id_user = $ids[0];
            
            $exists = UsersProjects::find()->where( [ 'id_user' => $this->id_user, 'id_projects' => Yii::$app->session['idproject'] ] )->exists();
            
            if($exists){                
                die( '<script>alert("This user is already attached to this project!"); window.location.href="?r=projects";</script>');                    
            }
            
            }
            return parent::beforeSave($insert);
        }
    }
    
}