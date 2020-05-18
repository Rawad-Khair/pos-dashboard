@extends('dashboard.main')
@section('title_of_page', 'Create a New Product')
@section('content')
<div class="col-md-10 col-md-offset-1">
    <form role="form" action="{{route('dashboard.products.update',$product)}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <fieldset>
            <div class="form-group {{$errors->has('category_id')?'has-error':''}}">
                <select class="form-control" name="category_id">
                    <option value="text">@lang('dashboard.choose_category')</option>
                    @foreach($categories as $category)
                        <option 
                            value="{{$category->id}}" 
                            {{ $category->id == $product->category_id ? 'selected' : null }}>
                                {{$category->translate(config(app()->getlocale()))->title}}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('category_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('category_id') }}</strong>
                    </span>
                @endif
            </div>
            @foreach(config('translatable.locales') as $locale)
                <div style="padding: 10px 0">
                    <div class="form-group {{$errors->has($locale.'.title')?'has-error':null}}">
                        <label for="{{$locale.'_title'}}">@lang('dashboard.'.$locale.'.name')</label>
                        <input
                            type="text"
                            id="{{$locale.'_title'}}"
                            class="form-control"
                            name="{{$locale}}[title]"
                            value="{{$product->translate($locale)->title}}"
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
                            class="form-control ckeditor"
                            name="{{$locale}}[desc]"
                            style="resize:none"
                        >
                            {{$product->translate($locale)->desc}}
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
                @if($product->image != 'no_img.png')
                    <p class="text-bold">@lang('dashboard.image')</p>
                @else
                    <p class="text-muted">@lang('dashboard.no_img')</p>
                @endif
            </div>
            <div  style="padding: 15px; margin-bottom: 30px; box-shadow:0 1px 5px black">
                <div class="form-group {{$errors->has('image')?'has-error':null}}">
                    @if($product->image != 'no_img.png')
                        <label for="image">@lang('dashboard.change_image')</label>
                        <span class="pull-right">
                            <input type="checkbox" id="remove_image" name="remove_image" value="remove"/>
                            <label for="remove_image" class="text-danger remove-cover">@lang('dashboard.remove_image')</label>
                        </span>
                    @else
                        <label for="image">@lang('dashboard.choose_image')</label>
                    @endif
                    <div class="choose-image">
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
                                src="{{$product->image_path}}" 
                                class="img-thumbnail" 
                                style="width: 100px; margin-top: 15px" 
                                alt="product_img" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group {{$errors->has('cost_price')?'has-error':null}}">
                <label for="cost_price">@lang('dashboard.cost_price')</label>
                <input
                    type="number"
                    step="0.01"
                    id="cost_price"
                    class="form-control"
                    name="cost_price"
                    value="{{$product->cost_price}}"
                />
                @if ($errors->has('cost_price'))
                    <span class="help-block">
                        <strong>{{ $errors->first('cost_price') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{$errors->has('sale_price')?'has-error':null}}">
                <label for="sale_price">@lang('dashboard.sale_price')</label>
                <input
                    type="number"
                    step="0.01"
                    id="sale_price"
                    class="form-control"
                    name="sale_price"
                    value="{{$product->sale_price}}"
                />
                @if ($errors->has('sale_price'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sale_price') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{$errors->has('count')?'has-error':null}}">
                <label for="count">@lang('dashboard.count')</label>
                <input
                    type="number"
                    step="0.01"
                    id="count"
                    class="form-control"
                    name="count"
                    value="{{$product->count}}"
                />
                @if ($errors->has('count'))
                    <span class="help-block">
                        <strong>{{ $errors->first('count') }}</strong>
                    </span>
                @endif
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