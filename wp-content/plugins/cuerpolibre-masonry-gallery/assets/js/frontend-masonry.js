document.addEventListener('DOMContentLoaded', function () {
    const masonryGalleries = document.querySelectorAll('.wp-block-gallery.has-masonry-layout');
    
    masonryGalleries.forEach(function (gallery) {
        const imgs = gallery.querySelectorAll('img');
        imgs.forEach(function (img) {
            if (!img.complete) {
                img.addEventListener('load', function () {
                    gallery.style.display = 'none';
                    gallery.offsetHeight; // trigger reflow
                    gallery.style.display = 'block';
                });
            }
        });
    });
});
