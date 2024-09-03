<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BorrowRecordFormRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مصرحًا له بإجراء هذا الطلب
     *
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
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'borrowed_at' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrowed_at',
        ];
    }

    /**
     * تخصيص أسماء الحقول لتكون أكثر وضوحًا في الرسائل
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'book_id' => 'الكتاب',
            'user_id' => 'المستخدم',
            'borrowed_at' => 'تاريخ الاستعارة',
            'due_date' => 'تاريخ الإعادة',
        ];
    }

    /**
     * تخصيص رسائل التحقق لتكون أكثر وضوحًا للمستخدمين
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'book_id.required' => 'يجب تحديد الكتاب المراد استعارته',
            'user_id.required' => 'يجب تحديد المستخدم الذي يستعير الكتاب',
            'due_date.after_or_equal' => 'تاريخ الإعادة يجب أن يكون بعد أو يساوي تاريخ الاستعارة',
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
     * - تسجيل سجل في ملف لوج
     * - إرسال إشعار إلى المستخدم
     * - تحديث عدد الاستعارات للمستخدم
     * - ضبط تاريخ الإرجاع تلقائيًا
     */
    protected function passedValidation()
    {
        // تسجيل سجل في ملف لوج
        \Log::info('تم التحقق بنجاح من بيانات الاستعارة', [
            'book_id' => $this->book_id,
            'user_id' => $this->user_id,
            'borrowed_at' => $this->borrowed_at,
            'due_date' => $this->due_date,
        ]);

        // إرسال إشعار إلى المستخدم
        $user = \App\Models\User::find($this->user_id);
        $user->notify(new \App\Notifications\BorrowRecordCreatedNotification($this->book_id, $this->due_date));

        // تحديث عدد الاستعارات للمستخدم
        $user->increment('borrow_count');

        // ضبط تاريخ الإرجاع تلقائيًا إذا لم يتم تحديده
        if (empty($this->due_date)) {
            $this->merge([
                'due_date' => now()->addDays(14)->format('Y-m-d'),
            ]);
        }
    }
}
