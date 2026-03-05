<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Отображение списка пользователей
     */
    public function index(Request $request)
    {
        $query = User::with('role')->withCount(['appointments', 'reviews']);
        
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Показ формы редактирования пользователя
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $completedAppointments = $user->appointments()
            ->whereHas('status', fn($q) => $q->where('name', 'завершено'))
            ->count();
        
        return view('admin.users.edit', compact('user', 'roles', 'completedAppointments'));
    }

    /**
     * Обновление данных пользователя
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Проверка на изменение пароля другого администратора
        if ($request->filled('password') && $user->isAdmin() && $user->id !== auth()->id()) {
            return back()->with('error', 'Вы не можете изменить пароль другого администратора!');
        }

        $data = $request->only(['name', 'email', 'phone', 'role_id']);
        
        // Если пароль был передан, хешируем его
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Пользователь успешно обновлен!');
    }

    /**
     * Удаление пользователя
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Вы не можете удалить самого себя!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Пользователь успешно удален!');
    }
}