@extends('dashboard.main')
@section('title_of_page', 'Create a New User')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('dashboard.register')</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('dashboard.users.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">@lang('dashboard.first_name')</label>
                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">@lang('dashboard.last_name')</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">@lang('dashboard.email')</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">@lang('dashboard.password')</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">@lang('dashboard.password_confirmation')</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-md-4 control-label">@lang('dashboard.image')</label>
                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control image_file" name="image" accept="image/x-png,image/gif,image/jpeg" />
                            </div>
                        </div>
                        <div class="form-group">
                            <img 
                                id="img-preview" 
                                src="{{url('uploads/users/images/no_img.png')}}" 
                                class="img-thumbnail col-md-offset-4" 
                                style="width: 100px; height:100px" 
                                alt="user_img" />
                        </div>
                        <hr class="hr-bright" />
                        <div class="nav-tabs-custom col-md-offset-1 {{ $errors->has('permissions') ? ' has-error' : '' }}">
                            <label class="header">@lang('dashboard.roles')</label>
                            @if ($errors->has('permissions'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('permissions') }}</strong>
                                </span>
                            @endif
<!---------------------- Models & CRUD Operations -------------------------------->
                            <?php 
                                $models = ['categories','users','products','clients',]; 
                                $actions = ['create', 'read', 'update', 'delete'];
                            ?>
<!--------------------------------------------------------------------------------->
                            <ul class="nav nav-tabs">
                                @foreach($models as $index=>$model)
                                    <li class="{{$index == 0 ? 'active' : ''}}">
                                        <a href="#{{$model}}" data-toggle="tab">
                                            @lang('dashboard.'.$model)
                                        </a>
                                    </li>
                                @endforeach    
                            </ul>
                            <div class="tab-content">
                                @foreach($models as $index=>$model)
                                    <div class="tab-pane {{$index == 0 ? 'active' : ''}}" id="{{$model}}">
                                        @foreach($actions as $action)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]" value="{{$action}}_{{$model}}" {{$action=='read'?'checked=':''}} />
                                                    @lang('dashboard.'.$action)
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary col-md-offset-1">
                                <i class="fa fa-plus-circle"></i>
                                @lang('dashboard.register')
                            </button>
                            <a href="{{ URL::previous() }}" class="btn btn-warning col-md-offset-1">
                                <i class="fa fa-arrow-circle-left"></i>
                                @lang('dashboard.cancel')
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop