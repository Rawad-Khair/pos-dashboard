@extends('dashboard.main')
@section('title_of_page', 'Edit Orders')
@section('content')

    <div class="panel panel-default ">
        <div class="panel-heading text-center">
            @lang('dashboard.edit_order')
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel-heading text-center">
                        @lang('dashboard.all_categories')
                    </div>
                    @foreach($categories as $category)
                        <div class="box collapsed-box">
                            <div class="box-header with-border bg-success" data-widget="collapse">
                            <h4 class="box-title">{{$category->translate(app()->getlocale())->title}}</h4>
                            </div>
                            @if($category->products->count() > 0)
                                <div class="box-body" style="display: none;">
                                    <table class="table table-hover">
                                        @foreach($category->products as $product)
                                            <tr class="row">
                                                <th class="col-md-4">{{$product->translate(app()->getlocale())->title}}</th>
                                                <th class="col-md-4 text-center">{{$product->sale_price}}</th>
                                                <th class="col-md-4 text-center">
                                                    <a 
                                                        href="#" 
                                                        class="add_order btn btn-success btn-sm fa fa-plus-square"
                                                        data-id="{{$product->id}}"
                                                        data-name="{{$product->translate(app()->getlocale())->title}}"
                                                        data-price="{{$product->sale_price}}"
                                                        @foreach($order->products as $pro)
                                                            {{$pro->pivot->product_id == $product->id ? 'disabled' : ''}}
                                                        @endforeach
                                                    >
                                                    </a>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @else
                                <div class="box-body bg-danger text-danger">
                                    @lang('dashboard.no_products')
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="col-md-6">
                    <div class="panel-heading text-center">
                        @lang('dashboard.orders')
                    </div>
                    <form action="{{route('dashboard.order.update',[$client,$order])}}" method="POST">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <table class="table table-hover text-center">
                            <thead>
                                <tr class="row bg-primary">
                                    <th class="col-md-1">#</th>
                                    <th class="col-md-3">@lang('dashboard.name')</th>
                                    <th class="col-md-2">@lang('dashboard.count')</th>
                                    <th class="col-md-3">@lang('dashboard.price')</th>
                                    <th class="col-md-3">@lang('dashboard.total')</th>
                                    <th class="col-md-3">
                                        <i class="fa fa-trash"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="order-list">
                                @foreach($order->products as $index=>$product)
                                    <tr class="row order-row" id="{{$product->id}}">
                                        <input type="hidden" value="{{$product->id}}" name="products_id[]"/>
                                        <td class="col-md-1 number order-number-{{$index + 1}}">
                                            {{$index +1}}
                                        </td>
                                        <td class="col-md-3">
                                            {{$product->title}}
                                        </td>
                                        <td class="col-md-2">
                                            <input type="number" min="1" value="{{$product->pivot->quantity}}" step="1" style="width: 100%" class="quantity" name="quantity[]" />
                                        </td>
                                        <td class="col-md-3">{{$product->sale_price}}</td>
                                        <td class="total-of-row">{{ $product->sale_price * $product->pivot->quantity }}</td>
                                        <td class="col-md-3">
                                        <i class="delete-order adjust-index fa fa-trash btn btn-danger" data-id="{{$product->id}}" data-price="{{$product->sale_price}}" data-order-index="{{count($order->products)}}"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <h4 class="box-footer">
                            <i class="fa fa-calculator"></i>
                            @lang('dashboard.all_total')
                            <mark class="total">{{ $order->total_price }}</mark>
                            <button type="submit" class="btn btn-success col-md-offset-2 confirm-order">
                                <i class="fa fa-send"></i>
                                @lang('dashboard.confirm_order')
                            </button>
                        </h4>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop