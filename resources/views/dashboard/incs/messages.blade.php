
<div class = "col-md-4" style ="position: absolute; z-index: 1000000; top: 25px;
            {{app()->getlocale() == 'ar' ? 'right: 0' : 'left: '}}">
    @if(session('msg_ok'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-check"></i>
            {{session('msg_ok')}}
        </div>
    @elseif(session('msg_danger'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-warning"></i>
        {{session('msg_danger')}}
    </div>
    @endif
</div>