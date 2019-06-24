<div class="col-md-12 p-t-10">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">search</i>
        </span>
        <div class="form-line">
    <input type="text" class="form-control date search" placeholder="search any keyword" name="search" value="{{ isset($request['search']) ? $request['search'] : '' }}">
        </div>
    </div>
</div>

@section('scripts')

    <script>
        $(function(){
            $('.search').keypress(function(event){
                input = $(this).val();
                var keycode = (event.keyCode ? event.keyCode : event.which);

                if(keycode == '13'){
                    window.location.href = "?search=" + input;
                }
            });
        });
    </script>

@append