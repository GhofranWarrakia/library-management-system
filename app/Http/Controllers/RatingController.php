<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * إضافة تقييم جديد لكتاب
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ], [
            'book_id.required' => 'يجب تحديد الكتاب المراد تقييمه',
            'book_id.exists' => 'الكتاب المحدد غير موجود',
            'rating.required' => 'يجب تقديم تقييم للكتاب',
            'rating.integer' => 'يجب أن يكون التقييم عبارة عن رقم صحيح',
            'rating.min' => 'يجب أن يكون التقييم على الأقل 1',
            'rating.max' => 'أقصى تقييم هو 5',
        ]);

        $rating = Rating::create([
            'user_id' => $request->user()->id,
            'book_id' => $validated['book_id'],
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        return response()->json([
            'message' => 'تم إضافة التقييم بنجاح',
            'rating' => $rating,
        ], 201);
    }

    /**
     * عرض جميع التقييمات لكتاب معين
     *
     * @param int $book_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($book_id)
    {
        $ratings = Rating::where('book_id', $book_id)->get();
        return response()->json($ratings);
    }

    /**
     * تحديث تقييم معين لكتاب
     *
     * @param Request $request
     * @param Rating $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Rating $rating)
    {
        $this->authorize('update', $rating);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ], [
            'rating.required' => 'يجب تقديم تقييم للكتاب',
            'rating.integer' => 'يجب أن يكون التقييم عبارة عن رقم صحيح',
            'rating.min' => 'يجب أن يكون التقييم على الأقل 1',
            'rating.max' => 'أقصى تقييم هو 5',
        ]);

        $rating->update($validated);

        return response()->json([
            'message' => 'تم تحديث التقييم بنجاح',
            'rating' => $rating,
        ]);
    }

    /**
     * حذف تقييم معين
     *
     * @param Rating $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Rating $rating)
    {
        $this->authorize('delete', $rating);

        $rating->delete();

        return response()->json([
            'message' => 'تم حذف التقييم بنجاح',
        ], 204);
    }
}
