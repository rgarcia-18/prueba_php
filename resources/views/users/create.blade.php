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
    <li>
        <a href="{{route('users.index')}}">{{trans('adminlte::adminlte.usuarios')}}</a>
    </li>
    <li class="active">{{trans('adminlte::adminlte.crear')}}</li>
</ol>
@stop

@section('content_header_options')
<div class="x_content">
    <a href="{{route('users.index')}}" class="btn btn-primary ">{{trans('adminlte::adminlte.regresar')}}</a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                    <i class="fa fa-edit"></i>
                    <h3 class="box-title">{{trans('adminlte::adminlte.crearUsuario')}}</h3>
            </div>	
            <form id="form-obj" role="form" method="post" action="{{route('users.store')}}">
                {{csrf_field()}}
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body">                        
                        <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                            <label for="name">{{ trans("adminlte::adminlte.nombre") }} (*)</label>
                            <input type="text" class="form-control" id="name" required="required" name="name" placeholder="{{ trans("adminlte::adminlte.nombre") }}" maxlength="255">
                        </div>
                        <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                            <label for="lastName">{{ trans("adminlte::adminlte.apellido") }} (*)</label>
                            <input type="text" class="form-control" id="lastName" required="required" name="lastName" placeholder="{{ trans("adminlte::adminlte.apellido") }}" maxlength="255">
                        </div>
                        <div class="clearfix"></div> 
                        <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                            <label for="email">{{ trans("adminlte::adminlte.email") }} (*)</label>
                            <input type="email" class="form-control" id="email" required="required" name="email" placeholder="{{ trans("adminlte::adminlte.email") }}" maxlength="255">
                        </div>
                        
                        <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                            <label for="password">{{ trans("adminlte::adminlte.password") }} (*)</label>
                            <input type="password" class="form-control" id="password" required="required" name="password" placeholder="{{ trans("adminlte::adminlte.password") }}" maxlength="255">
                        </div>
                        <div class="clearfix"></div> 
                        
                        <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                            <label for="password_confirmation">{{ trans("adminlte::adminlte.retype_password") }} (*)</label>
                            <input type="password" class="form-control" id="password_confirmation" required="required" name="password_confirmation" placeholder="{{ trans("adminlte::adminlte.retype_password") }}" maxlength="255">
                        </div>
                        

                        <input type="hidden" name="countButacas" id="countButacas" value="1">
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">{{trans('adminlte::adminlte.guardar')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.col -->
</div>
@stop

@section('js')
<script type="text/javascript">
    $(function(){

    });   
</script>
@stop
