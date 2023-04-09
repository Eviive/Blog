import '../scss/app.scss';
import { Toast } from 'bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';

type SearchResult = {
    title: string;
    url: string;
};

(() => {
    /********** Toasts **********/

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

    /********** Search bar **********/

    const searchInput = document.querySelector<HTMLInputElement>('input#search-input');
    const searchResults = document.querySelector<HTMLDivElement>('div#search-results');

    if (searchInput && searchResults) {
        type DebounceFn = (...args: any[]) => void;

        const debounce = <F extends DebounceFn>(func: F, delay: number) => {
            let timer: NodeJS.Timeout;

            return function(this: any, ...args: Parameters<F>) {
                const context = this;
                clearTimeout(timer);
                timer = setTimeout(() => func.apply(context, args), delay);
            }
        };

        const search = async (query: string) => {
            const res = await fetch(`/search?q=${query}`);

            const posts: SearchResult[] = await res.json();

            if (posts.length === 0) {
                searchResults.classList.add('d-none');
                return;
            }
            searchResults.classList.remove('d-none');

            const fragment = document.createDocumentFragment();

            for (const p of posts) {
                const a = document.createElement('a');
                a.classList.add('list-group-item', 'list-group-item-action');
                a.href = p.url;
                a.textContent = p.title;

                fragment.appendChild(a);
            }

            searchResults.replaceChildren(fragment);
        };

        const debouncedSearch = debounce(search, 400);

        searchInput.addEventListener('input', async () => {
            const value = searchInput.value;

            if (value === '') {
                searchResults.classList.add('d-none');
                return;
            }

            debouncedSearch(value);
        });
    }

})();
