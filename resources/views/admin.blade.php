@extends('adminlte::page')

@section('content')

<style type="text/css">
  a:visited{ color: #333;}
  a:link{ color: #333;}
  a:active{ color: #333;
  a:hover{ color: #333;}
</style>

<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('users.index') }}" class="modules">
            <div class="info-box">
                <span class="info-box-icon bg-blue">
                    <i class="fa fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-number">{{trans('adminlte::adminlte.usuarios')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->    
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{ route('reservaciones.index') }}" class="modules">
            <div class="info-box">
                <span class="info-box-icon bg-blue">
                    <i class="fa fa-calendar"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-number">{{trans('adminlte::adminlte.reservaciones')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
@stop
