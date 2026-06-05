import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Make vehicle cards clickable
    document.querySelectorAll('.vehicle-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't trigger if a button or link was already clicked directly
            if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON' || e.target.closest('a') || e.target.closest('button')) {
                return;
            }
            const link = this.querySelector('a.stretched-link') || this.querySelector('a');
            if (link) {
                window.location.href = link.href;
            }
        });
    });
});
