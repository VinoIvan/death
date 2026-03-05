@extends('client.layouts.app')

@section('title', 'VCM Laser - Салон лазерной эпиляции в Москве')
@section('description', 'Профессиональная лазерная эпиляция в салоне VCM Laser. Безболезненно, безопасно, навсегда.')

@section('content')
{{-- Hero секция --}}
<section class="hero-section">
    {{-- Фоновое изображение с затемнением --}}
    <div class="hero-background">
        <img src="{{ asset('images/hero-bg.jpg') }}" alt="Лазерная эпиляция" class="hero-bg-image">
        <div class="hero-overlay"></div>
    </div>
    
    <div class="container">
        <div class="hero-grid">
            {{-- Левая колонка с текстом --}}
            <div class="hero-content">
                <h1 class="hero-title">
                    Лазерная эпиляция<br>в Москве
                </h1>
                <p class="hero-subtitle">
                    Безболезненно · Безопасно · Навсегда
                </p>
                
                <p class="hero-text-large">
                    Избавим от нежелательных волос навсегда
                </p>
                
                {{-- Объединенная строка с текстом и кнопкой --}}
                <div class="hero-row">
                    <p class="hero-text-medium">
                        Студия лазерной эпиляции и аппаратного массажа
                    </p>
                    
                    {{-- Оффер и кнопка в две колонки --}}
                    <div class="hero-offer-row">
                        <span class="hero-offer-text">
                            Запишитесь на первое посещение <span class="highlight">со скидкой -30%</span>
                        </span>
                        <a href="{{ route('booking.index') }}" class="hero-button">
                            Записаться
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- Правая колонка с фото --}}
            <div class="hero-image-wrapper">
                <div class="hero-image-circle">
                    <img src="{{ asset('images/hero-circle.jpg') }}" alt="Лазерная эпиляция" class="hero-circle-img">
                </div>
            </div>
        </div>
        
        {{-- Статистика поверх фонового изображения --}}
        <div class="hero-stats-row">
            <div class="hero-stat-item">
                <div class="hero-stat-number">500+</div>
                <div class="hero-stat-label">Довольных клиентов</div>
            </div>
            <div class="hero-stat-item">
                <div class="hero-stat-number">5 лет</div>
                <div class="hero-stat-label">Опыта работы</div>
            </div>
            <div class="hero-stat-item">
                <div class="hero-stat-number">100%</div>
                <div class="hero-stat-label">Гарантия качества</div>
            </div>
        </div>
    </div>
</section>

{{-- Секция услуг --}}
<section class="services-section">
    <div class="container">
        <div class="services-header">
            <h2 class="services-title">Наши услуги</h2>
            <p class="services-subtitle">Выберите процедуру и запишитесь на удобное время</p>
        </div>

        <div class="services-list">
            @foreach($services->take(3) as $service)
            <div class="service-item">
                <div class="service-info">
                    <div class="service-name">{{ $service->name }}</div>
                    <div class="service-description">{{ Str::limit($service->description, 80) }}</div>
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

        <div class="services-footer">
            <a href="{{ route('services.index') }}" class="btn-outline">
                Все услуги
            </a>
        </div>
    </div>
</section>

