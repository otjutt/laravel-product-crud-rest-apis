<?php

namespace App\Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'data.attributes.name' => 'required|max:255',
            'data.attributes.price' => 'required|numeric|gte:0',
        ];
    }
}
