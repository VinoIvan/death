@extends('client.layouts.app')

@section('title', 'Завершение записи - VCM Laser')

@section('content')
<div class="booking-create-container">
    <div class="booking-create-header">
        <h1>Завершение записи</h1>
        <p>Введите ваши данные для подтверждения</p>
    </div>

    {{-- Индикатор шагов --}}
    <div class="booking-progress">
        <div class="progress-step completed">
            <span>1</span>
            <div class="step-label">Услуга</div>
        </div>
        <div class="progress-step completed">
            <span>2</span>
            <div class="step-label">Время</div>
        </div>
        <div class="progress-step active">
            <span>3</span>
            <div class="step-label">Данные</div>
        </div>
    </div>

    <div class="booking-create-content">
        {{-- Блок с выбранными данными --}}
        <div class="booking-summary">
            <h2>Ваш выбор</h2>
            
            <div class="summary-item">
                <span class="summary-label">Услуга:</span>
                <span class="summary-value">{{ $service->name }}</span>
            </div>
            
            <div class="summary-item">
                <span class="summary-label">Дата:</span>
                <span class="summary-value">{{ \Carbon\Carbon::parse($schedule->date)->format('d.m.Y') }}</span>
            </div>
            
            <div class="summary-item">
                <span class="summary-label">Время:</span>
                <span class="summary-value">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
            </div>
            
            <div class="summary-item">
                <span class="summary-label">Длительность:</span>
                <span class="summary-value">{{ $service->duration }} мин</span>
            </div>
            
            <div class="summary-item total">
                <span class="summary-label">К оплате:</span>
                <span class="summary-price">{{ number_format($service->price, 0, ',', ' ') }} ₽</span>
            </div>
        </div>

        {{-- Форма ввода данных --}}
        <div class="booking-form">
            <h2>Контактные данные</h2>
            
            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                {{-- Поле имя --}}
                <div class="form-group">
                    <label for="client_name" class="form-label">Ваше имя <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('client_name') is-invalid @enderror" 
                           id="client_name" 
                           name="client_name" 
                           value="{{ old('client_name', auth()->user()->name ?? '') }}" 
                           placeholder="Иван Петров"
                           required>
                    @error('client_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Поле телефон --}}
                <div class="form-group">
                    <label for="client_phone" class="form-label">Номер телефона <span class="text-danger">*</span></label>
                    <input type="tel" 
                           class="form-control @error('client_phone') is-invalid @enderror" 
                           id="client_phone" 
                           name="client_phone" 
                           value="{{ old('client_phone', auth()->user()->phone ?? '') }}" 
                           placeholder="+7 (999) 123-45-67"
                           required>
                    @error('client_phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="help-text">Для подтверждения записи и SMS-уведомлений</small>
                </div>

                {{-- Поле email --}}
                <div class="form-group">
                    <label for="client_email" class="form-label">Email</label>
                    <input type="email" 
                           class="form-control @error('client_email') is-invalid @enderror" 
                           id="client_email" 
                           name="client_email" 
                           value="{{ old('client_email', auth()->user()->email ?? '') }}" 
                           placeholder="ivan@example.com">
                    @error('client_email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="help-text">Для отправки подтверждения на email</small>
                </div>

                {{-- Поле комментарий --}}
                <div class="form-group">
                    <label for="comment" class="form-label">Комментарий</label>
                    <textarea class="form-control @error('comment') is-invalid @enderror" 
                              id="comment" 
                              name="comment" 
                              rows="3" 
                              placeholder="Ваши пожелания или вопросы">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Сообщение для гостей --}}
                @guest
                <div class="guest-message">
                    <i class="fas fa-info-circle"></i>
                    <p>Вы записываетесь как гость. <a href="{{ route('register') }}">Зарегистрируйтесь</a>, чтобы отслеживать историю посещений и получать скидки.</p>
                </div>
                @endguest

                {{-- Кнопки действий --}}
                <div class="form-actions">
                    <a href="{{ route('booking.index', ['service_id' => $service->id]) }}" class="btn-outline">Назад</a>
                    <button type="submit" class="btn-primary" id="submitBtn">
                        Подтвердить запись
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .booking-create-container {
        max-width: 1750px;
        margin: 0 auto;
        padding: 3rem 1rem;
    }

    {{-- Заголовок страницы --}}
    .booking-create-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .booking-create-header h1 {
        font-size: 4.4rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1.2rem;
        position: relative;
        display: inline-block;
    }

    .booking-create-header h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 4px;
        background: var(--primary-color);
    }

    .booking-create-header p {
        color: var(--gray-600);
        font-size: 1.8rem;
        max-width: 900px;
        margin: 1.5rem auto 0;
        font-weight: 400;
    }

    {{-- Индикатор шагов --}}
    .booking-progress {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4rem;
        position: relative;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .booking-progress::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gray-300);
        z-index: 1;
    }

    .progress-step {
        position: relative;
        z-index: 2;
        background: var(--white);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.6rem;
        color: var(--gray-500);
        border: 2px solid var(--gray-300);
        background: var(--white);
    }

    .progress-step.active {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .progress-step.completed {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--white);
    }

    .step-label {
        position: absolute;
        top: 55px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.2rem;
        color: var(--gray-500);
        white-space: nowrap;
    }

    {{-- Сетка контента --}}
    .booking-create-content {
        display: grid;
        grid-template-columns: 0.8fr 1.2fr;
        gap: 3rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    {{-- Блок сводки --}}
    .booking-summary {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: var(--shadow-sm);
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .booking-summary h2 {
        font-size: 2rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 1.2rem 0;
        border-bottom: 1px solid var(--gray-200);
        font-size: 1.5rem;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .summary-item.total {
        margin-top: 1rem;
        padding-top: 1.5rem;
        border-top: 2px solid var(--gray-300);
        font-weight: 600;
    }

    .summary-label {
        color: var(--gray-600);
    }

    .summary-value {
        color: var(--gray-900);
        font-weight: 500;
        text-align: right;
    }

    .summary-price {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.8rem;
    }

    {{-- Блок формы --}}
    .booking-form {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: var(--shadow-sm);
    }

    .booking-form h2 {
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
        background: var(--white);
    }

    .form-control:hover {
        border-color: var(--primary-color);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 76, 85, 0.1);
    }

    .form-control::placeholder {
        color: var(--gray-400);
        font-size: 1.4rem;
    }

    .form-control.is-invalid {
        border-color: var(--danger);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
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

    {{-- Сообщение для гостей --}}
    .guest-message {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: var(--primary-bg);
        border: 1px solid var(--primary-light);
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .guest-message i {
        color: var(--primary-color);
        font-size: 2rem;
        flex-shrink: 0;
    }

    .guest-message p {
        color: var(--gray-700);
        font-size: 1.4rem;
        margin: 0;
        line-height: 1.5;
    }

    .guest-message a {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
    }

    .guest-message a:hover {
        text-decoration: underline;
    }

    {{-- Кнопки действий --}}
    .form-actions {
        display: flex;
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 1.2rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.5rem;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
        flex: 1;
    }

    .btn-outline:hover {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 1.2rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.5rem;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
        flex: 1;
    }

    .btn-primary:hover {
        background: var(--primary-hover);
        color: white;
    }

    @media (max-width: 1200px) {
        .booking-create-header h1 {
            font-size: 4rem;
        }
        
        .booking-create-header p {
            font-size: 1.6rem;
        }
        
        .booking-create-content {
            gap: 2rem;
        }
    }

    @media (max-width: 992px) {
        .booking-create-content {
            grid-template-columns: 1fr;
        }
        
        .booking-summary {
            position: static;
            margin-bottom: 2rem;
        }
        
        .booking-create-header h1 {
            font-size: 3.5rem;
        }
        
        .booking-create-header p {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .booking-create-header h1 {
            font-size: 3rem;
        }
        
        .booking-create-header p {
            font-size: 1.4rem;
        }
        
        .progress-step {
            width: 45px;
            height: 45px;
            font-size: 1.4rem;
        }
        
        .step-label {
            font-size: 1rem;
            top: 50px;
        }
        
        .booking-summary {
            padding: 2rem;
        }
        
        .booking-summary h2 {
            font-size: 1.8rem;
        }
        
        .summary-item {
            font-size: 1.4rem;
        }
        
        .summary-price {
            font-size: 1.6rem;
        }
        
        .booking-form {
            padding: 2rem;
        }
        
        .booking-form h2 {
            font-size: 1.8rem;
        }
        
        .form-label {
            font-size: 1.4rem;
        }
        
        .form-control {
            font-size: 1.4rem;
            padding: 1rem 1.2rem;
        }
        
        .help-text,
        .error-message {
            font-size: 1.2rem;
        }
        
        .guest-message {
            padding: 1.2rem;
        }
        
        .guest-message i {
            font-size: 1.8rem;
        }
        
        .guest-message p {
            font-size: 1.3rem;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn-outline,
        .btn-primary {
            font-size: 1.4rem;
            padding: 1rem 2rem;
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .booking-create-header h1 {
            font-size: 2.5rem;
        }
        
        .booking-create-header p {
            font-size: 1.2rem;
        }
        
        .progress-step {
            width: 40px;
            height: 40px;
            font-size: 1.3rem;
        }
        
        .step-label {
            font-size: 0.9rem;
            top: 45px;
        }
        
        .booking-summary {
            padding: 1.5rem;
        }
        
        .booking-summary h2 {
            font-size: 1.6rem;
        }
        
        .summary-item {
            font-size: 1.3rem;
            flex-direction: column;
            gap: 0.3rem;
        }
        
        .summary-value {
            text-align: left;
        }
        
        .summary-price {
            font-size: 1.5rem;
        }
        
        .booking-form {
            padding: 1.5rem;
        }
        
        .booking-form h2 {
            font-size: 1.6rem;
        }
        
        .form-label {
            font-size: 1.3rem;
        }
        
        .form-control {
            font-size: 1.3rem;
            padding: 0.9rem 1rem;
        }
        
        .help-text,
        .error-message {
            font-size: 1.1rem;
        }
        
        .guest-message {
            flex-direction: column;
            text-align: center;
        }
        
        .guest-message p {
            font-size: 1.2rem;
        }
        
        .btn-outline,
        .btn-primary {
            font-size: 1.3rem;
            padding: 0.9rem 1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    {{-- Маска для телефона --}}
    document.getElementById('client_phone')?.addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        e.target.value = !x[2] ? x[1] : 
            '+7 (' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });
    
    {{-- Валидация формы перед отправкой --}}
    document.getElementById('bookingForm')?.addEventListener('submit', function(e) {
        const phone = document.getElementById('client_phone').value;
        const phoneRegex = /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/;
        
        if (!phoneRegex.test(phone)) {
            e.preventDefault();
            alert('Пожалуйста, введите корректный номер телефона');
        }
    });
</script>
@endpush