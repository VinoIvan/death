@extends('client.layouts.app')

@section('title', 'Контакты - VCM Laser')
@section('description', 'Контакты салона лазерной эпиляции VCM Laser. Адрес, телефон, режим работы, схема проезда.')

@section('content')
<div class="contacts-container">
    <div class="contacts-header">
        <h1>Контакты</h1>
        <p>Мы всегда рады видеть вас в нашем салоне</p>
    </div>

    {{-- Уведомления об успехе --}}
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Уведомления об ошибке --}}
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Получение контактных данных из базы --}}
    @php
        $phone = App\Models\Contact::where('type', 'phone')->where('is_active', true)->first();
        $workTime = App\Models\Contact::where('type', 'work_time')->where('is_active', true)->first();
        $email = App\Models\Contact::where('type', 'email')->where('is_active', true)->first();
        $address = App\Models\Contact::where('type', 'address')->where('is_active', true)->first();
    @endphp

    {{-- Карточки с контактами --}}
    <div class="contacts-grid">
        {{-- Карточка телефона --}}
        @if($phone)
        <div class="contact-card">
            <div class="contact-icon">
                <i class="fas fa-phone-alt"></i>
            </div>
            <h3 class="contact-title">Телефон</h3>
            <div class="contact-phones">
                @if($phone->phone_1)
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone->phone_1) }}" class="contact-value">
                    {{ $phone->phone_1 }}
                </a>
                @endif
                @if($phone->phone_2)
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone->phone_2) }}" class="contact-value">
                    {{ $phone->phone_2 }}
                </a>
                @endif
            </div>
        </div>
        @endif

        {{-- Карточка режима работы --}}
        @if($workTime)
        <div class="contact-card">
            <div class="contact-icon">
                <i class="fas fa-clock"></i>
            </div>
            <h3 class="contact-title">Режим работы</h3>
            <div class="work-hours">
                @if($workTime->work_days_week && $workTime->work_hours_week)
                <div class="work-hours-item">
                    <span class="work-day">{{ $workTime->work_days_week }}</span>
                    <span class="work-time">{{ $workTime->work_hours_week }}</span>
                </div>
                @endif
                @if($workTime->work_days_weekend && $workTime->work_hours_weekend)
                <div class="work-hours-item">
                    <span class="work-day">{{ $workTime->work_days_weekend }}</span>
                    <span class="work-time">{{ $workTime->work_hours_weekend }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Карточка email --}}
        @if($email)
        <div class="contact-card">
            <div class="contact-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <h3 class="contact-title">Email</h3>
            <a href="mailto:{{ $email->value }}" class="contact-value">{{ $email->value }}</a>
        </div>
        @endif

        {{-- Карточка адреса --}}
        @if($address)
        <div class="contact-card">
            <div class="contact-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <h3 class="contact-title">Адрес</h3>
            <p class="contact-text">{{ $address->value }}</p>
        </div>
        @endif
    </div>

    {{-- Карта --}}
    @if($address)
    <div class="map-section">
        <div class="map-header">
            <h2>Как нас найти</h2>
            <p>{{ $address->value }}</p>
        </div>
        <div class="map-container">
            <iframe 
                src="https://yandex.ru/map-widget/v1/?um=constructor%3A1x2x3x4x5x6x7x8x9x0&source=constructor" 
                width="100%" 
                height="400" 
                frameborder="0"
                allowfullscreen>
            </iframe>
        </div>
    </div>
    @endif

    {{-- Социальные сети --}}
    <div class="social-section">
        <h3>Мы в соцсетях</h3>
        <div class="social-links">
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
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/client/contacts.css') }}">
<style>
    .social-section {
        margin: 3rem 0;
        text-align: center;
    }
    
    .social-section h3 {
        font-size: 1.8rem;
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 1.5rem;
    }
    
    .social-links {
        display: flex;
        gap: 1.2rem;
        justify-content: center;
    }
    
    .footer-social-link {
        width: 60px;
        height: 60px;
        border: 2px solid var(--gray-300);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-500);
        transition: all 0.2s ease;
        text-decoration: none;
        font-size: 1.6rem;
    }
    
    .footer-social-link:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-3px);
        background: rgba(139, 76, 85, 0.02);
    }
    
    @media (max-width: 768px) {
        .footer-social-link {
            width: 50px;
            height: 50px;
            font-size: 1.4rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    {{-- Маска для телефона --}}
    document.getElementById('phone')?.addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        e.target.value = !x[2] ? x[1] : 
            '+7 (' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });
</script>
@endpush