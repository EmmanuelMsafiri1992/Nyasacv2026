@extends('layouts.admin')

@section('title', __('Subscription Packages'))
@section('page-title', __('Subscription Packages'))

@section('content')
<style>
.package-card {
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
    border-radius: 16px;
    overflow: hidden;
    height: 100%;
    background: #fff;
    position: relative;
}

.package-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
    border-color: #667eea;
}

.package-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px 25px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.package-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.3; }
}

.package-title {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 8px;
    position: relative;
    z-index: 1;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.package-duration {
    font-size: 14px;
    opacity: 0.9;
    font-weight: 500;
    position: relative;
    z-index: 1;
}

.package-price-wrapper {
    padding: 35px 25px;
    text-align: center;
    background: linear-gradient(to bottom, #f8f9fa 0%, white 100%);
    border-bottom: 2px solid #f1f5f9;
}

.package-price {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 5px;
}

.currency-symbol {
    font-size: 28px;
    font-weight: 700;
    color: #667eea;
}

.price-amount {
    font-size: 56px;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
}

.currency-code {
    font-size: 18px;
    color: #64748b;
    font-weight: 600;
}

.package-actions {
    padding: 25px;
    display: flex;
    gap: 10px;
}

.btn-edit-package {
    flex: 1;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid #667eea;
    background: white;
    color: #667eea;
}

.btn-edit-package:hover {
    background: #667eea;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
}

.btn-delete-package {
    flex: 1;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-delete-package:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.3);
}

.stats-card-packages {
    background: white;
    border-radius: 16px;
    padding: 0;
    margin-bottom: 35px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.stats-card-header-packages {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px 30px;
    border-bottom: 3px solid rgba(255,255,255,0.2);
}

.stats-card-title-packages {
    font-size: 20px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stats-grid-packages {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0;
}

.stat-item-package {
    text-align: center;
    padding: 35px 20px;
    background: white;
    border-right: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.stat-item-package:last-child {
    border-right: none;
}

.stat-item-package:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.stat-number-package {
    font-size: 44px;
    font-weight: 800;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
}

.stat-label-package {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    font-weight: 600;
}

.page-header-packages {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 35px;
}

.btn-create-package {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 14px 35px;
    font-weight: 700;
    border-radius: 10px;
    transition: all 0.3s ease;
    color: white;
    font-size: 15px;
}

.btn-create-package:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.packages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 35px;
}

.empty-state-packages {
    text-align: center;
    padding: 100px 20px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.empty-state-icon-packages {
    font-size: 80px;
    color: #cbd5e1;
    margin-bottom: 25px;
}

.empty-state-title-packages {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 12px;
}

.empty-state-text-packages {
    color: #64748b;
    font-size: 16px;
    margin-bottom: 30px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.pagination-wrapper-packages {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-top: 35px;
}

.pagination-info-packages {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f1f5f9;
}

.pagination-info-text-packages {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

.pagination-info-highlight-packages {
    color: #667eea;
    font-weight: 700;
}

@media (max-width: 768px) {
    .packages-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    .stats-grid-packages {
        grid-template-columns: 1fr 1fr;
    }

    .stat-item-package {
        border-right: none;
        border-bottom: 1px solid #e9ecef;
    }

    .stat-item-package:nth-child(odd) {
        border-right: 1px solid #e9ecef;
    }

    .stat-number-package {
        font-size: 36px;
    }

    .price-amount {
        font-size: 44px;
    }
}

@media (max-width: 480px) {
    .packages-grid {
        grid-template-columns: 1fr;
    }

    .stats-grid-packages {
        grid-template-columns: 1fr;
    }

    .stat-item-package:nth-child(odd) {
        border-right: none;
    }
}
</style>

<!-- Header -->
<div class="page-header-packages">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="mb-3 mb-md-0">
            <h2 class="mb-1" style="font-weight: 800; color: #1e293b;">
                <i class="fe fe-package mr-2" style="color: #667eea;"></i>Subscription Packages
            </h2>
            <p class="text-muted mb-0">Manage pricing plans and subscription options for your users</p>
        </div>
        <div>
            <a href="{{ route('settings.packages.create') }}" class="btn btn-create-package">
                <i class="fe fe-plus mr-2"></i>Create New Package
            </a>
        </div>
    </div>
</div>

@if($data->count() > 0)
    <!-- Statistics Overview -->
    <div class="stats-card-packages">
        <div class="stats-card-header-packages">
            <h5 class="stats-card-title-packages">
                <i class="fe fe-trending-up mr-2"></i>Packages Overview
            </h5>
        </div>
        <div class="stats-grid-packages">
            <div class="stat-item-package">
                <div class="stat-number-package">{{ $data->total() }}</div>
                <div class="stat-label-package">Total Packages</div>
            </div>
            <div class="stat-item-package">
                <div class="stat-number-package">{{ config('rb.CURRENCY_SYMBOL') }}{{ number_format($data->min('price'), 0) }}</div>
                <div class="stat-label-package">Starting From</div>
            </div>
            <div class="stat-item-package">
                <div class="stat-number-package">{{ config('rb.CURRENCY_SYMBOL') }}{{ number_format($data->max('price'), 0) }}</div>
                <div class="stat-label-package">Highest Price</div>
            </div>
        </div>
    </div>

    <!-- Packages Grid -->
    <div class="packages-grid">
        @foreach($data as $item)
        <div class="package-card">
            <div class="package-header">
                <div class="package-title">{{ $item->title }}</div>
                <div class="package-duration">
                    <i class="fe fe-clock mr-1"></i>{{ $item->interval_number }} {{ ucfirst($item->interval) }}
                </div>
            </div>

            <div class="package-price-wrapper">
                <div class="package-price">
                    <span class="currency-symbol">{{ config('rb.CURRENCY_SYMBOL') }}</span>
                    <span class="price-amount">{{ number_format($item->price, 0) }}</span>
                    <span class="currency-code">{{ config('rb.CURRENCY_CODE') }}</span>
                </div>
            </div>

            <div class="package-actions">
                <a href="{{ route('settings.packages.edit', $item) }}"
                   class="btn btn-edit-package">
                    <i class="fe fe-edit-2 mr-1"></i> Edit Package
                </a>
                <form method="post"
                      action="{{ route('settings.packages.destroy', $item) }}"
                      onsubmit="return confirm('@lang('Are you sure you want to delete this package?')');"
                      style="flex: 1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-delete-package w-100">
                        <i class="fe fe-trash-2 mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($data->hasPages())
    <div class="pagination-wrapper-packages">
        <div class="pagination-info-packages">
            <p class="pagination-info-text-packages mb-0">
                Showing
                <span class="pagination-info-highlight-packages">{{ $data->firstItem() }}</span>
                to
                <span class="pagination-info-highlight-packages">{{ $data->lastItem() }}</span>
                of
                <span class="pagination-info-highlight-packages">{{ $data->total() }}</span>
                packages
            </p>
        </div>
        <nav>
            {{ $data->appends( Request::all() )->links() }}
        </nav>
    </div>
    @endif
@else
    <!-- Empty State -->
    <div class="empty-state-packages">
        <div class="empty-state-icon-packages">
            <i class="fe fe-package"></i>
        </div>
        <div class="empty-state-title-packages">No Packages Yet</div>
        <div class="empty-state-text-packages">
            Start monetizing your platform by creating subscription packages for your users. Define pricing, duration, and features for each plan.
        </div>
        <a href="{{ route('settings.packages.create') }}" class="btn btn-create-package">
            <i class="fe fe-plus mr-2"></i>Create Your First Package
        </a>
    </div>
@endif
@stop
