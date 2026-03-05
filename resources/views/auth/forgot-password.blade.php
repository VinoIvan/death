@extends('client.layouts.app')

@section('title', 'Восстановление пароля - VCM Laser')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card" data-aos="fade-up">
        <div class="auth-header">
            <h1 class="auth-title">Восстановление пароля</h1>
            <p class="auth-subtitle">Мы отправим ссылку для сброса пароля на ваш email</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

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
                           value="{{ old('email') }}" 
                           placeholder="ivan@example.com" 
                           required 
                           autofocus>
                </div>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <span>Отправить ссылку</span>
                <i class="fas fa-paper-plane ms-2"></i>
            </button>

            <div class="auth-footer">
                <p><a href="{{ route('login') }}">Вернуться ко входу</a></p>
            </div>
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
    
    .alert {
        padding: 1rem;
        border-radius: var(--border-radius);
        font-size: 0.95rem;
    }
    
    .alert-success {
        background: var(--success-light);
        color: var(--success);
        border: 1px solid var(--success);
    }
</style>
@endpush
@endsection