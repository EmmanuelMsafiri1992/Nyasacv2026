@extends('layouts.admin')

@section('title', __('Email Templates'))
@section('page-title', __('Email Templates'))

@section('content')
<style>
.templates-page-header {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.templates-section {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 25px;
}

.templates-section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 30px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.templates-section-header i {
    font-size: 24px;
}

.templates-section-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.templates-section-body {
    padding: 0;
}

.header-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
}

.header-text h2 {
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.header-text h2 i {
    color: #667eea;
}

.header-text p {
    color: #64748b;
    margin: 0;
}

.btn-modern {
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn-modern:hover {
    transform: translateY(-2px);
    text-decoration: none;
}

.btn-success-modern {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
}

.btn-success-modern:hover {
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    color: white;
}

.table-modern {
    margin: 0;
}

.table-modern thead {
    background: #f8fafc;
}

.table-modern thead th {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    padding: 16px 20px;
    border: none;
    border-bottom: 2px solid #e2e8f0;
}

.table-modern tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
}

.table-modern tbody tr:hover {
    background: #f8fafc;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.template-name {
    font-weight: 700;
    color: #1e293b;
    font-size: 15px;
}

.template-subject {
    color: #64748b;
    font-size: 13px;
}

.badge-modern {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.badge-modern.success {
    background: #dcfce7;
    color: #16a34a;
}

.badge-modern.secondary {
    background: #f1f5f9;
    color: #64748b;
}

.badge-modern.info {
    background: #e0f2fe;
    color: #0284c7;
}

.meta-text {
    font-size: 13px;
    color: #1e293b;
    font-weight: 500;
}

.meta-subtext {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 2px;
}

.action-btn-group {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
}

.action-btn {
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.action-btn.preview {
    background: #f0f9ff;
    color: #0284c7;
}

.action-btn.preview:hover {
    background: #0284c7;
    color: white;
}

.action-btn.edit {
    background: #f0f7ff;
    color: #667eea;
}

.action-btn.edit:hover {
    background: #667eea;
    color: white;
}

.action-btn.delete {
    background: #fef2f2;
    color: #dc2626;
}

.action-btn.delete:hover {
    background: #dc2626;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 30px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-state-icon i {
    font-size: 36px;
    color: #667eea;
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
}

.empty-state p {
    color: #64748b;
    margin-bottom: 20px;
}

/* Pagination Styles */
.pagination-wrapper {
    margin-top: 25px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 20px 25px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
}

.pagination-info {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

.pagination-info strong {
    color: #1e293b;
    font-weight: 700;
}

.pagination-info i {
    vertical-align: middle;
}

.pagination-nav {
    display: flex;
    align-items: center;
}

.pagination {
    display: flex;
    align-items: center;
    gap: 6px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.pagination li {
    margin: 0;
}

.pagination li a,
.pagination li span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 14px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 2px solid #e2e8f0;
    background: white;
    color: #64748b;
}

.pagination li a:hover {
    border-color: #667eea;
    color: #667eea;
    background: #f8f9ff;
    transform: translateY(-2px);
}

.pagination li.active span,
.pagination .active > span {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border-color: transparent !important;
    color: white !important;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.pagination li.disabled span,
.pagination .disabled > span {
    background: #f8fafc !important;
    border-color: #e2e8f0 !important;
    color: #cbd5e1 !important;
    cursor: not-allowed;
}

/* Modal Styles */
.modal-modern .modal-content {
    border: none;
    border-radius: 16px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    overflow: hidden;
}

.modal-modern .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 25px;
    border: none;
}

.modal-modern .modal-title {
    font-weight: 700;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-modern .modal-header .close {
    color: white;
    opacity: 0.8;
    text-shadow: none;
    font-size: 28px;
    font-weight: 400;
}

.modal-modern .modal-header .close:hover {
    opacity: 1;
}

.modal-modern .modal-body {
    padding: 25px;
}

.modal-modern .modal-footer {
    padding: 20px 25px;
    border-top: 2px solid #f1f5f9;
    background: #f8fafc;
}

.preview-field {
    margin-bottom: 20px;
}

.preview-label {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.preview-label i {
    color: #667eea;
}

.preview-value {
    font-size: 15px;
    color: #1e293b;
    font-weight: 500;
}

.preview-message-box {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    font-size: 14px;
    line-height: 1.7;
    color: #475569;
    max-height: 300px;
    overflow-y: auto;
}

.btn-close-modern {
    background: #f1f5f9;
    border: 2px solid #e2e8f0;
    color: #64748b;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-close-modern:hover {
    background: #e2e8f0;
    color: #1e293b;
}

@media (max-width: 768px) {
    .templates-page-header {
        padding: 20px;
    }

    .header-actions {
        flex-direction: column;
        align-items: flex-start;
    }

    .action-btn-group {
        flex-direction: column;
        width: 100%;
    }

    .action-btn {
        width: 100%;
        justify-content: center;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 12px 15px;
    }

    .pagination-wrapper {
        flex-direction: column;
        text-align: center;
    }

    .pagination li a,
    .pagination li span {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        font-size: 13px;
    }
}
</style>

<div class="row">
    <div class="col-md-12">
        <!-- Page Header -->
        <div class="templates-page-header">
            <div class="header-actions">
                <div class="header-text">
                    <h2>
                        <i class="fe fe-mail"></i> @lang('Email Templates')
                    </h2>
                    <p>@lang('Create and manage reusable email templates for your campaigns')</p>
                </div>
                <a href="{{ route('settings.email-templates.create') }}" class="btn btn-modern btn-success-modern">
                    <i class="fe fe-plus"></i> @lang('Create New Template')
                </a>
            </div>
        </div>

        @if($templates->count() > 0)
        <!-- Templates Table -->
        <div class="templates-section">
            <div class="templates-section-header">
                <i class="fe fe-file-text"></i>
                <h3 class="templates-section-title">@lang('Your Templates')</h3>
            </div>
            <div class="templates-section-body">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>@lang('Template Name')</th>
                                <th>@lang('Subject')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Created')</th>
                                <th class="text-right">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($templates as $template)
                            <tr>
                                <td>
                                    <div class="template-name">{{ $template->name }}</div>
                                </td>
                                <td>
                                    <div class="template-subject">{{ Str::limit($template->subject, 50) }}</div>
                                </td>
                                <td>
                                    @if($template->category)
                                        <span class="badge-modern info">
                                            <i class="fe fe-tag"></i> {{ $template->category }}
                                        </span>
                                    @else
                                        <span class="badge-modern secondary">
                                            <i class="fe fe-minus"></i> @lang('None')
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($template->is_active)
                                        <span class="badge-modern success">
                                            <i class="fe fe-check-circle"></i> @lang('Active')
                                        </span>
                                    @else
                                        <span class="badge-modern secondary">
                                            <i class="fe fe-x-circle"></i> @lang('Inactive')
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="meta-text">{{ $template->created_at->format('M j, Y') }}</div>
                                    <div class="meta-subtext">{{ $template->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div class="action-btn-group">
                                        <button type="button" class="action-btn preview" onclick="previewTemplate({{ $template->id }})">
                                            <i class="fe fe-eye"></i> @lang('Preview')
                                        </button>
                                        <a href="{{ route('settings.email-templates.edit', $template) }}" class="action-btn edit">
                                            <i class="fe fe-edit-2"></i> @lang('Edit')
                                        </a>
                                        <button type="button" class="action-btn delete" onclick="if(confirm('@lang('Confirm delete?')')) { document.getElementById('delete-form-{{ $template->id }}').submit(); }">
                                            <i class="fe fe-trash-2"></i> @lang('Delete')
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $template->id }}" method="post" action="{{ route('settings.email-templates.destroy', $template) }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($templates->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <i class="fe fe-file-text mr-2" style="color: #667eea;"></i>
                @lang('Showing') <strong>{{ $templates->firstItem() ?? 0 }}</strong> @lang('to') <strong>{{ $templates->lastItem() ?? 0 }}</strong> @lang('of') <strong>{{ $templates->total() }}</strong> @lang('templates')
            </div>
            <div class="pagination-nav">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($templates->onFirstPage())
                        <li class="disabled">
                            <span><i class="fe fe-chevron-left"></i></span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $templates->previousPageUrl() }}">
                                <i class="fe fe-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($templates->getUrlRange(1, $templates->lastPage()) as $page => $url)
                        @if ($page == $templates->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @elseif ($page == 1 || $page == $templates->lastPage() || abs($page - $templates->currentPage()) <= 2)
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @elseif (abs($page - $templates->currentPage()) == 3)
                            <li class="disabled"><span>...</span></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($templates->hasMorePages())
                        <li>
                            <a href="{{ $templates->nextPageUrl() }}">
                                <i class="fe fe-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="disabled">
                            <span><i class="fe fe-chevron-right"></i></span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fe fe-mail"></i>
            </div>
            <h3>@lang('No Email Templates Yet')</h3>
            <p>@lang('Create your first email template to use in your campaigns.')</p>
            <a href="{{ route('settings.email-templates.create') }}" class="btn btn-modern btn-success-modern">
                <i class="fe fe-plus"></i> @lang('Create First Template')
            </a>
        </div>
        @endif

    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade modal-modern" id="previewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-eye"></i> @lang('Template Preview')
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="preview-field">
                    <div class="preview-label">
                        <i class="fe fe-file-text"></i> @lang('Template Name')
                    </div>
                    <div class="preview-value" id="preview-name"></div>
                </div>
                <div class="preview-field">
                    <div class="preview-label">
                        <i class="fe fe-type"></i> @lang('Subject')
                    </div>
                    <div class="preview-value" id="preview-subject"></div>
                </div>
                <div class="preview-field" style="margin-bottom: 0;">
                    <div class="preview-label">
                        <i class="fe fe-message-square"></i> @lang('Message')
                    </div>
                    <div class="preview-message-box" id="preview-message"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-close-modern" data-dismiss="modal">
                    <i class="fe fe-x mr-1"></i> @lang('Close')
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function previewTemplate(templateId) {
    fetch('{{ url("settings/email-templates") }}/' + templateId)
        .then(response => response.json())
        .then(data => {
            document.getElementById('preview-name').textContent = data.name;
            document.getElementById('preview-subject').textContent = data.subject;
            document.getElementById('preview-message').innerHTML = data.message.replace(/\n/g, '<br>');
            $('#previewModal').modal('show');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('@lang("Failed to load template preview")');
        });
}
</script>
@stop
