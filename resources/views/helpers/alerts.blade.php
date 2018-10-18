@if (count($errors) > 0)
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </h4>
    </div>
@endif

{{-- Mensajes de exito/error al guardar o modificar informacion de la base de datos --}}

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i>
            @if(is_array(Session('success')))
                <ul>
                    @foreach (Session('success') as $msg)
                        <li>{!! $msg !!}</li>
                    @endforeach
                </ul>
            @else
                 {!! Session('success') !!}
            @endif 
        </h4>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i>
            @if(is_array(Session('error')))
                <ul>
                    @foreach (Session('error') as $msg)
                        <li>{!! $msg !!}</li>
                    @endforeach
                </ul>
            @else
                {!! Session('error') !!}
            @endif
        </h4>
    </div>
@endif
