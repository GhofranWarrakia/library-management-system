<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\BorrowRecordController;
use App\Http\Controllers\RatingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route to get the authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes for user management
// Only accessible for authenticated users with 'api' guard
Route::middleware('auth:api')->group(function () {
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    Route::get('/users', [UserController::class, 'index']);

    /**
     * Store a newly created user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    Route::post('/users', [UserController::class, 'store']);

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    Route::get('/users/{id}', [UserController::class, 'show']);

    /**
     * Update the specified user.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    Route::put('/users/{id}', [UserController::class, 'update']);

    /**
     * Remove the specified user.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

// Routes for book management
// Only accessible for authenticated users with 'api' guard
Route::middleware('auth:api')->group(function () {
    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    Route::get('/books', [BookController::class, 'index']);

    /**
     * Store a newly created book.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    Route::post('/books', [BookController::class, 'store']);

    /**
     * Display the specified book.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    Route::get('/books/{id}', [BookController::class, 'show']);

    /**
     * Update the specified book.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    Route::put('/books/{id}', [BookController::class, 'update']);

    /**
     * Remove the specified book.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    /**
     * Filter books based on criteria.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    Route::get('/books/filter', [BookController::class, 'filterBooks']);
});

// Routes for borrow records management
// Only accessible for authenticated users with 'api' guard
Route::middleware('auth:api')->group(function () {
    /**
     * Display a listing of the borrow records for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    Route::get('/borrow-records', [BorrowRecordController::class, 'index']);

    /**
     * Store a newly created borrow record.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    Route::post('/borrow-records', [BorrowRecordController::class, 'store']);

    /**
     * Mark a book as returned.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    Route::post('/borrow-records/return', [BorrowRecordController::class, 'returnBook']);
});

// Routes for rating management
// Only accessible for authenticated users with 'api' guard
Route::middleware('auth:api')->group(function () {
    /**
     * Store a newly created rating.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    Route::post('/ratings', [RatingController::class, 'store']);

    /**
     * Display the ratings for a specific book.
     *
     * @param int $book_id
     * @return \Illuminate\Http\JsonResponse
     */
    Route::get('/books/{book_id}/ratings', [RatingController::class, 'index']);

    /**
     * Update the specified rating.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\JsonResponse
     */
    Route::put('/ratings/{rating}', [RatingController::class, 'update']);

    /**
     * Remove the specified rating.
     *
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\JsonResponse
     */
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy']);
});
