document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('[data-filter]');
    const columns = document.querySelectorAll('.area-column');

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            filterButtons.forEach((b) => b.classList.remove('active'));
            button.classList.add('active');

            const target = button.dataset.filter;
            columns.forEach((col) => {
                const matches = target === 'all' || col.dataset.area === target;
                col.style.display = matches ? '' : 'none';
            });
        });
    });

    const cards = document.querySelectorAll('.card');
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('card-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.2 }
    );

    cards.forEach((card) => {
        card.classList.add('card-hidden');
        observer.observe(card);
    });
});
