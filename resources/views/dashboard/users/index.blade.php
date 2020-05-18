@extends('dashboard.main')
@section('title_of_page', 'Users')
@section('content')
<div class="panel panel-default ">

    <div class="panel-heading text-center">
        @lang('dashboard.all_users')
        {{-- <small>{{$users->total()}}</small>  //The Total Number of Users--}}
    </div>
    <div class="box-body">
        <form action="{{route('dashboard.users.index')}}" method="GET" style="width:30%" class="d-inline-block">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control br-none" name="search" value="{{request()->search}}" placeholder="@lang('dashboard.search_in')" />
                <span class="input-group-btn">
                    <button class="btn btn-info btn-flat br-none" type="submit">
                        <i class="fa fa-search"></i>
                        @lang('dashboard.search')
                    </button>
                </span>
            </div>
            @if(auth()->user()->hasRole('boss'))
                <div class="d-inline-block" style="text-align: center; width: 100%; margin-top: 3px">
                    <div class="d-inline-block">
                        <input type="radio" name="search_for" id="all" value="all" class="input-vm"  {{(request()->search_for == ''||request()->search_for=="all") ? 'checked' : ''}} />
                        <label for="all" class="mr-none fw-none">@lang('dashboard.all')</label>
                    </div>
                    <div class="d-inline-block">
                        <input type="radio" name="search_for" id="all_admins" value="admins" class="input-vm" {{request()->search_for == 'admins' ? 'checked' : ''}} />
                        <label for="all_admins" class="mr-none fw-none">@lang('dashboard.only_admins')</label>
                    </div>
                    <div class="d-inline-block">
                        <input type="radio" name="search_for" id="all_users" value="users" class="input-vm" {{request()->search_for == 'users' ? 'checked' : ''}} />
                        <label for="all_users" class="mr-none fw-none">@lang('dashboard.only_users')</label>
                    </div>
                </div>
            @endif
        </form>
        <div class="d-inline-block {{app()->getlocale()=='ar'?'pull-left':'pull-right'}}">
            <a href="{{route('dashboard.users.create')}}" class="btn btn-info btn-sm">
                <i class="fa fa-plus"></i>
                @lang('dashboard.add')
            </a>
        </div>
    </div>
    <!-- Table -->
    <table class="table table-striped text-center">
        <thead>
            <tr class="bg-black">
                <th>#</th>
                <th>@lang('dashboard.first_name')</th>
                <th>@lang('dashboard.last_name')</th>
                <th>@lang('dashboard.email')</th>
                <th>@lang('dashboard.date')</th>
                <th>@lang('dashboard.image')</th>
                <th>@lang('dashboard.roles')</th>
                <th>@lang('dashboard.action')</th>
            </tr>
        </thead>
        <tbody>
            @if( count($users) != 1 )
                @foreach($users as $index=>$user)
                    @if($user->id != Auth::user()->id)
                        <tr class="{{ ($user->id == Auth::user()->id) ? 'bg-danger' : null}}">
                            <td>{{$index}}</td>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                {{$user->created_at->format('M-d-Y')}}
                            </td>
                            <td>
                                <img src="{{$user->image_path}}" alt="user_img" style="width:75px; height:75px" class="img-thumbnail img-circle" />
                            </td>
                            <td>
                                @if(($user->id != Auth::user()->id))
                                    <form action="{{route('dashboard.users_change_roles', $user)}}" method="POST">
                                        {{csrf_field()}}
                                        <select name="roles" class="padding-5">
                                            @foreach($roles as $role)
                                                @foreach($user->roles as $user_role)
                                                    @if($role->name !== 'boss')
                                                        <option 
                                                            value="{{$role->id}}"
                                                            {{ ($role->name == $user_role->name) ? 'selected' : null }}
                                                            >
                                                            {{$role->name}}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </select>
                                        <input type="submit" class="btn btn-primary btn-sm" value="@lang('dashboard.change')"/>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{route('dashboard.users.edit',$user->id)}}" class="btn btn-info btn-sm">
                                        <i class="fa fa-edit"></i>
                                        @lang('dashboard.update')
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm delete-item">
                                        <i class="fa fa-trash"></i>
                                        @lang('dashboard.delete')
                                    </a>
                                    <form action="{{route('dashboard.users_block',$user)}}" method="POST" class="d-inline-block">
                                        {{csrf_field()}}
                                        @if($user->is_blocked)
                                            <input type="hidden" name="unblock" /> 
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa fa-warning"></i>
                                                @lang('dashboard.unblock')
                                            </button> 
                                        @else
                                            <input type="hidden" name="block" />
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="fa fa-warning"></i>
                                                @lang('dashboard.block')
                                            </button>
                                        @endif
                                    </form>
                                    <!-- Delete Confirmation -->
                                    <div class="popup-container">
                                        <div class="message-container">
                                            <div class="confirmation-message text-center">
                                                <p style="margin-bottom: 10px">@lang('dashboard.confirm_delete')</p>
                                                <div>
                                                    <form action="{{route('dashboard.users.destroy',$user)}}" method="POST" class="d-inline-block">
                                                        {{csrf_field()}}
                                                        {{method_field('DELETE')}}
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                            @lang('dashboard.delete')
                                                        </button>
                                                    </form>
                                                    <a
                                                        href="#"
                                                        class='btn btn-warning btn-sm cancel-delete-item'
                                                    >
                                                        <i class="fa fa-arrow-circle-left"></i>
                                                        @lang('dashboard.cancel')</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @else 
                <tr class="bg-danger text-danger"> 
                    <td colspan="8"> 
                        <strong>@lang('dashboard.no_users')</strong> 
                    </td> 
                </tr>
            @endif 
        </tbody>
    </table>
    <div class="col-md-offset-1">{{$users->appends(request()->query())->links()}}</div>
</div>

@include('dashboard.incs.messages')
@stop