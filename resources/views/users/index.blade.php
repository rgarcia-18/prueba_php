@extends('adminlte::page')

@section('title',trans('adminlte::adminlte.usuarios'))

@section('content_header')
<h1>
	{{trans('adminlte::adminlte.usuarios')}}
</h1>
<ol class="breadcrumb">
    <li>
        <a href="{{route('admin')}}"><i class="fa fa-home"></i>{{trans('adminlte::adminlte.administracion')}}</a>
    </li>
    <li>{{trans('adminlte::adminlte.usuarios')}}</li>
</ol>
@stop

@section('content_header_options')
<div class="x_content">
    <a href="{{route('admin')}}" class="btn btn-primary ">{{trans('adminlte::adminlte.regresar')}}</a>
    <a href="{{route('users.new')}}" class="btn btn-primary">{{trans('adminlte::adminlte.crear')}}</a>
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
                        <th>{{trans('adminlte::adminlte.nombre')}}</th>
                        <th>{{trans('adminlte::adminlte.apellido')}}</th>
                        <th>{{trans('adminlte::adminlte.email')}}</th>
                        <th style="text-align: center;">{{trans('adminlte::adminlte.editar')}}</th>
                        <th style="text-align: center;">{{trans('adminlte::adminlte.eliminar')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user )
                            <tr>
                                <td>{{ $user->name}}</td>
                                <td>{{ $user->lastName }}</td>
                                <td>{{ $user->email }}</td>
                                <td style="text-align: center;"><a href="{{route('users.edit',['id' => $user->id ])}}"><i class="fa fa-edit fa-2x"></i></a></td>
                                <td style="text-align: center;"><a href="{{route('users.remove',['id' => $user->id ])}}" onclick='return confirm("{{trans('adminlte::adminlte.msgConfirmDelUsuario')}}");'><i class="fa fa-remove fa-2x"></i></a></td>
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