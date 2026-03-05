@extends('admin.layouts.admin')

@section('title', 'Просмотр записи #' . $appointment->id . ' - VCM Laser')
@section('page-title', 'Просмотр записи #' . $appointment->id)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/appointments-show.css') }}">
@endpush

@section('content')
<div class="appointments-show-container">
    <div class="page-header">
        <div class="d-flex gap-2">
            <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn-site">
                Редактировать
            </a>
            <a href="{{ route('admin.appointments.index') }}" class="btn-site">
                Назад к списку
            </a>
        </div>
    </div>

    <div class="detail-grid">
        {{-- Информация о записи --}}
        <div class="info-card">
            <h3>Информация о записи</h3>
            
            <div class="info-row">
                <span class="info-label">ID записи:</span>
                <span class="info-value">#{{ $appointment->id }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Дата:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($appointment->schedule->date)->format('d.m.Y') }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Время:</span>
                <span class="info-value">
                    {{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') }} — 
                    {{ \Carbon\Carbon::parse($appointment->schedule->end_time)->format('H:i') }}
                </span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Услуга:</span>
                <span class="info-value">
                    <strong>{{ $appointment->service->name }}</strong>
                    <br>
                    <small style="color: var(--gray-500); font-size: 0.9rem;">
                        {{ number_format($appointment->service->price, 0, ',', ' ') }} ₽ · 
                        {{ $appointment->service->duration }} мин
                    </small>
                </span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Статус:</span>
                <span class="info-value">
                    <span class="status-badge">{{ $appointment->status->name }}</span>
                </span>
            </div>
            
            @if($appointment->comment)
            <div class="info-row">
                <span class="info-label">Комментарий:</span>
                <span class="info-value">{{ $appointment->comment }}</span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="info-label">Создана:</span>
                <span class="info-value">{{ $appointment->created_at->format('d.m.Y H:i:s') }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Обновлена:</span>
                <span class="info-value">{{ $appointment->updated_at->format('d.m.Y H:i:s') }}</span>
            </div>
        </div>

        {{-- Информация о клиенте --}}
        <div class="info-card">
            <h3>Информация о клиенте</h3>
            
            <div class="info-row">
                <span class="info-label">Имя:</span>
                <span class="info-value">{{ $appointment->client_name }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Телефон:</span>
                <span class="info-value">
                    <a href="tel:{{ $appointment->client_phone }}">
                        {{ $appointment->client_phone }}
                    </a>
                </span>
            </div>
            
            @if($appointment->client_email)
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">
                    <a href="mailto:{{ $appointment->client_email }}">
                        {{ $appointment->client_email }}
                    </a>
                </span>
            </div>
            @endif
            
            @if($appointment->user)
            <div class="info-row">
                <span class="info-label">ID пользователя:</span>
                <span class="info-value">#{{ $appointment->user->id }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Email пользователя:</span>
                <span class="info-value">{{ $appointment->user->email }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Телефон пользователя:</span>
                <span class="info-value">{{ $appointment->user->phone }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Регистрация:</span>
                <span class="info-value">{{ $appointment->user->created_at->format('d.m.Y') }}</span>
            </div>
            @endif
        </div>

        {{-- Отзыв клиента (если есть) --}}
        @if($appointment->review)
        <div class="info-card" style="grid-column: span 2;">
            <h3>Отзыв клиента</h3>
            
            <div class="review-rating">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $appointment->review->rating)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
                <span>{{ $appointment->review->rating }}/5</span>
            </div>
            
            <div class="review-text">
                "{{ $appointment->review->comment }}"
            </div>
            
            <div class="review-meta">
                <span>{{ $appointment->review->created_at->format('d.m.Y H:i') }}</span>
                <span class="review-status {{ $appointment->review->is_approved ? 'approved' : 'pending' }}">
                    {{ $appointment->review->is_approved ? 'Одобрен' : 'На модерации' }}
                </span>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection