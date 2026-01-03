@extends('layouts.admin')

@section('title', __('Resume Template Categories'))
@section('page-title', __('Resume Template Categories'))

@section('content')
<style>
.category-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    height: 100%;
    background: #fff;
    position: relative;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.12);
    border-color: #667eea;
}

.category-thumbnail {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
    padding-top: 75%; /* 4:3 ratio */
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-thumbnail img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-card:hover .category-thumbnail img {
    transform: scale(1.08);
}

.category-icon-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 48px;
    color: #667eea;
    opacity: 0.2;
    z-index: 1;
}

.category-info {
    padding: 20px;
}

.category-name {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 12px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.category-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f1f5f9;
}

.category-meta-item {
    display: flex;
    align-items: center;
    font-size: 13px;
    color: #64748b;
}

.category-meta-item i {
    margin-right: 6px;
    color: #667eea;
    font-size: 14px;
}

.category-actions {
    display: flex;
    gap: 8px;
}

.btn-edit-cat, .btn-delete-cat {
    flex: 1;
    font-size: 13px;
    padding: 10px 12px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-edit-cat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(70, 127, 207, 0.3);
}

.btn-delete-cat:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

.stats-card-categories {
    background: white;
    border-radius: 12px;
    padding: 0;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.stats-card-header-categories {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 25px;
    border-bottom: 3px solid rgba(255,255,255,0.2);
}

.stats-card-title-categories {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stats-grid-categories {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 0;
}

.stat-item-category {
    text-align: center;
    padding: 30px 20px;
    background: white;
    border-right: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.stat-item-category:last-child {
    border-right: none;
}

.stat-item-category:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.stat-number-category {
    font-size: 42px;
    font-weight: 800;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
}

.stat-label-category {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

.page-header-categories {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.btn-create-category {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    color: white;
}

.btn-create-category:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: white;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.empty-state-categories {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 12px;
}

.empty-state-icon-categories {
    font-size: 64px;
    color: #cbd5e1;
    margin-bottom: 20px;
}

.empty-state-title-categories {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 10px;
}

.empty-state-text-categories {
    color: #64748b;
    margin-bottom: 25px;
}

/* Pagination Styles for Categories */
.pagination-wrapper-categories {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-top: 30px;
}

.pagination-info-categories {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f1f5f9;
}

.pagination-info-text-categories {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

.pagination-info-highlight-categories {
    color: #667eea;
    font-weight: 700;
}

@media (max-width: 768px) {
    .categories-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .stats-grid-categories {
        grid-template-columns: 1fr 1fr;
    }

    .stat-item-category {
        border-right: none;
        border-bottom: 1px solid #e9ecef;
    }

    .stat-item-category:nth-child(odd) {
        border-right: 1px solid #e9ecef;
    }

    .stat-number-category {
        font-size: 36px;
    }
}

@media (max-width: 480px) {
    .categories-grid {
        grid-template-columns: 1fr;
    }

    .stats-grid-categories {
        grid-template-columns: 1fr;
    }

    .stat-item-category:nth-child(odd) {
        border-right: none;
    }
}
</style>

<!-- Header with Search and Create Button -->
<div class="page-header-categories">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="mb-3 mb-md-0">
            <h2 class="mb-1" style="font-weight: 700; color: #1e293b;">
                <i class="fe fe-folder mr-2" style="color: #667eea;"></i>Template Categories
            </h2>
            <p class="text-muted mb-0">Organize your resume templates into categories</p>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form method="get" action="{{ route('settings.resumetemplatecategories.index') }}" autocomplete="off" class="search-box">
                <div class="input-group">
                    <input type="text" name="search" value="{{ Request::get('search') }}"
                           class="form-control" placeholder="Search categories..."
                           style="border-radius: 8px 0 0 8px; border-right: 0;">
                    <button class="btn btn-outline-secondary" type="submit"
                            style="border-radius: 0 8px 8px 0; border-left: 0;">
                        <i class="fe fe-search"></i>
                    </button>
                </div>
            </form>
            <a href="{{ route('settings.resumetemplatecategories.create') }}" class="btn btn-create-category">
                <i class="fe fe-plus mr-1"></i> Add New Category
            </a>
        </div>
    </div>
</div>

@if($data->count() > 0)
    <!-- Statistics Overview -->
    <div class="stats-card-categories">
        <div class="stats-card-header-categories">
            <h5 class="stats-card-title-categories">
                <i class="fe fe-pie-chart mr-2"></i>Categories Overview
            </h5>
        </div>
        <div class="stats-grid-categories">
            <div class="stat-item-category">
                <div class="stat-number-category">{{ $data->total() }}</div>
                <div class="stat-label-category">Total Categories</div>
            </div>
            <div class="stat-item-category">
                <div class="stat-number-category">{{ $data->where('created_at', '>=', now()->subDays(30))->count() }}</div>
                <div class="stat-label-category">Added This Month</div>
            </div>
            <div class="stat-item-category">
                <div class="stat-number-category">{{ $data->where('updated_at', '>=', now()->subDays(7))->count() }}</div>
                <div class="stat-label-category">Recently Updated</div>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="categories-grid">
        @foreach($data as $item)
        <div class="category-card">
            <div class="category-thumbnail">
                <div class="category-icon-overlay">
                    <i class="fe fe-folder"></i>
                </div>
                <img src="{{ URL::to('/') }}/images/categories/{{ $item->thumb }}"
                     alt="{{ $item->name }}"
                     onerror="this.style.display='none'">
            </div>

            <div class="category-info">
                <div class="category-name" title="{{ $item->name }}">
                    {{ $item->name }}
                </div>

                <div class="category-meta">
                    <div class="category-meta-item">
                        <i class="fe fe-calendar"></i>
                        <span>Created: {{ $item->created_at->format('M j, Y') }}</span>
                    </div>
                    <div class="category-meta-item">
                        <i class="fe fe-clock"></i>
                        <span>Updated: {{ $item->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="category-actions">
                    <a href="{{ route('settings.resumetemplatecategories.edit', $item) }}"
                       class="btn btn-primary btn-edit-cat">
                        <i class="fe fe-edit-2 mr-1"></i> Edit
                    </a>
                    <form method="post"
                          action="{{ route('settings.resumetemplatecategories.destroy', $item) }}"
                          onsubmit="return confirm('@lang('Are you sure you want to delete this category?')');"
                          style="flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete-cat w-100">
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
    <div class="pagination-wrapper-categories">
        <div class="pagination-info-categories">
            <p class="pagination-info-text-categories mb-0">
                Showing
                <span class="pagination-info-highlight-categories">{{ $data->firstItem() }}</span>
                to
                <span class="pagination-info-highlight-categories">{{ $data->lastItem() }}</span>
                of
                <span class="pagination-info-highlight-categories">{{ $data->total() }}</span>
                categories
            </p>
        </div>
        <nav>
            {{ $data->appends( Request::all() )->links() }}
        </nav>
    </div>
    @endif
@else
    <!-- Empty State -->
    <div class="empty-state-categories">
        <div class="empty-state-icon-categories">
            <i class="fe fe-folder"></i>
        </div>
        <div class="empty-state-title-categories">No Categories Found</div>
        <div class="empty-state-text-categories">
            @if(Request::get('search'))
                No categories match your search "{{ Request::get('search') }}". Try a different search term.
            @else
                Get started by creating your first template category to organize your templates.
            @endif
        </div>
        @if(!Request::get('search'))
        <a href="{{ route('settings.resumetemplatecategories.create') }}" class="btn btn-create-category">
            <i class="fe fe-plus mr-1"></i> Create Your First Category
        </a>
        @else
        <a href="{{ route('settings.resumetemplatecategories.index') }}" class="btn btn-outline-secondary">
            <i class="fe fe-x mr-1"></i> Clear Search
        </a>
        @endif
    </div>
@endif
@stop
