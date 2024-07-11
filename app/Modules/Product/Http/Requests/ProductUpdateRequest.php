<?php

namespace App\Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'data.attributes.name' => 'nullable|max:255',
            'data.attributes.price' => 'nullable|numeric|gte:0',
        ];
    }
}
