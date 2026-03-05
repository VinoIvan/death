@extends('client.layouts.app')

@section('title', 'Выберите запись для отзыва - VCM Laser')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Выберите запись для отзыва</h1>
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
                    <a href="{{ route('profile.edit') }}" class="profile-nav-item">
                        <i class="fas fa-user-edit"></i>
                        <span>Редактировать профиль</span>
                    </a>
                    <a href="{{ route('profile.reviews') }}" class="profile-nav-item active">
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
                    <h5>Завершенные записи</h5>
                </div>
                <div class="card-body">
                    @if($appointments->count() > 0)
                        <p class="text-muted mb-4">Выберите процедуру, о которой хотите оставить отзыв:</p>
                        
                        @foreach($appointments as $appointment)
                        <a href="{{ route('reviews.create', ['appointment_id' => $appointment->id]) }}" 
                           class="text-decoration-none">
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
                                        <span class="btn-outline-small">
                                            Выбрать
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    @else
                        {{-- Пустое состояние --}}
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h3>Нет записей для отзыва</h3>
                            <p>У вас пока нет завершенных записей,<br>на которые можно оставить отзыв.</p>
                            <div class="empty-state-actions">
                                <a href="{{ route('booking.index') }}" class="btn-primary-small">
                                    Записаться на процедуру
                                </a>
                                <a href="{{ route('profile.index') }}" class="btn-outline-small">
                                    В профиль
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/client/profile.css') }}">
<style>
    .appointment-item {
        padding: 1.5rem;
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }
    
    .appointment-item:hover {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-hover);
    }
    
    .date-badge {
        width: 70px;
        height: 70px;
        background: var(--white);
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
    }
    
    .date-badge .day {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1;
    }
    
    .date-badge .month {
        font-size: 1rem;
        color: var(--gray-500);
        text-transform: uppercase;
    }
    
    .appointment-info h6 {
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.3rem;
    }
    
    .appointment-info p {
        font-size: 1.4rem;
        color: var(--gray-800);
        margin: 0;
    }
    
    .text-muted {
        color: var(--gray-600);
        font-size: 1.5rem;
        margin-bottom: 2rem;
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
    
    .btn-primary-small {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.4rem;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    
    .btn-primary-small:hover {
        background: var(--primary-hover);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-state i {
        font-size: 5rem;
        color: var(--gray-300);
        margin-bottom: 2rem;
    }
    
    .empty-state h3 {
        font-size: 2.2rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        font-size: 1.6rem;
        color: var(--gray-600);
        margin-bottom: 2.5rem;
        line-height: 1.5;
    }
    
    .empty-state-actions {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .appointment-item .row {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        .appointment-item .col-auto {
            margin-bottom: 0.5rem;
        }
        
        .empty-state-actions {
            flex-direction: column;
        }
        
        .btn-outline-small,
        .btn-primary-small {
            width: 100%;
        }
        
        .empty-state h3 {
            font-size: 2rem;
        }
        
        .empty-state p {
            font-size: 1.4rem;
        }
    }
</style>
@endpush