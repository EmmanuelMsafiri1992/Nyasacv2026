<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $card->full_name }} - {{ $card->job_title ?? 'Virtual Card' }}</title>

    <meta name="description" content="{{ $card->bio ?? $card->full_name . ' - Digital Business Card' }}">
    <meta property="og:title" content="{{ $card->full_name }}">
    <meta property="og:description" content="{{ $card->bio ?? 'Digital Business Card' }}">
    @if($card->profile_photo)
    <meta property="og:image" content="{{ Storage::url($card->profile_photo) }}">
    @endif

    <link rel="stylesheet" href="{{ mix('css/app.bundle.css') }}">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .vcard-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .vcard {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .vcard-cover {
            height: 200px;
            background: linear-gradient(135deg, {{ $card->primary_color ?? '#667eea' }} 0%, {{ $card->primary_color ?? '#764ba2' }} 100%);
            position: relative;
        }

        .vcard-profile {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 6px solid white;
            position: absolute;
            bottom: -75px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .vcard-profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vcard-body {
            padding: 90px 30px 30px;
            text-align: center;
        }

        .vcard-name {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .vcard-title {
            font-size: 18px;
            color: {{ $card->primary_color ?? '#667eea' }};
            font-weight: 600;
            margin-bottom: 4px;
        }

        .vcard-company {
            font-size: 16px;
            color: #718096;
            margin-bottom: 20px;
        }

        .vcard-bio {
            font-size: 15px;
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .vcard-info {
            display: grid;
            gap: 12px;
            margin-bottom: 30px;
        }

        .vcard-info-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 12px 20px;
            background: #f7fafc;
            border-radius: 12px;
            color: #2d3748;
            text-decoration: none;
            transition: all 0.2s;
        }

        .vcard-info-item:hover {
            background: {{ $card->primary_color ?? '#667eea' }};
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .vcard-info-item i {
            font-size: 18px;
        }

        .vcard-social {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .vcard-social a {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #f7fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4a5568;
            transition: all 0.2s;
            font-size: 20px;
        }

        .vcard-social a:hover {
            background: {{ $card->primary_color ?? '#667eea' }};
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .vcard-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .vcard-btn {
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .vcard-btn-primary {
            background: {{ $card->primary_color ?? '#667eea' }};
            color: white;
        }

        .vcard-btn-primary:hover {
            background: {{ $card->primary_color ?? '#5568d3' }};
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .vcard-btn-secondary {
            background: #f7fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }

        .vcard-btn-secondary:hover {
            background: white;
            border-color: {{ $card->primary_color ?? '#667eea' }};
            color: {{ $card->primary_color ?? '#667eea' }};
            transform: translateY(-2px);
        }

        .vcard-qr {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .vcard-qr img {
            max-width: 200px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .vcard-footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: white;
        }

        .vcard-footer a {
            color: white;
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .vcard-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="vcard-container">
        <div class="vcard">
            <!-- Cover Photo -->
            <div class="vcard-cover" style="background-image: url('{{ $card->cover_photo ? Storage::url($card->cover_photo) : '' }}'); background-size: cover; background-position: center;">
                <div class="vcard-profile">
                    @if($card->profile_photo)
                        <img src="{{ Storage::url($card->profile_photo) }}" alt="{{ $card->full_name }}">
                    @else
                        <div style="width: 100%; height: 100%; background: {{ $card->primary_color ?? '#667eea' }}; display: flex; align-items: center; justify-content: center; font-size: 48px; font-weight: 700; color: white;">
                            {{ substr($card->full_name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Body -->
            <div class="vcard-body">
                <h1 class="vcard-name">{{ $card->full_name }}</h1>

                @if($card->job_title)
                    <div class="vcard-title">{{ $card->job_title }}</div>
                @endif

                @if($card->company)
                    <div class="vcard-company">{{ $card->company }}</div>
                @endif

                @if($card->bio)
                    <p class="vcard-bio">{{ $card->bio }}</p>
                @endif

                <!-- Contact Information -->
                <div class="vcard-info">
                    @if($card->email)
                        <a href="mailto:{{ $card->email }}" class="vcard-info-item">
                            <i class="fe fe-mail"></i>
                            <span>{{ $card->email }}</span>
                        </a>
                    @endif

                    @if($card->phone)
                        <a href="tel:{{ $card->phone }}" class="vcard-info-item">
                            <i class="fe fe-phone"></i>
                            <span>{{ $card->phone }}</span>
                        </a>
                    @endif

                    @if($card->website)
                        <a href="{{ $card->website }}" target="_blank" class="vcard-info-item">
                            <i class="fe fe-globe"></i>
                            <span>{{ parse_url($card->website, PHP_URL_HOST) }}</span>
                        </a>
                    @endif

                    @if($card->location)
                        <div class="vcard-info-item">
                            <i class="fe fe-map-pin"></i>
                            <span>{{ $card->location }}</span>
                        </div>
                    @endif
                </div>

                <!-- Social Media -->
                @if($card->social_links && count($card->social_links) > 0)
                    <div class="vcard-social">
                        @if(isset($card->social_links['linkedin']))
                            <a href="{{ $card->social_links['linkedin'] }}" target="_blank" title="LinkedIn">
                                <i class="fe fe-linkedin"></i>
                            </a>
                        @endif
                        @if(isset($card->social_links['twitter']))
                            <a href="{{ $card->social_links['twitter'] }}" target="_blank" title="Twitter">
                                <i class="fe fe-twitter"></i>
                            </a>
                        @endif
                        @if(isset($card->social_links['facebook']))
                            <a href="{{ $card->social_links['facebook'] }}" target="_blank" title="Facebook">
                                <i class="fe fe-facebook"></i>
                            </a>
                        @endif
                        @if(isset($card->social_links['instagram']))
                            <a href="{{ $card->social_links['instagram'] }}" target="_blank" title="Instagram">
                                <i class="fe fe-instagram"></i>
                            </a>
                        @endif
                        @if(isset($card->social_links['github']))
                            <a href="{{ $card->social_links['github'] }}" target="_blank" title="GitHub">
                                <i class="fe fe-github"></i>
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Actions -->
                <div class="vcard-actions">
                    <a href="{{ route('card.download', $card->slug) }}" class="vcard-btn vcard-btn-primary">
                        <i class="fe fe-download"></i>
                        <span>Save Contact</span>
                    </a>
                    <a href="#" onclick="shareCard(); return false;" class="vcard-btn vcard-btn-secondary">
                        <i class="fe fe-share-2"></i>
                        <span>Share Card</span>
                    </a>
                </div>

                <!-- QR Code -->
                <div class="vcard-qr">
                    <p style="color: #718096; margin-bottom: 15px;">Scan to save contact</p>
                    <img src="{{ $card->qr_code_url }}" alt="QR Code">
                </div>
            </div>
        </div>

        <div class="vcard-footer">
            <p>Powered by <a href="{{ url('/') }}">{{ config('app.name') }}</a></p>
        </div>
    </div>

    <script>
        function shareCard() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $card->full_name }}',
                    text: '{{ $card->job_title ?? "Virtual Card" }}',
                    url: window.location.href
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('Link copied to clipboard!');
            }
        }
    </script>
</body>
</html>
