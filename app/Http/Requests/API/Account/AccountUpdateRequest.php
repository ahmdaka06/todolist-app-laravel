<?php

namespace App\Http\Requests\API\Account;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AccountUpdateRequest extends BaseFormRequest
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
            'new_password' => 'required|min:6',
            'confirmation_new_password' => 'required|same:new_password',
            'old_password' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'new_password' => 'New Password',
            'confirmation_new_password' => 'Confirmation New Password',
            'old_password' => 'Old Password'
        ];
    }
}
