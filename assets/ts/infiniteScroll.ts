(() => {

    const container = document.querySelector('#infinite-scroll');

    if (!container) {
        return;
    }

    let page = 2; // First page is loaded by default by the controller
    let fetching = false;

    type Page = {
        html: string;
        hasNextPage: boolean;
    }

    const loadMorePosts = () => {
        if (fetching) {
            return;
        }
        fetching = true;
        fetch(`/infinite-scroll?page=${page}`)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Infinite scroll query failed');
                }
                return res.json();
            })
            .then((data: Page) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data.html, 'text/html');
                const posts = doc.querySelectorAll('.post');

                for (const post of posts) {
                    container.appendChild(post);
                }

                page++;
                updateObservedElement(data.hasNextPage);
            })
            .catch(console.log)
            .finally(() => { fetching = false; });
    };

    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            loadMorePosts();
        }
    }, {
        root: null,
        threshold: 0.5
    });

    const updateObservedElement = (resetElement = true) => {
        observer.disconnect();

        if (resetElement) {
            const lastChild = container.lastElementChild;

            if (lastChild) {
                observer.observe(lastChild);
            }
        }
    };

    updateObservedElement();

})();
