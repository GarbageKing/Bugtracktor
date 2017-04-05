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
            [[/*'id_user', */'id_projects', 'is_creator'], 'integer'],
            //[['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id']],
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
            'id_user' => 'Id User',
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
            if($this->isNewRecord && preg_match("/[a-z]/i", $this->id_user))
            { 
                //echo $this->id_user; die;
            $Users = Users::find()->where(['username' => $this->id_user])->all();
            
            $ids = [];
            
            foreach($Users as $user)
            {
                $ids[] = $user['id'];
            }
                
            $this->id_user = $ids[0];
            //$this->is_creator = 0;
            
            //echo $this->id_user; die;
            }
            return parent::beforeSave($insert);
        }
    }
    
}