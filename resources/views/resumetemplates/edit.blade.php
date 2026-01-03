@extends('layouts.admin')

@section('title', __('Update template'))
@section('page-title', __('Update template'))

@section('content')
<div class="row">
    <div class="col-md-12">

        <form role="form" method="post" action="{{ route('settings.resumetemplate.update', $resumeTemplate->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="form-label">@lang('Name')</label>
                                <input type="text" name="name" value="{{$resumeTemplate->name}}" class="form-control" placeholder="@lang('Name')">
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Categories')</label>
                                 <select name="category_id" class="form-control">
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}"
                                         @if ($item->id == $resumeTemplate->category_id)
                                            selected="selected"
                                        @endif>
                                        {{$item->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Thumb Template </label>
                                 <input name="thumb" type="file"><br>
                                 <img src="{{ URL::to('/') }}/images/{{ $resumeTemplate->thumb }}" data-value="" class="img-thumbnail" style="max-width: 100px; max-height: 100px;" />
                                <input type="hidden" name="hidden_image" value="{{ $resumeTemplate->thumb }}" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('HTML content')</label>

                                <textarea name="content" id="" rows="4" class="form-control">{{$resumeTemplate->content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Style content')</label>
                                <textarea rows="4" name="style" id="style" class="form-control">{{$resumeTemplate->style}}</textarea>
                            </div>
                            <div class="form-group">
                                <div class="form-label">@lang('Active')</div>
                                <label class="custom-switch">
                                    @if ($resumeTemplate->active)
                                        <input type="checkbox" name="active" value="1" class="custom-switch-input" checked>
                                    @else 
                                        <input type="checkbox" name="active" value="1" class="custom-switch-input" >
                                    @endif
                                    
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Allow active template')</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="form-label">@lang('Is Premium')</div>
                                <label class="custom-switch">
                                    @if ($resumeTemplate->is_premium)
                                        <input type="checkbox" name="is_premium"  value="1" class="custom-switch-input" checked>
                                    @else 
                                        <input type="checkbox" name="is_premium" class="custom-switch-input" >
                                    @endif
                                <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Premium template')</span>
                                </label>
                            </div>

                        </div>
                        
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.resumetemplate.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-blue ml-auto">@lang('Update Template')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@stop


@push('scripts')
<script>
$(document).ready(function(){

    // $('#send').click(function() {
    //     var jd = CKEDITOR.instances['termcondition'].getData();
    //     var resume = CKEDITOR.instances['privacy'].getData();
    //     // send your ajax request with value
    //     // profit!
    //     $('#jd_paste').html(jd);
    //     $('#resume_paste').html(resume);
        
    // });

});
</script>
@endpush