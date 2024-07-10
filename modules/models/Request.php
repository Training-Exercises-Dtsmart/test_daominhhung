<?php

namespace app\modules\models;

use app\models\base\Request as BaseRequest;
class Request extends BaseRequest
{
    public function fields()
    {
        return array_merge(parent::fields(), ['Email Staff' => 'positionName', 'Status Request' => 'requestStatuss']);
    }
    public function getRequestStatuss()
    {
        return isset($this->requestStatus) ? $this->requestStatus->status_name : null;
    }
    public function getPositionName()
    {
        return isset($this->employee) ? $this->employee->email : null;
    }
}