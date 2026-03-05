@extends('admin.layouts.admin')

@section('title', 'Управление услугами - VCM Laser')
@section('page-title', 'Управление услугами')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/services.css') }}">
@endpush

@section('content')
<div class="services-container">
    <div class="page-header">
        <a href="{{ route('admin.services.create') }}" class="btn-site">
            Добавить услугу
        </a>
    </div>

    {{-- Список услуг --}}
    <div class="services-list">
        @forelse($services as $service)
        <div class="service-item">
            {{-- Информация об услуге --}}
            <div class="service-info">
                <div class="service-name">{{ $service->name }}</div>
                <div class="service-description">{{ $service->description ?: 'Нет описания' }}</div>
                <div class="service-meta">
                    <span class="service-price">{{ number_format($service->price, 0, ',', ' ') }} ₽</span>
                    <span class="service-duration">
                        <i class="far fa-clock"></i>
                        {{ $service->duration }} мин
                    </span>
                </div>
            </div>
            
            {{-- Кнопки действий --}}
            <div class="service-actions">
                <a href="{{ route('admin.services.edit', $service) }}" 
                   class="btn-icon edit" title="Редактировать">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.services.destroy', $service) }}" 
                      method="POST" 
                      class="d-inline"
                      onsubmit="return confirm('Удалить услугу? Все связанные записи будут откреплены.');">
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
            <i class="fas fa-cut fa-3x mb-3" style="color: var(--gray-300);"></i>
            <h5 style="font-size: 1.3rem;">Услуги не найдены</h5>
            <p class="text-muted" style="font-size: 1rem;">Нажмите "Добавить услугу" для создания первой услуги</p>
            <a href="{{ route('admin.services.create') }}" class="btn-site mt-3">
                Добавить услугу
            </a>
        </div>
        @endforelse
    </div>

    {{-- Пагинация --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $services->withQueryString()->links('vendor.pagination.admin') }}
    </div>
</div>
@endsection