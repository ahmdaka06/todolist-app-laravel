<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends BaseFormRequest
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
            'email' => 'required',
            'password' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'password' => 'Password'
        ];
    }
}
