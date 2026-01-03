@extends('layouts.dashboard')

@section('title', __('Choose Template'))
@section('header-title', __('Choose Template'))

@section('content')
<div class="dashboard-content">
    <div class="mb-4">
        <h2 class="mb-0">@lang('Choose a Template')</h2>
        <p class="text-muted mb-0">@lang('Select the perfect template for your professional resume')</p>
    </div>

    <!-- Template Categories -->
    <div class="card mb-4">
        <div class="card-body">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a href="{{ url('resume/template')}}" class="nav-link {{ (request()->is('resume/template')) ? 'active' : '' }}">
                        <i class="fe fe-grid mr-2"></i>@lang("All Templates")
                    </a>
                </li>
                @foreach($categories as $item)
                    <li class="nav-item">
                        <a href="{{ url('resume/template/'). '/' .$item->id}}" class="nav-link {{ request()->is('resume/template/'.$item->id) ? 'active' : '' }}">
                            {{$item->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Templates Grid -->
    @if($data->count() > 0)
        <div class="row">
            @foreach($data as $item)
                <div class="col-md-6 col-lg-4 mb-4">
                    @php
                        $templateType = 'Modern';
                        if (strpos($item->name, 'Professional') !== false) $templateType = 'Professional';
                        elseif (strpos($item->name, 'Creative') !== false) $templateType = 'Creative';
                        elseif (strpos($item->name, 'Executive') !== false) $templateType = 'Executive';
                    @endphp
                    <div class="card card-template h-100" data-template-type="{{ $templateType }}">
                        @if($item->is_premium)
                            <div class="ribbon ribbon-top ribbon-bookmark bg-warning">
                                <i class="fe fe-star"></i> @lang("Premium")
                            </div>
                        @endif
                        @php
                            $parts = explode(' - ', $item->name);
                            $profession = isset($parts[0]) ? $parts[0] : $item->name;
                            $style = isset($parts[1]) ? $parts[1] : 'Modern';

                            // Define colors for each style
                            $styleColors = [
                                'Modern' => ['bg' => '#0ea5e9', 'gradient' => 'linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%)', 'icon' => 'zap'],
                                'Professional' => ['bg' => '#059669', 'gradient' => 'linear-gradient(135deg, #059669 0%, #047857 100%)', 'icon' => 'briefcase'],
                                'Creative' => ['bg' => '#ec4899', 'gradient' => 'linear-gradient(135deg, #ec4899 0%, #db2777 100%)', 'icon' => 'palette'],
                                'Executive' => ['bg' => '#1e40af', 'gradient' => 'linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%)', 'icon' => 'award']
                            ];
                            $color = $styleColors[$templateType] ?? $styleColors['Modern'];
                        @endphp

                        <a href="{{ url('resume/createresume/' . $item->id) }}" class="template-link">
                            <div class="template-preview-card" style="background: {{ $color['gradient'] }}; min-height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 20px; border-radius: 12px; position: relative; overflow: hidden;">

                                <!-- Background Pattern -->
                                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1; background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,.5) 10px, rgba(255,255,255,.5) 20px);"></div>

                                <!-- Content -->
                                <div style="position: relative; z-index: 1; text-align: center; color: white;">
                                    <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; backdrop-filter: blur(10px);">
                                        <i class="fe fe-{{ $color['icon'] }}" style="font-size: 40px;"></i>
                                    </div>

                                    <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 10px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">{{ $profession }}</h4>

                                    <div style="display: inline-block; background: rgba(255,255,255,0.25); padding: 8px 20px; border-radius: 20px; font-size: 14px; font-weight: 600; margin-bottom: 15px; backdrop-filter: blur(10px);">
                                        {{ $templateType }} DESIGN
                                    </div>

                                    <div style="font-size: 13px; opacity: 0.9; line-height: 1.6; max-width: 250px; margin: 0 auto;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap; margin-top: 15px;">
                                            @if($templateType == 'Modern')
                                                <span style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 12px; font-size: 11px;">Tech-Forward</span>
                                                <span style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 12px; font-size: 11px;">Clean</span>
                                            @elseif($templateType == 'Professional')
                                                <span style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 12px; font-size: 11px;">Formal</span>
                                                <span style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 12px; font-size: 11px;">Corporate</span>
                                            @elseif($templateType == 'Creative')
                                                <span style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 12px; font-size: 11px;">Artistic</span>
                                                <span style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 12px; font-size: 11px;">Unique</span>
                                            @else
                                                <span style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 12px; font-size: 11px;">C-Level</span>
                                                <span style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 12px; font-size: 11px;">Premium</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Hover Overlay -->
                                <div class="template-overlay">
                                    <div class="template-actions">
                                        <button class="btn btn-light btn-lg" style="font-weight: 600;">
                                            <i class="fe fe-edit mr-2"></i>@lang('Use This Template')
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body text-center">
                                <h5 class="card-title mb-2" style="font-size: 15px; font-weight: 700;">{{ $item->name }}</h5>
                                @if($item->is_premium)
                                    <span class="badge badge-warning">
                                        <i class="fe fe-star"></i> @lang('Premium')
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        <i class="fe fe-check"></i> @lang('Free')
                                    </span>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $data->appends( Request::all() )->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fe fe-layout" style="font-size: 80px; color: #e0e0e0;"></i>
                </div>
                <h3>@lang('No Templates Found')</h3>
                <p class="text-muted mb-4">@lang('No templates available in this category. Try selecting a different category.')</p>
                <a href="{{ url('resume/template')}}" class="btn btn-primary">
                    <i class="fe fe-grid mr-2"></i>@lang('View All Templates')
                </a>
            </div>
        </div>
    @endif
