/**
 * NyasaCV Landing Page 2025 Redesign - Enhanced Interactions
 * Modern animations, scroll effects, and interactive elements
 */

(function() {
    'use strict';

    // ==========================================
    // Smooth Scroll & Navigation Enhancements
    // ==========================================

    // Navigation scroll effect
    function updateNavOnScroll() {
        const nav = document.querySelector('.nav-redesign, .nav-ultra');
        if (!nav) return;

        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    }

    // Smooth scroll for anchor links
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#' || href === '#!') return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // ==========================================
    // Scroll-based Animation Observer
    // ==========================================

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                // For staggered animations
                if (entry.target.hasAttribute('data-stagger')) {
                    const children = entry.target.querySelectorAll('[data-stagger-item]');
                    children.forEach((child, index) => {
                        setTimeout(() => {
                            child.style.opacity = '1';
                            child.style.transform = 'translateY(0)';
                        }, index * 100);
                    });
                }
            }
        });
    }, observerOptions);

    // Observe all animate-on-scroll elements
    function initScrollAnimations() {
        const elements = document.querySelectorAll('.animate-on-scroll, .observe-animation, .feature-card, .template-card, .fade-in-up');
        elements.forEach(el => observer.observe(el));
    }

    // ==========================================
    // Parallax & 3D Effects
    // ==========================================

    function initParallaxEffects() {
        const hero = document.querySelector('.hero-redesign, .hero-ultra');
        if (!hero) return;

        document.addEventListener('mousemove', (e) => {
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;

            // Parallax floating elements
            document.querySelectorAll('.floating-element, .floating-badge').forEach((el, index) => {
                const speed = (index + 1) * 0.5;
                const x = (mouseX - 0.5) * speed * 20;
                const y = (mouseY - 0.5) * speed * 20;
                el.style.transform = `translate(${x}px, ${y}px)`;
            });
        });
    }

    // ==========================================
    // Card Hover Effects
    // ==========================================

    function initCardEffects() {
        const cards = document.querySelectorAll('.feature-card, .template-card, .pricing-card-ultra');

        cards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = (y - centerY) / 20;
                const rotateY = (centerX - x) / 20;

                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
            });
        });
    }

    // ==========================================
    // Number Counter Animation
    // ==========================================

    function animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = formatNumber(target);
                clearInterval(timer);
            } else {
                element.textContent = formatNumber(Math.floor(current));
            }
        }, 16);
    }

    function formatNumber(num) {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M+';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(0) + 'K+';
        }
        return num.toString();
    }

    function initCounters() {
        const counters = document.querySelectorAll('.stat-number, [data-counter]');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                    entry.target.classList.add('counted');
                    const target = parseInt(entry.target.getAttribute('data-target')) || 400000;
                    animateCounter(entry.target, target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => counterObserver.observe(counter));
    }

    // ==========================================
    // Mobile Menu Toggle
    // ==========================================

    function initMobileMenu() {
        const mobileBtn = document.querySelector('.mobile-menu-toggle, #mobile-menu-btn');
        const navLinks = document.querySelector('.nav-links, .d-none.d-md-flex');

        if (mobileBtn && navLinks) {
            mobileBtn.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                navLinks.classList.toggle('mobile-menu-active');
                mobileBtn.classList.toggle('active');

                // Animate hamburger icon
                const lines = mobileBtn.querySelectorAll('line');
                if (lines.length >= 3) {
                    if (navLinks.classList.contains('active')) {
                        lines[0].setAttribute('y1', '12');
                        lines[0].setAttribute('y2', '12');
                        lines[0].setAttribute('transform', 'rotate(45 12 12)');
                        lines[1].style.opacity = '0';
                        lines[2].setAttribute('y1', '12');
                        lines[2].setAttribute('y2', '12');
                        lines[2].setAttribute('transform', 'rotate(-45 12 12)');
                    } else {
                        lines[0].setAttribute('y1', '6');
                        lines[0].setAttribute('y2', '6');
                        lines[0].removeAttribute('transform');
                        lines[1].style.opacity = '1';
                        lines[2].setAttribute('y1', '18');
                        lines[2].setAttribute('y2', '18');
                        lines[2].removeAttribute('transform');
                    }
                }
            });

            // Close menu when clicking on links
            navLinks.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    navLinks.classList.remove('active', 'mobile-menu-active');
                    mobileBtn.classList.remove('active');
                });
            });
        }
    }

    // ==========================================
    // Template Image Lazy Loading
    // ==========================================

    function initLazyLoading() {
        const images = document.querySelectorAll('img[loading="lazy"]');

        if ('loading' in HTMLImageElement.prototype) {
            // Browser supports native lazy loading
            return;
        }

        // Fallback for browsers that don't support lazy loading
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    }

    // ==========================================
    // Gradient Background Animation
    // ==========================================

    function initGradientAnimation() {
        const shapes = document.querySelectorAll('.shape, .floating-element');

        shapes.forEach((shape, index) => {
            const randomDelay = Math.random() * 5;
            const randomDuration = 15 + Math.random() * 10;

            shape.style.animationDelay = `${randomDelay}s`;
            shape.style.animationDuration = `${randomDuration}s`;
        });
    }

    // ==========================================
    // CTA Pulse Animation
    // ==========================================

    function initCTAPulse() {
        const ctaButtons = document.querySelectorAll('.btn-primary-redesign, .btn-gradient-ultra');

        ctaButtons.forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                btn.style.animation = 'none';
                setTimeout(() => {
                    btn.style.animation = 'pulse 1.5s infinite';
                }, 10);
            });

            btn.addEventListener('mouseleave', () => {
                btn.style.animation = 'none';
            });
        });
    }

    // ==========================================
    // Performance Optimization
    // ==========================================

    // Debounce function for scroll events
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Throttle function for mouse move events
    function throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // ==========================================
    // Initialize All Features
    // ==========================================

    function init() {
        // Wait for DOM to be fully loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
            return;
        }

        // Initialize all features
        initSmoothScroll();
        initScrollAnimations();
        initMobileMenu();
        initLazyLoading();
        initGradientAnimation();
        initCTAPulse();
        initCounters();

        // Initialize features that require user interaction
        setTimeout(() => {
            initParallaxEffects();
            initCardEffects();
        }, 500);

        // Add scroll event listener with debounce
        window.addEventListener('scroll', debounce(updateNavOnScroll, 10));
        updateNavOnScroll(); // Initial check

        // Add resize event listener
        window.addEventListener('resize', debounce(() => {
            // Re-initialize features that depend on viewport size
            initParallaxEffects();
        }, 250));

        // Add custom cursor effect for premium sections
        const premiumSections = document.querySelectorAll('[data-premium]');
        premiumSections.forEach(section => {
            section.style.cursor = 'pointer';
        });

        console.log('✨ NyasaCV Landing Page 2025 Redesign Initialized');
    }

    // Start initialization
    init();

})();
