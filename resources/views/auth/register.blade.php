@extends('client.layouts.app')

@section('title', 'Регистрация - VCM Laser')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card register-card">
        <div class="auth-header">
            <h1 class="auth-title">Создать аккаунт</h1>
            <p class="auth-subtitle">Зарегистрируйтесь для записи онлайн</p>
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

        {{-- Форма регистрации --}}
        <form method="POST" action="{{ route('register') }}" class="auth-form" id="registerForm">
            @csrf

            {{-- Поле имени --}}
            <div class="form-group">
                <label for="name" class="form-label">Имя</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <i class="far fa-user"></i>
                    </span>
                    <input id="name" 
                           type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Иван Петров" 
                           autocomplete="name"
                           required>
                </div>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

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
                           required>
                </div>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Поле телефона --}}
            <div class="form-group">
                <label for="phone" class="form-label">Телефон</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <i class="fas fa-phone-alt"></i>
                    </span>
                    <input id="phone" 
                           type="tel" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           placeholder="+7 (999) 123-45-67" 
                           autocomplete="tel"
                           required>
                </div>
                @error('phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <small class="help-text">Формат: +7 (XXX) XXX-XX-XX</small>
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
                           autocomplete="new-password"
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Подтверждение пароля --}}
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                <div class="input-wrapper">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password_confirmation" 
                           type="password" 
                           class="form-control" 
                           name="password_confirmation" 
                           placeholder="••••••••" 
                           autocomplete="new-password"
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Требования к паролю --}}
            <div class="password-requirements">
                <h6>Требования к паролю:</h6>
                <ul class="list-unstyled">
                    <li class="requirement">• Минимум 8 символов</li>
                </ul>
            </div>

            {{-- Согласие с условиями --}}
            <div class="form-group terms-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="agree" {{ old('agree') ? 'checked' : '' }} required>
                    <span>Я принимаю <a href="#" target="_blank">условия использования</a> и <a href="#" target="_blank">политику конфиденциальности</a></span>
                </label>
                @error('agree')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Кнопка отправки --}}
            <button type="submit" class="btn-primary">
                Зарегистрироваться
            </button>

            {{-- Ссылка на вход --}}
            <div class="auth-footer">
                <p>Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
<style>
    .password-requirements {
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1rem 0;
    }
    
    .password-requirements h6 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 1rem;
    }
    
    .requirement {
        color: var(--gray-600);
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }
    
    .terms-group {
        margin: 1.5rem 0;
    }
    
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: var(--gray-700);
        font-size: 1.4rem;
        cursor: pointer;
    }
    
    .checkbox-label input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-color);
        cursor: pointer;
        flex-shrink: 0;
    }
    
    .checkbox-label a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .checkbox-label a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/auth.js') }}" type="module"></script>
<script>
    // Функция для показа/скрытия пароля (резервная)
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