<?php
namespace App\Http\Controllers;

use App\Http\Requests\BorrowRecordFormRequest;
use App\Models\BorrowRecord;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class BorrowRecordController extends Controller
{
    /**
     * عرض جميع سجلات الاستعارة الخاصة بالمستخدم الحالي
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $borrowRecords = BorrowRecord::where('user_id', $user->id)->get();

        return response()->json([
            'message' => 'سجل الاستعارات الخاصة بك',
            'borrow_records' => $borrowRecords,
        ], 200);
    }

    /**
     * إنشاء سجل استعارة جديد للكتاب
     *
     * @param BorrowRecordFormRequest $request
     * @return JsonResponse
     */
    public function store(BorrowRecordFormRequest $request): JsonResponse
    {
        $user = Auth::user();

        // التحقق من توفر الكتاب
        $book = Book::findOrFail($request->book_id);
        if ($book->is_borrowed) {
            return response()->json(['message' => 'هذا الكتاب مستعار بالفعل'], 400);
        }

        // إنشاء سجل الاستعارة
        $borrowRecord = BorrowRecord::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14),
        ]);

        // تحديث حالة الكتاب إلى مستعار
        $book->is_borrowed = true;
        $book->save();

        return response()->json([
            'message' => 'تم استعارة الكتاب بنجاح',
            'borrow_record' => $borrowRecord,
        ], 201);
    }

    /**
     * إرجاع كتاب مستعار وتحديث السجل
     *
     * @param BorrowRecordFormRequest $request
     * @return JsonResponse
     */
    public function returnBook(BorrowRecordFormRequest $request): JsonResponse
    {
        $user = Auth::user();
        $borrowRecord = BorrowRecord::where('book_id', $request->book_id)
                                    ->where('user_id', $user->id)
                                    ->whereNull('returned_at')
                                    ->firstOrFail();

        // تحديث سجل الإرجاع
        $borrowRecord->returned_at = now();
        $borrowRecord->save();

        // تحديث حالة الكتاب إلى غير مستعار
        $book = $borrowRecord->book;
        $book->is_borrowed = false;
        $book->save();

        return response()->json(['message' => 'تم إرجاع الكتاب بنجاح'], 200);
    }
}
