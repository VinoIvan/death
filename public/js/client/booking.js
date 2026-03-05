// Функции для страницы бронирования

import { formatDate, formatTime, showNotification, debounce } from '../shared/utils.js';

document.addEventListener('DOMContentLoaded', function() {
    initServiceSelection();   
    initDateSelection();
    initBookingForm();
    initPhoneMask();
});

// Выбор услуги
function initServiceSelection() {
    const serviceRadios = document.querySelectorAll('input[name="service_id"]');
    
    serviceRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('serviceForm').submit();  // Отправка формы при выборе услуги
        });
    });

    // Подсветка выбранной услуги
    const selectedService = document.querySelector('input[name="service_id"]:checked');
    if (selectedService) {
        const card = selectedService.closest('.service-card');
        if (card) card.classList.add('selected');
    }
}

// Выбор даты
function initDateSelection() {
    const dateCards = document.querySelectorAll('.date-card');
    
    dateCards.forEach(card => {
        card.addEventListener('click', function() {
            const date = this.dataset.date;
            
            // Убираем активный класс у всех
            dateCards.forEach(c => c.classList.remove('active'));
            
            // Добавляем активный класс выбранной дате
            this.classList.add('active');
            
            // Сохраняем выбранную дату
            sessionStorage.setItem('selectedDate', date);
            
            // Показываем слоты времени для выбранной даты
            loadTimeSlots(date);
        });
    });

    // Восстанавливаем выбранную дату из сессии
    const savedDate = sessionStorage.getItem('selectedDate');
    if (savedDate) {
        const dateCard = document.querySelector(`.date-card[data-date="${savedDate}"]`);
        if (dateCard) {
            setTimeout(() => {
                dateCard.click();
            }, 100);
        }
    }
}

// Загрузка слотов времени
async function loadTimeSlots(date) {
    const timeSection = document.getElementById('timeSection');
    const timeGrid = document.getElementById('timeGrid');
    const serviceId = new URLSearchParams(window.location.search).get('service_id');
    
    if (!timeSection || !timeGrid) return;
    
    timeSection.style.display = 'block';
    timeGrid.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Загрузка...</div>';
    
    try {
        // Очищаем дату от возможного времени
        const cleanDate = date.split(' ')[0];
        const url = `/api/slots?date=${cleanDate}${serviceId ? `&service_id=${serviceId}` : ''}`;
        console.log('Fetching slots from:', url);
        
        const response = await fetch(url);
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server response:', errorText);
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const slots = await response.json();
        console.log('Received slots:', slots);
        
        if (slots.length === 0) {
            timeGrid.innerHTML = '<div class="text-center py-4 text-muted">Нет доступного времени</div>';
            return;
        }
        
        timeGrid.innerHTML = '';
        slots.forEach(slot => {
            const timeSlot = createTimeSlot(slot);
            timeGrid.appendChild(timeSlot);
        });
        
    } catch (error) {
        console.error('Error loading slots:', error);
        timeGrid.innerHTML = '<div class="text-center py-4 text-danger">Ошибка загрузки. Пожалуйста, обновите страницу.</div>';
    }
}

// Создание элемента слота времени
function createTimeSlot(slot) {
    const div = document.createElement('div');
    div.className = 'time-slot available';
    div.textContent = slot.start_time.substring(0, 5);
    div.dataset.id = slot.id;
    div.dataset.time = slot.start_time;
    
    div.addEventListener('click', () => selectTimeSlot(slot.id));
    
    return div;
}

// Выбор времени
function selectTimeSlot(slotId) {
    const serviceId = new URLSearchParams(window.location.search).get('service_id');
    window.location.href = `/booking/create?service_id=${serviceId}&schedule_id=${slotId}`;
}

// Маска для телефона
function initPhoneMask() {
    const phoneInput = document.getElementById('client_phone');
    if (!phoneInput) return;

    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > 0) {
            if (value.startsWith('7') || value.startsWith('8')) {
                value = value.substring(1);
            }
            
            let formattedValue = '+7';
            
            if (value.length > 0) {
                formattedValue += ' (' + value.substring(0, 3);
            }
            if (value.length >= 4) {
                formattedValue += ') ' + value.substring(3, 6);
            }
            if (value.length >= 7) {
                formattedValue += '-' + value.substring(6, 8);
            }
            if (value.length >= 9) {
                formattedValue += '-' + value.substring(8, 10);
            }
            
            e.target.value = formattedValue;
        } else {
            e.target.value = '';
        }
    });
}

// Валидация формы бронирования
function initBookingForm() {
    const bookingForm = document.querySelector('.booking-form form');
    
    if (bookingForm) {
        bookingForm.addEventListener('submit', validateBookingForm);
    }
}

function validateBookingForm(e) {
    const name = document.getElementById('client_name');
    const phone = document.getElementById('client_phone');
    const email = document.getElementById('client_email');
    let isValid = true;

    // Валидация имени
    if (!name.value || name.value.length < 2) {
        showFieldError(name, 'Введите имя');
        isValid = false;
    } else {
        removeFieldError(name);
    }

    // Валидация телефона
    const phoneRegex = /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/;
    if (!phone.value || !phoneRegex.test(phone.value)) {
        showFieldError(phone, 'Введите корректный телефон');
        isValid = false;
    } else {
        removeFieldError(phone);
    }

    // Валидация email (если заполнен)
    if (email.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            showFieldError(email, 'Введите корректный email');
            isValid = false;
        } else {
            removeFieldError(email);
        }
    }

    if (!isValid) {
        e.preventDefault();
    }
}

function showFieldError(field, message) {
    field.classList.add('is-invalid');
    
    let errorDiv = field.nextElementSibling;
    if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        field.parentNode.appendChild(errorDiv);
    }
    errorDiv.textContent = message;
}

function removeFieldError(field) {
    field.classList.remove('is-invalid');
    const errorDiv = field.nextElementSibling;
    if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
        errorDiv.remove();
    }
}