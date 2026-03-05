@extends('admin.layouts.admin')

@section('title', 'Управление пользователями - VCM Laser')
@section('page-title', 'Управление пользователями')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endpush

@section('content')
<div class="users-container">
    {{-- Фильтры --}}
    <div class="filters-card">
        <form action="{{ route('admin.users.index') }}" method="GET" class="filters-form">
            {{-- Поиск --}}
            <div class="filter-group">
                <label class="form-label">Поиск</label>
                <input type="text" 
                       class="form-control" 
                       name="search" 
                       placeholder="Имя, email, телефон" 
                       value="{{ request('search') }}">
            </div>
            
            {{-- Фильтр по роли --}}
            <div class="filter-group">
                <label class="form-label">Роль</label>
                <select class="form-select" name="role_id">
                    <option value="">Все роли</option>
                    @foreach($roles as $role)
                        @if($role->name != 'guest')
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name == 'admin' ? 'Администратор' : ($role->name == 'registered' ? 'Клиент' : $role->name) }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            
            {{-- Кнопки фильтрации --}}
            <div class="filter-actions">
                <button type="submit" class="btn-site">Применить</button>
                <a href="{{ route('admin.users.index') }}" class="btn-site">Сбросить</a>
            </div>
        </form>
    </div>

    {{-- Таблица пользователей --}}
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Контакты</th>
                    <th>Роль</th>
                    <th>Регистрация</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td>
                        <div class="user-name">{{ $user->name }}</div>
                    </td>
                    <td>
                        <div class="user-email">{{ $user->email }}</div>
                        <div class="user-phone">{{ $user->phone }}</div>
                    </td>
                    <td>
                        @if($user->role->name == 'admin')
                            <span class="role-badge">Администратор</span>
                        @elseif($user->role->name == 'registered')
                            <span class="role-badge">Клиент</span>
                        @else
                            <span class="role-badge">{{ $user->role->name }}</span>
                        @endif
                    </td>
                    <td>
                        <span style="color: var(--gray-500);">{{ $user->created_at->format('d.m.Y') }}</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            {{-- Редактирование --}}
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="btn-icon edit" title="Редактировать">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            {{-- Удаление (кроме самого себя) --}}
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Удалить пользователя? Все его записи и отзывы будут удалены.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Удалить">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                {{-- Пустое состояние --}}
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-users-slash fa-3x mb-3" style="color: var(--gray-300);"></i>
                        <h5 style="font-size: 1.3rem;">Пользователи не найдены</h5>
                        <p style="color: var(--gray-500); font-size: 1rem;">Попробуйте изменить параметры фильтрации</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Пагинация --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $users->withQueryString()->links('vendor.pagination.admin') }}
        </div>
    </div>
</div>
@endsection