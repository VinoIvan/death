@extends('admin.layouts.admin')

@section('title', 'Редактирование услуги - VCM Laser')
@section('page-title', 'Редактирование услуги')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services-create.css') }}">
@endpush

@section('content')
<div class="services-create-container">
    <div class="page-header">
        <div>
            <a href="{{ route('admin.services.index') }}" class="btn-site me-2">
                Назад к списку
            </a>
            <a href="{{ route('admin.services.create') }}" class="btn-site">
                Добавить
            </a>
        </div>
    </div>

    {{-- Форма редактирования услуги --}}
    <div class="form-container">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')

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
                           value="{{ old('name', $service->name) }}" 
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
                               value="{{ old('price', $service->price) }}" 
                               step="0.01" 
                               min="0" 
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
                               value="{{ old('duration', $service->duration) }}" 
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
                              rows="5">{{ old('description', $service->description) }}</textarea>
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
                           value="{{ old('sort_order', $service->sort_order) }}" 
                           min="0">
                    @error('sort_order')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Кнопки действий --}}
            <div class="form-actions">
                <a href="{{ route('admin.services.index') }}" class="btn-site">Отмена</a>
                <button type="submit" class="btn-site-solid">Сохранить изменения</button>
            </div>
        </form>
    </div>
</div>
@endsection