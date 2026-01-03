<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Professional Resume Builder</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><defs><linearGradient id='g' x1='0%25' y1='0%25' x2='100%25' y2='100%25'><stop offset='0%25' style='stop-color:%23667eea'/><stop offset='100%25' style='stop-color:%23764ba2'/></linearGradient></defs><rect width='100' height='100' rx='20' fill='url(%23g)'/><path d='M35 25h20l15 15v35c0 3-2 5-5 5H35c-3 0-5-2-5-5V30c0-3 2-5 5-5z' fill='white'/><path d='M55 25v15h15' fill='none' stroke='white' stroke-width='3'/><line x1='40' y1='55' x2='60' y2='55' stroke='white' stroke-width='3'/><line x1='40' y1='65' x2='60' y2='65' stroke='white' stroke-width='3'/></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6716451863337296" crossorigin="anonymous"></script>
</head>
<body>
<style>
    /* ZETY-INSPIRED CLEAN PROFESSIONAL DESIGN */

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Lato', 'Helvetica Neue', Arial, sans-serif;
        color: #2d3748;
        line-height: 1.6;
        background: #fff;
        -webkit-font-smoothing: antialiased;
    }

    /* SIMPLE CLEAN HEADER */
    .zety-header {
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 0;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .zety-header-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .zety-logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        transition: transform 0.2s;
    }

    .zety-logo:hover {
        transform: translateY(-1px);
    }

    .zety-logo-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
    }

    .zety-logo-icon svg {
        width: 24px;
        height: 24px;
        fill: white;
    }

    .zety-logo-text {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.02em;
    }

    .zety-nav {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .zety-nav-link {
        color: #4a5568;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9375rem;
        transition: color 0.2s;
    }

    .zety-nav-link:hover {
        color: #667eea;
    }

    .zety-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        font-size: 0.9375rem;
    }

    .zety-btn:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    /* HERO SECTION - CLEAN & SIMPLE */
    .zety-hero {
        background: linear-gradient(135deg, #f5f3ff 0%, #ffffff 100%);
        padding: 4rem 2rem 5rem;
    }

    .zety-hero-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .zety-hero-left h1 {
        font-size: 3rem;
        font-weight: 800;
        color: #1a202c;
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }

    .zety-hero-left h1 .gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .zety-hero-left p {
        font-size: 1.25rem;
        color: #4a5568;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .zety-hero-cta {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .zety-btn-large {
        padding: 1.125rem 2.5rem;
        font-size: 1.125rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-block;
    }

    .zety-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
    }

    .zety-btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .zety-btn-secondary {
        background: #fff;
        color: #4a5568;
        border: 2px solid #e2e8f0;
    }

    .zety-btn-secondary:hover {
        border-color: #667eea;
        color: #667eea;
    }

    .zety-trust-badge {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #fff;
        border-radius: 0.5rem;
        border: 1px solid #e2e8f0;
    }

    .zety-trust-badge img {
        width: 80px;
        height: auto;
    }

    .zety-trust-text {
        font-size: 0.875rem;
        color: #4a5568;
    }

    .zety-trust-text strong {
        display: block;
        color: #1a202c;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    /* HERO RIGHT - SIMPLE FORM/VISUAL */
    .zety-hero-right {
        background: #fff;
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }

    .zety-form-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .zety-resume-preview {
        background: #fff;
        border-radius: 0.75rem;
        padding: 0;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .zety-resume-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .zety-resume-preview::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
        pointer-events: none;
    }

    /* HOW IT WORKS - CLEAN STEPS */
    .zety-how-it-works {
        padding: 5rem 2rem;
        background: #fff;
    }

    .zety-section-title {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 1rem;
    }

    .zety-section-subtitle {
        text-align: center;
        font-size: 1.125rem;
        color: #4a5568;
        margin-bottom: 4rem;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .zety-steps {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 3rem;
    }

    .zety-step {
        text-align: center;
        position: relative;
    }

    .zety-step-number {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 auto 1.5rem;
    }

    .zety-step-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.75rem;
    }

    .zety-step-text {
        color: #4a5568;
        line-height: 1.6;
    }

    /* FEATURES - SIMPLE LIST */
    .zety-features {
        padding: 5rem 2rem;
        background: #f7fafc;
    }

    .zety-features-grid {
        max-width: 1200px;
        margin: 3rem auto 0;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 3rem;
    }

    .zety-feature {
        display: flex;
        gap: 1.5rem;
        background: #fff;
        padding: 2rem;
        border-radius: 0.5rem;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .zety-feature:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-color: #667eea;
    }

    .zety-feature-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .zety-feature-icon svg {
        width: 24px;
        height: 24px;
        color: #667eea;
    }

    .zety-feature-content h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.5rem;
    }

    .zety-feature-content p {
        color: #4a5568;
        line-height: 1.6;
    }

    /* TEMPLATES SHOWCASE */
    .zety-templates {
        padding: 5rem 2rem;
        background: #fff;
    }

    .zety-templates-grid {
        max-width: 1200px;
        margin: 3rem auto 0;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }

    .zety-template-card {
        background: #fff;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        transition: all 0.3s;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .zety-template-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(102, 126, 234, 0.2);
        border-color: #667eea;
    }

    .zety-template-image {
        width: 100%;
        aspect-ratio: 3/4;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .zety-template-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .zety-template-card:hover .zety-template-image img {
        transform: scale(1.05);
    }

    .zety-template-name {
        padding: 1rem 1.25rem;
        text-align: center;
        font-weight: 600;
        color: #1a202c;
        font-size: 0.9375rem;
        background: #fff;
        border-top: 1px solid #f1f5f9;
    }

    /* SIMPLE PRICING */
    .zety-pricing {
        padding: 5rem 2rem;
        background: #f7fafc;
    }

    .zety-pricing-grid {
        max-width: 900px;
        margin: 3rem auto 0;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .zety-price-card {
        background: #fff;
        border-radius: 0.75rem;
        padding: 2.5rem 2rem;
        border: 2px solid #e2e8f0;
        transition: all 0.2s;
        text-align: center;
    }

    .zety-price-card:hover {
        border-color: #667eea;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .zety-price-card.featured {
        border-color: #667eea;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.2);
        position: relative;
        transform: scale(1.05);
    }

    .zety-price-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 0.375rem 1rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .zety-price-name {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 1rem;
    }

    .zety-price-amount {
        font-size: 3rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 0.5rem;
    }

    .zety-price-amount small {
        font-size: 1.25rem;
        color: #4a5568;
        font-weight: 500;
    }

    .zety-price-period {
        color: #4a5568;
        margin-bottom: 2rem;
        font-size: 0.9375rem;
    }

    .zety-price-features {
        list-style: none;
        margin-bottom: 2rem;
        text-align: left;
    }

    .zety-price-features li {
        padding: 0.75rem 0;
        color: #4a5568;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .zety-price-features li svg {
        color: #667eea;
        flex-shrink: 0;
    }

    .zety-price-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .zety-price-btn:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .zety-price-card.featured .zety-price-btn {
        background: #1a202c;
    }

    .zety-price-card.featured .zety-price-btn:hover {
        background: #2d3748;
    }

    /* FINAL CTA - SIMPLE */
    .zety-final-cta {
        padding: 5rem 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        text-align: center;
        color: #fff;
    }

    .zety-final-cta h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .zety-final-cta p {
        font-size: 1.25rem;
        margin-bottom: 2.5rem;
        opacity: 0.95;
    }

    .zety-final-cta .zety-btn-large {
        background: #fff;
        color: #667eea;
    }

    .zety-final-cta .zety-btn-large:hover {
        background: #f7fafc;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* FOOTER - SIMPLE */
    .zety-footer {
        background: #1a202c;
        color: #cbd5e0;
        padding: 3rem 2rem 2rem;
    }

    .zety-footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 3rem;
        margin-bottom: 2rem;
    }

    .zety-footer-col h4 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .zety-footer-link {
        display: block;
        color: #cbd5e0;
        text-decoration: none;
        margin-bottom: 0.75rem;
        font-size: 0.9375rem;
        transition: color 0.2s;
    }

    .zety-footer-link:hover {
        color: #667eea;
    }

    .zety-footer-bottom {
        max-width: 1200px;
        margin: 0 auto;
        padding-top: 2rem;
        border-top: 1px solid #2d3748;
        text-align: center;
        color: #718096;
        font-size: 0.875rem;
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .zety-hero-container,
        .zety-features-grid {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .zety-steps,
        .zety-templates-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .zety-pricing-grid {
            grid-template-columns: 1fr;
        }

        .zety-price-card.featured {
            transform: scale(1);
        }
    }

    @media (max-width: 768px) {
        .zety-hero-left h1 {
            font-size: 2rem;
        }

        .zety-section-title {
            font-size: 2rem;
        }

        .zety-steps,
        .zety-templates-grid,
        .zety-footer-content {
            grid-template-columns: 1fr;
        }

        .zety-hero-cta {
            flex-direction: column;
        }

        .zety-btn-large {
            width: 100%;
        }

        .zety-nav {
            display: none;
        }
    }
</style>

<!-- HEADER -->
<header class="zety-header">
    <div class="zety-header-content">
        <a href="/" class="zety-logo">
            <div class="zety-logo-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                    <path d="M14 2v6h6"/>
                    <line x1="8" y1="13" x2="16" y2="13" stroke="white" stroke-width="1.5" fill="none"/>
                    <line x1="8" y1="17" x2="16" y2="17" stroke="white" stroke-width="1.5" fill="none"/>
                </svg>
            </div>
            <span class="zety-logo-text">{{ config('app.name') }}</span>
        </a>
        <nav class="zety-nav">
            <a href="#features" class="zety-nav-link">Features</a>
            <a href="#templates" class="zety-nav-link">Templates</a>
            <a href="#pricing" class="zety-nav-link">Pricing</a>
            <a href="{{ route('login') }}" class="zety-nav-link">Sign In</a>
            <a href="{{ route('register') }}" class="zety-btn">Create Resume</a>
        </nav>
    </div>
</header>

<!-- HERO -->
<section class="zety-hero">
    <div class="zety-hero-container">
        <div class="zety-hero-left">
            <h1>
                Create a <span class="green">Professional Resume</span> in Minutes
            </h1>
            <p>
                Build your perfect resume with our easy-to-use builder. Choose from professional templates, customize, and download in PDF.
            </p>
            <div class="zety-hero-cta">
                <a href="{{ route('register') }}" class="zety-btn-large zety-btn-primary">Build My Resume</a>
                <a href="#templates" class="zety-btn-large zety-btn-secondary">View Templates</a>
            </div>
            <div class="zety-trust-badge">
                <div class="zety-trust-text">
                    <strong>Trusted by 400,000+ Users</strong>
                    Average rating: 4.9/5 ⭐⭐⭐⭐⭐
                </div>
            </div>
        </div>

        <div class="zety-hero-right">
            <h3 class="zety-form-title">Live Resume Preview</h3>
            <div class="zety-resume-preview">
                <img src="{{ asset('images/148218144.png') }}" alt="Professional Resume Preview" loading="eager">
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="zety-how-it-works">
    <h2 class="zety-section-title">How It Works</h2>
    <p class="zety-section-subtitle">Create your professional resume in 3 simple steps</p>

    <div class="zety-steps">
        <div class="zety-step">
            <div class="zety-step-number">1</div>
            <h3 class="zety-step-title">Choose Template</h3>
            <p class="zety-step-text">Pick from 50+ professionally designed, ATS-friendly resume templates.</p>
        </div>

        <div class="zety-step">
            <div class="zety-step-number">2</div>
            <h3 class="zety-step-title">Fill In Details</h3>
            <p class="zety-step-text">Add your information with our easy-to-use form. See live preview as you type.</p>
        </div>

        <div class="zety-step">
            <div class="zety-step-number">3</div>
            <h3 class="zety-step-title">Download PDF</h3>
            <p class="zety-step-text">Download your professional resume in high-quality PDF format.</p>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="zety-features" id="features">
    <h2 class="zety-section-title">Why Choose {{ config('app.name') }}</h2>
    <p class="zety-section-subtitle">Everything you need to create a winning resume</p>

    <div class="zety-features-grid">
        <div class="zety-feature">
            <div class="zety-feature-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="zety-feature-content">
                <h3>ATS-Optimized Templates</h3>
                <p>All templates are optimized to pass Applicant Tracking Systems used by 99% of Fortune 500 companies.</p>
            </div>
        </div>

        <div class="zety-feature">
            <div class="zety-feature-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                </svg>
            </div>
            <div class="zety-feature-content">
                <h3>Easy Customization</h3>
                <p>Customize colors, fonts, sections, and layout with our intuitive editor. No design skills required.</p>
            </div>
        </div>

        <div class="zety-feature">
            <div class="zety-feature-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="zety-feature-content">
                <h3>Professional Content</h3>
                <p>Pre-written examples and suggestions help you describe your experience effectively.</p>
            </div>
        </div>

        <div class="zety-feature">
            <div class="zety-feature-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
            </div>
            <div class="zety-feature-content">
                <h3>Download Anytime</h3>
                <p>Download your resume in PDF format. Update and download unlimited times.</p>
            </div>
        </div>
    </div>
</section>

<!-- TEMPLATES -->
<section class="zety-templates" id="templates">
    <h2 class="zety-section-title">Professional Resume Templates</h2>
    <p class="zety-section-subtitle">Choose from 50+ expertly designed templates</p>

    <div class="zety-templates-grid">
        @php
            $templates = \App\Models\ResumeTemplate::where('active', 1)->take(8)->get(['id', 'name', 'thumb']);
        @endphp
        @foreach($templates as $template)
        <div class="zety-template-card" onclick="window.location.href='/register'">
            <div class="zety-template-image">
                <img src="{{ asset('images/' . $template->thumb) }}" alt="{{ $template->name }}" loading="lazy">
            </div>
            <div class="zety-template-name">{{ $template->name }}</div>
        </div>
        @endforeach
    </div>
</section>

<!-- PRICING -->
<section class="zety-pricing" id="pricing">
    <h2 class="zety-section-title">Simple, Transparent Pricing</h2>
    <p class="zety-section-subtitle">Choose the plan that works for you</p>

    <div class="zety-pricing-grid">
        @foreach($packages ?? [] as $key => $package)
        <div class="zety-price-card {{ $package->is_featured ? 'featured' : '' }}">
            @if($package->is_featured)
            <span class="zety-price-badge">Most Popular</span>
            @endif
            <div class="zety-price-name">{{ $package->title }}</div>
            <div class="zety-price-amount">
                {{ $currency_symbol ?? '$' }}{{ $package->wholeprice }}
                <small>/{{ $package->interval }}</small>
            </div>
            <div class="zety-price-period">Billed {{ $package->interval_number }} {{ $package->interval }}</div>

            <ul class="zety-price-features">
                <li>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Unlimited Resumes
                </li>
                <li>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $package->settings['template_premium'] ? 'All Premium' : 'Free' }} Templates
                </li>
                <li>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $package->settings['export_pdf'] ? 'Unlimited' : 'Limited' }} PDF Downloads
                </li>
            </ul>

            <a href="{{ route('billing.package', $package) }}" class="zety-price-btn">Get Started</a>
        </div>
        @endforeach
    </div>
