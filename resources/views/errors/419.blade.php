@extends('client.layouts.app')

@section('title', 'Сессия истекла - VCM Laser')

@section('content')
<div class="error-container">
    <div class="error-content">
        <div class="error-icon">
            <i class="fas fa-clock"></i>
        </div>
        <h1 class="error-code">419</h1>
        <h2 class="error-title">Время сессии истекло</h2>
        <p class="error-message">
            Пожалуйста, обновите страницу и попробуйте снова.
        </p>
        <div class="error-actions">
            <a href="{{ url()->current() }}" class="btn-site">Обновить страницу</a>
            <a href="{{ route('home') }}" class="btn-site-outline">На главную</a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .error-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: linear-gradient(135deg, var(--primary-bg) 0%, var(--accent-bg) 100%);
        position: relative;
        overflow: hidden;
    }

    .error-container::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(139,76,85,0.1) 0%, transparent 70%);
        top: -200px;
        right: -200px;
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .error-container::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(235,215,214,0.2) 0%, transparent 70%);
        bottom: -150px;
        left: -150px;
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    .error-content {
        max-width: 600px;
        text-align: center;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius-lg);
        padding: 3rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255, 255, 255, 0.5);
        position: relative;
        z-index: 1;
    }

    .error-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #ffc107, #d39e00);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 3rem;
        animation: pulse 2s ease-in-out infinite;
    }

    .error-code {
        font-size: 5rem;
        font-weight: 700;
        color: #ffc107;
        line-height: 1;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .error-title {
        font-size: 2rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 1rem;
    }

    .error-message {
        color: var(--gray-600);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .error-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .btn-site {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        transition: background-color 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-site:hover {
        background: var(--primary-hover);
    }

    .btn-site-outline {
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 0.8rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-site-outline:hover {
        background: var(--primary-color);
        color: white;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @media (max-width: 768px) {
        .error-content {
            padding: 2rem;
        }

        .error-code {
            font-size: 4rem;
        }

        .error-title {
            font-size: 1.5rem;
        }

        .error-actions {
            flex-direction: column;
        }

        .btn-site, .btn-site-outline {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush