/**
 * NYASACV Mobile Optimization Script
 * Handles lazy loading, performance optimization, and mobile menu
 */

(function() {
    'use strict';

    // ============================================
    // LAZY LOADING IMAGES
    // ============================================
    function initLazyLoading() {
        // Check if browser supports IntersectionObserver
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;

                        // Load the image
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                        }

                        if (img.dataset.srcset) {
                            img.srcset = img.dataset.srcset;
                        }

                        // Add loaded class for transition
                        img.classList.add('loaded');

                        // Stop observing this image
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px',
                threshold: 0.01
            });

            // Observe all images with data-src attribute
            document.querySelectorAll('img[data-src], img[loading="lazy"]').forEach(img => {
                imageObserver.observe(img);
            });
        } else {
            // Fallback for browsers that don't support IntersectionObserver
            document.querySelectorAll('img[data-src]').forEach(img => {
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                }
                if (img.dataset.srcset) {
                    img.srcset = img.dataset.srcset;
                }
                img.classList.add('loaded');
            });
        }
    }

    // ============================================
    // MOBILE MENU TOGGLE
    // ============================================
    function initMobileMenu() {
        // Find navigation and menu elements
        const nav = document.querySelector('.nav-ultra');
        if (!nav) {
            console.log('Navigation not found');
            return;
        }

        // Find toggle button (already in HTML)
        const toggleBtn = nav.querySelector('.mobile-menu-toggle');
        if (!toggleBtn) {
            console.log('Mobile menu toggle button not found');
            return;
        }

        // Get mobile menu container
        const mobileMenu = nav.querySelector('.d-none.d-md-flex');
        if (!mobileMenu) {
            console.log('Mobile menu container not found');
            return;
        }

        console.log('Mobile menu initialized successfully');
        console.log('Toggle button:', toggleBtn);
        console.log('Mobile menu:', mobileMenu);

        // Toggle menu on button click
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            console.log('Hamburger menu clicked!');
            console.log('Menu before toggle:', mobileMenu.className);

            mobileMenu.classList.toggle('mobile-menu-active');
            toggleBtn.classList.toggle('active');
            document.body.classList.toggle('menu-open');

            console.log('Menu after toggle:', mobileMenu.className);

            // Update button icon
            if (mobileMenu.classList.contains('mobile-menu-active')) {
                toggleBtn.innerHTML = `
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                `;
            } else {
                toggleBtn.innerHTML = `
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                `;
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!nav.contains(e.target) && mobileMenu.classList.contains('mobile-menu-active')) {
                mobileMenu.classList.remove('mobile-menu-active');
                toggleBtn.classList.remove('active');
                document.body.classList.remove('menu-open');
                toggleBtn.innerHTML = `
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                `;
            }
        });
    }

    // ============================================
    // SMOOTH SCROLL
    // ============================================
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#' || href === '#!') return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const offsetTop = target.offsetTop - 80; // Account for fixed nav

                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });

                    // Close mobile menu if open
                    const mobileMenu = document.querySelector('.mobile-menu-active');
                    if (mobileMenu) {
                        mobileMenu.classList.remove('mobile-menu-active');
                        document.body.classList.remove('menu-open');
                        const toggleBtn = document.querySelector('.mobile-menu-toggle');
                        if (toggleBtn) {
                            toggleBtn.classList.remove('active');
                        }
                    }
                }
            });
        });
    }

    // ============================================
    // NAVBAR SCROLL EFFECT
    // ============================================
    function initNavbarScroll() {
        const nav = document.querySelector('.nav-ultra');
        if (!nav) return;

        let lastScroll = 0;

        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 100) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }

            lastScroll = currentScroll;
        });
    }

    // ============================================
    // ANIMATE ON SCROLL
    // ============================================
    function initAnimateOnScroll() {
        if ('IntersectionObserver' in window) {
            const animateObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                animateObserver.observe(el);
            });
        }
    }

    // ============================================
    // IMAGE PRELOADING FOR CRITICAL IMAGES
    // ============================================
    function preloadCriticalImages() {
        // Preload hero images
        const heroImages = document.querySelectorAll('.hero-ultra img, .mockup-image');
        heroImages.forEach(img => {
            if (img.dataset.src) {
                const preloadImg = new Image();
                preloadImg.src = img.dataset.src;
            }
        });
    }

    // ============================================
    // DEFER NON-CRITICAL CSS
    // ============================================
    function deferNonCriticalCSS() {
        const stylesheets = document.querySelectorAll('link[rel="stylesheet"][data-defer]');
        stylesheets.forEach(stylesheet => {
            stylesheet.setAttribute('media', 'print');
            stylesheet.onload = function() {
                this.media = 'all';
            };
        });
    }

    // ============================================
    // REDUCE MOTION FOR ACCESSIBILITY
    // ============================================
    function handleReducedMotion() {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

        if (prefersReducedMotion.matches) {
            document.documentElement.style.setProperty('--transition-fast', '0ms');
            document.documentElement.style.setProperty('--transition-base', '0ms');
            document.documentElement.style.setProperty('--transition-slow', '0ms');
        }
    }

    // ============================================
    // FIX VIEWPORT HEIGHT ON MOBILE
    // ============================================
    function fixViewportHeight() {
        // Fix for mobile browsers where 100vh includes the address bar
        const setVH = () => {
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        };

        setVH();
        window.addEventListener('resize', setVH);
        window.addEventListener('orientationchange', setVH);
    }

    // ============================================
    // PERFORMANCE MONITORING
    // ============================================
    function monitorPerformance() {
        if ('PerformanceObserver' in window) {
            // Monitor Largest Contentful Paint (LCP)
            try {
                const lcpObserver = new PerformanceObserver((list) => {
                    const entries = list.getEntries();
                    const lastEntry = entries[entries.length - 1];
                    console.log('LCP:', lastEntry.renderTime || lastEntry.loadTime);
                });
                lcpObserver.observe({ entryTypes: ['largest-contentful-paint'] });
            } catch (e) {
                console.log('LCP monitoring not supported');
            }

            // Monitor First Input Delay (FID)
            try {
                const fidObserver = new PerformanceObserver((list) => {
                    const entries = list.getEntries();
                    entries.forEach(entry => {
                        console.log('FID:', entry.processingStart - entry.startTime);
                    });
                });
                fidObserver.observe({ entryTypes: ['first-input'] });
            } catch (e) {
                console.log('FID monitoring not supported');
            }
        }
    }

    // ============================================
    // INITIALIZE ALL FUNCTIONS
    // ============================================
    function init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                initAll();
            });
        } else {
            initAll();
        }
    }

    function initAll() {
        initLazyLoading();
        initMobileMenu();
        initSmoothScroll();
        initNavbarScroll();
        initAnimateOnScroll();
        preloadCriticalImages();
        handleReducedMotion();
        fixViewportHeight();

        // Only monitor performance in development
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            monitorPerformance();
        }
    }

    // Start initialization
    init();

})();
