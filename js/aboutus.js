window.addEventListener('resize', function() {
    location.reload();
});
    // Initialize ScrollReveal only for larger screens
    if (window.innerWidth >= 768) {
        ScrollReveal().reveal('.iconcontent', {
            duration: 1000,
            distance: '50px',
            origin: 'bottom',
            opacity: 0,
            reset: true,
            viewFactor: 0.8
        });
    }
