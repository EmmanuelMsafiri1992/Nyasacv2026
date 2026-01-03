@extends('layouts.dashboard')

@section('title', __('My Resumes'))
@section('header-title', __('My Resumes'))

@section('content')
<div class="dashboard-content">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"></button>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-0">@lang('All Resumes')</h2>
            <p class="text-muted mb-0">@lang('Manage and organize your resume collection')</p>
        </div>
        <div>
            <a href="{{ route('resume.template') }}" class="btn btn-primary">
                <i class="fe fe-plus-circle mr-2"></i>@lang('Create New Resume')
            </a>
        </div>
    </div>

    @if($data->count() > 0)
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-vcenter mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>@lang('Resume Name')</th>
                            <th>@lang('Job Title')</th>
                            <th>@lang('Template')</th>
                            <th>@lang('Created')</th>
                            <th>@lang('Last Modified')</th>
                            <th class="text-right">@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>
                                <div class="font-weight-bold">
                                    <a href="{{ route('resume.edit', $item) }}">{{ $item->name }}</a>
                                </div>
                                <div class="small text-muted">{{ $item->user->name }}</div>
                            </td>
                            <td>
                                <span class="text-muted">{{ $item->job_title ?? 'Not specified' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $item->template->title ?? 'Default' }}</span>
                            </td>
                            <td>
                                <div>{{ $item->created_at->format('M j, Y') }}</div>
                                <div class="small text-muted">{{ $item->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div>{{ $item->updated_at->format('M j, Y') }}</div>
                                <div class="small text-muted">{{ $item->updated_at->diffForHumans() }}</div>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-success" href="{{ route('resume.exportpdf', $item) }}" target="_blank" title="@lang('Export PDF')">
                                        <i class="fe fe-download"></i>
                                    </a>
                                    <a class="btn btn-sm btn-primary" href="{{ route('resume.edit', $item) }}" title="@lang('Edit')">
                                        <i class="fe fe-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('@lang('Are you sure you want to delete this resume?')')) { document.getElementById('delete-form-{{ $item->id }}').submit(); }" title="@lang('Delete')">
                                        <i class="fe fe-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $item->id }}" method="post" action="{{ route('resume.delete', $item) }}" style="display: none;">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $data->appends( Request::all() )->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fe fe-file-text" style="font-size: 80px; color: #e0e0e0;"></i>
                </div>
                <h3>@lang('No Resumes Found')</h3>
                <p class="text-muted mb-4">@lang('You haven\'t created any resumes yet. Start building your professional resume now!')</p>
                <a href="{{ route('resume.template') }}" class="btn btn-primary btn-lg">
                    <i class="fe fe-plus-circle mr-2"></i>@lang('Create Your First Resume')
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
