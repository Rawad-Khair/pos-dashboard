
<div class="padding-5">
    <table class="table table-hover text-center">
        <thead>
            <tr class="bg-success">
                <th>#</th>
                <th>@lang('dashboard.name')</th>
                <th>@lang('dashboard.sale_price')</th>
                <th>@lang('dashboard.count')</th>
                <th>@lang('dashboard.total')</th>
            </tr>
        </thead>
        <tbody>
            @if(count($products) > 0)
                @foreach($products as $index=>$product)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$product->title}}</td>
                        <td>{{$product->sale_price}}</td>
                        <td>{{$product->pivot->quantity}}</td>
                        <td><b>{{$product->sale_price * $product->pivot->quantity}}</b></td>
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
    <div class="box-footer">
        <h4 class="d-inline-block">
            <i class="fa fa-calculator"></i>
            @lang('dashboard.total'):
            <strong>{{$order->total_price}}</strong>
        </h4>
        <h5 class="pull-right d-inline-block">
            <i class="fa fa-calendar"></i>
            @lang('dashboard.date_of_order'):
            {{$order->created_at->format('H:m D/M/Y')}}
        </h5>
    </div>
</div>
