@extends('client.layouts.app')

@section('title', 'Услуги лазерной эпиляции - VCM Laser')
@section('description', 'Полный список услуг лазерной эпиляции в салоне VCM Laser.')

@section('content')
<div class="services-container">
    {{-- Заголовок страницы --}}
    <div class="services-header">
        <h1>Наши услуги</h1>
        <p>Выберите процедуру и запишитесь на удобное время</p>
    </div>

    @if($services->count() > 0)
    {{-- Фильтры --}}
    <div class="services-filters">
        <div class="services-filters__sort">
            <label for="sort">Сортировка:</label>
            <select id="sort" onchange="window.location.href = this.value">
                <option value="{{ route('services.index', ['sort' => 'default']) }}" {{ request('sort') == 'default' ? 'selected' : '' }}>По умолчанию</option>
                <option value="{{ route('services.index', ['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Сначала недорогие</option>
                <option value="{{ route('services.index', ['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Сначала дорогие</option>
                <option value="{{ route('services.index', ['sort' => 'duration']) }}" {{ request('sort') == 'duration' ? 'selected' : '' }}>По длительности</option>
            </select>
        </div>
        
        <div class="services-filters__search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Поиск услуг..." id="searchInput">
        </div>
    </div>

    {{-- Список услуг --}}
    <div class="services-list" id="servicesList">
        @foreach($services as $service)
        <div class="service-item" data-name="{{ strtolower($service->name) }}" data-price="{{ $service->price }}">
            <div class="service-info">
                <div class="service-name">{{ $service->name }}</div>
                <div class="service-description">{{ Str::limit($service->description, 120) }}</div>
                <div class="service-meta">
                    <span class="service-price">{{ number_format($service->price, 0, ',', ' ') }} ₽</span>
                    <span class="service-duration">
                        <i class="far fa-clock"></i>
                        {{ $service->duration }} мин
                    </span>
                </div>
            </div>
            <div class="service-actions">
                <a href="{{ route('booking.index', ['service_id' => $service->id]) }}" class="btn-primary-sm">
                    Записаться
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Пагинация --}}
    @if($services->hasPages())
    <div class="pagination">
        {{ $services->withQueryString()->links() }}
    </div>
    @endif

    @else
    {{-- Пустое состояние --}}
    <div class="empty-state">
        <i class="fas fa-cut"></i>
        <h3>Услуги временно недоступны</h3>
        <p>Пожалуйста, зайдите позже или свяжитесь с нами</p>
    </div>
    @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/client/services.css') }}">
@endpush

@push('scripts')
<script>
    document.getElementById('searchInput')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.service-item');
        let visibleCount = 0;
        
        items.forEach(item => {
            const name = item.dataset.name;
            if (name.includes(searchTerm)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Показать/скрыть сообщение об отсутствии результатов
        let noResultsMsg = document.getElementById('noResultsMsg');
        
        if (visibleCount === 0 && items.length > 0) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'noResultsMsg';
                noResultsMsg.className = 'empty-state';
                noResultsMsg.innerHTML = `
                    <i class="fas fa-search"></i>
                    <h3>Ничего не найдено</h3>
                    <p>Попробуйте изменить поисковый запрос</p>
                `;
                document.getElementById('servicesList').appendChild(noResultsMsg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    });
</script>
@endpush