<?php
namespace app\modules\models\form;

use Yii;
use app\models\Employee;
class EmployeeForm extends Employee
{
    public function formName(): string
    {
        return '';
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['name', 'email', 'position_id'], "required"],
            ["email", "email"],
            ['password', 'string', 'min' => 6],
        ]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->password !== null) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            $this->access_token = Yii::$app->security->generateRandomString();
            return true;
        }
        return false;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}