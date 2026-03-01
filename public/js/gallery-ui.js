(function(window, document, $) {
    'use strict';

    function initInfiniteScroll() {
        var items = Array.from(document.querySelectorAll('.js-infinite-item'));
        var sentinel = document.querySelector('.gallery-infinite-sentinel');
        if (!items.length || !sentinel) {
            return;
        }

        var container = items[0].parentElement;
        if (!container) {
            return;
        }

        var initialCount = 18;
        var batchSize = 12;
        var queued = items.slice(initialCount);

        queued.forEach(function(item) {
            if (item.parentElement === container) {
                container.removeChild(item);
            }
        });

        var hasIsotopeInstance = function($container) {
            return !!($container && $container.length && $container.data('isotope'));
        };

        var ensureIsotope = function($container) {
            if (!$ || !$container || !$container.length || typeof $container.isotope !== 'function') {
                return false;
            }

            if (hasIsotopeInstance($container)) {
                return true;
            }

            try {
                $container.isotope({
                    itemSelector: '.fusion-element-grid',
                    layoutMode: 'masonry',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.fusion-grid-sizer'
                    }
                });
            } catch (e) {
                return false;
            }

            return hasIsotopeInstance($container);
        };

        var relayout = function() {
            if (!$) {
                return;
            }

            var $container = $(container);
            if (ensureIsotope($container)) {
                try {
                    $container.isotope('reloadItems');
                    $container.isotope('layout');
                } catch (e) {
                    // Ignore unsupported gallery modes.
                }
            }

            $(window).trigger('resize');
            window.dispatchEvent(new Event('fusion-resize-horizontal'));
        };

        var observer;
        var revealMore = function() {
            if (!queued.length) {
                sentinel.classList.add('gallery-infinite-complete');
                if (observer) {
                    observer.disconnect();
                }
                return;
            }

            var frag = document.createDocumentFragment();
            var nextBatch = queued.splice(0, batchSize);
            nextBatch.forEach(function(item) {
                frag.appendChild(item);
            });
            container.appendChild(frag);

            requestAnimationFrame(relayout);
            setTimeout(relayout, 80);
            setTimeout(relayout, 220);
        };

        var shouldLoadMore = function() {
            if (!queued.length) {
                return false;
            }
            var rect = sentinel.getBoundingClientRect();
            return rect.top <= (window.innerHeight + 240);
        };

        var checking = false;
        var checkAndLoad = function() {
            if (checking) {
                return;
            }

            checking = true;
            try {
                while (shouldLoadMore()) {
                    revealMore();
                }
            } finally {
                checking = false;
            }
        };

        observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    checkAndLoad();
                }
            });
        }, {
            rootMargin: '240px 0px'
        });

        observer.observe(sentinel);
        window.addEventListener('scroll', checkAndLoad, { passive: true });
        window.addEventListener('resize', checkAndLoad);
        checkAndLoad();
    }

    function initModals() {
        if (!$ || typeof $.fn.colorbox !== 'function') {
            return;
        }

        $('a.gallery').colorbox({
            rel: 'gal',
            className: 'cbox-modern cbox-gallery',
            transition: 'fade',
            speed: 180,
            opacity: 0.55,
            maxWidth: '85%',
            maxHeight: '85%',
            scalePhotos: true
        });

        $('a.certificate-pdf-popup').colorbox({
            iframe: true,
            className: 'cbox-modern cbox-certificate',
            width: '85%',
            height: '90%',
            maxWidth: '1200px',
            transition: 'fade',
            speed: 180,
            opacity: 0.55
        });

        $(document)
            .off('click.galleryBadgeModal', 'a.badge-image-popup')
            .on('click.galleryBadgeModal', 'a.badge-image-popup', function(event) {
                event.preventDefault();
                $.colorbox({
                    href: $(this).attr('href'),
                    photo: true,
                    className: 'cbox-modern cbox-certificate',
                    transition: 'fade',
                    speed: 180,
                    opacity: 0.55,
                    maxWidth: '85%',
                    maxHeight: '85%',
                    scalePhotos: true
                });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initInfiniteScroll();
            initModals();
        });
    } else {
        initInfiniteScroll();
        initModals();
    }
})(window, document, window.jQuery);
