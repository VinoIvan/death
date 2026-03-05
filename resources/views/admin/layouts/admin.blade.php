<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Токен для защиты от CSRF-атак --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Админ-панель - VCM Laser')</title>
    
    {{-- Favicon для всех браузеров --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon/favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon/favicon.ico') }}" type="image/x-icon">
    
    {{-- Для современных браузеров (PNG) --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    
    {{-- Для устройств Apple (основной) --}}
    <link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-icon-180x180.png') }}">
    
    {{-- Манифест для PWA --}}
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    
    {{-- Цвет для браузера --}}
    <meta name="theme-color" content="#8b4c55">
    
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Admin CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/appointments.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/schedules.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reviews.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/alerts.css') }}">
    {{-- Pagination styles --}}
    <link rel="stylesheet" href="{{ asset('css/admin/pagination.css') }}">
    
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        {{-- Боковое меню --}}
        <div class="admin-sidebar">
            <div class="admin-sidebar-header">
                <h3>VCM Laser</h3>
                <small>Админ-панель</small>
            </div>
            
            <nav class="admin-nav">
                {{-- Записи --}}
                <a href="{{ route('admin.appointments.index') }}" class="admin-nav-item {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Записи</span>
                </a>
                
                {{-- Услуги --}}
                <a href="{{ route('admin.services.index') }}" class="admin-nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="fas fa-cut"></i>
                    <span>Услуги</span>
                </a>
                
                {{-- Расписание --}}
                <a href="{{ route('admin.schedules.index') }}" class="admin-nav-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i>
                    <span>Расписание</span>
                </a>
                
                {{-- Пользователи --}}
                <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Пользователи</span>
                </a>
                
                {{-- Отзывы --}}
                <a href="{{ route('admin.reviews.index') }}" class="admin-nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span>Отзывы</span>
                </a>
                
                <hr>
                
                {{-- Выход --}}
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="admin-nav-item logout" style="width: 100%; border: none; background: none; cursor: pointer;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Выйти</span>
                    </button>
                </form>
            </nav>
        </div>

        {{-- Основной контент --}}
        <div class="admin-content">
            {{-- Шапка --}}
            <div class="admin-header">
                <div class="page-title-display">
                    @yield('page-title', 'Управление')
                </div>
                <div class="user-name-display">
                    {{ Auth::user()->name }}
                </div>
            </div>

            {{-- Flash-сообщения --}}
            @if(session('success'))
                <div class="admin-alert admin-alert-success">
                    {{ session('success') }}
                    <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="admin-alert admin-alert-danger">
                    {{ session('error') }}
                    <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
                </div>
            @endif

            {{-- Контент страницы --}}
            <main class="admin-main">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Скрипты --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/admin/alerts.js') }}"></script>
    @stack('scripts')
</body>
</html>