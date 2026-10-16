/**
 * Cuerpo Libre — main.js
 * Handles: sticky header, mobile nav, scroll reveal, FAQ accordion, booking form, lightbox
 */

document.addEventListener('DOMContentLoaded', () => {

    /* ─────────────────────────────────────────
       0. AGE VERIFICATION (Priority)
    ───────────────────────────────────────── */
    const ageOverlay = document.getElementById('age-verification');
    const ageConfirm = document.getElementById('age-confirm');
    const ageExit    = document.getElementById('age-exit');

    if (ageOverlay) {
        // Check for reset parameter or localStorage
        const urlParams = new URLSearchParams(window.location.search);
        const resetAge  = urlParams.has('reset_age');
        
        if (resetAge) {
            localStorage.removeItem('age-verified');
        }

        const isVerified = localStorage.getItem('age-verified');

        if (!isVerified) {
            // Priority display
            ageOverlay.style.display = 'flex'; 
            setTimeout(() => {
                ageOverlay.classList.add('is-active');
                document.body.style.overflow = 'hidden';
            }, 50);
        } else {
            ageOverlay.style.display = 'none';
        }

        ageConfirm?.addEventListener('click', () => {
            localStorage.setItem('age-verified', 'true');
            ageOverlay.classList.remove('is-active');
            document.body.style.overflow = '';
            
            setTimeout(() => {
                ageOverlay.style.display = 'none';
            }, 800);
        });

        ageExit?.addEventListener('click', () => {
            window.location.href = 'https://www.google.com';
        });
    }

    /* ─────────────────────────────────────────
       1. STICKY HEADER
    ───────────────────────────────────────── */
    const header = document.getElementById('masthead');
    if (header) {
        const onScroll = () => {
            header.classList.toggle('scrolled', window.scrollY > 40);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    /* ─────────────────────────────────────────
       2. FULLSCREEN NAV OVERLAY
    ───────────────────────────────────────── */
    const menuOpenBtn    = document.getElementById('menuOpenBtn');
    const navOverlay     = document.getElementById('navOverlay');
    const navOverlayClose = document.getElementById('navOverlayClose');

    const openOverlay = () => {
        if (!navOverlay) return;
        navOverlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        menuOpenBtn?.setAttribute('aria-expanded', 'true');
        navOverlayClose?.focus();
    };

    const closeOverlay = () => {
        if (!navOverlay) return;
        navOverlay.classList.remove('is-open');
        document.body.style.overflow = '';
        menuOpenBtn?.setAttribute('aria-expanded', 'false');
        menuOpenBtn?.focus();
    };

    menuOpenBtn?.addEventListener('click', openOverlay);
    navOverlayClose?.addEventListener('click', closeOverlay);

    // Close when any nav link is clicked
    navOverlay?.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeOverlay);
    });

    // Close with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && navOverlay?.classList.contains('is-open')) {
            closeOverlay();
        }
    });

    /* ─────────────────────────────────────────
       3. SCROLL REVEAL
    ───────────────────────────────────────── */
    const reveals = document.querySelectorAll('.reveal');

    if (reveals.length && 'IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.12, rootMargin: '0px 0px -48px 0px' }
        );

        reveals.forEach(el => revealObserver.observe(el));
    } else {
        reveals.forEach(el => el.classList.add('is-visible'));
    }

    /* ─────────────────────────────────────────
       4. FAQ ACCORDION
    ───────────────────────────────────────── */
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer   = item.querySelector('.faq-answer');

        if (!question || !answer) return;

        question.addEventListener('click', () => {
            const isOpen = item.classList.contains('is-open');

            faqItems.forEach(i => {
                i.classList.remove('is-open');
                const a = i.querySelector('.faq-answer');
                if (a) a.style.maxHeight = '0';
            });

            if (!isOpen) {
                item.classList.add('is-open');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });

    /* ─────────────────────────────────────────
       5. BOOKING FORM HANDLER
    ───────────────────────────────────────── */
    const bookingForm = document.getElementById('bookingForm');
    const formMessage = document.getElementById('formMessage');

    if (bookingForm && formMessage) {
        bookingForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const formData = new FormData(bookingForm);
            formData.append('action', 'submit_booking');
            // Ensure compatibility with backend field naming
            formData.append('session_type', bookingForm.querySelector('[name="session-type"]').value);
            formData.append('meeting_date', bookingForm.querySelector('[name="meeting-date"]').value);

            const btn = bookingForm.querySelector('button[type="submit"]');
            const originalText = btn.textContent;

            btn.textContent = 'Enviando...';
            btn.disabled = true;

            fetch(cl_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.textContent = originalText;
                btn.disabled = false;

                if (data.success) {
                    formMessage.innerHTML = `<p style="color: #c8a882; font-size: 0.9rem; margin-top: 16px; text-align:center; letter-spacing:0.05em;">✓ &nbsp;${data.data.message}</p>`;
                    bookingForm.reset();
                } else {
                    formMessage.innerHTML = `<p style="color: #ff5555; font-size: 0.9rem; margin-top: 16px; text-align:center;">✕ &nbsp;${data.data.message}</p>`;
                }

                setTimeout(() => { formMessage.innerHTML = ''; }, 8000);
            })
            .catch(error => {
                btn.textContent = originalText;
                btn.disabled = false;
                formMessage.innerHTML = `<p style="color: #ff5555; font-size: 0.9rem; margin-top: 16px; text-align:center;">✕ &nbsp;Error de conexión. Intenta de nuevo.</p>`;
            });
        });
    }

    /* ─────────────────────────────────────────
       6. SMOOTH ANCHOR SCROLL
    ───────────────────────────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                const headerH = header ? header.offsetHeight : 0;
                const top = target.getBoundingClientRect().top + window.scrollY - headerH - 24;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        });
    });

    /* ─────────────────────────────────────────
       7. CURSOR SUBTLE PARALLAX on hero
    ───────────────────────────────────────── */
    const heroBg = document.querySelector('.hero-bg');
    if (heroBg) {
        document.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth  - 0.5) * 18;
            const y = (e.clientY / window.innerHeight - 0.5) * 12;
            heroBg.style.transform = `translate(${x}px, ${y}px)`;
        }, { passive: true });
    }

    /* ─────────────────────────────────────────
       8. LIGHTBOX WITH NAVIGATION & GESTURES
    ───────────────────────────────────────── */
    const lightbox    = document.getElementById('cl-lightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const closeBtn    = document.getElementById('lightboxClose');
    const prevBtn     = document.getElementById('lightboxPrev');
    const nextBtn     = document.getElementById('lightboxNext');
    const captionEl   = document.getElementById('lightboxCaption');

    let currentGallery = [];
    let currentIndex   = 0;

    // Resolves the highest resolution image from WP elements
    const getLargeImageSrc = (img) => {
        if (!img) return '';
        
        // 1. Check for custom data attributes
        const dataAttrs = ['fullUrl', 'largeFile', 'mediumFile', 'origFile'];
        for (const attr of dataAttrs) {
            if (img.dataset && img.dataset[attr]) {
                return img.dataset[attr];
            }
        }
        
        // 2. Check if the parent link wraps a high-res image file
        const parentLink = img.closest('a');
        if (parentLink && /\.(jpg|jpeg|png|webp|gif|svg)(?:\?.*)?$/i.test(parentLink.getAttribute('href') || '')) {
            return parentLink.getAttribute('href');
        }
        
        // 3. Parse srcset to extract the largest image
        if (img.srcset) {
            try {
                const items = img.srcset.split(',').map(item => {
                    const parts = item.trim().split(/\s+/);
                    const url = parts[0];
                    let width = 0;
                    if (parts[1]) {
                        if (parts[1].endsWith('w')) {
                            width = parseInt(parts[1].slice(0, -1), 10) || 0;
                        } else if (parts[1].endsWith('x')) {
                            width = (parseFloat(parts[1].slice(0, -1)) || 1) * 1000;
                        }
                    }
                    return { url, width };
                });
                const sorted = items.filter(item => item.url).sort((a, b) => b.width - a.width);
                if (sorted.length > 0) {
                    return sorted[0].url;
                }
            } catch (e) {
                console.error('Error parsing srcset:', e);
            }
        }
        
        // 4. Suffix removal fallback
        let src = img.src;
        if (src) {
            const regex = /(-\d+x\d+)(\.[a-zA-Z0-9]+(?:\?.*)?)$/;
            if (regex.test(src)) {
                return src.replace(regex, '$2');
            }
        }
        
        return src;
    };

    if (lightbox && lightboxImg) {
        const updateLightbox = () => {
            const item = currentGallery[currentIndex];
            if (!item) return;
            
            lightboxImg.classList.add('swapping');
            if (captionEl) {
                captionEl.classList.remove('is-active');
            }
            
            setTimeout(() => {
                const tempImg = new Image();
                tempImg.src = item.src;
                tempImg.onload = () => {
                    lightboxImg.src = item.src;
                    lightboxImg.alt = item.alt || '';
                    lightboxImg.classList.remove('swapping');
                    
                    if (captionEl) {
                        captionEl.textContent = item.alt || '';
                        if (item.alt) {
                            captionEl.classList.add('is-active');
                        }
                    }
                };
            }, 50);
        };

        const openLightbox = (src, alt, galleryImages) => {
            currentGallery = galleryImages;
            currentIndex = galleryImages.findIndex(img => img.src === src);
            if (currentIndex === -1) currentIndex = 0;

            lightboxImg.src = src;
            lightboxImg.alt = alt || '';
            
            if (captionEl) {
                captionEl.textContent = alt || '';
                if (alt) {
                    captionEl.classList.add('is-active');
                } else {
                    captionEl.classList.remove('is-active');
                }
            }

            lightbox.classList.add('is-active');
            document.body.style.overflow = 'hidden';

            if (currentGallery.length <= 1) {
                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'none';
            } else {
                if (prevBtn) prevBtn.style.display = 'flex';
                if (nextBtn) nextBtn.style.display = 'flex';
            }
        };

        const closeLightbox = () => {
            lightbox.classList.remove('is-active');
            document.body.style.overflow = '';
            setTimeout(() => { 
                lightboxImg.src = ''; 
                if (captionEl) captionEl.textContent = '';
            }, 400);
        };

        const showNext = (e) => {
            if (e) e.stopPropagation();
            if (currentGallery.length <= 1) return;
            currentIndex = (currentIndex + 1) % currentGallery.length;
            updateLightbox();
        };

        const showPrev = (e) => {
            if (e) e.stopPropagation();
            if (currentGallery.length <= 1) return;
            currentIndex = (currentIndex - 1 + currentGallery.length) % currentGallery.length;
            updateLightbox();
        };

        document.addEventListener('click', (e) => {
            const target = e.target;
            if (target.tagName !== 'IMG') return;

            const containerSelectors = [
                '.gallery-masonry-grid',
                '.wp-block-gallery',
                '.featured-grid',
                '.gallery-preview-grid',
                '.entry-content',
                '.wp-block-image'
            ];

            let container = null;
            for (const selector of containerSelectors) {
                container = target.closest(selector);
                if (container) break;
            }

            if (container) {
                e.preventDefault();
                e.stopPropagation();

                const imgs = Array.from(container.querySelectorAll('img')).map(img => ({
                    src: getLargeImageSrc(img),
                    alt: img.alt || img.getAttribute('alt') || ''
                }));

                openLightbox(getLargeImageSrc(target), target.alt || target.getAttribute('alt') || '', imgs);
            }
        }, true);

        closeBtn?.addEventListener('click', closeLightbox);
        prevBtn?.addEventListener('click', showPrev);
        nextBtn?.addEventListener('click', showNext);

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox || e.target.closest('.cl-lightbox-close')) {
                closeLightbox();
            }
        });
        
        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('is-active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') showNext();
            if (e.key === 'ArrowLeft') showPrev();
        });

        // Touch Swipe Gestures for Mobile
        let touchStartX = 0;
        let touchEndX = 0;

        lightbox.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        lightbox.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleGesture();
        }, { passive: true });

        const handleGesture = () => {
            const swipeThreshold = 50;
            if (touchEndX < touchStartX - swipeThreshold) {
                showNext();
            }
            if (touchEndX > touchStartX + swipeThreshold) {
                showPrev();
            }
        };
    }
    
});