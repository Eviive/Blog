import '../scss/app.scss';
import { Toast } from 'bootstrap';
import "bootstrap-icons/font/bootstrap-icons.css";

(() => {
    for (const el of document.querySelectorAll<HTMLDivElement>('div.toast')) {
        const toast = new Toast(el, {
            autohide: false
        });

        let minutes = 0;
        const interval = setInterval(() => {
            minutes++;

            const time = el.querySelector<HTMLElement>('small.time');

            if (time) {
                time.textContent = minutes == 0 ? 'Now' : `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
            }
        }, 60000);

        el.addEventListener('hidden.bs.toast', () => {
            clearInterval(interval);
        });

        toast.show();
    }
})();
