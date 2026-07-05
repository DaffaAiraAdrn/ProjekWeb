/* ============================================
   DF_137 — MAIN.JS
   Lenis, GSAP, Cursor, Loader, Reveals, Filters
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ============================================
    // PAGE LOADER
    // ============================================
    const pageLoader = document.getElementById('pageLoader');
    if (pageLoader) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                pageLoader.classList.add('hidden');
            }, 600);
        });
        // Fallback: hide after 3s no matter what
        setTimeout(() => pageLoader.classList.add('hidden'), 3000);
    }

    if (prefersReducedMotion) {
        document.querySelectorAll('.reveal, .reveal-up, .reveal-down, .reveal-left, .reveal-right, .reveal-fade, .reveal-scale, .reveal-rotate').forEach(el => el.classList.add('visible'));
        return;
    }

    // ============================================
    // LENIS SMOOTH SCROLL
    // ============================================
    let lenis = null;
    if (typeof Lenis !== 'undefined') {
        lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            smoothWheel: true,
            smoothTouch: false,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        // Sync with GSAP ScrollTrigger
        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            lenis.on('scroll', ScrollTrigger.update);
            gsap.ticker.add((time) => lenis.raf(time));
            gsap.ticker.lagSmoothing(0);
        }
    }

    // ============================================
    // GSAP SCROLLTRIGGER REGISTRATION
    // ============================================
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
    }

    // ============================================
    // CUSTOM CURSOR
    // ============================================
    const cursorDot = document.getElementById('cursorDot');
    const cursorRing = document.getElementById('cursorRing');

    if (cursorDot && cursorRing && !prefersReducedMotion) {
        let mouseX = 0, mouseY = 0;
        let ringX = 0, ringY = 0;

        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
            cursorDot.style.left = mouseX + 'px';
            cursorDot.style.top = mouseY + 'px';
        });

        // Smooth ring follow
        function animateRing() {
            ringX += (mouseX - ringX) * 0.15;
            ringY += (mouseY - ringY) * 0.15;
            cursorRing.style.left = ringX + 'px';
            cursorRing.style.top = ringY + 'px';
            requestAnimationFrame(animateRing);
        }
        animateRing();

        // Hover effects on interactive elements
        const hoverTargets = document.querySelectorAll('a, button, .tilt-card, .filter-tab, .portfolio-card, .blog-card, .report-card, .featured-card, .gallery-item, input, textarea, .social-link, .contact-social-link');
        hoverTargets.forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursorRing.classList.add('hover');
                cursorDot.classList.add('hover');
            });
            el.addEventListener('mouseleave', () => {
                cursorRing.classList.remove('hover');
                cursorDot.classList.remove('hover');
            });
        });
    }

    // ============================================
    // NAVBAR SCROLL BEHAVIOR
    // ============================================
    const navbar = document.getElementById('navbar');
    if (navbar) {
        let lastScroll = 0;
        const handleScroll = () => {
            const currentScroll = window.scrollY;
            if (currentScroll > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            lastScroll = currentScroll;
        };
        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
    }

    // ============================================
    // MOBILE NAV TOGGLE
    // ============================================
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');
    if (navToggle && navLinks) {
        navToggle.addEventListener('click', () => {
            navToggle.classList.toggle('active');
            navLinks.classList.toggle('open');
        });
        // Close on link click
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navToggle.classList.remove('active');
                navLinks.classList.remove('open');
            });
        });
    }

    // ============================================
    // SCROLL REVEAL ANIMATIONS
    // ============================================
    const revealElements = document.querySelectorAll('.reveal, .reveal-up, .reveal-down, .reveal-left, .reveal-right, .reveal-fade, .reveal-scale, .reveal-rotate, .text-reveal');

    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        // GSAP-based reveals
        revealElements.forEach(el => {
            gsap.fromTo(el,
                { opacity: 0, y: 40 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 85%',
                        toggleActions: 'play none none none',
                        onEnter: () => el.classList.add('visible'),
                    }
                }
            );
        });
    } else {
        // IntersectionObserver fallback
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        revealElements.forEach(el => observer.observe(el));
    }

    // ============================================
    // SKILL BAR ANIMATIONS
    // ============================================
    const skillBars = document.querySelectorAll('.skill-bar-fill');
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        skillBars.forEach(bar => {
            const width = bar.getAttribute('data-width');
            gsap.to(bar, {
                width: width + '%',
                duration: 1.5,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: bar,
                    start: 'top 90%',
                    toggleActions: 'play none none none',
                }
            });
        });
    } else {
        const skillObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bar = entry.target;
                    bar.style.width = bar.getAttribute('data-width') + '%';
                }
            });
        }, { threshold: 0.3 });
        skillBars.forEach(bar => skillObserver.observe(bar));
    }

    // ============================================
    // CIRCULAR PROGRESS ANIMATIONS
    // ============================================
    const circularProgresses = document.querySelectorAll('.circular-progress');
    circularProgresses.forEach(cp => {
        const percent = parseInt(cp.getAttribute('data-percent'));
        const fillRing = cp.querySelector('.fill-ring');
        const percentDisplay = cp.querySelector('.circular-percent');
        const circumference = 2 * Math.PI * 65; // r=65
        const offset = circumference - (percent / 100) * circumference;

        const animateCircular = () => {
            if (fillRing) {
                fillRing.style.strokeDashoffset = circumference;
                fillRing.style.strokeDasharray = circumference;
                requestAnimationFrame(() => {
                    fillRing.style.strokeDashoffset = offset;
                });
            }
            if (percentDisplay) {
                let current = 0;
                const interval = setInterval(() => {
                    current += 2;
                    if (current >= percent) {
                        current = percent;
                        clearInterval(interval);
                    }
                    percentDisplay.textContent = current + '%';
                }, 30);
            }
        };

        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            ScrollTrigger.create({
                trigger: cp,
                start: 'top 85%',
                onEnter: animateCircular,
                once: true,
            });
        } else {
            const circObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCircular();
                        circObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });
            circObserver.observe(cp);
        }
    });

    // ============================================
    // COUNTER ANIMATIONS
    // ============================================
    const counters = document.querySelectorAll('[data-counter]');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-counter'));
        const animateCounter = () => {
            let current = 0;
            const increment = Math.max(1, Math.ceil(target / 60));
            const interval = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(interval);
                }
                counter.textContent = current;
            }, 25);
        };

        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            ScrollTrigger.create({
                trigger: counter,
                start: 'top 85%',
                onEnter: animateCounter,
                once: true,
            });
        } else {
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter();
                        counterObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });
            counterObserver.observe(counter);
        }
    });

    // ============================================
    // PORTFOLIO FILTER
    // ============================================
    const filterTabs = document.querySelectorAll('.filter-tab');
    const portfolioCards = document.querySelectorAll('.portfolio-card, [data-category]');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const filter = tab.getAttribute('data-filter');

            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            // Filter cards
            portfolioCards.forEach(card => {
                const category = (card.getAttribute('data-category') || '').toLowerCase();
                if (filter === 'all' || category === filter) {
                    card.style.display = '';
                    if (typeof gsap !== 'undefined') {
                        gsap.fromTo(card,
                            { opacity: 0, scale: 0.9, y: 20 },
                            { opacity: 1, scale: 1, y: 0, duration: 0.5, ease: 'power3.out' }
                        );
                    }
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // ============================================
    // CARD 3D TILT EFFECT
    // ============================================
    const tiltCards = document.querySelectorAll('.tilt-card');
    if (!prefersReducedMotion) {
        tiltCards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width;
                const y = (e.clientY - rect.top) / rect.height;
                const tiltX = (y - 0.5) * -12;
                const tiltY = (x - 0.5) * 12;
                card.style.transform = `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale(1.02)`;

                // Shine effect
                const shine = card.querySelector('.tilt-card-shine');
                if (shine) {
                    shine.style.setProperty('--shine-x', (x * 100) + '%');
                    shine.style.setProperty('--shine-y', (y * 100) + '%');
                }
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale(1)';
            });
        });
    }

    // ============================================
    // PARALLAX ORBS
    // ============================================
    const parallaxOrbs = document.querySelectorAll('[data-parallax-speed]');
    if (parallaxOrbs.length && !prefersReducedMotion) {
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            parallaxOrbs.forEach(orb => {
                const speed = parseFloat(orb.getAttribute('data-parallax-speed'));
                orb.style.transform = `translateY(${scrollY * speed}px)`;
            });
        }, { passive: true });
    }

    // ============================================
    // CONTACT FORM AJAX
    // ============================================
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const successMsg = document.getElementById('formSuccess');
            const errorMsg = document.getElementById('formError');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');

            successMsg.style.display = 'none';
            errorMsg.style.display = 'none';
            submitText.textContent = 'Sending...';
            submitBtn.disabled = true;

            try {
                const formData = new FormData(contactForm);
                const response = await fetch(contactForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token'),
                    }
                });

                const data = await response.json();

                if (response.ok && (data.success || data.message)) {
                    successMsg.style.display = 'block';
                    contactForm.reset();
                } else {
                    errorMsg.style.display = 'block';
                    if (data.errors) {
                        errorMsg.textContent = Object.values(data.errors).join(' ');
                    }
                }
            } catch (err) {
                // Fallback: submit normally
                contactForm.submit();
                return;
            }

            submitText.textContent = 'Send Message';
            submitBtn.disabled = false;

            // Hide success after 5s
            setTimeout(() => {
                if (successMsg) successMsg.style.display = 'none';
            }, 5000);
        });
    }

    // ============================================
    // LIGHTBOX
    // ============================================
    const lightboxTriggers = document.querySelectorAll('[data-lightbox], .gallery-item');
    if (lightboxTriggers.length) {
        // Create lightbox if it doesn't exist
        let lightbox = document.querySelector('.lightbox');
        if (!lightbox) {
            lightbox = document.createElement('div');
            lightbox.className = 'lightbox';
            lightbox.innerHTML = `
                <div class="lightbox-content">
                    <button class="lightbox-close" aria-label="Close">&times;</button>
                    <img src="" alt="Lightbox image">
                </div>
            `;
            document.body.appendChild(lightbox);
        }

        const lightboxImg = lightbox.querySelector('img');
        const lightboxClose = lightbox.querySelector('.lightbox-close');
        let currentImages = [];
        let currentIndex = 0;

        lightboxTriggers.forEach((trigger, idx) => {
            const img = trigger.querySelector('img') || trigger;
            if (img.src) {
                currentImages.push(img.src);
                trigger.setAttribute('data-lightbox-index', currentImages.length - 1);
            }
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const index = parseInt(trigger.getAttribute('data-lightbox-index')) || 0;
                currentIndex = index;
                lightboxImg.src = currentImages[currentIndex];
                lightbox.classList.add('open');
                document.body.style.overflow = 'hidden';
            });
        });

        const closeLightbox = () => {
            lightbox.classList.remove('open');
            document.body.style.overflow = '';
        };

        lightboxClose.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && lightbox.classList.contains('open')) closeLightbox();
        });
    }

    // ============================================
    // READING PROGRESS BAR
    // ============================================
    const readingProgress = document.getElementById('readingProgress');
    if (readingProgress) {
        const article = document.querySelector('.blog-detail-body, .report-detail-body');
        const updateProgress = () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = (scrollTop / docHeight) * 100;
            readingProgress.style.width = progress + '%';
        };
        window.addEventListener('scroll', updateProgress, { passive: true });
        updateProgress();
    }

    // ============================================
    // MAGNETIC BUTTONS
    // ============================================
    if (!prefersReducedMotion) {
        const magneticElements = document.querySelectorAll('.btn-primary, .nav-logo');
        magneticElements.forEach(el => {
            el.classList.add('hover-magnetic');
            el.addEventListener('mousemove', (e) => {
                const rect = el.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                el.style.transform = `translate(${x * 0.2}px, ${y * 0.2}px)`;
            });
            el.addEventListener('mouseleave', () => {
                el.style.transform = 'translate(0, 0)';
            });
        });
    }

    // ============================================
    // SMOOTH ANCHOR LINKS
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const href = anchor.getAttribute('href');
            if (href === '#' || href === '#!') return;
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                if (lenis) {
                    lenis.scrollTo(target);
                } else {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });

    // ============================================
    // REFRESH SCROLLTRIGGER ON LOAD
    // ============================================
    if (typeof ScrollTrigger !== 'undefined') {
        window.addEventListener('load', () => {
            setTimeout(() => ScrollTrigger.refresh(), 100);
        });
    }
});
