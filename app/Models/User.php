<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * تحديد الحقول التي يمكن تعيينها بشكل جماعي
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',      // اسم المستخدم
        'email',     // عنوان البريد الإلكتروني
        'password',  // كلمة المرور
    ];

    /**
     * تحديد الحقول التي يجب إخفاؤها عند تحويل النموذج إلى مصفوفة أو JSON
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',         // كلمة المرور (يجب إخفاؤها لأسباب أمنية)
        'remember_token',   // رمز التذكير (يستخدم للتوثيق التلقائي)
    ];

    /**
     * علاقة "واحد إلى العديد" مع نموذج BorrowRecord
     *
     * يحدد أن المستخدم يمكن أن يكون له العديد من سجلات الاستعارة
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function borrowRecords()
    {
        return $this->hasMany(BorrowRecord::class);
    }

    /**
     * الحصول على معرّف JWT الخاص بالمستخدم
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * الحصول على المطالبات المخصصة لـ JWT
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
