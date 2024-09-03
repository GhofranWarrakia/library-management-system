<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * عرض قائمة جميع المستخدمين
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json([
            'message' => 'قائمة المستخدمين',
            'users' => $users,
        ], 200);
    }

    /**
     * إنشاء مستخدم جديد
     *
     * @param UserFormRequest $request
     * @return JsonResponse
     */
    public function store(UserFormRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'تم إنشاء المستخدم بنجاح',
            'user' => $user,
        ], 201);
    }

    /**
     * عرض تفاصيل مستخدم محدد
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = User::findOrFail($id);

        return response()->json([
            'message' => 'تفاصيل المستخدم',
            'user' => $user,
        ], 200);
    }

    /**
     * تحديث بيانات مستخدم محدد
     *
     * @param UserFormRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UserFormRequest $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'تم تحديث بيانات المستخدم بنجاح',
            'user' => $user,
        ], 200);
    }

    /**
     * حذف مستخدم محدد
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'تم حذف المستخدم بنجاح',
        ], 200);
    }
}
