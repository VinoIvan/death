@extends('admin.layouts.admin')

@section('title', 'Редактирование пользователя - VCM Laser')
@section('page-title', 'Редактирование пользователя')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users-edit.css') }}">
@endpush

@section('content')
<div class="users-edit-container">
    <div class="page-header">
        <a href="{{ route('admin.users.index') }}" class="btn-site">
            Назад к списку
        </a>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')

            {{-- Основная информация --}}
            <div class="form-section">
                <h3 class="form-section-title">Основная информация</h3>
                
                {{-- Имя --}}
                <div class="form-group">
                    <label for="name" class="form-label">Имя <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Телефон --}}
                <div class="form-group">
                    <label for="phone" class="form-label">Телефон <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone', $user->phone) }}" 
                           required>
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Роль --}}
                <div class="form-group">
                    <label for="role_id" class="form-label">Роль <span class="text-danger">*</span></label>
                    <select class="form-select @error('role_id') is-invalid @enderror" 
                            id="role_id" 
                            name="role_id" 
                            required>
                        @foreach($roles as $role)
                            @if($role->name != 'guest')
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name == 'admin' ? 'Администратор' : ($role->name == 'registered' ? 'Клиент' : $role->name) }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    @if($user->id === auth()->id())
                        <small class="help-text" style="color: #856404; background: #fff3cd; padding: 0.3rem 0.9rem; border-radius: 20px; display: inline-block; margin-top: 0.6rem;">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Вы редактируете свою учетную запись
                        </small>
                    @endif
                </div>
            </div>

            {{-- Смена пароля --}}
            <div class="form-section">
                <h3 class="form-section-title">Смена пароля</h3>
                
                {{-- Новый пароль --}}
                <div class="form-group">
                    <label for="password" class="form-label">Новый пароль</label>
                    <div style="position: relative;">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Оставьте пустым, чтобы не менять"
                               style="padding-right: 45px;">
                        <button type="button" 
                                onclick="togglePassword('password')" 
                                style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--gray-500); font-size: 1.3rem;">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="help-text">Минимум 8 символов</small>
                </div>

                {{-- Подтверждение пароля --}}
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                    <div style="position: relative;">
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Подтвердите новый пароль"
                               style="padding-right: 45px;">
                        <button type="button" 
                                onclick="togglePassword('password_confirmation')" 
                                style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--gray-500); font-size: 1.3rem;">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                {{-- Информационное сообщение --}}
                <div class="alert-info" style="background: var(--info-light); border: 1px solid var(--info); color: var(--info); border-radius: 8px; padding: 1rem; margin-top: 1rem;">
                    <i class="fas fa-info-circle me-2"></i>
                    Заполните поля только если нужно изменить пароль пользователя.
                </div>
            </div>

            {{-- Кнопки действий --}}
            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn-site">Отмена</a>
                <button type="submit" class="btn-site-solid">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users-edit.css') }}">
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

    // Валидация формы перед отправкой
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;
        
        if (password || confirm) {
            if (password.length < 8 && password.length > 0) {
                e.preventDefault();
                alert('Пароль должен содержать минимум 8 символов');
            } else if (password !== confirm) {
                e.preventDefault();
                alert('Пароли не совпадают');
            }
        }
    });
</script>
@endpush
@endsection