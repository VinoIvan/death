// Основные функции для клиентской части

import { debounce, showNotification } from '../shared/utils.js';

document.addEventListener('DOMContentLoaded', function() {
    initNavbarScroll();
    initMobileMenu();
    initSmoothScroll();
    initTooltips();
    initAOS();
});

// Изменение навбара при скролле
function initNavbarScroll() {
    const navbar = document.getElementById('mainNav');
    if (!navbar) return;

    window.addEventListener('scroll', debounce(function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }, 10));
}

// Мобильное меню
function initMobileMenu() {
    const toggler = document.querySelector('.navbar-toggler');
    const menu = document.getElementById('navbarMain');
    const navLinks = document.querySelectorAll('.nav-link');

    if (toggler && menu) {
        // Открытие/закрытие меню
        toggler.addEventListener('click', function() {
            menu.classList.toggle('show');
        });

        // Закрытие меню при клике на ссылку
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.remove('show');
            });
        });

        // Закрытие меню при клике вне области
        document.addEventListener('click', function(event) {
            if (!menu.contains(event.target) && !toggler.contains(event.target)) {
                menu.classList.remove('show');
            }
        });
    }
}

// Плавный скролл к якорям
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Инициализация тултипов Bootstrap
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    if (tooltips.length > 0 && typeof bootstrap !== 'undefined') {
        tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));
    }
}

// Инициализация AOS анимаций
function initAOS() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });
    }
}

// Анимация появления элементов при скролле
export function observeElements() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Если элемент с анимацией счетчика
                if (entry.target.classList.contains('counter')) {
                    animateCounter(entry.target);
                }
            }
        });
    }, { 
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('.fade-in, .slide-in, .counter').forEach(el => {
        observer.observe(el);
    });
}

// Анимация счетчиков
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target') || element.textContent);
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Ленивая загрузка изображений
export function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
}

// Инициализация при загрузке страницы
window.addEventListener('load', function() {
    observeElements();
    lazyLoadImages();
});