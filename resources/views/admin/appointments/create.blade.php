@extends('admin.layouts.admin')

@section('title', 'Создание записи - VCM Laser')
@section('page-title', 'Создание новой записи')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/appointments-create.css') }}">
<style>
    select.form-select option[disabled][selected] {
        color: var(--primary-color) !important;
        font-weight: 500;
    }
    
    select.form-select option:disabled {
        color: var(--gray-400);
    }
</style>
@endpush

@section('content')
<div class="appointments-create-container">
    <div class="page-header">
        <a href="{{ route('admin.appointments.index') }}" class="btn-site">
            Назад к списку
        </a>
    </div>

    {{-- Форма создания записи --}}
    <div class="form-container">
        <form action="{{ route('admin.appointments.store') }}" method="POST" class="admin-form">
            @csrf

            {{-- Информация о записи --}}
            <div class="form-section">
                <h3 class="form-section-title">Информация о записи</h3>
                
                <div class="form-row">
                    {{-- Выбор услуги --}}
                    <div class="form-group">
                        <label for="service_id" class="form-label">Услуга <span class="text-danger">*</span></label>
                        <select class="form-select @error('service_id') is-invalid @enderror" 
                                id="service_id" 
                                name="service_id" 
                                required>
                            <option value="" disabled selected>— Выберите услугу —</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} — {{ number_format($service->price, 0, ',', ' ') }} ₽ ({{ $service->duration }} мин)
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Выбор даты (загружается через JS) --}}
                    <div class="form-group">
                        <label for="appointment_date" class="form-label">Дата <span class="text-danger">*</span></label>
                        <select class="form-select @error('appointment_date') is-invalid @enderror" 
                                id="appointment_date" 
                                name="appointment_date" 
                                required disabled>
                            <option value="" disabled selected>— Сначала выберите услугу —</option>
                        </select>
                        @error('appointment_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    {{-- Выбор времени (загружается через JS) --}}
                    <div class="form-group">
                        <label for="schedule_id" class="form-label">Время <span class="text-danger">*</span></label>
                        <select class="form-select @error('schedule_id') is-invalid @enderror" 
                                id="schedule_id" 
                                name="schedule_id" 
                                required disabled>
                            <option value="" disabled selected>— Сначала выберите дату —</option>
                        </select>
                        @error('schedule_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Выбор статуса --}}
                    <div class="form-group">
                        <label for="status_id" class="form-label">Статус <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_id') is-invalid @enderror" 
                                id="status_id" 
                                name="status_id" 
                                required>
                            <option value="" disabled selected>— Выберите статус —</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Информация о клиенте --}}
            <div class="form-section">
                <h3 class="form-section-title">Информация о клиенте</h3>
                
                <div class="form-row">
                    {{-- Имя клиента --}}
                    <div class="form-group">
                        <label for="client_name" class="form-label">Имя клиента <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('client_name') is-invalid @enderror" 
                               id="client_name" 
                               name="client_name" 
                               value="{{ old('client_name') }}" 
                               placeholder="Введите имя клиента"
                               required>
                        @error('client_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Телефон клиента --}}
                    <div class="form-group">
                        <label for="client_phone" class="form-label">Телефон <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('client_phone') is-invalid @enderror" 
                               id="client_phone" 
                               name="client_phone" 
                               value="{{ old('client_phone') }}" 
                               placeholder="+7 (999) 123-45-67"
                               required>
                        @error('client_phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    {{-- Email клиента --}}
                    <div class="form-group">
                        <label for="client_email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('client_email') is-invalid @enderror" 
                               id="client_email" 
                               name="client_email" 
                               value="{{ old('client_email') }}" 
                               placeholder="client@example.com">
                        @error('client_email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Комментарий --}}
                <div class="form-group">
                    <label for="comment" class="form-label">Комментарий</label>
                    <textarea class="form-control @error('comment') is-invalid @enderror" 
                              id="comment" 
                              name="comment" 
                              rows="4" 
                              placeholder="Дополнительная информация или пожелания...">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Кнопки действий --}}
            <div class="form-actions">
                <a href="{{ route('admin.appointments.index') }}" class="btn-site">Отмена</a>
                <button type="submit" class="btn-site-solid">Создать запись</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    {{-- Маска для телефона --}}
    document.getElementById('client_phone')?.addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        e.target.value = !x[2] ? x[1] : 
            '+7 (' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });

    {{-- Элементы формы --}}
    const serviceSelect = document.getElementById('service_id');
    const dateSelect = document.getElementById('appointment_date');
    const timeSelect = document.getElementById('schedule_id');

    {{-- Функция для извлечения даты из ISO строки --}}
    function extractDateFromISO(isoString) {
        if (isoString && isoString.includes('T')) {
            return isoString.split('T')[0];
        }
        return isoString;
    }

    {{-- Загрузка доступных дат при выборе услуги --}}
    serviceSelect.addEventListener('change', function() {
        const serviceId = this.value;
        
        if (!serviceId) {
            dateSelect.innerHTML = '<option value="" disabled selected>— Сначала выберите услугу —</option>';
            dateSelect.disabled = true;
            timeSelect.innerHTML = '<option value="" disabled selected>— Сначала выберите дату —</option>';
            timeSelect.disabled = true;
            return;
        }
        
        dateSelect.innerHTML = '<option value="" disabled selected>— Загрузка... —</option>';
        dateSelect.disabled = true;
        timeSelect.innerHTML = '<option value="" disabled selected>— Сначала выберите дату —</option>';
        timeSelect.disabled = true;
        
        fetch(`/ad/api/slots?service_id=${serviceId}`)
            .then(response => response.json())
            .then(data => {
                const dates = {};
                data.forEach(slot => {
                    const cleanDate = extractDateFromISO(slot.date);
                    if (!dates[cleanDate]) {
                        dates[cleanDate] = [];
                    }
                    dates[cleanDate].push({
                        ...slot,
                        cleanDate: cleanDate
                    });
                });
                
                dateSelect.innerHTML = '<option value="" disabled selected>— Выберите дату —</option>';
                
                Object.keys(dates).sort().forEach(dateStr => {
                    const option = document.createElement('option');
                    option.value = dateStr;
                    
                    const [year, month, day] = dateStr.split('-');
                    const formattedDate = `${day}.${month}.${year}`;
                    
                    option.textContent = formattedDate;
                    dateSelect.appendChild(option);
                });
                
                dateSelect.disabled = false;
                dateSelect.dataset.slots = JSON.stringify(data);
            })
            .catch(error => {
                console.error('Error loading slots:', error);
                dateSelect.innerHTML = '<option value="" disabled selected>— Ошибка загрузки —</option>';
                dateSelect.disabled = false;
            });
    });

    {{-- Загрузка доступного времени при выборе даты --}}
    dateSelect.addEventListener('change', function() {
        const selectedDate = this.value;
        const slots = JSON.parse(this.dataset.slots || '[]');
        
        if (!selectedDate || !slots.length) {
            timeSelect.innerHTML = '<option value="" disabled selected>— Нет доступного времени —</option>';
            timeSelect.disabled = true;
            return;
        }
        
        const timeSlots = slots.filter(slot => {
            const slotDate = extractDateFromISO(slot.date);
            return slotDate === selectedDate;
        });
        
        timeSelect.innerHTML = '<option value="" disabled selected>— Выберите время —</option>';
        
        timeSlots.forEach(slot => {
            const option = document.createElement('option');
            option.value = slot.id;
            
            const startTime = slot.start_time.substring(0,5);
            const endTime = slot.end_time.substring(0,5);
            
            option.textContent = `${startTime} — ${endTime}`;
            timeSelect.appendChild(option);
        });
        
        timeSelect.disabled = false;
    });
</script>
@endpush
@endsection