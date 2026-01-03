@extends('layouts.admin')

@section('title', __('Resume Templates'))
@section('page-title', __('Resume Templates'))

@section('content')
<style>
.template-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
    height: 100%;
    background: #fff;
}

.template-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-color: #467fcf;
}

.template-thumbnail {
    position: relative;
    overflow: hidden;
    background: #f8f9fa;
    padding-top: 141.4%; /* A4 ratio (1:1.414) */
}

.template-thumbnail img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.template-card:hover .template-thumbnail img {
    transform: scale(1.05);
}

.template-badges {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 2;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.template-info {
    padding: 20px;
}

.template-name {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 10px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.template-actions {
    display: flex;
    gap: 8px;
    margin-top: 15px;
}

.btn-edit, .btn-delete {
    flex: 1;
    font-size: 13px;
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: 500;
}

.stats-card {
    background: white;
    border-radius: 10px;
    padding: 0;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.stats-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 25px;
    border-bottom: 3px solid rgba(255,255,255,0.2);
}

.stats-card-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0;
    padding: 0;
}

.stat-item {
    text-align: center;
    padding: 30px 20px;
    background: white;
    border-right: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.stat-item:last-child {
    border-right: none;
}

.stat-item:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.stat-number {
    font-size: 42px;
    font-weight: 800;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
}

.stat-label {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

.page-header-modern {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 25px;
}

.search-box {
    max-width: 400px;
}

.badge-premium {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border: none;
    padding: 5px 12px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.badge-free {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    border: none;
    padding: 5px 12px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.badge-active {
    background: #10b981;
    padding: 5px 12px;
    font-size: 11px;
    font-weight: 600;
}

.badge-inactive {
    background: #f59e0b;
    padding: 5px 12px;
    font-size: 11px;
    font-weight: 600;
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 10px;
}

.empty-state-icon {
    font-size: 64px;
    color: #cbd5e1;
    margin-bottom: 20px;
}

.empty-state-title {
    font-size: 24px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 10px;
}

.empty-state-text {
    color: #64748b;
    margin-bottom: 25px;
}

.btn-create {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    transition: transform 0.2s ease;
}

.btn-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.templates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

@media (max-width: 768px) {
    .templates-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }

    .stat-item {
        border-right: none;
        border-bottom: 1px solid #e9ecef;
    }

    .stat-item:nth-child(odd) {
        border-right: 1px solid #e9ecef;
    }

    .stat-number {
        font-size: 36px;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .stat-item:nth-child(odd) {
        border-right: none;
    }
}

/* Pagination Styles */
.pagination-wrapper {
    background: white;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-top: 30px;
}

.pagination-info {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f1f5f9;
}

.pagination-info-text {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

.pagination-info-highlight {
    color: #667eea;
    font-weight: 700;
}

.pagination {
    margin: 0;
    justify-content: center;
    gap: 8px;
}

.pagination .page-item {
    margin: 0;
}

.pagination .page-link {
    border: 2px solid #e2e8f0;
    color: #475569;
    padding: 10px 16px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    min-width: 45px;
    text-align: center;
    background: white;
}

.pagination .page-link:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.pagination .page-item.disabled .page-link {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #cbd5e1;
    cursor: not-allowed;
}

.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    font-weight: 700;
    padding: 10px 20px;
}

.pagination .page-link i {
    font-size: 14px;
}

@media (max-width: 576px) {
    .pagination .page-link {
        padding: 8px 12px;
        font-size: 13px;
        min-width: 38px;
    }

    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 8px 14px;
    }

    .pagination-wrapper {
        padding: 20px 15px;
    }
}
</style>

<!-- Header with Search and Create Button -->
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="mb-3 mb-md-0">
            <h2 class="mb-1" style="font-weight: 700; color: #1e293b;">Resume Templates</h2>
            <p class="text-muted mb-0">Manage and organize your resume template collection</p>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form method="get" action="{{ route('settings.resumetemplate.index') }}" autocomplete="off" class="search-box">
                <div class="input-group">
                    <input type="text" name="search" value="{{ Request::get('search') }}"
                           class="form-control" placeholder="Search templates..."
                           style="border-radius: 8px 0 0 8px; border-right: 0;">
                    <button class="btn btn-outline-secondary" type="submit"
                            style="border-radius: 0 8px 8px 0; border-left: 0;">
                        <i class="fe fe-search"></i>
                    </button>
                </div>
            </form>
            <a href="{{ route('settings.resumetemplate.create') }}" class="btn btn-create text-white">
                <i class="fe fe-plus mr-1"></i> Add New Template
            </a>
        </div>
    </div>
</div>

@if($data->count() > 0)
    <!-- Statistics Overview -->
    <div class="stats-card">
        <div class="stats-card-header">
            <h5 class="stats-card-title">
                <i class="fe fe-bar-chart-2 mr-2"></i>Templates Overview
            </h5>
        </div>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ $data->total() }}</div>
                <div class="stat-label">Total Templates</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $data->where('active', true)->count() }}</div>
                <div class="stat-label">Active Templates</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $data->where('is_premium', true)->count() }}</div>
                <div class="stat-label">Premium Templates</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $data->where('is_premium', false)->count() }}</div>
                <div class="stat-label">Free Templates</div>
            </div>
        </div>
    </div>

    <!-- Templates Grid -->
    <div class="templates-grid">
        @foreach($data as $item)
        <div class="template-card">
            <div class="template-thumbnail">
                <img src="{{ URL::to('/') }}/images/{{ $item->thumb }}"
                     alt="{{ $item->name }}"
                     onerror="this.src='{{ URL::to('/') }}/images/placeholder-template.png'">

                <div class="template-badges">
                    @if($item->is_premium)
                        <span class="badge badge-premium">PREMIUM</span>
                    @else
                        <span class="badge badge-free">FREE</span>
                    @endif

                    @if($item->active)
                        <span class="badge badge-active">ACTIVE</span>
                    @else
                        <span class="badge badge-inactive">INACTIVE</span>
                    @endif
                </div>
            </div>

            <div class="template-info">
                <div class="template-name" title="{{ $item->name }}">
                    {{ $item->name }}
                </div>

                <div class="template-actions">
                    <a href="{{ route('settings.resumetemplate.edit', $item) }}"
                       class="btn btn-primary btn-edit">
                        <i class="fe fe-edit-2 mr-1"></i> Edit
                    </a>
                    <form method="post"
                          action="{{ route('settings.resumetemplate.destroy', $item) }}"
                          onsubmit="return confirm('@lang('Are you sure you want to delete this template?')');"
                          style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete w-100">
                            <i class="fe fe-trash-2 mr-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($data->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            <p class="pagination-info-text mb-0">
                Showing
                <span class="pagination-info-highlight">{{ $data->firstItem() }}</span>
                to
                <span class="pagination-info-highlight">{{ $data->lastItem() }}</span>
                of
                <span class="pagination-info-highlight">{{ $data->total() }}</span>
                templates
            </p>
        </div>
        <nav>
            {{ $data->appends( Request::all() )->links() }}
        </nav>
    </div>
    @endif
@else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fe fe-file-text"></i>
        </div>
        <div class="empty-state-title">No Resume Templates Found</div>
        <div class="empty-state-text">
            @if(Request::get('search'))
                No templates match your search "{{ Request::get('search') }}". Try a different search term.
            @else
                Get started by creating your first resume template.
            @endif
        </div>
        @if(!Request::get('search'))
        <a href="{{ route('settings.resumetemplate.create') }}" class="btn btn-create text-white">
            <i class="fe fe-plus mr-1"></i> Create Your First Template
        </a>
        @else
        <a href="{{ route('settings.resumetemplate.index') }}" class="btn btn-outline-secondary">
            <i class="fe fe-x mr-1"></i> Clear Search
        </a>
        @endif
    </div>
@endif
@stop
