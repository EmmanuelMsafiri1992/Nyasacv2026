@extends('layouts.admin')

@section('title', __('Payments'))
@section('page-title', __('Payments'))

@section('content')
<style>
.payment-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 20px 25px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.payment-card:hover {
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
    border-color: #667eea;
    transform: translateX(5px);
}

.payment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f5f9;
}

.payment-user {
    display: flex;
    align-items: center;
    gap: 12px;
}

.payment-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 18px;
}

.payment-user-info h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
}

.payment-user-info p {
    margin: 0;
    font-size: 13px;
    color: #64748b;
}

.payment-status {
    display: flex;
    align-items: center;
    gap: 8px;
}

.badge-paid {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}

.badge-unpaid {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}

.payment-body {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.payment-detail {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.payment-detail-label {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.payment-detail-value {
    font-size: 15px;
    color: #1e293b;
    font-weight: 600;
}

.payment-amount {
    font-size: 24px !important;
    font-weight: 800 !important;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.payment-reference {
    font-size: 12px;
    color: #94a3b8;
    font-family: monospace;
}

.stats-card-payments {
    background: white;
    border-radius: 16px;
    padding: 0;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}

.stats-card-header-payments {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px 30px;
    border-bottom: 3px solid rgba(255,255,255,0.2);
}

.stats-card-title-payments {
    font-size: 20px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stats-grid-payments {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 0;
}

.stat-item-payment {
    text-align: center;
    padding: 35px 20px;
    background: white;
    border-right: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.stat-item-payment:last-child {
    border-right: none;
}

.stat-item-payment:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.stat-number-payment {
    font-size: 40px;
    font-weight: 800;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
}

.stat-label-payment {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

.page-header-payments {
    background: white;
    padding: 25px 30px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.search-box-payments {
    max-width: 500px;
}

.empty-state-payments {
    text-align: center;
    padding: 100px 20px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.empty-state-icon-payments {
    font-size: 80px;
    color: #cbd5e1;
    margin-bottom: 25px;
}

.empty-state-title-payments {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 12px;
}

.empty-state-text-payments {
    color: #64748b;
    font-size: 16px;
    margin-bottom: 30px;
}

.pagination-wrapper-payments {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-top: 30px;
}

.pagination-info-payments {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f1f5f9;
}

.pagination-info-text-payments {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

.pagination-info-highlight-payments {
    color: #667eea;
    font-weight: 700;
}

@media (max-width: 768px) {
    .payment-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .payment-body {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .stats-grid-payments {
        grid-template-columns: 1fr 1fr;
    }

    .stat-item-payment {
        border-right: none;
        border-bottom: 1px solid #e9ecef;
    }

    .stat-item-payment:nth-child(odd) {
        border-right: 1px solid #e9ecef;
    }

    .stat-number-payment {
        font-size: 32px;
    }
}

@media (max-width: 480px) {
    .stats-grid-payments {
        grid-template-columns: 1fr;
    }

    .stat-item-payment:nth-child(odd) {
        border-right: none;
    }

    .payment-card:hover {
        transform: none;
    }
}
</style>

<!-- Header with Search -->
<div class="page-header-payments">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="mb-3 mb-md-0">
            <h2 class="mb-1" style="font-weight: 800; color: #1e293b;">
                <i class="fe fe-credit-card mr-2" style="color: #667eea;"></i>Payment Transactions
            </h2>
            <p class="text-muted mb-0">Track and manage all payment transactions</p>
        </div>
        <div class="search-box-payments">
            <form method="get" action="{{ route('settings.payments') }}" autocomplete="off">
                <div class="input-group">
                    <input type="text" name="search" value="{{ Request::get('search') }}"
                           class="form-control" placeholder="Search by user, package, or reference..."
                           style="border-radius: 8px 0 0 8px; border-right: 0;">
                    <button class="btn btn-outline-secondary" type="submit"
                            style="border-radius: 0 8px 8px 0; border-left: 0;">
                        <i class="fe fe-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($data->count() > 0)
    <!-- Statistics Overview -->
    <div class="stats-card-payments">
        <div class="stats-card-header-payments">
            <h5 class="stats-card-title-payments">
                <i class="fe fe-activity mr-2"></i>Payment Analytics
            </h5>
        </div>
        <div class="stats-grid-payments">
            <div class="stat-item-payment">
                <div class="stat-number-payment">{{ $data->total() }}</div>
                <div class="stat-label-payment">Total Transactions</div>
            </div>
            <div class="stat-item-payment">
                <div class="stat-number-payment">{{ config('rb.CURRENCY_SYMBOL') }}{{ number_format($data->sum('total'), 2) }}</div>
                <div class="stat-label-payment">Total Revenue</div>
            </div>
            <div class="stat-item-payment">
                <div class="stat-number-payment">{{ $data->where('is_paid', true)->count() }}</div>
                <div class="stat-label-payment">Successful Payments</div>
            </div>
            <div class="stat-item-payment">
                <div class="stat-number-payment">{{ $data->where('is_paid', false)->count() }}</div>
                <div class="stat-label-payment">Pending Payments</div>
            </div>
        </div>
    </div>

    <!-- Payments List -->
    <div class="payments-list">
        @foreach($data as $item)
        <div class="payment-card">
            <div class="payment-header">
                <div class="payment-user">
                    <div class="payment-avatar">
                        {{ strtoupper(substr($item->user->name, 0, 1)) }}
                    </div>
                    <div class="payment-user-info">
                        <h4>{{ $item->user->name }}</h4>
                        <p>
                            <i class="fe fe-calendar mr-1"></i>
                            {{ $item->created_at->format('M d, Y') }} at {{ $item->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
                <div class="payment-status">
                    @if($item->is_paid)
                        <span class="badge-paid">
                            <i class="fe fe-check-circle"></i> Paid
                        </span>
                    @else
                        <span class="badge-unpaid">
                            <i class="fe fe-clock"></i> Pending
                        </span>
                    @endif
                </div>
            </div>

            <div class="payment-body">
                <div class="payment-detail">
                    <span class="payment-detail-label">Package</span>
                    <span class="payment-detail-value">{{ $item->package->title }}</span>
                </div>

                <div class="payment-detail">
                    <span class="payment-detail-label">Payment Gateway</span>
                    <span class="payment-detail-value">@lang('saas.payment_' . $item->gateway)</span>
                    <span class="payment-reference">Ref: {{ $item->reference }}</span>
                </div>

                <div class="payment-detail">
                    <span class="payment-detail-label">Amount</span>
                    <span class="payment-detail-value payment-amount">
                        {{ config('rb.CURRENCY_SYMBOL') }}{{ number_format($item->total, 2) }} {{ $item->currency }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($data->hasPages())
    <div class="pagination-wrapper-payments">
        <div class="pagination-info-payments">
            <p class="pagination-info-text-payments mb-0">
                Showing
                <span class="pagination-info-highlight-payments">{{ $data->firstItem() }}</span>
                to
                <span class="pagination-info-highlight-payments">{{ $data->lastItem() }}</span>
                of
                <span class="pagination-info-highlight-payments">{{ $data->total() }}</span>
                transactions
            </p>
        </div>
        <nav>
            {{ $data->appends( Request::all() )->links() }}
        </nav>
    </div>
    @endif
@else
    <!-- Empty State -->
    <div class="empty-state-payments">
        <div class="empty-state-icon-payments">
            <i class="fe fe-credit-card"></i>
        </div>
        <div class="empty-state-title-payments">
            @if(Request::get('search'))
                No Transactions Found
            @else
                No Payment Transactions Yet
            @endif
        </div>
        <div class="empty-state-text-payments">
            @if(Request::get('search'))
                No transactions match your search "{{ Request::get('search') }}". Try a different search term.
            @else
                Payment transactions will appear here once users start subscribing to packages.
            @endif
        </div>
        @if(Request::get('search'))
        <a href="{{ route('settings.payments') }}" class="btn btn-outline-secondary">
            <i class="fe fe-x mr-1"></i> Clear Search
        </a>
        @endif
    </div>
@endif
@stop
