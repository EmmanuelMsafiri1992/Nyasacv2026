@extends('layouts.admin')

@section('title', __('Create template'))
@section('page-title', __('Create template'))

@section('content')
<div class="row">
    <div class="col-md-12">

        <form role="form" method="post" action="{{ route('settings.resumetemplate.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="form-label">@lang('Name')</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="@lang('Name')">
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Categories')</label>
                                 <select name="category_id" class="form-control">
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Thumb Template</label>
                                <input name="thumb" type="file"><br>
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('HTML content')</label>
                                <textarea rows="4" name="content" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Style content')</label>
                                <textarea rows="4" name="style" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-label">@lang('Active')</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="active" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Allow active template')</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="form-label">@lang('Is Premium')</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="is_premium" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Premium template')</span>
                                </label>
                            </div>

                        </div>
                        
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.users.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-success ml-auto">@lang('Add template')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@stop