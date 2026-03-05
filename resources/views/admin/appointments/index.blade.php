@extends('admin.layouts.admin')

@section('title', 'Управление записями - VCM Laser')
@section('page-title', 'Управление записями')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/appointments.css') }}">
@endpush

@section('content')
<div class="appointments-container">
    <div class="page-header">
        <div class="d-flex gap-2">
            <a href="{{ route('admin.appointments.create') }}" class="btn-site">
                Новая запись
            </a>
        </div>
    </div>

    {{-- Фильтры --}}
    <div class="filters-card">
        <form action="{{ route('admin.appointments.index') }}" method="GET" class="filters-form">
            {{-- Поиск --}}
            <div class="filter-group">
                <label class="form-label">Поиск</label>
                <input type="text" 
                       class="form-control" 
                       name="search" 
                       placeholder="Имя, телефон..." 
                       value="{{ request('search') }}">
            </div>

            {{-- Фильтр по дате --}}
            <div class="filter-group date-filter">
                <label class="form-label">Дата</label>
                <input type="date" 
                       class="form-control" 
                       name="date" 
                       value="{{ request('date') }}">
            </div>

            {{-- Фильтр по услуге --}}
            <div class="filter-group">
                <label class="form-label">Услуга</label>
                <select class="form-select" name="service_id">
                    <option value="">Все услуги</option>
                    @foreach($services ?? [] as $service)
                        <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Фильтр по статусу --}}
            <div class="filter-group">
                <label class="form-label">Статус</label>
                <select class="form-select" name="status_id">
                    <option value="">Все статусы</option>
                    @foreach($statuses ?? [] as $status)
                        <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Кнопки фильтрации --}}
            <div class="filter-actions">
                <button type="submit" class="btn-site">Применить</button>
                <a href="{{ route('admin.appointments.index') }}" class="btn-site">Сбросить</a>
            </div>
        </form>
    </div>

    {{-- Таблица записей --}}
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Дата/Время</th>
                    <th>Клиент</th>
                    <th>Услуга</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments ?? [] as $appointment)
                <tr>
                    <td>#{{ $appointment->id }}</td>
                    <td>
                        <div class="appointment-date">{{ \Carbon\Carbon::parse($appointment->schedule->date)->format('d.m.Y') }}</div>
                        <div class="appointment-time">{{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') }}</div>
                    </td>
                    <td>
                        <div class="appointment-client">{{ $appointment->client_name }}</div>
                        <div class="appointment-phone">{{ $appointment->client_phone }}</div>
                    </td>
                    <td>
                        <div class="appointment-service">{{ $appointment->service->name }}</div>
                    </td>
                    <td>
                        <span class="status-badge">
                            {{ $appointment->status->name }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            {{-- Просмотр --}}
                            <a href="{{ route('admin.appointments.show', $appointment) }}" 
                               class="btn-icon view" title="Просмотр">
                                <i class="fas fa-eye"></i>
                            </a>
                            {{-- Редактирование --}}
                            <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                               class="btn-icon edit" title="Редактировать">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- Удаление --}}
                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Удалить запись?');">
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
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 style="font-size: 1.3rem;">Записи не найдены</h5>
                        <p class="text-muted" style="font-size: 1rem;">Попробуйте изменить параметры фильтрации</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Пагинация --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $appointments->withQueryString()->links('vendor.pagination.admin') }}
        </div>
    </div>
</div>
@endsection