@extends('admin.layouts.admin')

@section('title', 'Добавление услуги - VCM Laser')
@section('page-title', 'Добавление услуги')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services-create.css') }}">
@endpush

@section('content')
<div class="services-create-container">
    <div class="page-header">
        <a href="{{ route('admin.services.index') }}" class="btn-site">
            Назад к списку
        </a>
    </div>

    {{-- Форма создания услуги --}}
    <div class="form-container">
        <form action="{{ route('admin.services.store') }}" method="POST" class="admin-form">
            @csrf

            {{-- Основная информация --}}
            <div class="form-section">
                <h3 class="form-section-title">Основная информация</h3>
                
                {{-- Название услуги --}}
                <div class="form-group">
                    <label for="name" class="form-label">Название услуги <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Например: Лазерная эпиляция верхней губы"
                           required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    {{-- Цена --}}
                    <div class="form-group">
                        <label for="price" class="form-label">Цена (₽) <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('price') is-invalid @enderror" 
                               id="price" 
                               name="price" 
                               value="{{ old('price') }}" 
                               step="0.01" 
                               min="0" 
                               placeholder="1500"
                               required>
                        @error('price')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Длительность --}}
                    <div class="form-group">
                        <label for="duration" class="form-label">Длительность (мин) <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('duration') is-invalid @enderror" 
                               id="duration" 
                               name="duration" 
                               value="{{ old('duration', 30) }}" 
                               min="5" 
                               step="5" 
                               required>
                        @error('duration')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Описание --}}
                <div class="form-group">
                    <label for="description" class="form-label">Описание</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="5" 
                              placeholder="Подробное описание процедуры...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Настройки --}}
            <div class="form-section">
                <h3 class="form-section-title">Настройки</h3>
                
                {{-- Порядок сортировки --}}
                <div class="form-group" style="max-width: 200px;">
                    <label for="sort_order" class="form-label">Порядок сортировки</label>
                    <input type="number" 
                           class="form-control @error('sort_order') is-invalid @enderror" 
                           id="sort_order" 
                           name="sort_order" 
                           value="{{ old('sort_order', 0) }}" 
                           min="0">
                    @error('sort_order')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Кнопки действий --}}
            <div class="form-actions">
                <a href="{{ route('admin.services.index') }}" class="btn-site">Отмена</a>
                <button type="submit" class="btn-site-solid">Сохранить услугу</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    {{-- Очистка поля цены от нечисловых символов --}}
    document.getElementById('price')?.addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, '');
        if (value) {
            this.value = parseInt(value);
        }
    });
</script>
@endpush
@endsection