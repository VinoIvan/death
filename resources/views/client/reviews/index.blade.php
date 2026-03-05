@extends('client.layouts.app')

@section('title', 'Отзывы клиентов - VCM Laser')
@section('description', 'Реальные отзывы клиентов о салоне лазерной эпиляции VCM Laser.')

@section('content')
<div class="reviews-container">
    {{-- Заголовок страницы --}}
    <div class="reviews-header">
        <h1>Отзывы наших клиентов</h1>
        <p>Реальные впечатления тех, кто уже посетил наш салон</p>
    </div>

    @if(session('success'))
        {{-- Уведомление об успехе --}}
        <div class="alert alert-success" id="successAlert" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($reviews->count() > 0)
    {{-- Фильтры по рейтингу --}}
    <div class="reviews-filters">
        <div class="rating-filters">
            <a href="{{ route('reviews.index') }}" class="rating-filter {{ !request('rating') ? 'active' : '' }}">Все</a>
            @foreach([5,4,3,2,1] as $rating)
            <a href="{{ route('reviews.index', ['rating' => $rating]) }}" 
               class="rating-filter {{ request('rating') == $rating ? 'active' : '' }}">
                {{ $rating }}
            </a>
            @endforeach
        </div>
        
        @auth
        <a href="{{ route('reviews.create') }}" class="btn-outline">
            Оставить отзыв
        </a>
        @endauth
    </div>

    {{-- Список отзывов --}}
    <div class="reviews-list">
        @foreach($reviews as $review)
        <div class="review-item">
            <div class="review-info">
                <div class="review-author">{{ $review->user->name }}</div>
                <div class="review-rating">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <div class="review-content">"{{ $review->comment }}"</div>
                <div class="review-meta">
                    <span class="review-date">
                        <i class="far fa-calendar-alt"></i>
                        {{ $review->created_at->format('d.m.Y') }}
                    </span>
                    @if($review->appointment && $review->appointment->service)
                    <span class="review-service">
                        {{ $review->appointment->service->name }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Пагинация --}}
    @if($reviews->hasPages())
    <div class="pagination">
        {{ $reviews->withQueryString()->links() }}
    </div>
    @endif

    @else
    {{-- Пустое состояние --}}
    <div class="empty-state">
        <i class="fas fa-star"></i>
        <h3>Пока нет отзывов</h3>
        <p>Будьте первым, кто оставит отзыв о нашем салоне!</p>
        @auth
        <a href="{{ route('reviews.create') }}" class="btn-outline">Оставить отзыв</a>
        @else
        <a href="{{ route('login') }}" class="btn-outline">Войдите, чтобы оставить отзыв</a>
        @endauth
    </div>
    @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/client/reviews.css') }}">
@endpush