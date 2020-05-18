@extends('dashboard.main')
@section('title_of_page', 'Edit Categoties')
@section('content')
<div class="col-md-10 col-md-offset-1">
    <form role="form" action="{{route('dashboard.categories.update',$category->id)}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <fieldset>
            @foreach(config('translatable.locales') as $locale)
                <div style="padding: 25px 0">
                    <div class="form-group {{$errors->has($locale.'.title')?'has-error':null}}">
                        <label for="{{$locale.'_title'}}">@lang('dashboard.'.$locale.'.name')</label>
                        <input
                            type="text"
                            id="{{$locale.'_title'}}"
                            class="form-control"
                            name="{{$locale}}[title]"
                            value="{{$category->translate($locale)->title}}"
                        />
                        @if ($errors->has($locale.'.title'))
                            <span class="help-block">
                                <strong>{{ $errors->first($locale.'.title') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->has($locale.'.desc')?'has-error':null}}">
                        <label for="{{$locale.'_desc'}}">@lang('dashboard.'.$locale.'.description')</label>
                        <textarea
                            id="{{$locale.'_desc'}}"
                            class="form-control"
                            name="{{$locale}}[desc]"
                            style="resize:none"
                        >
                            {{$category->translate($locale)->desc}}
                        </textarea>
                        @if ($errors->has($locale.'.desc'))
                        <span class="help-block">
                            <strong>{{ $errors->first($locale.'.desc') }}</strong>
                        </span>
                    @endif
                    </div>
                </div>
            @endforeach
            <div class="form-group">
                @if($category->image != 'no_img.png')
                    <p class="text-bold">@lang('dashboard.image')</p>
                @else
                    <p class="text-muted">@lang('dashboard.no_img')</p>
                @endif
            </div>
            <div  style="padding: 15px; margin-bottom: 30px; box-shadow:0 1px 5px black">
                <div class="form-group {{$errors->has('image')?'has-error':null}}">
                    @if($category->image != 'no_img.png')
                        <label for="image">@lang('dashboard.change_image')</label>
                    @else
                        <label for="image">@lang('dashboard.choose_image')</label>
                    @endif
                    <input
                    type="file"
                    id="image"
                    class="form-control image_file"
                    name="image"
                    accept="image/x-png,image/gif,image/jpeg"
                    />
                    <div class="form-group">
                        <img 
                            id="img-preview" 
                            src="{{url('uploads/dashboard/categories/images/'.$category->image)}}" 
                            class="img-thumbnail" 
                            style="width: 100px; margin-top: 15px" 
                            alt="category_img" />
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i>
                @lang('dashboard.save_changes')
            </button>
            <a href="{{ URL::previous() }}" class="btn btn-warning">
                <i class="fa fa-arrow-left"></i>
                @lang('dashboard.cancel')
            </a>
        </fieldset>
    </form>
    </div>
@stop