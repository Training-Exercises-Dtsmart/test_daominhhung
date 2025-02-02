<?php

namespace app\modules\models;

use app\models\base\Employee as BaseEmployee;
use yii\web\IdentityInterface;
class  Employee extends BaseEmployee implements IdentityInterface
{
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->access_token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->access_token === $authKey;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    public function fields(): array
    {
        return [
            'name',
            'email',
            'position',
            'created_at'
        ];
    }
}