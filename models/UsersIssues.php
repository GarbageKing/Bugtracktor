<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_issues".
 *
 * @property string $id
 * @property string $id_user
 * @property string $id_issue
 * @property integer $is_creator
 *
 * @property Users $idUser
 * @property Issues $idIssue
 */
class UsersIssues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_issues';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_issue', 'is_creator'], 'required'],
            [['id_issue', 'is_creator'], 'integer'],            
            [['id_issue'], 'exist', 'skipOnError' => true, 'targetClass' => Issues::className(), 'targetAttribute' => ['id_issue' => 'id']],            
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
            'id_issue' => 'Id Issue',
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
    public function getIdIssue()
    {
        return $this->hasOne(Issues::className(), ['id' => 'id_issue']);
    }
        
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            
            if($this->isNewRecord && preg_match("/[a-z]/i", $this->id_user))
            { 
                
            $Users = Users::find()->where(['username' => $this->id_user])->all();
            
            $ids = [];
            
            foreach($Users as $user)
            {
                $ids[] = $user['id'];
            }
                
            $this->id_user = $ids[0];
            
            $exists = UsersIssues::find()->where( [ 'id_user' => $this->id_user, 'id_issue' => Yii::$app->session['idissue'] ] )->exists();
            
            if($exists){                
                die( '<script>alert("This user is already attached to this issue!"); window.location.href="?r=issues";</script>');                    
            }            
            
            }
            return parent::beforeSave($insert);
        }
    }
    
}