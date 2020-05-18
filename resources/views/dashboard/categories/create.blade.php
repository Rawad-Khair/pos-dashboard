@extends('dashboard.main')
@section('title_of_page', 'Create a New Categoty')
@section('content')
<div class="col-md-10 col-md-offset-1">
    <form role="form" action="{{route('dashboard.categories.store')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <fieldset>
            @foreach(config('translatable.locales') as $locale)
                <div style="padding: 10px 0">
                    <div class="form-group {{$errors->has($locale.'.title')?'has-error':null}}">
                        <label for="{{$locale.'_title'}}">@lang('dashboard.'.$locale.'.name')</label>
                        <input
                            type="text"
                            id="{{$locale.'_title'}}"
                            class="form-control"
                            name="{{$locale}}[title]"
                            value="{{old($locale.'.title')}}"
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
                            {{old($locale.'.desc')}}
                        </textarea>
                        @if ($errors->has($locale.'.desc'))
                        <span class="help-block">
                            <strong>{{ $errors->first($locale.'.desc') }}</strong>
                        </span>
                    @endif
                    </div>
                </div>
            @endforeach
            <div  style="padding: 15px; margin-bottom: 30px; box-shadow:0 1px 5px black">
                <div class="form-group {{$errors->has('image')?'has-error':null}}">
                    <label for="image">@lang('dashboard.image')</label>
                    <input
                        type="file"
                        id="image"
                        class="form-control image_file"
                        name="image"
                        accept="image/x-png,image/gif,image/jpeg"
                    />
                </div>
                <div class="form-group">
                    <img 
                        id="img-preview" 
                        src="{{url('uploads/dashboard/categories/images/no_img.png')}}" 
                        class="img-thumbnail" 
                        style="width: 100px" 
                        alt="user_img" />
                </div>
            </div>
            <button type="submit "class="btn btn-primary">
                <i class="fa fa-plus-circle"></i>
                @lang('dashboard.add_new_category')
            </button>
            <a href="{{ URL::previous() }}" class="btn btn-warning">
                <i class="fa fa-arrow-left"></i>
                @lang('dashboard.cancel')
            </a>
        </fieldset>
    </form>
    </div>
@stop