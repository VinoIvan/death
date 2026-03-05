// Функции для личного кабинета

import { showNotification, debounce, formatPhone } from '../shared/utils.js';

document.addEventListener('DOMContentLoaded', function() {
    initPasswordChange();
    initProfileEdit();
    initAppointmentCancellation();
    initReviewSubmission();
    initPhoneMask();
});

// Смена пароля
function initPasswordChange() {
    const passwordForm = document.querySelector('form[action*="password"]');
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', validatePasswordForm);
    }
    
    initPasswordStrengthMeter();
    initPasswordToggle();
}

function validatePasswordForm(e) {
    const currentPassword = document.getElementById('current_password');
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');
    let isValid = true;

    if (!currentPassword.value) {
        showFieldError(currentPassword, 'Введите текущий пароль');
        isValid = false;
    } else {
        removeFieldError(currentPassword);
    }

    if (!newPassword.value || newPassword.value.length < 8) {
        showFieldError(newPassword, 'Пароль должен быть не менее 8 символов');
        isValid = false;
    } else {
        removeFieldError(newPassword);
    }

    if (newPassword.value !== confirmPassword.value) {
        showFieldError(confirmPassword, 'Пароли не совпадают');
        isValid = false;
    } else {
        removeFieldError(confirmPassword);
    }

    if (!isValid) {
        e.preventDefault();
    }
}

function initPasswordStrengthMeter() {
    const passwordInput = document.getElementById('new_password');
    const meter = document.querySelector('.strength-meter-fill');
    const text = document.querySelector('.strength-text');
    const requirements = document.querySelectorAll('.requirement');

    if (passwordInput && meter) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            // Проверка требований
            const checks = {
                length: password.length >= 8,
                lowercase: /[a-z]/.test(password),
                uppercase: /[A-Z]/.test(password),
                number: /[0-9]/.test(password)
            };

            // Обновление иконок требований
            requirements.forEach(req => {
                const type = req.dataset.require;
                if (checks[type]) {
                    req.classList.add('valid');
                    req.querySelector('i').className = 'fas fa-check-circle me-2';
                } else {
                    req.classList.remove('valid');
                    req.querySelector('i').className = 'fas fa-circle me-2';
                }
            });

            // Расчет силы пароля
            if (checks.length) strength += 25;
            if (checks.lowercase) strength += 25;
            if (checks.uppercase) strength += 25;
            if (checks.number) strength += 25;

            meter.style.width = strength + '%';

            if (strength <= 25) {
                meter.style.background = '#dc3545';
                if (text) text.textContent = 'Слабый пароль';
            } else if (strength <= 50) {
                meter.style.background = '#ffc107';
                if (text) text.textContent = 'Средний пароль';
            } else if (strength <= 75) {
                meter.style.background = '#17a2b8';
                if (text) text.textContent = 'Хороший пароль';
            } else {
                meter.style.background = '#28a745';
                if (text) text.textContent = 'Надежный пароль';
            }
        });
    }
}

function initPasswordToggle() {
    document.querySelectorAll('.password-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'far fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'far fa-eye';
            }
        });
    });
}

// Редактирование профиля
function initProfileEdit() {
    const profileForm = document.querySelector('.profile-form');
    
    if (profileForm) {
        profileForm.addEventListener('submit', validateProfileForm);
    }
}

function validateProfileForm(e) {
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    let isValid = true;

    if (!name.value || name.value.length < 2) {
        showFieldError(name, 'Введите имя');
        isValid = false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value || !emailRegex.test(email.value)) {
        showFieldError(email, 'Введите корректный email');
        isValid = false;
    }

    const phoneRegex = /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/;
    if (!phone.value || !phoneRegex.test(phone.value)) {
        showFieldError(phone, 'Введите корректный телефон');
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
    }
}

function initPhoneMask() {
    const phoneInput = document.getElementById('phone');
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

// Отмена записи
function initAppointmentCancellation() {
    document.querySelectorAll('.cancel-appointment').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            
            if (!confirm('Вы уверены, что хотите отменить запись?')) {
                return;
            }
            
            const appointmentId = this.dataset.id;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            try {
                const response = await fetch(`/profile/cancel-appointment/${appointmentId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotification('Запись успешно отменена', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(data.message || 'Ошибка при отмене записи', 'danger');
                }
                
            } catch (error) {
                console.error('Error:', error);
                showNotification('Ошибка при отмене записи', 'danger');
            }
        });
    });
}

// Отправка отзыва
function initReviewSubmission() {
    const reviewForm = document.getElementById('reviewForm');
    
    if (reviewForm) {
        reviewForm.addEventListener('submit', validateReviewForm);
    }
    
    initRatingSelection();
    initCharCounter();
}

function validateReviewForm(e) {
    const rating = document.querySelector('input[name="rating"]:checked');
    const comment = document.getElementById('comment');
    let isValid = true;

    if (!rating) {
        showFieldError(document.querySelector('.rating-input'), 'Поставьте оценку');
        isValid = false;
    }

    if (!comment.value || comment.value.length < 10) {
        showFieldError(comment, 'Отзыв должен содержать минимум 10 символов');
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
    }
}

function initRatingSelection() {
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    const ratingText = document.getElementById('ratingText');
    
    const messages = {
        5: 'Отлично!',
        4: 'Хорошо',
        3: 'Нормально',
        2: 'Плохо',
        1: 'Ужасно'
    };
    
    ratingInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked && ratingText) {
                ratingText.innerHTML = `<span style="color: var(--primary-color);">${messages[this.value]}</span>`;
            }
        });
    });
}

function initCharCounter() {
    const commentInput = document.getElementById('comment');
    const counter = document.getElementById('charCount');
    
    if (commentInput && counter) {
        commentInput.addEventListener('input', function() {
            counter.textContent = this.value.length;
        });
    }
}

// Удаление отзыва
window.deleteReview = function(id) {
    if (!confirm('Удалить отзыв?')) return;
    
    const form = document.getElementById('deleteReviewForm');
    form.action = `/reviews/${id}`;
    form.submit();
};

// Вспомогательные функции
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