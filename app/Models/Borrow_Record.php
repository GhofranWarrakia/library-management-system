<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowRecord extends Model
{
    use HasFactory;

    /**
     * تحديد الحقول التي يمكن تعيينها بشكل جماعي
     *
     * @var array<string>
     */
    protected $fillable = [
        'book_id',        // معرف الكتاب الذي تم استعاره
        'user_id',        // معرف المستخدم الذي استعاره
        'borrowed_at',    // تاريخ استعارة الكتاب
        'due_date',       // تاريخ إرجاع الكتاب
        'returned_at',    // تاريخ إرجاع الكتاب الفعلي (null إذا لم يُرجع بعد)
    ];

    /**
     * علاقة "ينتمي إلى" مع نموذج User
     *
     * يحدد أن سجل الاستعارة ينتمي إلى مستخدم واحد
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة "ينتمي إلى" مع نموذج Book
     *
     * يحدد أن سجل الاستعارة ينتمي إلى كتاب واحد
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
