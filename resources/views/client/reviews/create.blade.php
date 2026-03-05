@extends('client.layouts.app')

@section('title', 'Оставить отзыв - VCM Laser')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Оставить отзыв</h1>
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
                    <h5>Оставить отзыв</h5>
                </div>
                <div class="card-body">
                    @if(isset($appointment))
                    {{-- Информация о выбранной записи --}}
                    <div class="appointment-item mb-4">
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
                        </div>
                    </div>
                    @endif

                    {{-- Форма отправки отзыва --}}
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="appointment_id" value="{{ $appointment->id ?? request('appointment_id') }}">

                        {{-- Выбор рейтинга --}}
                        <div class="form-group">
                            <label class="form-label">Оценка <span class="text-danger">*</span></label>
                            <div class="rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                            @error('rating')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Текст отзыва --}}
                        <div class="form-group">
                            <label for="comment" class="form-label">Ваш отзыв <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" 
                                      name="comment" 
                                      rows="5" 
                                      placeholder="Расскажите о вашем опыте посещения салона..."
                                      required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Кнопки действий --}}
                        <div class="form-actions">
                            <a href="{{ route('reviews.select-appointment') }}" class="btn-outline-small">Назад</a>
                            <button type="submit" class="btn-primary-small">
                                Отправить отзыв
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/client/profile.css') }}">
<style>
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 0.8rem;
        margin-bottom: 1rem;
    }
    
    .rating-input input {
        display: none;
    }
    
    .rating-input label {
        font-size: 2.5rem;
        color: var(--gray-300);
        cursor: pointer;
        transition: color 0.2s ease;
    }
    
    .rating-input label:hover,
    .rating-input label:hover ~ label {
        color: var(--primary-color) !important;
    }
    
    .rating-input input:checked ~ label {
        color: var(--primary-color) !important;
    }
    
    .rating-input input:checked + label {
        color: var(--primary-color) !important;
    }
    
    .appointment-item {
        padding: 1.5rem;
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        margin-bottom: 2rem;
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
    
    .btn-outline-small {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.5rem;
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
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.5rem;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    
    .btn-primary-small:hover {
        background: var(--primary-hover);
    }
    
    .form-actions {
        display: flex;
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        
        .btn-outline-small,
        .btn-primary-small {
            width: 100%;
        }
        
        .rating-input label {
            font-size: 2rem;
        }
    }
</style>
@endpush