<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\NotSupportedException;

class Users extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['email', 'password_hash', 'mobile_number'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::class, 'message' => 'This email address has already been taken.'],
            ['password_hash', 'string', 'min' => 6],
            ['mobile_number', 'string', 'length' => 10],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isAttributeChanged('password_hash')) {
                $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password_hash);
            }
            return true;
        }
        return false;
    }

    // IdentityInterface methods
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }
}
