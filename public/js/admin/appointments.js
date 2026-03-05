// Функции для управления записями
document.addEventListener('DOMContentLoaded', function() {
    initFilters();
    initStatusChange();
    initBulkActions();
    initCalendar();
    initSearch();
    initDatePicker();
});

// Фильтры
function initFilters() {
    const filterForm = document.querySelector('.filters-form');
    if (!filterForm) return;

    filterForm.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', () => filterForm.submit());
    });

    const searchInput = filterForm.querySelector('input[type="search"], input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            filterForm.submit();
        }, 500));
    }
}

// Изменение статуса
function initStatusChange() {
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', async function() {
            const appointmentId = this.dataset.id;
            const statusId = this.value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            try {
                const response = await fetch(`/admin/appointments/${appointmentId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status_id: statusId })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotification('Статус обновлен', 'success');
                    updateStatusBadge(appointmentId, statusId);
                } else {
                    showNotification('Ошибка при обновлении статуса', 'danger');
                    this.value = this.dataset.oldValue;
                }
                
            } catch (error) {
                console.error('Error:', error);
                showNotification('Ошибка при обновлении статуса', 'danger');
                this.value = this.dataset.oldValue;
            }
        });

        select.addEventListener('focus', function() {
            this.dataset.oldValue = this.value;
        });
    });
}

// Обновление бейджа статуса
function updateStatusBadge(appointmentId, statusId) {
    const badge = document.querySelector(`.status-badge[data-id="${appointmentId}"]`);
    if (!badge) return;

    const statuses = {
        1: { text: 'Ожидание' },
        2: { text: 'Принято' },
        3: { text: 'В обработке' },
        4: { text: 'Отменено' },
        5: { text: 'Завершено' }
    };

    const status = statuses[statusId] || statuses[1];
    badge.textContent = status.text;
}

// Массовые действия
function initBulkActions() {
    const selectAll = document.getElementById('select-all');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    
    if (selectAll && bulkActions) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.select-item').forEach(cb => {
                cb.checked = this.checked;
            });
            updateSelectedCount();
            toggleBulkActions();
        });

        document.querySelectorAll('.select-item').forEach(cb => {
            cb.addEventListener('change', function() {
                updateSelectedCount();
                toggleBulkActions();
                
                if (selectAll) {
                    const allChecked = document.querySelectorAll('.select-item:checked').length === document.querySelectorAll('.select-item').length;
                    selectAll.checked = allChecked;
                    selectAll.indeterminate = !allChecked && document.querySelectorAll('.select-item:checked').length > 0;
                }
            });
        });
    }

    const applyBulkAction = document.getElementById('apply-bulk-action');
    if (applyBulkAction) {
        applyBulkAction.addEventListener('click', performBulkAction);
    }
}

function updateSelectedCount() {
    const selectedCount = document.getElementById('selected-count');
    const count = document.querySelectorAll('.select-item:checked').length;
    if (selectedCount) {
        selectedCount.textContent = count;
    }
}

function toggleBulkActions() {
    const bulkActions = document.getElementById('bulk-actions');
    const selected = document.querySelectorAll('.select-item:checked');
    
    if (bulkActions) {
        bulkActions.style.display = selected.length > 0 ? 'flex' : 'none';
    }
}

async function performBulkAction() {
    const action = document.getElementById('bulk-action-select')?.value;
    const selectedIds = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
    
    if (!action || selectedIds.length === 0) {
        showNotification('Выберите действие и записи', 'warning');
        return;
    }

    if (!confirm(`Выполнить действие "${action}" для ${selectedIds.length} записей?`)) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    try {
        const response = await fetch('/admin/appointments/bulk', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                action: action,
                ids: selectedIds
            })
        });

        const data = await response.json();

        if (data.success) {
            showNotification(`Действие выполнено для ${selectedIds.length} записей`, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('Ошибка при выполнении действия', 'danger');
        }

    } catch (error) {
        console.error('Error:', error);
        showNotification('Ошибка при выполнении действия', 'danger');
    }
}

// Календарь
function initCalendar() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl || typeof FullCalendar === 'undefined') return;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'ru',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '/admin/api/appointments',
        eventClick: function(info) {
            window.location.href = `/admin/appointments/${info.event.id}`;
        },
        dayMaxEvents: true,
        weekends: true,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        }
    });

    calendar.render();
    window.appointmentsCalendar = calendar;
}

// Поиск с автодополнением
function initSearch() {
    const searchInput = document.getElementById('appointment-search');
    if (!searchInput) return;

    const searchResults = document.getElementById('search-results');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            searchResults.innerHTML = '';
            searchResults.classList.remove('show');
            return;
        }

        searchTimeout = setTimeout(async () => {
            try {
                const response = await fetch(`/admin/api/search-appointments?q=${encodeURIComponent(query)}`);
                const results = await response.json();
                displaySearchResults(results);
            } catch (error) {
                console.error('Search error:', error);
            }
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.remove('show');
        }
    });
}

function displaySearchResults(results) {
    const container = document.getElementById('search-results');
    if (!container) return;

    if (results.length === 0) {
        container.innerHTML = '<div class="p-3 text-muted text-center">Ничего не найдено</div>';
        container.classList.add('show');
        return;
    }

    let html = '<div class="list-group">';
    results.forEach(result => {
        html += `
            <a href="/admin/appointments/${result.id}" class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${result.client_name}</strong>
                        <div class="small text-muted">${result.client_phone}</div>
                    </div>
                    <div class="text-end">
                        <div class="small">${formatDate(result.date)}</div>
                        <div class="small text-muted">${result.service_name}</div>
                    </div>
                </div>
            </a>
        `;
    });
    html += '</div>';
    
    container.innerHTML = html;
    container.classList.add('show');
}

// Date picker
function initDatePicker() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    
    dateInputs.forEach(input => {
        if (input.hasAttribute('data-min-today')) {
            const today = new Date().toISOString().split('T')[0];
            input.setAttribute('min', today);
        }

        const quickSelect = input.closest('.date-picker-group')?.querySelector('.quick-date-select');
        if (quickSelect) {
            quickSelect.addEventListener('change', function() {
                if (this.value) {
                    const date = new Date();
                    switch (this.value) {
                        case 'today':
                            input.value = date.toISOString().split('T')[0];
                            break;
                        case 'tomorrow':
                            date.setDate(date.getDate() + 1);
                            input.value = date.toISOString().split('T')[0];
                            break;
                        case 'next-week':
                            date.setDate(date.getDate() + 7);
                            input.value = date.toISOString().split('T')[0];
                            break;
                    }
                }
            });
        }
    });
}

// Дебаунс
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Показ уведомлений
function showNotification(message, type = 'success') {
    console.log(message);
    alert(message);
}

// Форматирование даты
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU');
}