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
    <li>
        <a href="{{route('reservaciones.index')}}">{{trans('adminlte::adminlte.reservaciones')}}</a>
    </li>
    <li class="active">{{trans('adminlte::adminlte.crear')}}</li>
</ol>
@stop

@section('content_header_options')
<div class="x_content">
    <a href="{{route('reservaciones.index')}}" class="btn btn-primary ">{{trans('adminlte::adminlte.regresar')}}</a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                    <i class="fa fa-edit"></i>
                    <h3 class="box-title">{{trans('adminlte::adminlte.crearReserva')}}</h3>
            </div>	
            <form id="form-obj" role="form" method="post" action="{{route('reservaciones.store')}}">
                {{csrf_field()}}
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body">                        
                        <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                            <label for="fecha">{{ trans("adminlte::adminlte.fecha") }} (*)</label>
                            <input type="text" autocomplete="off" class="form-control" required="required" id="fecha" name="fecha" placeholder="{{ trans("adminlte::adminlte.fecha") }}"  maxlength="255">
                        </div>
                        <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                            <label for="numPersonas">{{ trans("adminlte::adminlte.numPersonas") }} (*)</label>
                            <input type="number" class="form-control" id="numPersonas" required="required" name="numPersonas" placeholder="{{ trans("adminlte::adminlte.numPersonas") }}" maxlength="255">
                        </div>
                        <div class="clearfix"></div> 
                        <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                            <label for="usuario">{{ trans("adminlte::adminlte.usuario") }} (*)</label>
                            <select class="form-control fila" name="usuario" id="usuario" required="required">
                                <option></option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}} {{$user->lastName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>    
                        <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                            <h3>{{ trans("adminlte::adminlte.butacas") }}</h3>
                        </div>
                        <div class="clearfix"></div> 
                        <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                            <table class="table table-bordered" name="tblButacas" id="tblButacas">
                            <tbody>
                                <tr>
                                    <th style="text-align:center;"></th>
                                    <th>{{trans("adminlte::adminlte.fila")}}</th>
                                    <th>{{trans("adminlte::adminlte.columna")}}</th>
                                    <th style="text-align:center;">{{trans("adminlte::adminlte.butaca")}}</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <select class="form-control fila" name="butaca[1][fila]" required="required">
                                            <option></option>
                                            @foreach(config('app.filas') as $fila)
                                                <option value="{{$fila}}">{{$fila}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control columna" name="butaca[1][columna]" required="required">
                                            <option></option>
                                            @foreach(config('app.columnas') as $columna)
                                                <option value="{{$columna}}">{{$columna}}</option>
                                            @endforeach
                                        </select>                                        
                                    </td>
                                    <td class="numButaca" style="text-align:center;"></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        <input type="hidden" name="countButacas" id="countButacas" value="1">
                        <div class="clearfix"></div> 
                        <div class="form-group col-xs-5 col-sm-2 col-md-6 col-lg-3">
                            <button type="button" id="agregar" name="agregar" class="btn btn-primary">
                                <i class="fa fa-plus"></i>&nbsp;&nbsp;{{ trans("adminlte::adminlte.agregar") }}
                            </button>
                        </div>
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
    
    count = 0;
    
    $(function(){
        $('#fecha').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });
            
        $("#agregar").click(function(){
            var count = parseInt($("#countButacas").val());
            addRow(++count);
        });
      
        $('body').on('click','.eliminarButaca',function(){ 
          $(this).parent().parent().remove();
        });
        
        $('body').on('change','.fila, .columna',function(){
            
            var _token  = "{{csrf_token()}}";
            var _method = "PUT";  
        
           $row = $(this).parent().parent();
           fila = ($row).find('.fila').val();
           columna = ($row).find('.columna').val();                       
           if(fila != '' && columna != ''){
               
                $.ajax({
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    url: "{{route('reservaciones.validateAjax')}}",
                    type: 'POST',
                    cache: false,
                    data: {'_fila':fila,'_columna':columna, '_token':_token,'_method':_method},
                    datatype: 'html',
                    beforeSend: function(){},
                    success: function(data){
                        //valida si la butaca no esta seleccionada
                        if(data.count > 0){
                            //alerta para indicar que la butaca ya esta seleccionada
                            var msg = "{{trans('adminlte::adminlte.msgButacaOcupada2')}}";
                            alert(msg.replace('XX',fila+' - '+columna));

                            //resetea la fila para seleccionar una butaca diferente
                            ($row).find('.fila').val('');
                            ($row).find('.columna').val('');
                            ($row).find('.numButaca').html('');                    
                        }//if
                        else if(validate(fila,columna) > 1){
                            //alerta para indicar que la butaca ya esta seleccionada
                            var msg = "{{trans('adminlte::adminlte.msgButacaOcupada')}}";
                            alert(msg.replace('XX',fila+' - '+columna));

                            //resetea la fila para seleccionar una butaca diferente
                            ($row).find('.fila').val('');
                            ($row).find('.columna').val('');
                            ($row).find('.numButaca').html('');
                        }//elseif
                        else{
                            ($row).find('.numButaca').html(fila+' - '+columna);
                        }//else                
                    },
                    error: function(xhr,textStatus,thrownError){
                        alert(xhr + "\n" + textStatus + "\n" + thrownError);
                    }
                }); //ajax 
           }//if
        });

    });
    
    function addRow(count){
        var row = '<tr><td style="text-align:center;"><a href="javascript:void(0);" class="eliminarButaca"><i class="fa fa-remove"></i></a></td><td><select class="form-control fila" name="butaca['+count+'][fila]" required="required"><option></option>@foreach(config('app.filas') as $fila)<option value="{{$fila}}">{{$fila}}</option>@endforeach</select></td><td><select class="form-control columna" name="butaca['+count+'][columna]" required="required"><option></option>@foreach(config('app.columnas') as $columna)<option value="{{$columna}}">{{$columna}}</option>@endforeach</select></td><td class="numButaca" style="text-align:center;"></td></tr>';
        $("#countButacas").val(count);
        $("#tblButacas").append(row);
    }//addRow
    
    function validate(fila,columna){
        
        var butacas = [];
        var valor = '';
        var butaca = fila+' - '+columna;
        var resp;
        
        //añade la butaca actual al array
        butacas.push(butaca);
        
        //recorre las filas de la tabla
        $("#tblButacas tr").each(function() {
            valor = $(this).find("td").eq(3).html();
            if(valor){
                //añade la butaba al array de butacas
                butacas.push($.trim(valor));
            }//if
        });
        //cuantas butaca repetidas existen
        resp = countArray(butacas,butaca);
        //cantidad
        return resp;
    }//validate
    
    //cuenta la butaca actual en la tabla
    function countArray(butacas,butaca){
        var count = 0;
        butacas.forEach(function(element) {
            if(butaca === element){
                count++;
            }//if
        });
        return count;
    }
    
</script>
@stop
