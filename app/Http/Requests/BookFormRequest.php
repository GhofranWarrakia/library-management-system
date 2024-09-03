<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookFormRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مصرحًا له بإجراء هذا الطلب
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // السماح بالتحقق
    }

    /**
     * الحصول على قواعد التحقق التي تنطبق على الطلب
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3',
            'author' => 'required|string|min:3',
            'description' => 'nullable|string',
            'published_at' => 'required|date',
        ];
    }

    /**
     * تخصيص أسماء الحقول للتعامل مع الرسائل
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'title' => 'اسم الكتاب',
            'author' => 'اسم المؤلف',
        ];
    }

    /**
     * تخصيص رسائل التحقق للحقول
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'title.required' => 'اسم الكتاب مطلوب',
            'author.required' => 'اسم المؤلف مطلوب',
        ];
    }

    /**
     * التعامل مع حالات فشل التحقق من البيانات
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => 'فشل التحقق من البيانات المدخلة',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }

    /**
     * تنفيذ العمليات بعد نجاح التحقق من البيانات
     *
     * - تسجيل المعلومات في ملف لوج.
     * - إرسال إشعار للمسؤول.
     * - ضبط تاريخ النشر إذا كان فارغًا.
     */
    protected function passedValidation()
    {
        // تسجيل المعلومات في ملف لوج
        \Log::info('تم التحقق بنجاح من بيانات الكتاب', [
            'title' => $this->title,
            'author' => $this->author,
        ]);

        // إرسال إشعار للمسؤول
        \Notification::route('mail', 'admin@example.com')
                     ->notify(new \App\Notifications\NewBookAddedNotification($this->title, $this->author));

        // ضبط تاريخ النشر إذا كان فارغًا
        if (empty($this->published_at)) {
            $this->merge([
                'published_at' => now()->format('Y-m-d'),
            ]);
        }
    }
}
