<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Токен для защиты от CSRF-атак --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Динамический заголовок и описание страницы --}}
    <title>@yield('title', 'VCM Laser - Салон лазерной эпиляции')</title>
    <meta name="description" content="@yield('description', 'Профессиональная лазерная эпиляция в Москве')">
    
    {{-- Favicon для всех браузеров --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon/favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon/favicon.ico') }}" type="image/x-icon">
    
    {{-- Для современных браузеров (PNG) --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('images/favicon/favicon-48x48.png') }}">
    
    {{-- Для устройств Apple --}}
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-icon-180x180.png') }}">
    
    {{-- Для Android --}}
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/favicon/android-icon-512x512.png') }}">
    
    {{-- Манифест для PWA --}}
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    
    {{-- Цвета для браузера и статус-бара --}}
    <meta name="theme-color" content="#8b4c55">
    <meta name="msapplication-TileColor" content="#8b4c55">
    <meta name="msapplication-TileImage" content="{{ asset('images/favicon/ms-icon-144x144.png') }}">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
    
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- AOS библиотека для анимаций --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    {{-- Клиентские CSS стили --}}
    <link rel="stylesheet" href="{{ asset('css/client/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/alerts.css') }}">
    @stack('styles')
</head>
<body>
    {{-- Навигационная панель --}}
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container-fluid">
            {{-- Логотип слева --}}
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="VCM Laser" height="50">
            </a>
            
            {{-- Кнопка для мобильного меню --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            {{-- Основное меню по центру --}}
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav navbar-nav-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Услуги</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('booking.*') ? 'active' : '' }}" href="{{ route('booking.index') }}">Записаться</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}" href="{{ route('reviews.index') }}">Отзывы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contacts') ? 'active' : '' }}" href="{{ route('contacts') }}">Контакты</a>
                    </li>
                </ul>
                
                {{-- Кнопки авторизации справа --}}
                <ul class="navbar-nav navbar-nav-right">
                    @auth
                        {{-- Пользователь авторизован --}}
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Личный кабинет</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Выйти</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        {{-- Пользователь не авторизован --}}
                        <li class="nav-item">
                            <a class="nav-link-login" href="{{ route('login') }}">Войти</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">Регистрация</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Flash-сообщения об успехе --}}
    @if(session('success'))
        <div class="alert alert-success" id="successAlert" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    @endif
    
    {{-- Flash-сообщения об ошибке --}}
    @if(session('error'))
        <div class="alert alert-danger" id="errorAlert" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    @endif

    {{-- Основной контент страницы --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- Подвал сайта --}}
    <footer class="footer">
        <div class="container">
            <div class="row">
                {{-- Информация о компании --}}
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="footer-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="VCM Laser" height="50">
                    </div>
                    <p class="footer-description">
                        Профессиональный салон лазерной эпиляции в Москве. 
                        Современное оборудование, опытные мастера, индивидуальный подход к каждому клиенту.
                    </p>
                    {{-- Социальные сети --}}
                    <div class="footer-social">
                        <a href="#" class="footer-social-link" target="_blank">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="#" class="footer-social-link" target="_blank">
                            <i class="fab fa-vk"></i>
                        </a>
                        <a href="#" class="footer-social-link" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="footer-social-link" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                {{-- Навигация по сайту --}}
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-title">Навигация</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Главная</a></li>
                        <li><a href="{{ route('services.index') }}">Услуги</a></li>
                        <li><a href="{{ route('booking.index') }}">Запись</a></li>
                        <li><a href="{{ route('reviews.index') }}">Отзывы</a></li>
                        <li><a href="{{ route('contacts') }}">Контакты</a></li>
                    </ul>
                </div>
                
                {{-- Контактная информация --}}
                <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-title">Контакты</h5>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-phone"></i>
                            <div>
                                <a href="tel:+79991234567">+7 (999) 123-45-67</a><br>
                                <a href="tel:+79997654321">+7 (999) 765-43-21</a>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:info@vcm-laser.ru">info@vcm-laser.ru</a>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>г. Москва, ул. Лазерная, д. 10</span>
                        </li>
                    </ul>
                </div>
                
                {{-- Режим работы --}}
                <div class="col-lg-3 col-md-4">
                    <h5 class="footer-title">Режим работы</h5>
                    <ul class="footer-hours">
                        <li>
                            <span class="days">Пн-Пт</span>
                            <span class="time">10:00-21:00</span>
                        </li>
                        <li>
                            <span class="days">Сб-Вс</span>
                            <span class="time">11:00-19:00</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            {{-- Нижняя часть подвала с копирайтом --}}
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <p class="footer-copyright">
                            &copy; {{ date('Y') }} VCM Laser. Все права защищены.
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="footer-policy">
                            <a href="#">Политика конфиденциальности</a>
                            <span class="separator">|</span>
                            <a href="#">Пользовательское соглашение</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Скрипты --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="module" src="{{ asset('js/client/main.js') }}"></script>
    <script type="module" src="{{ asset('js/client/booking.js') }}"></script>
    <script type="module" src="{{ asset('js/client/profile.js') }}"></script>
    <script>
        {{-- Инициализация AOS анимаций --}}
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
        
        {{-- Автоматическое скрытие уведомлений через 5 секунд --}}
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.classList.add('hide');
                    setTimeout(function() {
                        if (alert.parentNode) {
                            const bsAlert = new bootstrap.Alert(alert);
                            bsAlert.close();
                        }
                    }, 300);
                });
            }, 5000);
        });
    </script>
    @stack('scripts')
</body>
</html>