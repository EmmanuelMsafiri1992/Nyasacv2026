@extends('layouts.admin')

@section('title', __('Update template'))
@section('page-title', __('Update Category'))

@section('content')
<div class="row">
    <div class="col-md-12">

        <form role="form" method="post" action="{{ route('settings.resumetemplatecategories.update', $category->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="form-label">@lang('Name')</label>
                                <input type="text" name="name" value="{{$category->name}}" class="form-control" placeholder="@lang('Name')">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Thumb Category </label>
                                 <input name="thumb" type="file"><br>
                                 <img src="{{ URL::to('/') }}/images/categories/{{ $category->thumb }}" data-value="" class="img-thumbnail" style="max-width: 100px; max-height: 100px;" />
                                <input type="hidden" name="hidden_image" value="{{ $category->thumb }}" />
                            </div>


                        </div>
                        
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.resumetemplatecategories.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-blue ml-auto">@lang('Update Category')</button>
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