</section>

<!-- FINAL CTA -->
<section class="zety-final-cta">
    <h2>Ready to Build Your Resume?</h2>
    <p>Join 400,000+ users who created their perfect resume with {{ config('app.name') }}</p>
    <a href="{{ route('register') }}" class="zety-btn-large">Create My Resume Now</a>
</section>

<!-- FOOTER -->
<footer class="zety-footer">
    <div class="zety-footer-content">
        <div class="zety-footer-col">
            <h4>{{ config('app.name') }}</h4>
            <a href="{{ route('about') }}" class="zety-footer-link">About Us</a>
            <a href="{{ route('contact') }}" class="zety-footer-link">Contact</a>
            <a href="{{ route('blog') }}" class="zety-footer-link">Blog</a>
        </div>
        <div class="zety-footer-col">
            <h4>Resources</h4>
            <a href="#templates" class="zety-footer-link">Templates</a>
            <a href="#features" class="zety-footer-link">Features</a>
            <a href="#pricing" class="zety-footer-link">Pricing</a>
        </div>
        <div class="zety-footer-col">
            <h4>Legal</h4>
            <a href="{{ route('privacy') }}" class="zety-footer-link">Privacy Policy</a>
            <a href="{{ route('terms') }}" class="zety-footer-link">Terms of Service</a>
        </div>
        <div class="zety-footer-col">
            <h4>Support</h4>
            <a href="{{ route('contact') }}" class="zety-footer-link">Help Center</a>
            <a href="{{ route('contact') }}" class="zety-footer-link">Contact Support</a>
        </div>
    </div>
    <div class="zety-footer-bottom">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</footer>

</body>
</html>
