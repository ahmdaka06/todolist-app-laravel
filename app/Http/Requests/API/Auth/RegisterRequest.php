<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends BaseFormRequest
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
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
