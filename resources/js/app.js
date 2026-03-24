import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

if (document.readyState !== 'loading') {
    Alpine.start();
} else {
    document.addEventListener('DOMContentLoaded', () => {
        Alpine.start();
    });
}
