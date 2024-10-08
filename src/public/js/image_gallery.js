
    const thumbnail = document.querySelector('.item__image-thumbnail img');
    const images = document.querySelectorAll('.item__images img');
    images.forEach((image) => {
        image.addEventListener('mouseover', (event) => {
            thumbnail.src = event.target.src;
            thumbnail.animate({
                opacity: [0, 1]
            }, 300);
        });
    });