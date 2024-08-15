<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CreateCatRequest extends FormRequest
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
        if($this->isMethod('put') || $this->isMethod('patch')){
            return [
                'name'=>'required|min:5|unique:categories,name,'.Category::where('id',$this->id)->value('id'),
                'description'=>'required|min:10',
                //'ordering' => 'required|min:1|unique:categories,ordering,'.Category::where('id',$this->id)->value('id'),
                'image'=>'nullable|image|mimes:png,jpg,jpeg,svg',

                'parent_id'=>'required_with:sub|exists:categories,id',
                'is_child_of'=>'nullable',
            ];
        }else{
            return [
                'name'=>'required|min:5|unique:categories,name',
                'description'=>'required|min:10',
                'image'=>'required|image|mimes:png,jpg,jpeg,svg',

                'parent_id'=>'required_with:sub|exists:categories,id',
                'is_child_of'=>'nullable',
            ];
        }

    }

    public function prepareForValidation()
    {
        return $this->merge([
            'is_active' => $this->is_active ?: false,
        ]);
    }
}
