@extends('client.layouts.app')

@section('title', 'Вход / Регистрация - VCM Laser')

@section('content')
<div class="auth-wrapper">
    <!-- Левая колонка с брендом -->
    <div class="auth-brand-column">
        <div class="brand-content">
            <div class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="VCM Laser">
            </div>
            <h1 class="brand-title">VCM Laser</h1>
            <p class="brand-subtitle">Салон лазерной эпиляции</p>
            
            <div class="brand-features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="feature-text">
                        <h3>Быстро</h3>
                        <p>Сеанс от 15 минут</p>
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-text">
                        <h3>Безопасно</h3>
                        <p>Сертифицированное оборудование</p>
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-infinity"></i>
                    </div>
                    <div class="feature-text">
                        <h3>Навсегда</h3>
                        <p>Результат после курса</p>
                    </div>
                </div>
            </div>
            
            <div class="brand-testimonial">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p>"Лучший салон в Москве! Очень довольна результатом"</p>
                <span class="testimonial-author">— Анна К.</span>
            </div>
        </div>
    </div>

    <!-- Правая колонка с формами -->
    <div class="auth-form-column">
        <div class="form-container">
            <!-- Заголовок в зависимости от URL -->
            <div class="form-header">
                @if(request()->routeIs('login'))
                    <h2 class="form-title">Добро пожаловать!</h2>
                    <p class="form-subtitle">Войдите в свой аккаунт</p>
                @else
                    <h2 class="form-title">Создать аккаунт</h2>
                    <p class="form-subtitle">Зарегистрируйтесь для записи онлайн</p>
                @endif
            </div>

            <!-- Форма входа (показывается только на странице /login) -->
            @if(request()->routeIs('login'))
            <div id="loginForm" class="auth-form active">
                <form method="POST" action="{{ route('login') }}" class="form">
                    @csrf

                    <div class="form-group">
                        <label for="login_email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="far fa-envelope"></i>
                            </span>
                            <input id="login_email" 
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

                    <div class="form-group">
                        <label for="login_password" class="form-label">Пароль</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input id="login_password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="••••••••" 
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('login_password')">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Запомнить меня</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Забыли пароль?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>Войти</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>

                    <div class="form-footer">
                        <p>Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
                    </div>
                </form>
            </div>
            @endif

            <!-- Форма регистрации (показывается только на странице /register) -->
            @if(request()->routeIs('register'))
            <div id="registerForm" class="auth-form active">
                <form method="POST" action="{{ route('register') }}" id="registerFormElement" class="form">
                    @csrf

                    <div class="form-group">
                        <label for="register_name" class="form-label">Имя</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="far fa-user"></i>
                            </span>
                            <input id="register_name" 
                                   type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Иван Петров" 
                                   required>
                        </div>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="register_email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="far fa-envelope"></i>
                            </span>
                            <input id="register_email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="ivan@example.com" 
                                   required>
                        </div>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="register_phone" class="form-label">Телефон</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-phone-alt"></i>
                            </span>
                            <input id="register_phone" 
                                   type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="+7 (999) 123-45-67" 
                                   required>
                        </div>
                        @error('phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="register_password" class="form-label">Пароль</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input id="register_password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="••••••••" 
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('register_password')">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="register_password_confirmation" class="form-label">Подтверждение пароля</label>
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input id="register_password_confirmation" 
                                   type="password" 
                                   class="form-control" 
                                   name="password_confirmation" 
                                   placeholder="••••••••" 
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('register_password_confirmation')">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="password-strength">
                        <div class="strength-meter">
                            <div class="strength-meter-fill" id="passwordStrength"></div>
                        </div>
                        <div class="strength-text" id="strengthText"></div>
                    </div>

                    <div class="form-group terms-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="agree" required>
                            <span>Я принимаю <a href="#" target="_blank">условия использования</a> и <a href="#" target="_blank">политику конфиденциальности</a></span>
                        </label>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>Создать аккаунт</span>
                        <i class="fas fa-user-plus"></i>
                    </button>

                    <div class="form-footer">
                        <p>Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
                    </div>
                </form>
            </div>
            @endif

            <!-- Социальные сети (опционально, можно оставить или убрать) -->
            <div class="social-auth">
                <div class="divider">
                    <span>или войдите через</span>
                </div>
                
                <div class="social-buttons">
                    <a href="#" class="social-button vk">
                        <i class="fab fa-vk"></i>
                        <span>ВКонтакте</span>
                    </a>
                    <a href="#" class="social-button telegram">
                        <i class="fab fa-telegram"></i>
                        <span>Telegram</span>
                    </a>
                    <a href="#" class="social-button google">
                        <i class="fab fa-google"></i>
                        <span>Google</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .auth-wrapper {
        display: flex;
        min-height: calc(100vh - 90px);
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    /* Левая колонка с брендом */
    .auth-brand-column {
        flex: 1;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        position: relative;
        overflow: hidden;
    }

    .auth-brand-column::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        top: -250px;
        right: -250px;
        border-radius: 50%;
    }

    .auth-brand-column::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        bottom: -150px;
        left: -150px;
        border-radius: 50%;
    }

    .brand-content {
        max-width: 500px;
        color: white;
        position: relative;
        z-index: 1;
    }

    .brand-logo {
        margin-bottom: 2rem;
    }

    .brand-logo img {
        height: 80px;
        filter: brightness(0) invert(1);
    }

    .brand-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .brand-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 3rem;
    }

    .brand-features {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .feature-text h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .feature-text p {
        opacity: 0.8;
        font-size: 0.95rem;
    }

    .brand-testimonial {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .testimonial-rating {
        color: #ffc107;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .testimonial-rating i {
        margin-right: 0.25rem;
    }

    .brand-testimonial p {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        font-style: italic;
    }

    .testimonial-author {
        opacity: 0.8;
        font-size: 0.95rem;
    }

    /* Правая колонка с формами */
    .auth-form-column {
        flex: 1;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        position: relative;
    }

    .form-container {
        max-width: 500px;
        width: 100%;
    }

    /* Заголовок формы */
    .form-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .form-subtitle {
        color: var(--text-light);
        font-size: 1rem;
    }

    /* Формы */
    .auth-form {
        display: block;
    }

    .form {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .form-group {
        width: 100%;
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        color: var(--text-light);
        font-size: 1rem;
        z-index: 1;
    }

    .form-control {
        width: 100%;
        padding: 1rem 1rem 1rem 2.8rem;
        border: 2px solid var(--accent-bg);
        border-radius: 16px;
        font-size: 1rem;
        transition: var(--transition);
        background: var(--white);
    }

    .form-control:hover {
        border-color: var(--primary-light);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(139, 76, 85, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        background: none;
        border: none;
        color: var(--text-light);
        cursor: pointer;
        padding: 0.5rem;
        font-size: 1.1rem;
        z-index: 1;
    }

    .password-toggle:hover {
        color: var(--primary-color);
    }

    .error-message {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .error-message::before {
        content: '⚠️';
        font-size: 0.85rem;
    }

    /* Индикатор надежности пароля */
    .password-strength {
        margin-top: 0.5rem;
    }

    .strength-meter {
        height: 6px;
        background: var(--accent-bg);
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .strength-meter-fill {
        height: 100%;
        width: 0;
        transition: width 0.3s ease;
    }

    .strength-text {
        font-size: 0.85rem;
        color: var(--text-light);
    }

    /* Опции формы */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin: 0.5rem 0;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--text-light);
        font-size: 0.95rem;
        cursor: pointer;
    }

    .checkbox-label input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-color);
        margin: 0;
        cursor: pointer;
    }

    .checkbox-label a {
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .checkbox-label a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    .forgot-link {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .forgot-link:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    .terms-group {
        margin-top: 0.5rem;
    }

    /* Кнопка отправки */
    .btn-submit {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 16px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        position: relative;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(139, 76, 85, 0.3);
    }

    .btn-submit:hover::before {
        left: 100%;
    }

    /* Футер формы */
    .form-footer {
        text-align: center;
        margin-top: 1.5rem;
    }

    .form-footer p {
        color: var(--text-light);
        font-size: 0.95rem;
    }

    .form-footer a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .form-footer a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    /* Социальная авторизация */
    .social-auth {
        margin-top: 2rem;
    }

    .divider {
        text-align: center;
        position: relative;
        margin: 2rem 0;
    }

    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: calc(50% - 100px);
        height: 1px;
        background: var(--accent-bg);
    }

    .divider::before {
        left: 0;
    }

    .divider::after {
        right: 0;
    }

    .divider span {
        background: white;
        padding: 0 1rem;
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .social-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .social-button {
        flex: 1;
        padding: 0.875rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: white;
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
    }

    .social-button.vk {
        background: #4c75a3;
    }

    .social-button.telegram {
        background: #0088cc;
    }

    .social-button.google {
        background: #db4437;
    }

    .social-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Адаптивность */
    @media (max-width: 1024px) {
        .auth-wrapper {
            flex-direction: column;
        }

        .auth-brand-column {
            padding: 2rem;
        }

        .brand-content {
            max-width: 100%;
            text-align: center;
        }

        .brand-features {
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }

        .feature-item {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
    }

    @media (max-width: 768px) {
        .auth-form-column {
            padding: 2rem;
        }

        .brand-title {
            font-size: 2.5rem;
        }

        .social-buttons {
            flex-direction: column;
        }

        .social-button {
            padding: 1rem;
        }

        .form-options {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .auth-brand-column {
            padding: 1.5rem;
        }

        .auth-form-column {
            padding: 1.5rem;
        }

        .brand-title {
            font-size: 2rem;
        }

        .brand-features {
            gap: 1rem;
        }

        .feature-item {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Показ/скрытие пароля
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
    const phoneInput = document.getElementById('register_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
            e.target.value = !x[2] ? x[1] : 
                '+7 (' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
        });
    }

    // Индикатор надежности пароля
    const passwordInput = document.getElementById('register_password');
    const strengthMeter = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let message = '';

            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]+/)) strength += 25;
            if (password.match(/[A-Z]+/)) strength += 25;
            if (password.match(/[0-9]+/)) strength += 25;

            strengthMeter.style.width = strength + '%';

            if (strength <= 25) {
                strengthMeter.style.background = '#dc3545';
                message = 'Слабый пароль';
            } else if (strength <= 50) {
                strengthMeter.style.background = '#ffc107';
                message = 'Средний пароль';
            } else if (strength <= 75) {
                strengthMeter.style.background = '#17a2b8';
                message = 'Хороший пароль';
            } else {
                strengthMeter.style.background = '#28a745';
                message = 'Надежный пароль';
            }

            strengthText.textContent = message;
        });
    }
</script>
@endpush
@endsection