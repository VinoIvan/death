@extends('admin.layouts.admin')

@section('title', 'Управление расписанием - VCM Laser')
@section('page-title', 'Управление расписанием')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/schedules.css') }}">
@endpush

@section('content')
<div class="schedules-container">
    <div class="page-header">
        <div class="d-flex gap-2">
            <a href="{{ route('admin.schedules.create', ['date' => $date->format('Y-m-d')]) }}" 
               class="btn-site">
                Добавить слот
            </a>
        </div>
    </div>

    {{-- Навигация по датам --}}
    <div class="date-navigation">
        <a href="{{ route('admin.schedules.index', ['date' => $date->copy()->subDay()->format('Y-m-d')]) }}" 
           class="date-nav-btn">
            <i class="fas fa-chevron-left"></i>
        </a>
        
        <div class="current-date">
            {{ $date->format('d.m.Y') }}
            <span class="day-of-week">{{ $date->isoFormat('dddd') }}</span>
        </div>
        
        <a href="{{ route('admin.schedules.index', ['date' => $date->copy()->addDay()->format('Y-m-d')]) }}" 
           class="date-nav-btn">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>

    {{-- Таблица расписания --}}
    <div class="schedule-day-view">
        <div class="day-header">
            <h2>Расписание на {{ $date->format('d.m.Y') }}</h2>
            <span class="text-muted">{{ $schedules->total() }} слотов</span>
        </div>

        <div class="slots-list">
            @forelse($schedules as $schedule)
            <div class="slot-item">
                {{-- Время слота --}}
                <div class="slot-time">
                    <i class="far fa-clock"></i>
                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} — 
                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                </div>
                
                {{-- Информация об услуге --}}
                <div class="slot-service">
                    <div class="slot-service-name">
                        @if($schedule->service)
                            {{ $schedule->service->name }}
                        @else
                            <span style="color: var(--gray-500);">Любая услуга</span>
                        @endif
                    </div>
                    @if($schedule->service)
                        <div class="slot-service-meta">
                            {{ number_format($schedule->service->price, 0, ',', ' ') }} ₽ · 
                            {{ $schedule->service->duration }} мин
                        </div>
                    @endif
                </div>
                
                {{-- Статус слота --}}
                <div class="slot-status">
                    @if($schedule->current_bookings > 0)
                        <span class="busy">Занято</span>
                    @else
                        <span class="free">Свободно</span>
                    @endif
                </div>
                
                {{-- Кнопки действий --}}
                <div class="slot-actions">
                    <a href="{{ route('admin.schedules.edit', $schedule) }}" 
                       class="btn-icon edit" title="Редактировать">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.schedules.destroy', $schedule) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Удалить слот?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon delete" title="Удалить">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            {{-- Пустое состояние --}}
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x mb-3" style="color: var(--gray-300);"></i>
                <h5 style="font-size: 1.3rem;">Нет слотов на эту дату</h5>
                <p style="color: var(--gray-500); font-size: 1rem;">Нажмите "Добавить слот" для создания нового времени</p>
                <div class="mt-3">
                    <a href="{{ route('admin.schedules.create', ['date' => $date->format('Y-m-d')]) }}" class="btn-site">
                        Добавить слот
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Пагинация --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $schedules->links() }}
        </div>
    </div>
</div>
@endsection