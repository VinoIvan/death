@extends('admin.layouts.admin')

@section('title', 'Добавление слота - VCM Laser')
@section('page-title', 'Добавление слота времени')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/schedules-create.css') }}">
@endpush

@section('content')
<div class="schedules-create-container">
    <div class="page-header">
        <a href="{{ route('admin.schedules.index', ['date' => request('date')]) }}" class="btn-site">
            Назад к расписанию
        </a>
    </div>

    {{-- Форма создания слота --}}
    <div class="form-container">
        <form action="{{ route('admin.schedules.store') }}" method="POST" class="admin-form">
            @csrf

            {{-- Блок времени --}}
            <div class="form-section">
                <h3 class="form-section-title">Время</h3>
                
                <div class="form-row">
                    {{-- Дата --}}
                    <div class="form-group">
                        <label for="date" class="form-label">Дата <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control @error('date') is-invalid @enderror" 
                               id="date" 
                               name="date" 
                               value="{{ old('date', request('date', now()->format('Y-m-d'))) }}" 
                               min="{{ now()->format('Y-m-d') }}" 
                               required>
                        @error('date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Время начала --}}
                    <div class="form-group">
                        <label for="start_time" class="form-label">Время начала <span class="text-danger">*</span></label>
                        <input type="time" 
                               class="form-control @error('start_time') is-invalid @enderror" 
                               id="start_time" 
                               name="start_time" 
                               value="{{ old('start_time', '10:00') }}" 
                               required>
                        @error('start_time')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Время окончания --}}
                    <div class="form-group">
                        <label for="end_time" class="form-label">Время окончания <span class="text-danger">*</span></label>
                        <input type="time" 
                               class="form-control @error('end_time') is-invalid @enderror" 
                               id="end_time" 
                               name="end_time" 
                               value="{{ old('end_time', '11:00') }}" 
                               required>
                        @error('end_time')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Блок услуги --}}
            <div class="form-section">
                <h3 class="form-section-title">Услуга</h3>
                
                <div class="form-group" style="max-width: 500px;">
                    <label for="service_id" class="form-label">Услуга</label>
                    <select class="form-select @error('service_id') is-invalid @enderror" 
                            id="service_id" 
                            name="service_id">
                        <option value="">— Любая услуга —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} ({{ number_format($service->price, 0, ',', ' ') }} ₽, {{ $service->duration }} мин)
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="help-text">Оставьте пустым, если слот подходит для любой услуги</small>
                </div>
            </div>

            {{-- Предупреждение --}}
            <div class="alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Важно!</strong> Убедитесь, что выбранное время не пересекается с существующими слотами.
            </div>

            {{-- Кнопки действий --}}
            <div class="form-actions">
                <a href="{{ route('admin.schedules.index', ['date' => request('date')]) }}" class="btn-site">Отмена</a>
                <button type="submit" class="btn-site-solid">Сохранить слот</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    {{-- Валидация времени --}}
    document.getElementById('start_time')?.addEventListener('change', function() {
        const endTime = document.getElementById('end_time');
        if (endTime.value && this.value >= endTime.value) {
            endTime.value = '';
        }
        endTime.min = this.value;
    });

    document.getElementById('end_time')?.addEventListener('change', function() {
        const startTime = document.getElementById('start_time');
        if (startTime.value && this.value <= startTime.value) {
            this.value = '';
            alert('Время окончания должно быть позже времени начала');
        }
    });
</script>
@endpush
@endsection