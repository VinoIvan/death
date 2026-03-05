@extends('client.layouts.app')

@section('title', 'Сброс пароля - VCM Laser')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card" data-aos="fade-up">
        <div class="auth-header">
            <h1 class="auth-title">Сброс пароля</h1>
            <p class="auth-subtitle">Введите новый пароль</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="far fa-envelope"></i>
                    </span>
                    <input id="email" 
                           type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email', $request->email) }}" 
                           readonly>
                </div>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Новый пароль</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password" 
                           type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           placeholder="••••••••" 
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password_confirmation" 
                           type="password" 
                           class="form-control" 
                           name="password_confirmation" 
                           placeholder="••••••••" 
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Password Strength Meter -->
            <div class="password-strength">
                <div class="strength-meter">
                    <div class="strength-meter-fill" id="passwordStrength"></div>
                </div>
                <div class="strength-text" id="strengthText"></div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <span>Сбросить пароль</span>
                <i class="fas fa-sync-alt ms-2"></i>
            </button>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
<style>
    .auth-wrapper {
        min-height: calc(100vh - 90px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: linear-gradient(135deg, var(--primary-bg) 0%, var(--accent-bg) 100%);
    }
    
    .auth-card {
        max-width: 440px;
        width: 100%;
        background: var(--white);
        border-radius: var(--border-radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
    }
    
    input[readonly] {
        background: var(--gray-100);
        cursor: not-allowed;
    }
    
    .password-strength {
        margin: 0.5rem 0 1rem;
    }
    
    .strength-meter {
        height: 4px;
        background: var(--gray-200);
        border-radius: 2px;
        overflow: hidden;
        margin-bottom: 0.25rem;
    }
    
    .strength-meter-fill {
        height: 100%;
        width: 0;
        transition: width 0.3s ease;
    }
    
    .strength-text {
        font-size: 0.8rem;
        color: var(--gray-500);
    }
</style>
@endpush

@push('scripts')
<script>
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

    // Индикатор надежности пароля
    const passwordInput = document.getElementById('password');
    const strengthMeter = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let message = '';
            let color = '';

            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]+/)) strength += 25;
            if (password.match(/[A-Z]+/)) strength += 25;
            if (password.match(/[0-9]+/)) strength += 25;

            if (strength <= 25) {
                color = '#dc3545';
                message = 'Слабый пароль';
            } else if (strength <= 50) {
                color = '#ffc107';
                message = 'Средний пароль';
            } else if (strength <= 75) {
                color = '#17a2b8';
                message = 'Хороший пароль';
            } else {
                color = '#28a745';
                message = 'Надежный пароль';
            }

            strengthMeter.style.width = strength + '%';
            strengthMeter.style.background = color;
            strengthText.textContent = message;
            strengthText.style.color = color;
        });
    }
</script>
@endpush
@endsection