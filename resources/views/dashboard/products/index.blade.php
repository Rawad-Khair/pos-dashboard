@extends('dashboard.main')
@section('title_of_page', 'products')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            @lang('dashboard.all_products')
        </div>
        <!-- Search Box --->
        <div class="box-body">
            <form action="{{route('dashboard.products.index')}}" method="GET" style="width:30%" class="d-inline-block">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control br-none" name="search" value="{{request()->search}}" placeholder="@lang('dashboard.search_in')" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-flat br-none" type="submit">
                            <i class="fa fa-search"></i>
                            @lang('dashboard.search')
                        </button>
                    </span>
                </div>
                @if(auth()->user()->hasRole(['boss','admin']))
                    <div class="d-inline-block" style="text-align: center; width: 100%; margin-top: 3px">
                        <select class="form-control" name="category_id">
                            <option value="all">@lang('dashboard.choose_category')</option>
                            @foreach($categories as $category)
                                <option 
                                    value="{{$category->id}}" 
                                    {{(request()->category_id==$category->id)?'selected':null}}>
                                        {{$category->translate(config(app()->getlocale()))->title}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </form>
            <div class="d-inline-block {{app()->getlocale()=='ar'?'pull-left':'pull-right'}}">
                <a href="{{route('dashboard.products.create')}}" class="btn btn-info">
                    <i class="fa fa-plus"></i>
                    @lang('dashboard.add_new_product')
                </a>
            </div>
        </div>
        <!-- Table -->
        <table class="table table-striped text-center">
            <thead>
                <tr class="bg-black">
                    <th>@lang('dashboard.name')</th>
                    <th>@lang('dashboard.description')</th>
                    <th>@lang('dashboard.cat')</th>
                    <th>@lang('dashboard.producer')</th>
                    <th>@lang('dashboard.image')</th>
                    <th>@lang('dashboard.cost_price')</th>
                    <th>@lang('dashboard.sale_price')</th>
                    <th>@lang('dashboard.profit')</th>
                    <th>@lang('dashboard.count')</th>
                    <th>@lang('dashboard.approval')</th>
                    <th>@lang('dashboard.action')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($products) > 0)
                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->translate(app()->getlocale())->title}}</td>
                            <td>{!! $product->translate(app()->getlocale())->desc !!}</td>
                            <td>{{$product->category->translate(app()->getlocale())->title}}</td>
                            <td>
                                {{$product->user->first_name.' '.$product->user->last_name}}
                            </td>
                            <td>
                                @if($product->img != 'no_img.png')
                                    <img src="{{$product->image_path}}" alt="product" style="width: 60px" class="img-thumbnail"/></td>
                                @else
                                    <p class="text-muted">@lang('dashboard.no_img')</p>
                                @endif
                            <td>{{$product->cost_price}}</td>
                            <td>{{$product->sale_price}}</td>
                            <td>{{$product->profit}}</td>
                            <td>{{$product->count}}</td>
                            <td>
                                @if($product->is_approved == 0)
                                    <form action="{{route('dashboard.products.approve',$product)}}" method="POST">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-exclamation"></i>
                                            @lang('dashboard.approve_product')
                                        </button>
                                    </form>
                                @else 
                                    <span class="text-success">
                                        <i class="fa fa-check"></i>
                                        @lang('dashboard.approved')
                                    </span>
                                @endif 
                            </td>
                            <td>
                                <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-info btn-sm">
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
                                                <form action="{{route('dashboard.products.destroy',$product)}}" method="POST" class="d-inline-block">
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
                        <td colspan="11"> 
                            <strong>@lang('dashboard.no_products')</strong> 
                        </td> 
                    </tr>        
                @endif
            </tbody>
        </table>
        <div class="col-md-offset-1">{{$products->appends(request()->query())->links()}}</div>
    </div>
    @include('dashboard.incs.messages')
@stop