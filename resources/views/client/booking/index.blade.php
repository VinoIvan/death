@extends('client.layouts.app')

@section('title', 'Запись на процедуру - VCM Laser')
@section('description', 'Онлайн запись на лазерную эпиляцию в салоне VCM Laser. Выберите услугу и удобное время.')

@section('content')
<div class="booking-container">
    <div class="booking-header">
        <h1>Запись на процедуру</h1>
        <p>Выберите услугу и удобное время</p>
    </div>

    {{-- Индикатор шагов --}}
    <div class="booking-progress">
        <div class="progress-step active">
            <span>1</span>
            <div class="step-label">Услуга</div>
        </div>
        <div class="progress-step">
            <span>2</span>
            <div class="step-label">Время</div>
        </div>
        <div class="progress-step">
            <span>3</span>
            <div class="step-label">Данные</div>
        </div>
    </div>

    {{-- Выбор услуги --}}
    <form action="{{ route('booking.index') }}" method="GET" id="serviceForm">
        <div class="services-list">
            @foreach($services as $service)
            <div class="service-card {{ $selectedService && $selectedService->id == $service->id ? 'selected' : '' }}">
                <label class="service-card-label">
                    <input type="radio" 
                           name="service_id" 
                           value="{{ $service->id }}"
                           {{ $selectedService && $selectedService->id == $service->id ? 'checked' : '' }}
                           onchange="this.form.submit()">
                    <div class="service-card-content">
                        <div class="service-card-info">
                            <div class="service-card-name">{{ $service->name }}</div>
                            <div class="service-card-description">{{ Str::limit($service->description, 100) }}</div>
                        </div>
                        <div class="service-card-meta">
                            <span class="service-card-price">{{ number_format($service->price, 0, ',', ' ') }} ₽</span>
                            <span class="service-card-duration">
                                <i class="far fa-clock"></i>
                                {{ $service->duration }} мин
                            </span>
                        </div>
                    </div>
                </label>
            </div>
            @endforeach
        </div>
    </form>

    {{-- Выбор даты --}}
    @if($selectedService)
        @if(count($availableDates) > 0)
            <div class="date-section">
                <h3>Выберите дату</h3>
                <div class="date-grid">
                    @foreach($availableDates as $date => $slots)
                        @php
                            $dateObj = \Carbon\Carbon::parse($date);
                            $isToday = $dateObj->isToday();
                        @endphp
                        <div class="date-card {{ $isToday ? 'today' : '' }}"
                             data-date="{{ $date }}"
                             onclick="selectDate('{{ $date }}')">
                            <span class="date-day">{{ $dateObj->format('d') }}</span>
                            <span class="date-month">{{ $dateObj->format('M') }}</span>
                            <span class="date-weekday">{{ $dateObj->isoFormat('dd') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Блок с выбором времени (заполняется через JS) --}}
            <div class="time-section" id="timeSection" style="display: none;">
                <h3>Выберите время</h3>
                <div class="time-grid" id="timeGrid"></div>
            </div>
        @else
            {{-- Нет свободного времени --}}
            <div class="booking-info">
                <p>Нет свободного времени на выбранную услугу</p>
            </div>
        @endif
    @else
        {{-- Услуга не выбрана --}}
        <div class="booking-info">
            <p>Выберите услугу для продолжения</p>
        </div>
    @endif
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/client/booking.css') }}">
@endpush

@push('scripts')
<script>
    // Доступные слоты из PHP
    const availableSlots = @json($availableDates ?? []);
    
    // Функция выбора даты
    function selectDate(date) {
        // Убираем активный класс у всех карточек дат
        document.querySelectorAll('.date-card').forEach(card => {
            card.classList.remove('active');
        });
        
        // Добавляем активный класс выбранной дате
        event.currentTarget.classList.add('active');
        
        // Показываем секцию с временем
        const timeSection = document.getElementById('timeSection');
        const timeGrid = document.getElementById('timeGrid');
        
        timeSection.style.display = 'block';
        timeGrid.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Загрузка...</div>';
        
        // Получаем слоты для выбранной даты
        const slots = availableSlots[date] || [];
        
        if (slots.length === 0) {
            timeGrid.innerHTML = '<div class="text-center py-4 text-muted">Нет доступного времени</div>';
            return;
        }
        
        // Отображаем доступные слоты времени
        timeGrid.innerHTML = '';
        slots.forEach(slot => {
            const timeSlot = document.createElement('button');
            timeSlot.className = 'time-slot available';
            timeSlot.textContent = slot.start_time.substring(0, 5);
            timeSlot.onclick = () => selectTime(slot.id);
            timeGrid.appendChild(timeSlot);
        });
    }
    
    // Функция выбора времени
    function selectTime(scheduleId) {
        const serviceId = new URLSearchParams(window.location.search).get('service_id');
        window.location.href = `/booking/create?service_id=${serviceId}&schedule_id=${scheduleId}`;
    }
    
    // Автоматический выбор сохраненной даты
    @if(session('selected_date'))
    setTimeout(() => {
        selectDate('{{ session("selected_date") }}');
    }, 100);
    @endif
</script>
@endpush