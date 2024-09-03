<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookFormRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * عرض قائمة جميع الكتب
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $books = Book::all();

        return response()->json([
            'message' => 'قائمة الكتب',
            'books' => $books,
        ], 200);
    }

    /**
     * إنشاء كتاب جديد
     *
     * @param BookFormRequest $request
     * @return JsonResponse
     */
    public function store(BookFormRequest $request): JsonResponse
    {
        $book = Book::create($request->validated());

        return response()->json([
            'message' => 'تم إنشاء الكتاب بنجاح',
            'book' => $book,
        ], 201);
    }

    /**
     * عرض تفاصيل كتاب محدد
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $book = Book::findOrFail($id);

        return response()->json([
            'message' => 'تفاصيل الكتاب',
            'book' => $book,
        ], 200);
    }

    /**
     * تحديث بيانات كتاب محدد
     *
     * @param BookFormRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(BookFormRequest $request, $id): JsonResponse
    {
        $book = Book::findOrFail($id);
        $book->update($request->validated());

        return response()->json([
            'message' => 'تم تحديث بيانات الكتاب بنجاح',
            'book' => $book,
        ], 200);
    }

    /**
     * حذف كتاب محدد.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'message' => 'تم حذف الكتاب بنجاح',
        ], 200);
    }

    /**
     * فلترة الكتب بناءً على معايير محددة مثل المؤلف، النوع، والتوفر
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function filterBooks(Request $request): JsonResponse
    {
        $query = Book::query();

        if ($request->has('author')) {
            $query->where('author', $request->input('author'));
        }

        if ($request->has('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        if ($request->has('available')) {
            $query->where('available', $request->input('available') == 'true');
        }

        $books = $query->get();

        if ($books->isEmpty()) {
            return response()->json(['message' => 'لم يتم العثور على الكتاب المطابق للمعلومات التي تريدها'], 404);
        }

        return response()->json($books);
    }
}
