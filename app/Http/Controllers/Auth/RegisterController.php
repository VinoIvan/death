<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Показать форму регистрации.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Обработать регистрацию.
     */
    public function register(Request $request): RedirectResponse
    {
        $messages = [
            'name.required' => 'Поле имя обязательно для заполнения',
            'name.max' => 'Имя не может превышать 255 символов',
            'email.required' => 'Поле email обязательно для заполнения',
            'email.email' => 'Введите корректный email адрес',
            'email.unique' => 'Пользователь с таким email уже существует',
            'phone.required' => 'Поле телефон обязательно для заполнения',
            'phone.regex' => 'Введите корректный номер телефона',
            'password.required' => 'Поле пароль обязательно для заполнения',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'agree.required' => 'Необходимо согласие с правилами',
        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'agree' => ['required'],
        ], $messages);

        // Всегда создаем пользователя с ролью registered (id = 2)
        $role = Role::where('name', 'registered')->first();
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $role ? $role->id : 2,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Регистрация успешно завершена!');
    }
}