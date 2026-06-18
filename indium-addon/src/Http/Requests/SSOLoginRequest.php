<?php

namespace Indium\PterodactylAddon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SSOLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'indium_sso_token' => 'required|string',
            'indium_sso_redirect' => 'nullable|string',
        ];
    }
}
