@extends('adminlte::page')

@section('title',trans('adminlte::adminlte.reservaciones'))

@section('content_header')
<h1>
	{{trans('adminlte::adminlte.reservaciones')}}
</h1>
<ol class="breadcrumb">
    <li>
        <a href="{{route('admin')}}"><i class="fa fa-home"></i>{{trans('adminlte::adminlte.administracion')}}</a>
    </li>
    <li>{{trans('adminlte::adminlte.reservaciones')}}</li>
</ol>
@stop

@section('content_header_options')
<div class="x_content">
    <a href="{{route('admin')}}" class="btn btn-primary ">{{trans('adminlte::adminlte.regresar')}}</a>
    <a href="{{route('reservaciones.new')}}" class="btn btn-primary">{{trans('adminlte::adminlte.crear')}}</a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>{{trans('adminlte::adminlte.usuario')}}</th>
                        <th>{{trans('adminlte::adminlte.fecha')}}</th>
                        <th>{{trans('adminlte::adminlte.numPersonas')}}</th>
                        <th>{{trans('adminlte::adminlte.butacas')}}</th>
                        <th style="text-align: center;">{{trans('adminlte::adminlte.editar')}}</th>
                        <th style="text-align: center;">{{trans('adminlte::adminlte.eliminar')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($reservaciones as $reserva )
                            <tr>
                                <td>{{ \App\User::find($reserva->id_user)->name }} {{\App\User::find($reserva->id_user)->lastName}}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
                                <td style="text-align: center;">{{ $reserva->num_personas }}</td>
                                <td>
                                    <ul>
                                        @foreach(\App\butaca_reserva::where('id_reserva',$reserva->id)->get() as $butaca)
                                            <li>{{$butaca->fila}} - {{$butaca->columna}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td style="text-align: center;"><a href="{{route('reservaciones.edit',['id' => $reserva->id ])}}"><i class="fa fa-edit fa-2x"></i></a></td>
                                <td style="text-align: center;"><a href="{{route('reservaciones.remove',['id' => $reserva->id ])}}" onclick='return confirm("{{trans('adminlte::adminlte.msgConfirmDelEvento')}}");'><i class="fa fa-remove fa-2x"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
         </div>
     </div>
</div>
@stop
@section('js')
<script>
  $(function () {
    $('#datatable-buttons').DataTable();
  })
</script>
 @stop