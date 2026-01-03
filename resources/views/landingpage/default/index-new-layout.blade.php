@extends('frontend.layouts.app')

@section('page-title', __('Resume Builder - Create Professional Resumes'))

@section('content')
<style>
    /* ULTRA MODERN LANDING PAGE - COMPLETE NEW LAYOUT */
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        -webkit-font-smoothing: antialiased;
        color: #1f2937;
        line-height: 1.6;
    }

    /* MODERN NAVIGATION */
    .modern-nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid #f3f4f6;
    }

    .modern-nav-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 1.25rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modern-logo {
        font-size: 1.5rem;
        font-weight: 800;
        color: #6366f1;
        text-decoration: none;
    }

    .modern-nav-links {
        display: flex;
        gap: 2rem;
        align-items: center;
    }

    .modern-nav-link {
        color: #6b7280;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9375rem;
        transition: color 0.2s;
    }

    .modern-nav-link:hover {
        color: #6366f1;
    }

    .modern-btn-primary {
        background: #6366f1;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .modern-btn-primary:hover {
        background: #4f46e5;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    /* SPLIT SCREEN HERO */
    .split-hero {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
        align-items: center;
        gap: 4rem;
        padding: 8rem 2rem 4rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .hero-left {
        padding-right: 2rem;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #ede9fe;
        color: #6366f1;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 2rem;
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        color: #111827;
        letter-spacing: -0.03em;
    }

    .hero-title .gradient {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-description {
        font-size: 1.25rem;
        color: #6b7280;
        margin-bottom: 2.5rem;
        line-height: 1.7;
    }

    .hero-cta-group {
        display: flex;
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .btn-large {
        padding: 1.125rem 2.5rem;
        font-size: 1.0625rem;
        border-radius: 0.875rem;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-hero {
        background: #6366f1;
        color: white;
    }

    .btn-primary-hero:hover {
        background: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }

    .btn-secondary-hero {
        background: white;
        color: #374151;
        border: 2px solid #e5e7eb;
    }

    .btn-secondary-hero:hover {
        border-color: #6366f1;
        color: #6366f1;
    }

    .hero-stats {
        display: flex;
        gap: 3rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .stat {
        text-align: left;
    }

    .stat-number {
        font-size: 2.25rem;
        font-weight: 800;
        color: #111827;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    /* HERO RIGHT - VISUAL */
    .hero-right {
        position: relative;
        height: 600px;
    }

    .hero-visual-stack {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .resume-card {
        position: absolute;
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        padding: 2rem;
        transition: transform 0.3s ease;
    }

    .resume-card:hover {
        transform: translateY(-8px);
    }

    .resume-1 {
        width: 350px;
        top: 0;
        left: 0;
        z-index: 3;
    }

    .resume-2 {
        width: 320px;
        top: 100px;
        right: 0;
        z-index: 2;
        opacity: 0.9;
    }

    .resume-3 {
        width: 300px;
        bottom: 0;
        left: 50px;
        z-index: 1;
        opacity: 0.8;
    }

    /* BENTO BOX FEATURES */
    .bento-section {
        padding: 6rem 2rem;
        background: #f9fafb;
    }

    .bento-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-badge {
        display: inline-block;
        background: #ede9fe;
        color: #6366f1;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .section-title {
        font-size: 3rem;
        font-weight: 900;
        color: #111827;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .section-subtitle {
        font-size: 1.25rem;
        color: #6b7280;
        max-width: 700px;
        margin: 0 auto;
    }

    .bento-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(2, 300px);
        gap: 1.5rem;
    }

    .bento-item {
        background: white;
        border-radius: 1.5rem;
        padding: 2.5rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .bento-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        border-color: #6366f1;
    }

    .bento-large {
        grid-column: span 2;
    }

    .bento-tall {
        grid-row: span 2;
    }

    .bento-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .bento-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.75rem;
    }

    .bento-text {
        color: #6b7280;
        line-height: 1.7;
    }

    /* ALTERNATING CONTENT SECTIONS */
    .alternate-section {
        padding: 6rem 2rem;
    }

    .alternate-content {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6rem;
        align-items: center;
    }

    .alternate-text h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .alternate-text p {
        font-size: 1.125rem;
        color: #6b7280;
        margin-bottom: 2rem;
        line-height: 1.7;
    }

    .feature-list {
        list-style: none;
        margin-bottom: 2rem;
    }

    .feature-list li {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .check-icon {
        width: 24px;
        height: 24px;
        background: #6366f1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .alternate-visual {
        background: linear-gradient(135deg, #ede9fe 0%, #fae8ff 100%);
        border-radius: 1.5rem;
        padding: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 500px;
    }

    /* MODERN PRICING */
    .pricing-section {
        padding: 6rem 2rem;
        background: linear-gradient(180deg, white 0%, #f9fafb 100%);
    }

    .pricing-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 4rem;
    }

    .pricing-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2.5rem;
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
        position: relative;
    }

    .pricing-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        border-color: #6366f1;
    }

    .pricing-featured {
        border-color: #6366f1;
        transform: scale(1.05);
        box-shadow: 0 20px 60px rgba(99, 102, 241, 0.2);
    }

    .pricing-badge {
        position: absolute;
        top: -12px;
        right: 2rem;
        background: #6366f1;
        color: white;
        padding: 0.375rem 1rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .pricing-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .pricing-price {
        font-size: 3rem;
        font-weight: 900;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .pricing-price span {
        font-size: 1.25rem;
        color: #6b7280;
        font-weight: 500;
    }

    .pricing-description {
        color: #6b7280;
        margin-bottom: 2rem;
    }

    .pricing-features {
        list-style: none;
        margin-bottom: 2rem;
    }

    .pricing-features li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: #374151;
    }

    .pricing-cta {
        width: 100%;
        padding: 1rem;
        background: #6366f1;
        color: white;
        border: none;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pricing-cta:hover {
        background: #4f46e5;
    }

    /* MODERN CTA */
    .final-cta {
        padding: 6rem 2rem;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        text-align: center;
        color: white;
    }

    .final-cta h2 {
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 1.5rem;
    }

    .final-cta p {
        font-size: 1.25rem;
        margin-bottom: 2.5rem;
        opacity: 0.95;
    }

    .cta-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .split-hero,
        .alternate-content,
        .pricing-grid {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .bento-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .hero-title {
            font-size: 3rem;
        }

        .section-title {
            font-size: 2.25rem;
        }
    }

    @media (max-width: 768px) {
        .bento-grid {
            grid-template-columns: 1fr;
        }

        .bento-large,
        .bento-tall {
            grid-column: span 1;
            grid-row: span 1;
        }

        .hero-title {
            font-size: 2.25rem;
        }

        .hero-cta-group {
            flex-direction: column;
        }

        .btn-large {
            width: 100%;
            justify-content: center;
        }

        .modern-nav-links {
            display: none;
        }
    }
</style>

<!-- MODERN NAVIGATION -->
<nav class="modern-nav">
    <div class="modern-nav-content">
        <a href="/" class="modern-logo">{{ config('app.name') }}</a>
        <div class="modern-nav-links">
            <a href="#features" class="modern-nav-link">Features</a>
            <a href="#templates" class="modern-nav-link">Templates</a>
            <a href="#pricing" class="modern-nav-link">Pricing</a>
            <a href="{{ route('login') }}" class="modern-nav-link">Sign In</a>
            <a href="{{ route('register') }}" class="modern-btn-primary">Get Started Free</a>
        </div>
    </div>
</nav>

<!-- SPLIT SCREEN HERO -->
<section class="split-hero">
    <div class="hero-left">
        <div class="hero-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            Trusted by 400,000+ Professionals
        </div>

        <h1 class="hero-title">
            Create Your <span class="gradient">Perfect Resume</span> in Minutes
        </h1>

        <p class="hero-description">
            Build a professional, ATS-friendly resume with our easy-to-use builder. Choose from 50+ templates, customize, and download in PDF format.
        </p>

        <div class="hero-cta-group">
            <a href="{{ route('register') }}" class="btn-large btn-primary-hero">
                Start Building Free
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="#templates" class="btn-large btn-secondary-hero">
                Browse Templates
            </a>
        </div>

        <div class="hero-stats">
            <div class="stat">
                <div class="stat-number">400K+</div>
                <div class="stat-label">Happy Users</div>
            </div>
            <div class="stat">
                <div class="stat-number">50+</div>
                <div class="stat-label">Templates</div>
            </div>
            <div class="stat">
                <div class="stat-number">4.9/5</div>
                <div class="stat-label">Rating</div>
            </div>
        </div>
    </div>

    <div class="hero-right">
        <div class="hero-visual-stack">
            <div class="resume-card resume-1">
                <div style="height: 60px; background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); border-radius: 0.5rem; margin-bottom: 1rem;"></div>
                <div style="height: 8px; background: #e5e7eb; border-radius: 0.25rem; margin-bottom: 0.5rem;"></div>
                <div style="height: 8px; background: #e5e7eb; border-radius: 0.25rem; width: 80%; margin-bottom: 0.5rem;"></div>
                <div style="height: 8px; background: #e5e7eb; border-radius: 0.25rem; width: 60%; margin-bottom: 1.5rem;"></div>
                <div style="height: 6px; background: #e5e7eb; border-radius: 0.25rem; margin-bottom: 0.375rem;"></div>
                <div style="height: 6px; background: #e5e7eb; border-radius: 0.25rem; width: 90%;"></div>
            </div>
            <div class="resume-card resume-2">
                <div style="height: 50px; background: linear-gradient(135deg, #ec4899 0%, #f97316 100%); border-radius: 0.5rem; margin-bottom: 1rem;"></div>
                <div style="height: 6px; background: #e5e7eb; border-radius: 0.25rem; margin-bottom: 0.375rem;"></div>
                <div style="height: 6px; background: #e5e7eb; border-radius: 0.25rem; width: 75%;"></div>
            </div>
            <div class="resume-card resume-3">
                <div style="height: 40px; background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%); border-radius: 0.5rem; margin-bottom: 0.75rem;"></div>
                <div style="height: 5px; background: #e5e7eb; border-radius: 0.25rem; margin-bottom: 0.25rem;"></div>
                <div style="height: 5px; background: #e5e7eb; border-radius: 0.25rem; width: 70%;"></div>
            </div>
        </div>
    </div>
</section>

<!-- BENTO BOX FEATURES -->
<section class="bento-section" id="features">
    <div class="bento-container">
        <div class="section-header">
            <div class="section-badge">Features</div>
            <h2 class="section-title">Everything You Need to Land Your Dream Job</h2>
            <p class="section-subtitle">Powerful features designed to help you create professional resumes that stand out and get results.</p>
        </div>

        <div class="bento-grid">
            <div class="bento-item bento-large">
                <div class="bento-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                </div>
                <h3 class="bento-title">50+ Professional Templates</h3>
                <p class="bento-text">Choose from our collection of ATS-friendly, recruiter-approved resume templates designed for every industry.</p>
            </div>

            <div class="bento-item">
                <div class="bento-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <path d="M3 9h18M9 21V9"></path>
                    </svg>
                </div>
                <h3 class="bento-title">Easy Builder</h3>
                <p class="bento-text">Intuitive drag-and-drop interface.</p>
            </div>

            <div class="bento-item">
                <div class="bento-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </div>
                <h3 class="bento-title">PDF Export</h3>
                <p class="bento-text">Download in high-quality PDF.</p>
            </div>

            <div class="bento-item bento-tall">
                <div class="bento-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <h3 class="bento-title">ATS-Optimized</h3>
                <p class="bento-text">All templates are optimized to pass Applicant Tracking Systems, ensuring your resume gets seen by recruiters.</p>
            </div>

            <div class="bento-item">
                <div class="bento-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <h3 class="bento-title">Virtual Cards</h3>
                <p class="bento-text">Digital business cards included.</p>
            </div>

            <div class="bento-item">
                <div class="bento-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                </div>
                <h3 class="bento-title">Portfolios</h3>
                <p class="bento-text">Showcase your work online.</p>
            </div>
        </div>
    </div>
</section>

<!-- ALTERNATING CONTENT -->
<section class="alternate-section">
    <div class="alternate-content">
        <div class="alternate-text">
            <h2>Build Resumes That Get You Hired</h2>
            <p>Our professional templates are crafted by career experts and optimized to help you land more interviews.</p>
            <ul class="feature-list">
                <li>
                    <div class="check-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div>
                        <strong>Real-time Preview:</strong> See your changes instantly as you build
                    </div>
                </li>
                <li>
                    <div class="check-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div>
                        <strong>Unlimited Customization:</strong> Colors, fonts, and layouts
                    </div>
                </li>
                <li>
                    <div class="check-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div>
                        <strong>Cover Letters:</strong> Matching templates for complete application packages
                    </div>
                </li>
            </ul>
            <a href="{{ route('register') }}" class="modern-btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                Start Building Now
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="alternate-visual">
            <div style="text-align: center; color: #6366f1; font-weight: 600; font-size: 1.125rem;">Resume Preview Visual</div>
        </div>
    </div>
</section>

<!-- PRICING -->
<section class="pricing-section" id="pricing">
    <div class="section-header">
        <div class="section-badge">Pricing</div>
        <h2 class="section-title">Simple, Transparent Pricing</h2>
        <p class="section-subtitle">Choose the plan that works for you. Start free, upgrade anytime.</p>
    </div>

    <div class="pricing-grid">
        @foreach($packages ?? [] as $package)
        <div class="pricing-card {{ $package->is_featured ? 'pricing-featured' : '' }}">
            @if($package->is_featured)
            <div class="pricing-badge">Most Popular</div>
            @endif
            <div class="pricing-name">{{ $package->title }}</div>
            <div class="pricing-price">
                {{ $currency_symbol ?? '$' }}{{ $package->wholeprice }}<span>/{{ $package->interval }}</span>
            </div>
            <div class="pricing-description">Perfect for {{ strtolower($package->title) }} users</div>
            <ul class="pricing-features">
                <li>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Unlimited Resumes
                </li>
                <li>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    {{ $package->settings['template_premium'] ? 'Premium' : 'Free' }} Templates
                </li>
                <li>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    {{ $package->settings['export_pdf'] ? 'Unlimited' : 'Limited' }} PDF Downloads
                </li>
            </ul>
            <a href="{{ route('billing.package', $package) }}" class="pricing-cta">Choose {{ $package->title }}</a>
        </div>
        @endforeach
    </div>
</section>

<!-- FINAL CTA -->
<section class="final-cta">
    <h2>Ready to Land Your Dream Job?</h2>
    <p>Join 400,000+ professionals who've created their perfect resume with {{ config('app.name') }}</p>
    <div class="cta-buttons">
        <a href="{{ route('register') }}" class="btn-large" style="background: white; color: #6366f1;">
            Start Building Free
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</section>

@endsection
