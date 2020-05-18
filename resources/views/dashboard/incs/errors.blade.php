@if($errors -> any())
    @foreach($errors->all() as $err)
        <div class="bg-danger text-danger" style="padding: 10px">
            {{$err}}
        </div>
    @endforeach
@endif