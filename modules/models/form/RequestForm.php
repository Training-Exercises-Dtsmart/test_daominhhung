<?php

namespace app\modules\models\form;

use app\models\Request;

class RequestForm extends Request
{
    public function formName(): string
    {
        return '';
    }
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['employee_id', 'leave_date', 'leave_reason'], "required"],
//            ["leave_date", "date"],
//            ['leave_reason', 'string', 'min' => 6],
        ]);
    }
}