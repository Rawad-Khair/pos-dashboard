<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel" style="white-space: normal; padding-bottom: 20px">
      <div class="pull-left image">
        <img
          src="{{url('uploads/users/images/'.auth()->user()->image)}}"
          class="img-circle"
          alt="User Image"
        >
      </div>
      <div class="pull-left info">
        <p>{{auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li>
        <a href="{{route('dashboard.index')}}">
          <i class="fa fa-dashboard"></i><span>@lang('dashboard.dashboard')</span>
        </a>
      </li>
      <li>
        <a href="{{route('dashboard.users.index')}}">
          <i class="fa fa-user"></i><span>@lang('dashboard.users')</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-green">new</small>
          </span>
        </a>
      </li>
      <li>
        <a href="{{route('dashboard.categories.index')}}">
          <i class="fa fa-list"></i><span>@lang('dashboard.categories')</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-blue">{{count($categories)}}</small>
          </span>
        </a>
      </li>
      <li>
        <a href="{{route('dashboard.products.index')}}">
          <i class="fa fa-product-hunt"></i><span>@lang('dashboard.products')</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-red"></small>
          </span>
        </a>
      </li>
      <li>
        <a href="{{route('dashboard.clients.index')}}">
          <i class="fa fa-product-hunt"></i><span>@lang('dashboard.clients')</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-green"></small>
          </span>
        </a>
      </li>
      <li>
        <a href="{{route('dashboard.orders.index')}}">
          <i class="fa fa-send"></i><span>@lang('dashboard.orders')</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-green"></small>
          </span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i>
          <span>@lang('dashboard.cp_languages')</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">{{count(LaravelLocalization::getSupportedLocales())}}</span>
          </span>
        </a>
        <ul class="treeview-menu">
          @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
              <li>
                  <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    <i class="fa fa-circle-o"></i>{{ $properties['native'] }}
                  </a>
              </li>
          @endforeach
        </ul>
      </li>
    </ul>
    <!-- search form -->
    <form
      action="#"
      method="get"
      class="sidebar-form"
    >
      <div class="input-group">
        <input
          type="text"
          name="q"
          class="form-control"
          placeholder="Search..."
        >
        <span class="input-group-btn">
          <button
            type="submit"
            name="search"
            id="search-btn"
            class="btn btn-flat"
          ><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
  </section>
  <!-- /.sidebar -->
</aside>