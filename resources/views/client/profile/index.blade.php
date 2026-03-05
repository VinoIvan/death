@extends('client.layouts.app')

@section('title', 'Личный кабинет - VCM Laser')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Личный кабинет</h1>
    </div>

    {{-- Уведомления об успехе --}}
    @if(session('success'))
        <div class="alert alert-success" id="successAlert" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Уведомления об ошибке --}}
    @if(session('error'))
        <div class="alert alert-danger" id="errorAlert" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                    <a href="{{ route('profile.index') }}" class="profile-nav-item active">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Обзор</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="profile-nav-item">
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
            {{-- Статистика --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $stats['total_visits'] }}</div>
                        <div class="stat-label">Всего визитов</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $stats['completed_visits'] }}</div>
                        <div class="stat-label">Завершено</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $stats['upcoming_visits'] }}</div>
                        <div class="stat-label">Предстоит</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $stats['reviews_count'] }}</div>
                        <div class="stat-label">Отзывы</div>
                    </div>
                </div>
            </div>

            {{-- Ближайшие записи --}}
            <div class="content-card">
                <div class="card-header">
                    <h5>Ближайшие записи</h5>
                    <a href="{{ route('booking.index') }}" class="btn-outline-small">
                        Записаться
                    </a>
                </div>
                <div class="card-body">
                    @php
                        $upcoming = $recentAppointments->where('schedule.date', '>=', now()->format('Y-m-d'));
                    @endphp
                    
                    @if($upcoming->count() > 0)
                        @foreach($upcoming as $appointment)
                        <div class="appointment-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="date-badge">
                                        <span class="day">{{ \Carbon\Carbon::parse($appointment->schedule->date)->format('d') }}</span>
                                        <span class="month">{{ \Carbon\Carbon::parse($appointment->schedule->date)->format('M') }}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="appointment-info">
                                        <h6>{{ $appointment->service->name }}</h6>
                                        <p>
                                            {{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') }} • {{ number_format($appointment->service->price, 0, ',', ' ') }} ₽
                                        </p>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <span class="status-badge">
                                        {{ $appointment->status->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        {{-- Пустое состояние --}}
                        <div class="empty-appointments">
                            <i class="fas fa-calendar-times"></i>
                            <h3>Нет ближайших записей</h3>
                            <p>Запишитесь на процедуру прямо сейчас</p>
                            <a href="{{ route('booking.index') }}" class="btn-outline-small">
                                Выбрать время
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Завершенные посещения --}}
            @if(isset($completedAppointments) && $completedAppointments->count() > 0)
            <div class="content-card">
                <div class="card-header">
                    <h5>Завершенные посещения</h5>
                </div>
                <div class="card-body">
                    @foreach($completedAppointments as $appointment)
                    <div class="appointment-item">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="date-badge">
                                    <span class="day">{{ \Carbon\Carbon::parse($appointment->schedule->date)->format('d') }}</span>
                                    <span class="month">{{ \Carbon\Carbon::parse($appointment->schedule->date)->format('M') }}</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="appointment-info">
                                    <h6>{{ $appointment->service->name }}</h6>
                                    <p>
                                        {{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') }} • {{ number_format($appointment->service->price, 0, ',', ' ') }} ₽
                                    </p>
                                </div>
                            </div>
                            <div class="col-auto">
                                @if(!$appointment->review)
                                    <a href="{{ route('reviews.create', ['appointment_id' => $appointment->id]) }}" 
                                       class="btn-outline-small">
                                        Оставить отзыв
                                    </a>
                                @else
                                    <span class="status-badge">
                                        Отзыв оставлен
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/client/profile.css') }}">
<style>
    {{-- Стили для уведомлений --}}
    .alert {
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 400px;
        padding: 1rem 1.5rem;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(139, 76, 85, 0.2);
        animation: slideIn 0.3s ease forwards;
        border: none;
    }
    
    .alert-success {
        background: #8b4c55;
        color: white;
    }
    
    .alert-success i {
        color: white;
        margin-right: 0.5rem;
    }
    
    .alert-success .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        margin-left: 1rem;
    }
    
    .alert-success .btn-close:hover {
        opacity: 1;
    }
    
    .alert-danger {
        background: #dc3545;
        color: white;
    }
    
    .alert-danger i {
        color: white;
        margin-right: 0.5rem;
    }
    
    .alert-danger .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        margin-left: 1rem;
    }
    
    .alert-danger .btn-close:hover {
        opacity: 1;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .alert.hide {
        animation: slideOut 0.3s ease forwards;
    }
    
    {{-- Стили для пустого состояния --}}
    .empty-appointments {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-appointments i {
        font-size: 5rem;
        color: var(--gray-300);
        margin-bottom: 2rem;
    }
    
    .empty-appointments h3 {
        font-size: 2.2rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 1rem;
    }
    
    .empty-appointments p {
        font-size: 1.6rem;
        color: var(--gray-600);
        margin-bottom: 2.5rem;
    }
    
    .btn-outline-small {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.4rem;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    
    .btn-outline-small:hover {
        background: var(--primary-color);
        color: white;
    }
    
    @media (max-width: 768px) {
        .alert {
            min-width: 250px;
            right: 10px;
            left: 10px;
            max-width: calc(100% - 20px);
        }
        
        .empty-appointments h3 {
            font-size: 2rem;
        }
        
        .empty-appointments p {
            font-size: 1.4rem;
        }
        
        .empty-appointments i {
            font-size: 4rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.add('hide');
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        });
    });
</script>
@endpush