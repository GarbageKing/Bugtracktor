<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projects".
 *
 * @property string $id
 * @property string $name
 * @property string $cr_date
 *
 * @property Issues[] $issues
 * @property UsersProjects[] $usersProjects
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['cr_date'], 'safe'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'cr_date' => 'Cr Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasMany(Issues::className(), ['id_project' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersProjects()
    {
        return $this->hasMany(UsersProjects::className(), ['id_projects' => 'id']);
    }
    
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord)
            { 
                
            $project_id = Projects::find()->where(['name' => trim($this->name)])->one()['id'];       
            
            $exists = UsersProjects::find()->where( [ 'id_user' => Yii::$app->user->getId(), 'id_projects' => $project_id ] )->exists();
            
            if($exists){                
                die( '<script>alert("You already have a project with this name!"); window.location.href="?r=projects%2Fcreate";</script>');                    
            }
            
            }
            return parent::beforeSave($insert);
        }
    }
    
}
