<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * تحديد الحقول التي يمكن تعيينها بشكل جماعي
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',          // عنوان الكتاب
        'author',         // مؤلف الكتاب
        'description',    // وصف الكتاب
        'published_at',   // تاريخ نشر الكتاب
        'is_borrowed',    // حالة الاستعارة: true إذا كان الكتاب مستعارًا، false إذا كان متاحًا
        'genre',          // نوع الكتاب (مثل: خيال، تكنولوجيا، تعليمي)
        'available'       // حالة التوافر: true إذا كان الكتاب متاحًا للإعارة، false إذا لم يكن متاحًا
    ];

    /**
     * علاقة "واحد إلى العديد" مع نموذج BorrowRecord.
     *
     * يحدد أن كتابًا واحدًا يمكن أن يرتبط بالعديد من سجلات الاستعارة
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function borrowRecords()
    {
        return $this->hasMany(BorrowRecord::class);
    }
}
