<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * تحديد الحقول التي يمكن تعيينها بشكل جماعي
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',        // معرف المستخدم الذي قدم التقييم
        'book_id',        // معرف الكتاب الذي تم تقييمه
        'rating',         // تقييم الكتاب (من 1 إلى 5)
        'review',         // مراجعة الكتاب (نص اختياري)
    ];

    /**
     * علاقة "ينتمي إلى" مع نموذج User
     *
     * يحدد أن التقييم ينتمي إلى مستخدم واحد
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
     * يحدد أن التقييم ينتمي إلى كتاب واحد
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
