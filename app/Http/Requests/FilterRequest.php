<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FilterRequest extends FormRequest
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
            'category' => 'required|exists:categories,id|',
            'sub_category' => 'filled|' . Rule::exists('sub_categories', 'id')->where('category_id', request('category')),
            'rating' => 'filled|numeric|between:0,5',
            'brand' => Rule::when(
                request()->has('sub_category'),
                [
                    'filled',
                    Rule::exists('brand_sub_categories', 'brand_id')->where('sub_category_id', request('sub_category'))
                ],
                [
                    'filled',
                    Rule::exists('brand_categories', 'brand_id')->where('category_id', request('category'))
                ]
            ),
            'discount' => 'filled|numeric|min:1|max:99',
            'price' => 'filled|array|size:2',
            'price.*' => 'numeric|min:1',
            'orderByPrice' => 'filled|in:high,low'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors()
        ], 422));
    }
}
