// Функции для страниц авторизации

import { formatPhone, isValidEmail, isValidPhone, showFieldError, removeFieldError } from '../shared/utils.js';

document.addEventListener('DOMContentLoaded', function() {
    initPasswordToggles();
    initPhoneMask();
    initFormValidation();
});

// Показ/скрытие пароля
function initPasswordToggles() {
    document.querySelectorAll('.password-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-wrapper, .input-group').querySelector('input');
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

// Маска для телефона
function initPhoneMask() {
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
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

        phoneInput.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' || e.key === 'Delete') {
                let value = this.value.replace(/\D/g, '');
                if (value.length <= 1) {
                    this.value = '';
                }
            }
        });
    }
}

// Валидация форм
function initFormValidation() {
    const loginForm = document.querySelector('form[action*="login"]');
    const registerForm = document.getElementById('registerForm');

    if (loginForm) {
        loginForm.addEventListener('submit', validateLoginForm);
    }

    if (registerForm) {
        registerForm.addEventListener('submit', validateRegisterForm);
    }
}

function validateLoginForm(e) {
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    let isValid = true;

    // Валидация email
    if (!email.value || !isValidEmail(email.value)) {
        showFieldError(email, 'Введите корректный email');
        isValid = false;
    } else {
        removeFieldError(email);
    }

    // Валидация пароля
    if (!password.value || password.value.length < 6) {
        showFieldError(password, 'Пароль должен быть не менее 6 символов');
        isValid = false;
    } else {
        removeFieldError(password);
    }

    if (!isValid) {
        e.preventDefault();
    }
}

function validateRegisterForm(e) {
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    const agree = document.querySelector('input[name="agree"]');
    let isValid = true;

    // Валидация имени
    if (!name.value || name.value.length < 2) {
        showFieldError(name, 'Введите имя (минимум 2 символа)');
        isValid = false;
    } else {
        removeFieldError(name);
    }

    // Валидация email
    if (!email.value || !isValidEmail(email.value)) {
        showFieldError(email, 'Введите корректный email');
        isValid = false;
    } else {
        removeFieldError(email);
    }

    // Валидация телефона
    if (!phone.value || !isValidPhone(phone.value)) {
        showFieldError(phone, 'Введите корректный номер телефона');
        isValid = false;
    } else {
        removeFieldError(phone);
    }

    // Валидация пароля - только проверка длины
    if (!password.value || password.value.length < 8) {
        showFieldError(password, 'Пароль должен быть не менее 8 символов');
        isValid = false;
    } else {
        removeFieldError(password);
    }

    // Проверка совпадения паролей
    if (password.value !== passwordConfirm.value) {
        showFieldError(passwordConfirm, 'Пароли не совпадают');
        isValid = false;
    } else {
        removeFieldError(passwordConfirm);
    }

    // Проверка согласия
    if (!agree || !agree.checked) {
        showFieldError(agree, 'Необходимо согласие с условиями');
        isValid = false;
    } else {
        removeFieldError(agree);
    }

    if (!isValid) {
        e.preventDefault();
    }
}