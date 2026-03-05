@extends('admin.layouts.admin')

@section('title', 'Редактирование слота - VCM Laser')
@section('page-title', 'Редактирование слота времени')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/schedules-edit.css') }}">
@endpush

@section('content')
<div class="schedules-edit-container">
    <div class="page-header">
        <a href="{{ route('admin.schedules.index', ['date' => $schedule->date]) }}" class="btn-site">
            Назад к расписанию
        </a>
    </div>

    {{-- Форма редактирования --}}
    <div class="form-container">
        {{-- Информационный блок --}}
        <div class="info-box">
            <div class="info-item">
                <div class="info-item-label">Дата</div>
                <div class="info-item-value">{{ \Carbon\Carbon::parse($schedule->date)->format('d.m.Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">Время</div>
                <div class="info-item-value">
                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} — 
                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                </div>
            </div>
            <div class="info-item">
                <div class="info-item-label">Записей</div>
                <div class="info-item-value highlight">{{ $schedule->current_bookings }}</div>
            </div>
        </div>

        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')

            {{-- Информация о слоте --}}
            <div class="form-section">
                <h3 class="form-section-title">Информация о слоте</h3>
                
                {{-- Выбор услуги --}}
                <div class="form-group">
                    <label for="service_id" class="form-label">Услуга</label>
                    <select class="form-select @error('service_id') is-invalid @enderror" 
                            id="service_id" 
                            name="service_id">
                        <option value="">— Любая услуга —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $schedule->service_id == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} ({{ number_format($service->price, 0, ',', ' ') }} ₽, {{ $service->duration }} мин)
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Предупреждение --}}
            <div class="alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Внимание!</strong> Дата и время не могут быть изменены. 
                Для изменения этих параметров удалите текущий слот и создайте новый.
            </div>

            {{-- Список записей на этот слот --}}
            @if($schedule->appointments()->exists())
            <div class="form-section">
                <h3 class="form-section-title">Записи на этот слот ({{ $schedule->appointments->count() }})</h3>
                <div style="overflow-x: auto;">
                    <table class="appointments-table">
                        <thead>
                            <tr>
                                <th>Клиент</th>
                                <th>Телефон</th>
                                <th>Email</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedule->appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->client_name }}</td>
                                <td>{{ $appointment->client_phone }}</td>
                                <td>{{ $appointment->client_email ?? '—' }}</td>
                                <td><span class="status">{{ $appointment->status->name }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Кнопки действий --}}
            <div class="form-actions">
                <a href="{{ route('admin.schedules.index', ['date' => $schedule->date]) }}" class="btn-site">Отмена</a>
                <button type="submit" class="btn-site-solid">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>
@endsection