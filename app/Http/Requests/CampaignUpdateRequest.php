<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignUpdateRequest extends FormRequest
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
            'to' => 'required',
            'from' => 'required',
            'daily_budget' => 'required|numeric',
            'total_budget' => 'required|numeric',
            'creatives.*' => 'image'
        ];
    }
    public function messages()
    {
        return [
            'creatives.*.image' => "Creative image must be an image type."
        ];
    }
}
