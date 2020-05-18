@extends('dashboard.main')
@section('title_of_page', 'Orders')
@section('content')
<div class="panel panel-default ">
    <div class="panel-heading text-center">
        @lang('dashboard.all_orders')
    </div>
     <!-- Search Box --->
     <div class="box-body">
        <form action="{{route('dashboard.orders.index')}}" method="GET" style="width:30%" class="d-inline-block">
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
    </div>
    <!-- Table -->
    <div class="row">
        <div class="col-md-12 show-orders">
            <table class="table table-hover text-center">
                <thead>
                    <tr class="bg-black">
                        <th>#</th>
                        <th>@lang('dashboard.client_name')</th>
                        <th>@lang('dashboard.total_price')</th>
                        <th>@lang('dashboard.date_of_order')</th>
                        <th>@lang('dashboard.show_order_products')</th>
                        <th>@lang('dashboard.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($orders) > 0)
                        @foreach($orders as $index=>$order)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>{{$order->client->name}}</td>
                                <td>{{$order->total_price}}</td>
                                <td>{{$order->created_at->format('M/D Y')}}</td>
                                <td>
                                    <a 
                                        href="#" 
                                        class="show-order-products btn btn-success btn-sm"
                                        data-url="{{route('dashboard.order.products',$order->id)}}"
                                    >
                                        <i class="fa fa-tv"></i>
                                        @lang('dashboard.show_order_products')
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('dashboard.order.edit',[$order->client, $order])}}" class="btn btn-info btn-sm" title="@lang('dashboard.update')">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm delete-item" title="@lang('dashboard.delete')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <!-- Delete Confirmation -->
                                    <div class="popup-container">
                                        <div class="message-container">
                                            <div class="confirmation-message text-center">
                                                <p style="margin-bottom: 10px">@lang('dashboard.confirm_delete')</p>
                                                <div>
                                                    <form action="{{route('dashboard.orders.destroy',$order->id)}}" method="POST" class="d-inline-block">
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
                                <strong>@lang('dashboard.no_orders')</strong> 
                            </td> 
                        </tr>        
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div class="show-products">
            </div>
        </div>
    </div>
</div>
@include('dashboard.incs.messages')
@stop