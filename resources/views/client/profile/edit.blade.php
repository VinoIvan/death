@extends('client.layouts.app')

@section('title', 'Редактирование профиля - VCM Laser')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Редактирование профиля</h1>
    </div>

    <div class="row">
        {{-- Боковое меню профиля --}}
        <div class="col-lg-3 mb-4">
            <div class="profile-sidebar">
                <div class="profile-card">
                    <h5 class="profile-name">{{ Auth::user()->name }}</h5>
                    <p class="profile-email"><i class="fas fa-envelope"></i> {{ Auth::user()->email }}</p>
                    <p class="profile-phone"><i class="fas fa-phone"></i> {{ Auth::user()->phone }}</p>
                </div>

                <nav class="profile-nav">
                    <a href="{{ route('profile.index') }}" class="profile-nav-item">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Обзор</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="profile-nav-item active">
                        <i class="fas fa-user-edit"></i>
                        <span>Редактировать профиль</span>
                    </a>
                    <a href="{{ route('profile.reviews') }}" class="profile-nav-item">
                        <i class="fas fa-star"></i>
                        <span>Мои отзывы</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="profile-nav-item w-100 text-start border-0 bg-transparent">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="text-danger">Выйти</span>
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        {{-- Основной контент --}}
        <div class="col-lg-9">
            <div class="content-card">
                <div class="card-header">
                    <h5>Редактирование профиля</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                        @csrf
                        @method('PUT')

                        <h3 class="form-section-title">Личные данные</h3>

                        {{-- Поле имя --}}
                        <div class="form-group">
                            <label for="name" class="form-label">Имя <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', Auth::user()->name) }}" 
                                   required>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Поле email --}}
                        <div class="form-group">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', Auth::user()->email) }}" 
                                   required>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Поле телефон --}}
                        <div class="form-group">
                            <label for="phone" class="form-label">Телефон <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', Auth::user()->phone) }}" 
                                   required>
                            @error('phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <small class="help-text">Формат: +7 (XXX) XXX-XX-XX</small>
                        </div>

                        {{-- Секция смены пароля --}}
                        <h3 class="form-section-title mt-5">Изменение пароля</h3>
                        <p class="text-muted mb-4">Заполните только если хотите изменить пароль</p>

                        {{-- Текущий пароль --}}
                        <div class="form-group">
                            <label for="current_password" class="form-label">Текущий пароль</label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password"
                                       autocomplete="off">
                                <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Новый пароль --}}
                        <div class="form-group">
                            <label for="new_password" class="form-label">Новый пароль</label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       id="new_password" 
                                       name="new_password"
                                       autocomplete="new-password">
                                <button type="button" class="password-toggle" onclick="togglePassword('new_password')">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Подтверждение пароля --}}
                        <div class="form-group">
                            <label for="new_password_confirmation" class="form-label">Подтверждение пароля</label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control" 
                                       id="new_password_confirmation" 
                                       name="new_password_confirmation"
                                       autocomplete="new-password">
                                <button type="button" class="password-toggle" onclick="togglePassword('new_password_confirmation')">
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

                        {{-- Кнопки действий --}}
                        <div class="form-actions">
                            <a href="{{ route('profile.index') }}" class="btn-outline-small">Отмена</a>
                            <button type="submit" class="btn-primary-small">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/client/profile.css') }}">
<style>
    .profile-form {
        max-width: 100%;
    }
    
    .form-section-title {
        font-size: 2rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .form-group {
        margin-bottom: 2rem;
    }
    
    .form-label {
        display: block;
        font-size: 1.5rem;
        font-weight: 500;
        color: var(--gray-800);
        margin-bottom: 0.8rem;
    }
    
    .form-control {
        width: 100%;
        padding: 1.2rem 1.5rem;
        border: 1px solid var(--gray-300);
        border-radius: 12px;
        font-size: 1.5rem;
        color: var(--gray-800);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        background: var(--white) !important;
    }
    
    {{-- Переопределение стилей автозаполнения браузера --}}
    .form-control:-webkit-autofill,
    .form-control:-webkit-autofill:hover,
    .form-control:-webkit-autofill:focus,
    .form-control:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px white inset !important;
        -webkit-text-fill-color: var(--gray-800) !important;
        box-shadow: 0 0 0 30px white inset !important;
        background-color: transparent !important;
        background: white !important;
        border: 1px solid var(--gray-300) !important;
    }
    
    .form-control:hover {
        border-color: var(--primary-color);
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 76, 85, 0.1);
    }
    
    .form-control.is-invalid {
        border-color: var(--danger);
    }
    
    {{-- Стили для обертки пароля --}}
    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .password-wrapper .form-control {
        padding-right: 5rem;
    }
    
    .password-toggle {
        position: absolute;
        right: 1.5rem;
        background: none;
        border: none;
        color: var(--gray-500);
        cursor: pointer;
        padding: 0.5rem;
        font-size: 1.8rem;
        transition: color 0.2s ease;
        z-index: 2;
    }
    
    .password-toggle:hover {
        color: var(--primary-color);
    }
    
    .help-text {
        color: var(--gray-500);
        font-size: 1.3rem;
        margin-top: 0.5rem;
        display: block;
    }
    
    .error-message {
        color: var(--danger);
        font-size: 1.3rem;
        margin-top: 0.5rem;
    }
    
    .password-requirements {
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        padding: 2rem;
        margin: 2rem 0;
    }
    
    .password-requirements h6 {
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 1rem;
    }
    
    .requirement {
        color: var(--gray-600);
        font-size: 1.4rem;
        margin-bottom: 0.8rem;
    }
    
    .text-muted {
        color: var(--gray-500);
        font-size: 1.4rem;
        margin-bottom: 2rem;
    }
    
    .form-actions {
        display: flex;
        gap: 1.5rem;
        margin-top: 3rem;
    }
    
    .btn-outline-small {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.5rem;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
        flex: 1;
    }
    
    .btn-outline-small:hover {
        background: var(--primary-color);
        color: white;
    }
    
    .btn-primary-small {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.5rem;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
        flex: 1;
    }
    
    .btn-primary-small:hover {
        background: var(--primary-hover);
    }
    
    @media (max-width: 768px) {
        .form-section-title {
            font-size: 1.8rem;
        }
        
        .form-label {
            font-size: 1.4rem;
        }
        
        .form-control {
            font-size: 1.4rem;
            padding: 1rem 1.2rem;
        }
        
        .password-toggle {
            font-size: 1.6rem;
            right: 1.2rem;
        }
        
        .help-text,
        .error-message {
            font-size: 1.2rem;
        }
        
        .password-requirements {
            padding: 1.5rem;
        }
        
        .password-requirements h6 {
            font-size: 1.5rem;
        }
        
        .requirement {
            font-size: 1.3rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-outline-small,
        .btn-primary-small {
            width: 100%;
            font-size: 1.4rem;
        }
    }
</style>
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

    // Маска для телефона
    document.getElementById('phone')?.addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        e.target.value = !x[2] ? x[1] : 
            '+7 (' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });
</script>
@endpush