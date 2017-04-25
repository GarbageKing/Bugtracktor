<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "issues".
 *
 * @property string $id
 * @property string $id_project
 * @property string $name
 * @property string $description
 * @property integer $priority
 * @property integer $status
 * @property string $cr_date
 *
 * @property Projects $idProject
 * @property UsersIssues[] $usersIssues
 */
class Issues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'issues';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_project', 'name'], 'required'],
            [['id_project', 'priority', 'status'], 'integer'],
            [['cr_date'], 'safe'],
            [['name'], 'string', 'max' => 300],
            [['description'], 'string', 'max' => 2000],
            [['id_project'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['id_project' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_project' => 'Project',
            'name' => 'Issue Name',
            'description' => 'Description',
            'priority' => 'Type',
            'status' => 'Status',
            'cr_date' => 'Cr Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'id_project']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersIssues()
    {
        return $this->hasMany(UsersIssues::className(), ['id_issue' => 'id']);
    }
    
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($this->isNewRecord)
            { 
                
            $this->status = 1;
                
            $exists = Issues::find()->where(['name' => trim($this->name), 'id_project' => $this->id_project])->exists();                   
            
            if($exists){                
                die( '<script>alert("There is an issue within this project with the same name!"); window.location.href="?r=issues%2Fcreate";</script>');                    
            }
            
            }
            return parent::beforeSave($insert);
        }
    }    
    
}
