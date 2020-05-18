@extends('dashboard.main')
@section('title_of_page', 'Create a New Order')
@section('content')

    <div class="panel panel-default ">
        <div class="panel-heading text-center">
            @lang('dashboard.add_new_order')
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
                    <form action="{{route('dashboard.order.store',$client->id)}}" method="POST">
                        {{csrf_field()}}
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
                            <tbody class="order-list"></tbody>
                        </table>
                        <h4 class="box-footer">
                            <i class="fa fa-calculator"></i>
                            @lang('dashboard.all_total')
                            <mark class="total">0.00</mark>
                            <button type="submit" class="btn btn-success col-md-offset-2 confirm-order" disabled>
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