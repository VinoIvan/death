@extends('client.layouts.app')

@section('title', 'Запись подтверждена - VCM Laser')

@section('content')
<div class="booking-success-container">
    {{-- Карточка успеха --}}
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 class="success-title">Запись подтверждена!</h1>
        <p class="success-subtitle">Спасибо, что выбрали VCM Laser</p>
        
        {{-- Детали записи --}}
        <div class="booking-details">
            <div class="detail-row">
                <span class="detail-label">Услуга:</span>
                <span class="detail-value">{{ $appointment->service->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Дата:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->schedule->date)->format('d.m.Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Время:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Стоимость:</span>
                <span class="detail-value price">{{ number_format($appointment->service->price, 0, ',', ' ') }} ₽</span>
            </div>
        </div>

        {{-- Кнопки действий --}}
        <div class="success-actions">
            <a href="{{ route('home') }}" class="btn-outline">
                На главную
            </a>
            @auth
            <a href="{{ route('profile.index') }}" class="btn-primary">
                Мои записи
            </a>
            @endauth
        </div>

        {{-- Сообщение для гостей --}}
        @guest
        <div class="guest-message">
            <p>Хотите сохранить историю посещений?</p>
            <a href="{{ route('register') }}" class="btn-outline">
                Зарегистрироваться
            </a>
        </div>
        @endguest
    </div>
</div>
@endsection

@push('styles')
<style>
    .booking-success-container {
        max-width: 1750px;
        margin: 4rem auto;
        padding: 0 1rem;
    }
    
    .success-card {
        max-width: 600px;
        margin: 0 auto;
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 30px;
        padding: 4rem 3rem;
        text-align: center;
        box-shadow: var(--shadow-lg);
    }
    
    .success-icon {
        width: 100px;
        height: 100px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        margin: 0 auto 2rem;
        box-shadow: 0 10px 30px rgba(139, 76, 85, 0.3);
    }
    
    .success-title {
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1rem;
    }
    
    .success-subtitle {
        font-size: 1.8rem;
        color: var(--gray-600);
        margin-bottom: 3rem;
    }
    
    .booking-details {
        background: var(--gray-50);
        border-radius: 20px;
        padding: 2rem;
        margin: 3rem 0;
        text-align: left;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 1.2rem 0;
        border-bottom: 1px solid var(--gray-200);
        font-size: 1.6rem;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        color: var(--gray-600);
        font-weight: 500;
    }
    
    .detail-value {
        color: var(--gray-900);
        font-weight: 600;
    }
    
    .detail-value.price {
        color: var(--primary-color);
        font-size: 1.8rem;
    }
    
    {{-- Кнопки в столбик --}}
    .success-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .btn-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 1.2rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.6rem;
        transition: all 0.2s ease;
        text-decoration: none;
        width: 100%;
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
        padding: 1.2rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.6rem;
        transition: all 0.2s ease;
        text-decoration: none;
        width: 100%;
    }
    
    .btn-primary:hover {
        background: var(--primary-hover);
    }
    
    .guest-message {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--gray-200);
    }
    
    .guest-message p {
        color: var(--gray-600);
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .guest-message .btn-outline {
        max-width: 300px;
        margin: 0 auto;
    }
    
    @media (max-width: 768px) {
        .success-card {
            padding: 3rem 2rem;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            font-size: 3rem;
        }
        
        .success-title {
            font-size: 3rem;
        }
        
        .success-subtitle {
            font-size: 1.6rem;
        }
        
        .booking-details {
            padding: 1.5rem;
        }
        
        .detail-row {
            font-size: 1.5rem;
        }
        
        .detail-value.price {
            font-size: 1.6rem;
        }
        
        .btn-outline,
        .btn-primary {
            font-size: 1.5rem;
            padding: 1rem 1.5rem;
        }
        
        .guest-message p {
            font-size: 1.4rem;
        }
        
        .guest-message .btn-outline {
            max-width: 100%;
        }
    }
    
    @media (max-width: 480px) {
        .success-card {
            padding: 2rem 1.5rem;
        }
        
        .success-icon {
            width: 70px;
            height: 70px;
            font-size: 2.5rem;
        }
        
        .success-title {
            font-size: 2.5rem;
        }
        
        .success-subtitle {
            font-size: 1.4rem;
        }
        
        .detail-row {
            font-size: 1.4rem;
            flex-direction: column;
            gap: 0.3rem;
        }
        
        .detail-value {
            text-align: left;
        }
        
        .detail-value.price {
            font-size: 1.5rem;
        }
        
        .btn-outline,
        .btn-primary {
            font-size: 1.4rem;
            padding: 0.9rem 1.2rem;
        }
        
        .guest-message p {
            font-size: 1.3rem;
        }
    }
</style>
@endpush