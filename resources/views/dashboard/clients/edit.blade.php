@extends('dashboard.main')
@section('title_of_page', 'Edit Clients')
@section('content')
    <div class="col-md-10 col-md-offset-1">
        <form role="form" action="{{route('dashboard.clients.update',$client)}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <fieldset>
                <div style="padding: 10px 0">
                    <div class="form-group {{$errors->has('name')?'has-error':null}}">
                        <label for="clinet_name">@lang('dashboard.name')</label>
                        <input
                            type="text"
                            id="clinet_name"
                            class="form-control"
                            name="name"
                            value="{{$client->name}}"
                        />
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    @for($i = 0; $i < count($client->phone); $i++)
                    <div class="form-group {{$errors->has('phone.'.$i)?'has-error':null}}">
                        <label for="{{'clinet_phone_'.$i}}">{{trans('dashboard.phone').' -'.($i+1)}}</label>
                            <input
                                type="text"
                                id="{{'clinet_phone_'.$i}}"
                                class="form-control"
                                name="phone[]"
                                value="{{$client->phone[$i]?$client->phone[$i]:''}}"
                                {{-- value="{{$client->phone[$i]??''}}" --}}
                            />
                            @if ($errors->has('phone.'.$i))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone.'.$i) }}</strong>
                                </span>
                            @endif
                        </div>
                    @endfor
                    <div class="form-group {{$errors->has('address')?'has-error':null}}">
                        <label for="clinet_address">@lang('dashboard.address')</label>
                        <textarea
                            type="text"
                            id="clinet_address"
                            class="form-control"
                            name="address"
                            style="resize:none"
                        >
                            {{$client->address}}
                        </textarea>
                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    @if($client->image != 'no_img.png')
                        <p class="text-bold">@lang('dashboard.image')</p>
                        <img 
                            src="{{url('uploads/dashboard/clients/images/'.$client->image)}}" 
                            class="img-thumbnail" 
                            style="width: 100px" 
                            alt="user_img" />
                    @else
                        <p class="text-muted">@lang('dashboard.no_img')</p>
                    @endif
                </div>
                <div  style="padding: 15px; margin-bottom: 30px; box-shadow:0 1px 5px black">
                    <div class="form-group {{$errors->has('image')?'has-error':null}}">
                        @if($client->image != 'no_img.png')
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
                                src="{{url('uploads/dashboard/clients/images/'.$client->image)}}" 
                                class="img-thumbnail" 
                                style="width: 100px" 
                                alt="user_img" />
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

