@extends('dashboard.main')
@section('title_of_page', 'Edit Users')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('dashboard.register')</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('dashboard.users.update',$user->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT')}}
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">@lang('dashboard.first_name')</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required autofocus>

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
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required autofocus>

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
                                <input id="email" type="email" class="form-control" name="email" value="{{  $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
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
                                src="{{$user->image_path}}" 
                                class="img-thumbnail col-md-offset-4" 
                                style="width: 100px; height: 100px" 
                                alt="user_img" />
                        </div>
                        <div class="box collapsed-box">
                            <div class="box-header with-border">
                              <h3 class="box-title">@lang('dashboard.change_password')</h3>
                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                              </div>
                            </div>
                            <div class="box-body" style="display: none;">
                                 {{-- <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">@lang('dashboard.password')</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div> --}}
                                {{--
                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">@lang('dashboard.password_confirmation')</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="" required>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
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
                                                <input 
                                                    type="checkbox" 
                                                    name="permissions[]" 
                                                    value="{{$action}}_{{$model}}" 
                                                    {{$user->hasPermission($action.'_'.$model) ? 'checked' : ''}}
                                                />
                                                @lang('dashboard.'.$action)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary col-md-offset-2">
                                <i class="fa fa-save"></i>  
                                @lang('dashboard.save_changes')
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
@include('dashboard.incs.messages')
@stop