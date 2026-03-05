// Ждем загрузки DOM
document.addEventListener('DOMContentLoaded', function() {
    autoHideAlerts();
});

function autoHideAlerts() {
    setTimeout(function() {
        // Находим все уведомления
        const alerts = document.querySelectorAll('.admin-alert');
        
        // Для каждого уведомления
        alerts.forEach(function(alert) {
            // Запускаем анимацию скрытия
            alert.style.animation = 'slideOut 0.3s ease forwards';
            
            // После завершения анимации удаляем элемент
            setTimeout(function() {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 300);
        });
    }, 5000); // 5 секунд
}