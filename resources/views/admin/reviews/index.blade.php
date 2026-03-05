@extends('admin.layouts.admin')

@section('title', 'Управление отзывами - VCM Laser')
@section('page-title', 'Управление отзывами')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/reviews.css') }}">
@endpush

@section('content')
<div class="reviews-container">
    {{-- Фильтры --}}
    <div class="filters-card">
        <form action="{{ route('admin.reviews.index') }}" method="GET" class="filters-form">
            <div class="rating-filters">
                <a href="{{ route('admin.reviews.index') }}" class="rating-filter {{ !request('rating') ? 'active' : '' }}">Все</a>
                @foreach([5,4,3,2,1] as $rating)
                <a href="{{ route('admin.reviews.index', ['rating' => $rating]) }}" 
                   class="rating-filter {{ request('rating') == $rating ? 'active' : '' }}">
                    {{ $rating }}
                </a>
                @endforeach
            </div>
        </form>
    </div>

    {{-- Таблица отзывов --}}
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Услуга</th>
                    <th>Оценка</th>
                    <th>Отзыв</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>#{{ $review->id }}</td>
                    <td>
                        <div class="user-name">{{ $review->user->name }}</div>
                        <div class="user-email">{{ $review->user->email }}</div>
                    </td>
                    <td>
                        @if($review->appointment && $review->appointment->service)
                            <div class="service-name">{{ $review->appointment->service->name }}</div>
                            <div class="service-date">
                                {{ \Carbon\Carbon::parse($review->appointment->schedule->date)->format('d.m.Y') }}
                            </div>
                        @else
                            <span style="color: var(--gray-400);">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                    </td>
                    <td>
                        <div class="review-text" title="{{ $review->comment }}">
                            "{{ Str::limit($review->comment, 80) }}"
                        </div>
                    </td>
                    <td>
                        <span class="review-date">{{ $review->created_at->format('d.m.Y') }}</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            {{-- Удаление отзыва --}}
                            <form action="{{ route('admin.reviews.destroy', $review) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Удалить отзыв? Это действие нельзя отменить.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Удалить">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                {{-- Пустое состояние --}}
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-star fa-3x mb-3" style="color: var(--gray-300);"></i>
                        <h5 style="font-size: 1.3rem;">Отзывы не найдены</h5>
                        <p style="color: var(--gray-500); font-size: 1rem;">Попробуйте изменить параметры фильтрации</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Пагинация --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $reviews->withQueryString()->links('vendor.pagination.admin') }}
        </div>
    </div>
</div>
@endsection