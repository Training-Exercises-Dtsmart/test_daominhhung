<?php

namespace app\modules\controllers;


use Yii;
use app\modules\models\Employee;
use app\modules\models\Request;
use app\modules\HTTPS_CODE;
use app\modules\models\form\RequestForm;
use app\modules\models\pagination\Pagination;

class RequestController extends Controller
{
    public function actionIndex()
    {
        $request = Request::find();
        if(empty($request))
        {
            return $this->json(false, [], 'Request not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        $provider = Pagination::getPagination($request,10, SORT_ASC);
        return $this->json(true, $provider, 'success', HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionCreate()
    {
        $request = new RequestForm();
        $request->load(Yii::$app->request->post());
        if($request->validate())
        {
            if(!$request->save())
            {
                return $this->json(false, $request->errors, 'Create request fail', HTTPS_CODE::BADREQUEST_CODE);
            }
        }
        return $this->json(true, $request, 'success', HTTPS_CODE::SUCCESS_CODE);
    }
    public function actionUpdate($id)
    {
        $request = Request::findOne($id);
        if (!$request) {
            return $this->json(false, [], 'Request not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        $accessToken = Yii::$app->request->headers->get('Authorization');
        if (!$accessToken) {
            return $this->json(false, [], 'Unauthorized', HTTPS_CODE::BADREQUEST_CODE);
        }
        $employee = Employee::findIdentityByAccessToken($accessToken);
        if (!$employee || $employee->position_id !== 2) {
            return $this->json(false, [], 'Unauthorized', HTTPS_CODE::BADREQUEST_CODE);
        }
        $request->load(Yii::$app->request->post(), '');
        $request->hr_id = $employee->id;
        if (!$request->validate() || !$request->save()) {
            return $this->json(false, $request->getErrors(), 'Update request failed', HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, $request, 'Request updated successfully', HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionDelete($id)
    {
        $request = Request::find()->select('id')->where(['id' => $id])->one();
        if(empty($request)) {
            return $this->json(false, [], 'Request not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        return $this->json(true, $request, 'Request deleted successfully', HTTPS_CODE::SUCCESS_CODE);
    }
}