@extends('client.layouts.app')

@section('title', 'Мои отзывы - VCM Laser')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Мои отзывы</h1>
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
                    <h5>Мои отзывы</h5>
                    <a href="{{ route('reviews.create') }}" class="btn-outline-small">
                        Написать отзыв
                    </a>
                </div>
                <div class="card-body">
                    @if($reviews->count() > 0)
                        {{-- Список отзывов --}}
                        <div class="reviews-list">
                            @foreach($reviews as $review)
                            <div class="review-item">
                                <div class="review-item-header">
                                    <div class="review-service-info">
                                        <h6>
                                            @if($review->appointment && $review->appointment->service)
                                                {{ $review->appointment->service->name }}
                                            @else
                                                Отзыв
                                            @endif
                                        </h6>
                                        <div class="review-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="review-actions">
                                        @if($review->is_approved)
                                            <span class="status-badge">Опубликован</span>
                                        @else
                                            <span class="status-badge">На модерации</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="review-item-content">
                                    <p>{{ $review->comment }}</p>
                                </div>
                                
                                <div class="review-item-footer">
                                    <small>
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $review->created_at->format('d.m.Y') }}
                                    </small>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Пагинация --}}
                        @if($reviews->hasPages())
                        <div class="pagination mt-4">
                            {{ $reviews->links() }}
                        </div>
                        @endif
                    @else
                        {{-- Пустое состояние --}}
                        <div class="empty-state">
                            <i class="fas fa-star"></i>
                            <h3>У вас пока нет отзывов</h3>
                            <p>Оставьте отзыв о процедуре</p>
                            <div class="empty-state-actions">
                                <a href="{{ route('profile.index') }}" class="btn-outline-small">
                                    В профиль
                                </a>
                                <a href="{{ route('reviews.create') }}" class="btn-primary-small">
                                    Написать отзыв
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
    
    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .review-item {
        padding: 2rem;
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    
    .review-item:hover {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-hover);
    }
    
    .review-item-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .review-service-info h6 {
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }
    
    .review-rating {
        display: flex;
        gap: 0.3rem;
    }
    
    .review-rating i {
        font-size: 1.4rem;
    }
    
    .review-rating .fas.fa-star {
        color: var(--primary-color) !important;
    }
    
    .review-rating .far.fa-star {
        color: var(--gray-300) !important;
    }
    
    .review-item-content p {
        color: var(--gray-700);
        font-size: 1.5rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .review-item-footer {
        display: flex;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }
    
    .review-item-footer small {
        color: var(--gray-500);
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .review-item-footer i {
        color: var(--primary-color);
        font-size: 1.3rem;
    }
    
    .status-badge {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--gray-900);
        display: inline-block;
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
    }
    
    .empty-state-actions {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }
    
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 0.5rem;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        color: var(--gray-700);
        background: var(--white);
        text-decoration: none;
        transition: border-color 0.2s ease, color 0.2s ease;
        font-size: 1.4rem;
    }
    
    .pagination .page-link:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }
    
    .pagination .active .page-link {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--white);
    }
    
    @media (max-width: 768px) {
        .review-item-header {
            flex-direction: column;
        }
        
        .review-actions {
            width: 100%;
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
        
        .status-badge {
            width: 100%;
            text-align: left;
        }
    }
</style>
@endpush