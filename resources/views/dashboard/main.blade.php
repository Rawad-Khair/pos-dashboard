<?php 
  $route = 'dashboard.incs';
  $route_content = $route.'/contents';
 ?>

@include($route.'/header')
@include($route.'/navbar')
@include($route.'/aside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Main content -->
  <section class="content">
    
    <div class="row">
      <section class="col-lg-12 connectedSortable">
        @yield('content')
      </section>
    </div>

  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->

{{--@include($route_content.'/control_slidebar')--}}

@include($route.'/footer')