</div>

@section('styles')
<style>
.card-template {
    transition: transform 0.3s, box-shadow 0.3s;
    overflow: hidden;
}

.card-template:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.template-link {
    text-decoration: none;
    color: inherit;
}

.template-link:hover {
    text-decoration: none;
    color: inherit;
}

.template-preview {
    position: relative;
    overflow: hidden;
    background: white;
    padding: 0;
    height: 400px;
}

.template-iframe {
    background: white;
}

.card-template:hover .template-iframe {
    transform: scale(0.32) !important;
    transition: transform 0.3s;
}

.template-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(102, 126, 234, 0.95);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.card-template:hover .template-overlay {
    opacity: 1;
}

.template-actions {
    transform: translateY(20px);
    transition: transform 0.3s;
}

.card-template:hover .template-actions {
    transform: translateY(0);
}

.ribbon {
    width: 100px;
    position: absolute;
    top: 10px;
    right: -10px;
    padding: 5px 10px;
    color: white;
    text-align: center;
    font-size: 12px;
    font-weight: bold;
    z-index: 10;
}

.ribbon-bookmark:before {
    content: '';
    position: absolute;
    right: 0;
    bottom: -10px;
    border-left: 50px solid transparent;
    border-right: 50px solid;
    border-right-color: inherit;
    border-bottom: 10px solid transparent;
}

.nav-pills .nav-link {
    border-radius: 8px;
    font-weight: 500;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Template Type Badges */
.template-link .card-title {
    font-size: 15px;
    font-weight: 700;
    line-height: 1.4;
    color: #333;
}

.template-link .text-muted {
    font-size: 12px;
    font-weight: 500;
}

/* Add colored border based on template type */
.card-template[data-template-type="Modern"] .template-preview {
    border-left: 5px solid #0ea5e9;
}

.card-template[data-template-type="Professional"] .template-preview {
    border-left: 5px solid #059669;
}

.card-template[data-template-type="Creative"] .template-preview {
    border-left: 5px solid #ec4899;
}

.card-template[data-template-type="Executive"] .template-preview {
    border-left: 5px solid #1e40af;
}
</style>
@endsection

@section('scripts')
<script>
function previewTemplate(templateId) {
    // This would open a modal with full template preview
    // For now, it just prevents the link click
    console.log('Preview template:', templateId);
}
</script>
@endsection
@endsection
