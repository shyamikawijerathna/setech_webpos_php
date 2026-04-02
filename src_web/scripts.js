// Ensure the carousel starts with a 3-second interval on page load
document.addEventListener('DOMContentLoaded', function () {
    const myCarousel = document.querySelector('#mainCarousel');
    const carousel = new bootstrap.Carousel(myCarousel, {
        interval: 3000, // 3000ms = 3 seconds
        touch: true,    // Enable swipe on mobile
        pause: 'hover'  // Pause when mouse is over the image
    });
});