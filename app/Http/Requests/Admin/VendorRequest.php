<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'logo'        => 'required_without:id|mimes:jpg,jpeg,png',
            'name'        => 'required|string|max:100',
            'mobile'      => 'required|max:100',
            'email'       => 'sometimes|nullable|email',
            'category_id' => 'required|exists:main_categories,id',
            'address'     => 'required|string|max:500',
//            'password'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'logo.required'           => 'الشعار مطلوب .',
            'logo.mimes'              => 'يجب ان تكون نوع الصورة "jpg,jpeg,png"',
            'logo.required_without'   => 'الشعار مطلوب',
            'name.required'           => 'الاسم مطلوب',
            'name.max'                => 'يجب الا يزيد الاسم عن 100 حرف',
            'mobile.max'              => 'يجب الا يزيد رقم الهاتف عن 100 حرف',
            'mobile.required'         => 'رقم الهاتف مطلوب .',
            'email.required'          => 'البريد الإلكتروني مطلوب ',
            'email.email'             => 'صيغة البريد الالكتروني غير صحيحية',
            'email.string'            => 'يجب ان يكون الايميل عباراة عن حروف وارقام ورموز فقط',
            'category_id.required'    => 'القسم مطلوب .',
            'category_id.exists'      => 'القسم غير موجود.',
            'address.required'        => 'العنوان مطوب',
            'address.max'             => 'يجب الا يزيد العنوان عن 500 حرف',
            'address.string'          => 'العنوان لابد ان يكون حروف وارقام',
            'password.required'       => 'يجب ادخال كلمة المرور'
        ];
    }
}
