import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const alerts = document.querySelectorAll('[data-auto-dismiss]');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
});
