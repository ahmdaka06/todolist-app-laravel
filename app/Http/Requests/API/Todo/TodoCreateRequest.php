<?php

namespace App\Http\Requests\API\Todo;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TodoCreateRequest extends BaseFormRequest
{
    protected function getValidatorInstance() {
		$instance = parent::getValidatorInstance();
        if ($instance->fails() == true) {
			throw new HttpResponseException(
                $this->sendError(__('general.bad_request'), parent::getValidatorInstance()->errors()->toArray(), 422)
            );
		}
        return parent::getValidatorInstance();
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required',
            'status' => 'required|in:waiting,progress,completed,fail,reject',
            'started_at' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'started_at' => 'Started At'
        ];
    }
}
