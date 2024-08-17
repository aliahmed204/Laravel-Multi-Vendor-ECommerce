<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:shops,phone,'.auth('seller')->user()->shop->id,
            'description' => 'nullable|string|max:500',
            'address' => 'required|string|max:255',
            'logo'    => 'nullable|image'
//            'seller_id' => 'nullable|exists:sellers,id',
        ];
    }
}
