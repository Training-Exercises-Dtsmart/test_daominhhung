<?php

namespace app\modules\controllers;

use Yii;
use app\modules\models\Employee;
use app\modules\models\form\EmployeeForm;
use app\modules\HTTPS_CODE;
use app\modules\models\pagination\Pagination;

class EmployeeController extends Controller
{
    public function actionIndex()
    {
        $employee = Employee::find();

        if(empty($employee))
        {
            return $this->json(false, [], 'Employee not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        $provider = Pagination::getPagination($employee,10, SORT_ASC);
        return $this->json(true, $provider, 'success', HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionLogin()
    {
        $email = Yii::$app->getRequest()->post('email');
        $password = Yii::$app->getRequest()->post('password');
        if (!$email || !$password) {
            return $this->json(false, [], 'Missing required parameters: username, password', HTTPS_CODE::BADREQUEST_CODE);
        }
        $user = EmployeeForm::findOne(['email' => $email]);
        if (!$user) {
            return $this->json(false, [], 'User not found or incorrect password', HTTPS_CODE::NOUTFOUND_CODE);
        }
        if (!$user->validatePassword($password, $user->password)) {
            return $this->json(false, [], 'Incorrect password', HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, ['data' => $user], 'success', HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionRegister()
    {
        $employee = new EmployeeForm();
        $employee->load(Yii::$app->request->post());

        if(!$employee->validate() || !$employee->save())
        {
            return $this->json(false, $employee->getErrors(), 'Create employee fail', HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, $employee, 'sucess', HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionUpdate($id)
    {
        $employee = Employee::findOne($id);
        if(!$employee)
        {
            return $this->json(false, [], 'Employee not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        $employee->load(Yii::$app->request->post());
        if(!$employee->validate())
        {
            if(!$employee->save())
            {
                return $this->json(false, $employee->getErrors(), 'Update employee fail', HTTPS_CODE::BADREQUEST_CODE);
            }
        }
        return $this->json(true, $employee, 'success', HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionDelete($id)
    {
        $employee = Employee::find()->select('id')->where(['id' => $id])->one();
        if(empty($employee))
        {
            return $this->json(false, [], 'Employee not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        return $this->json(true, $employee, 'success', HTTPS_CODE::SUCCESS_CODE);
    }
}