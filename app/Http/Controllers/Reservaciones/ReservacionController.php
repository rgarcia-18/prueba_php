<?php
/**
 * Clase para la gestion de reservas
 * Ruben Garcia
 * ruga-18@hotmail.com
 */
namespace App\Http\Controllers\Reservaciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReservacionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * redireccionamiento al index
     * muestra el index del modulo reservaciones
     * @return view
     */
    public function index(){ 
        //consulta las reservaciones
        $reservaciones = \App\reserva::all();        
        //vista para crear las reservas
        return view('reservaciones.index',compact('reservaciones'));
    }
    
    /**
     * Muestra la vista para la creacion de reservas
     * Retorna vista para crear reservaciones
     * @return view
     */
    public function create(){
        //consulta los usuarios del sistema
        $users = \App\User::all();
        //vista para crear las reservas
        return view('reservaciones.reservaciones',compact('users'));
    }
    
    /**
     * Elimina una reserva
     * Elimina la informacion de una reserva
     * @param  int $id id del evento
     * @return view
     */
    public function remove($id){
        try{
            //inicia la transaccion
            \DB::beginTransaction();
            //Elimina la reserva
            \App\butaca_reserva::where('id_reserva',$id)->delete();
            //libera las butacas
            \App\reserva::find($id)->delete();              
            //mensaje de exito
            
            //commit
            \DB::commit();
            Session::flash('success',trans('adminlte::adminlte.reservaDelOk'));   
        }catch(QueryException $e){
            //rollBack en caso de error
            \DB::rollBack();
            Session::flash('error','error -> '.$e);
        }//cath
        //redireccionamiento al index del modulo
        return redirect()->route('reservaciones.index');
    }
     
    /**
     * retorna vista para editar la informacion del evento.
     * @param int $id id del evento
     * @return view
     */
    public function edit($id){        
        //vista para crear las reservas
        $count = 1;
        $users = \App\User::all();
        $reservacion = \App\reserva::find($id);        
        $butacas = \App\butaca_reserva::where('id_reserva',$reservacion->id)->get();
        return view('reservaciones.edit',compact('reservacion','butacas','users','count'));
    }
    
    /**
     * Modifica una reserva
     * Modifica la informacion de una reserva
     * @param Illuminate\Http\Request $request
     * @return view
     */
    public function modification(Request $request){
        
        try{
            //validacion de datos
            $this->validate($request,[
                'fecha' => 'required|date_format:d/m/Y',
                'numPersonas' => 'required|numeric'
            ],[
                'fecha.required' => trans('adminlte::adminlte.fechaMsgRequired'),
                'fecha.date_format'     => trans('adminlte::adminlte.fechaMsgDate'),
                'numPersonas.required' => trans('adminlte::adminlte.numPersonasMsgRequired'),
                'numPersonas.numeric' => trans('adminlte::adminlte.numPersonasMsgNumeric')
            ]);
            
            //inicia la transaccion
            \DB::beginTransaction();
            
            //consulta la reserva para editarla
            $reserva = \App\reserva::find($request->id);            
            $reserva->fecha = \Carbon\Carbon::createFromFormat('d/m/Y',$request->fecha)->format('Y-m-d 00:00:00');
            $reserva->num_personas = $request->numPersonas;
            
            //guarda la reserva
            if($reserva->save()){
                //elimina las butacas
                \App\butaca_reserva::where('id_reserva',$request->id)->delete();   
            }//if
                     
            //valida que existan butacas
            if(count($request->butaca)>0){
                
                //guarda nuevamente las butacas
                foreach($request->butaca as $butaca){
                    $butaca_reserva = new \App\butaca_reserva();
                    $butaca_reserva->fila = $butaca['fila'];
                    $butaca_reserva->columna = $butaca['columna'];
                    $butaca_reserva->ind_estado = 1;
                    $butaca_reserva->id_reserva = $request->id;
                    $butaca_reserva->save();
                }//foreach
            }//if     
                  
            //confirma la transaccion
            \DB::commit();
            //mensaje de exito
            Session::flash('success',trans('adminlte::adminlte.reservaEditOk'));
            
        }catch(QueryException $e){
            //rollBack en caso de error
            \DB::rollBack();
            Session::flash('error','error -> '.$e);
        }//cath
       
        //retorna nuevamente a la vista
        return redirect()->route('reservaciones.index');
    }  
    
    /**
     * guarda una reserva
     * guarda la informacion de una nueva reserva
     * @param Illuminate\Http\Request $request
     * @return view
     */
    public function store(Request $request){

        try{
            //validacion de datos
            $this->validate($request,[
                'fecha' => 'required|date_format:d/m/Y',
                'numPersonas' => 'required|numeric'
            ],[
                'fecha.required' => trans('adminlte::adminlte.fechaMsgRequired'),
                'fecha.date_format'     => trans('adminlte::adminlte.fechaMsgDate'),
                'numPersonas.required' => trans('adminlte::adminlte.numPersonasMsgRequired'),
                'numPersonas.numeric' => trans('adminlte::adminlte.numPersonasMsgNumeric')
            ]);
            
            //inicia la transaccion
            \DB::beginTransaction();
            
            //inserta la nueva reserva           
            $id = \DB::table('reservas')->insertGetId([
                'id_user' => $request->usuario,
                'fecha' => \Carbon\Carbon::createFromFormat('d/m/Y',$request->fecha)->format('Y-m-d 00:00:00'),
                'num_personas' => $request->numPersonas,                
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ]);
                        
            //valida que existan butacas
            if(count($request->butaca)>0){
                foreach($request->butaca as $butaca){
                    $butaca_reserva = new \App\butaca_reserva();
                    $butaca_reserva->fila = $butaca['fila'];
                    $butaca_reserva->columna = $butaca['columna'];
                    $butaca_reserva->ind_estado = 1;
                    $butaca_reserva->id_reserva = $id;
                    $butaca_reserva->save();
                }//foreach
            }//if     
                
            //confirma la transaccion
            \DB::commit();
            //mensaje de exito
            Session::flash('success',trans('adminlte::adminlte.reservaOk'));
            
        }catch(QueryException $e){
            //rollBack en caso de error
            \DB::rollBack();
            Session::flash('error','error -> '.$e);
        }//cath
       
        //retorna nuevamente a la vista
        return redirect()->route('reservaciones.index');
    }
    
    /**
     * Valida si una bitaca ya se encuentra reservada
     * validacion ajax para saber si una butaca ya se encuentra reservada
     * @param Illuminate\Http\Request $request
     * @return json
     */
    public function validateAjax(Request $request){  
        if($request->_reserva){
            $cout = \App\butaca_reserva::where('fila',$request->_fila)->where('columna',$request->_columna)->where('id_reserva','<>',$request->_reserva)->where('ind_estado',1)->get()->count();    
        }//if
        else{
            $cout = \App\butaca_reserva::where('fila',$request->_fila)->where('columna',$request->_columna)->where('ind_estado',1)->get()->count();    
        }//else        
        return response()->json(['count' => $cout]);
    }
    
}
