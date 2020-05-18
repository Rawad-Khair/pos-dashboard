@extends('dashboard.main')
@section('title_of_page', 'Clients')
@section('content')
<div class="panel panel-default ">
    <div class="panel-heading text-center">
        @lang('dashboard.all_clients')
    </div>
     <!-- Search Box --->
     <div class="box-body">
        <form action="{{route('dashboard.clients.index')}}" method="GET" style="width:30%" class="d-inline-block">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control br-none" name="search" value="{{request()->search}}" placeholder="@lang('dashboard.search_in')" />
                <span class="input-group-btn">
                    <button class="btn btn-info btn-flat br-none" type="submit">
                        <i class="fa fa-search"></i>
                        @lang('dashboard.search')
                    </button>
                </span>
            </div>
        </form>
        <div class="d-inline-block {{app()->getlocale()=='ar'?'pull-left':'pull-right'}}">
            <a href="{{route('dashboard.clients.create')}}" class="btn btn-info">
                <i class="fa fa-plus"></i>
                @lang('dashboard.add_new_client')
            </a>
        </div>
    </div>
    <!-- Table -->
    <table class="table table-striped text-center">
        <thead>
            <tr class="bg-black">
                <th>@lang('dashboard.name')</th>
                <th>@lang('dashboard.phone')</th>
                <th>@lang('dashboard.address')</th>
                <th>@lang('dashboard.orders')</th>
                <th>@lang('dashboard.image')</th>
                <th>@lang('dashboard.action')</th>
            </tr>
        </thead>
        <tbody>
            @if(count($clients) > 0)
                @foreach($clients as $client)
                    <tr>
                        <td>{{$client->name}}</td>
                        <td>{{is_array($client->phone) ? implode('-', array_filter($client->phone)) : $client->phone}}</td>
                        <td>{{$client->address}}</td>
                        <td>
                            <a href="{{route('dashboard.order.create',$client->id)}}">
                                <i class="fa fa-plus-square"></i>
                                @lang('dashboard.add_new_order')
                            </a>
                        </td>
                        <td>
                            @if($client->image !== 'no_img.png')
                                <img src="{{url('uploads/dashboard/clients/images/'.$client->image)}}" alt="client" style="width: 75px" class="img-thumbnail" /></td>
                            @else
                                <p class="text-muted">@lang('dashboard.no_img')</p>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('dashboard.clients.edit',$client->id)}}" class="btn btn-info btn-sm">
                                <i class="fa fa-edit"></i>
                                @lang('dashboard.update')
                            </a>
                            <a href="#" class="btn btn-danger btn-sm delete-item">
                                <i class="fa fa-trash"></i>
                                @lang('dashboard.delete')
                            </a>
                             <!-- Delete Confirmation -->
                            <div class="popup-container">
                                <div class="message-container">
                                    <div class="confirmation-message text-center">
                                        <p style="margin-bottom: 10px">@lang('dashboard.confirm_delete')</p>
                                        <div>
                                            <form action="{{route('dashboard.clients.destroy',$client)}}" method="POST" class="d-inline-block">
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
                        </td>
                    </tr>
                @endforeach
            @else 
                <tr class="bg-danger text-danger"> 
                    <td colspan="6"> 
                        <strong>@lang('dashboard.no_clients')</strong> 
                    </td> 
                </tr>        
            @endif
        </tbody>
    </table>
</div>
@include('dashboard.incs.messages')
@stop