{{-- Секция отзывов --}}
<section class="reviews-section">
    <div class="container">
        <div class="reviews-header">
            <h2 class="reviews-title">Отзывы наших клиентов</h2>
            <p class="reviews-subtitle">Реальные впечатления тех, кто уже посетил наш салон</p>
        </div>

        @if($reviews->count() > 0)
        <div class="reviews-list">
            @foreach($reviews->take(3) as $review)
            <div class="review-item">
                <div class="review-info">
                    <div class="review-author">{{ $review->user->name }}</div>
                    <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="review-content">"{{ $review->comment }}"</div>
                    <div class="review-meta">
                        <span class="review-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ $review->created_at->format('d.m.Y') }}
                        </span>
                        @if($review->appointment && $review->appointment->service)
                        <span class="review-service">
                            {{ $review->appointment->service->name }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="reviews-footer">
            <a href="{{ route('reviews.index') }}" class="btn-outline">
                Все отзывы
            </a>
        </div>
        @else
        {{-- Пустое состояние для отзывов --}}
        <div class="text-center py-5">
            <i class="fas fa-star fa-3x text-muted mb-3"></i>
            <h5 class="fs-4">Пока нет отзывов</h5>
            <p class="text-muted fs-5">Будьте первым, кто оставит отзыв!</p>
            @auth
            <a href="{{ route('reviews.create') }}" class="btn-outline mt-3">
                Оставить отзыв
            </a>
            @endauth
        </div>
        @endif
    </div>
</section>

{{-- Секция специального предложения --}}
<section class="offer-section">
    <div class="container">
        <div class="offer-card">
            <div class="offer-content">
                <div class="offer-text">
                    <h3 class="offer-title">Специальное предложение</h3>
                    <div class="offer-highlight">Первая процедура</div>
                    <p class="offer-description">со скидкой 30% для новых клиентов</p>
                    <a href="{{ route('booking.index') }}" class="offer-button">
                        Получить скидку
                    </a>
                </div>
                <div class="offer-badge-wrapper">
                    <div class="offer-badge">
                        <span>-30%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Секция FAQ --}}
<section class="faq-section">
    <div class="container">
        {{-- Заголовок по центру --}}
        <div class="faq-header">
            <h2 class="faq-header-title">Вы часто спрашиваете нас!</h2>
            <p class="faq-header-subtitle">Ответы на самые популярные вопросы о лазерной эпиляции</p>
        </div>

        <div class="faq-wrapper">
            {{-- Левая колонка с фото --}}
            <div class="faq-left">
                <div class="faq-left-image">
                    <img src="{{ asset('images/faq-laser.jpg') }}" alt="Лазерная эпиляция" class="img-fluid">
                </div>
            </div>
            
            {{-- Правая колонка с вопросами --}}
            <div class="faq-right">
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h3>Лазерная эпиляция — это больно?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Современные лазеры оснащены системой охлаждения, что делает процедуру максимально комфортной. Большинство клиентов отмечают лишь легкое покалывание или тепло. Наши мастера подбирают индивидуальные настройки для каждого клиента, чтобы минимизировать дискомфорт.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h3>На каком лазере вы работаете?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Мы работаем на современном диодном лазере с тройной системой охлаждения. Это оборудование премиум-класса, которое подходит для всех типов кожи и волос.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h3>Как подготовиться к процедуре?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>За 2-3 дня до процедуры нужно сбрить волосы (длина должна быть 1-2 мм). За 2 недели исключить загар и не использовать автозагар. Не использовать кремы с ретинолом за 3-5 дней до процедуры. В день процедуры кожа должна быть чистой, без косметики.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h3>Почему стоит попробовать лазерную эпиляцию?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Лазерная эпиляция — это долговременный результат, отсутствие вросших волос, раздражения и экономия времени на бритье. После курса процедур вы забудете о нежелательных волосах навсегда.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h3>Лазерная эпиляция — это навсегда?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Да, после полного курса процедур волосы удаляются навсегда. Однако под воздействием гормональных изменений может потребоваться поддерживающая терапия раз в полгода-год.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h3>Когда будет виден результат?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Первые результаты видны уже после первой процедуры — волосы становятся тоньше и светлее, их рост замедляется. Полный эффект достигается после курса из 6-8 процедур.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/client/home.css') }}">
@endpush

@push('scripts')
<script>
    // Функция для открытия/закрытия FAQ
    function toggleFaq(element) {
        const faqItem = element.closest('.faq-item');
        
        // Закрываем все другие открытые FAQ
        document.querySelectorAll('.faq-item.active').forEach(item => {
            if (item !== faqItem) {
                item.classList.remove('active');
            }
        });
        
        // Открываем/закрываем текущий FAQ
        faqItem.classList.toggle('active');
    }

    // Обновление AOS анимаций после загрузки DOM
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.refresh();
        }
    });
</script>
@endpush