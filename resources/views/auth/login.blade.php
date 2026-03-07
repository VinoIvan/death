@extends('client.layouts.app')

@section('title', 'Вход - VCM Laser')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        {{-- Заголовок --}}
        <div class="auth-header">
            <h1 class="auth-title">Добро пожаловать</h1>
            <p class="auth-subtitle">Войдите в свой аккаунт</p>
        </div>

        {{-- Уведомления об ошибках --}}
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Уведомления об успехе --}}
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Форма входа --}}
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            {{-- Поле email --}}
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <i class="far fa-envelope"></i>
                    </span>
                    <input id="email" 
                           type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="ivan@example.com" 
                           autocomplete="email"
                           required 
                           autofocus>
                </div>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Поле пароля --}}
            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password" 
                           type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           placeholder="••••••••" 
                           autocomplete="current-password"
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Опции формы (только чекбокс "Запомнить меня") --}}
            <div class="form-options">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Запомнить меня</span>
                </label>
            </div>

            {{-- Кнопка отправки --}}
            <button type="submit" class="btn-primary">
                Войти
            </button>

            {{-- Ссылка на регистрацию --}}
            <div class="auth-footer">
                <p>Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
@endpush

@push('scripts')
<script>
    // Функция для показа/скрытия пароля
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling;
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'far fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'far fa-eye';
        }
    }
</script>
@endpush