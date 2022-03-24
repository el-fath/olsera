<?php

namespace App\Http\Requests\Tax;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
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
            'name' => 'required',
            'rate' => 'required|numeric|gte:0|lte:99.99'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name is required',
            'rate.required' => 'rate is required',
            'rate.numeric' => 'rate type must be decimal',
            'rate.gte' => 'rate must be greater than 0',
            'rate.lte' => 'rate must be lower than 100'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'messages' => $validator->messages()
        ], 400);

        throw new HttpResponseException($response);
    }
}
