<?php
/**
 * Clase para la gestion de usuarios
 * Ruben Garcia
 * ruga-18@hotmail.com
 */
namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
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
     * muestra el index del modulo usuarios
     * @return view
     */
    public function index(){
        //consulta los usuarios del sistema
        $users = \App\User::all();
        //index del modulo
        return view('users.index',compact('users'));
    }
    
    /**
     * Muestra la vista para la creacion de usuarios
     * Retorna vista para crear un usuario
     * @return view
     */
    public function create(){
        //retorna la viata pra crear usuarios
        return view('users.create');
    }
    
    /**
     * retorna vista para editar la informacion de un usuario.
     * @param int $id id del usuario
     * @return view
     */
    public function edit($id){     
        //consulta la informacion del usuario
        $user = \App\User::find($id);
        //retorna la vista para modificar el usuario
        return view('users.edit', compact('user'));
    }
    
    
    /**
     * guarda un usuario
     * guarda la informacion de un nuevo usuario
     * @param Illuminate\Http\Request $request
     * @return view
     */
    public function store(Request $request){  
        
        try{
            //validacion de datos
            $this->validate($request,[
                'name' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
            
            //crea el objeto usuario         
            $user = new \App\User();     
            $user->name = $request->name;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            
            //mensaje de exito
            Session::flash('success',trans('adminlte::adminlte.msgUserOk'));
            
        }catch(QueryException $e){
            Session::flash('error','error -> '.$e);
        }//cath
       
        //retorna nuevamente a la vista
        return redirect()->route('users.index');
    }
    
    /**
     * Modifica un usuario
     * Modifica la informacion de un usuario
     * @param Illuminate\Http\Request $request
     * @return view
     */
    public function modific(Request $request){  
        
        try{
            //validacion de datos
            $this->validate($request,[
                'name' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$request->id,
                'password' => 'nullable|string|min:6|confirmed',
            ]);
            
            //consulta el usuario      
            $user = \App\User::find($request->id);     
            $user->name = $request->name;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            
            //mensaje de exito
            Session::flash('success',trans('adminlte::adminlte.msgUserEditOk'));
            
        }catch(QueryException $e){
            Session::flash('error','error -> '.$e);
        }//cath
       
        //retorna nuevamente a la vista
        return redirect()->route('users.index');
    }
    
    /**
     * Elimina un usuario
     * Elimina la informacion de un usuario
     * @param  int $id id del usuario
     * @return view
     */
    public function remove($id){
        try{
            //whereIn
            $user = \App\User::find($id);
            $reservas = \App\reserva::where('id_user',$user->id)->pluck('id')->toArray();
            
            //Elimina las butacas correspondientes a las reservas del usuario
            \App\butaca_reserva::whereIn('id_reserva',$reservas)->delete();
            
            //elimina las reservas
            \App\reserva::where('id_user',$user->id)->delete();
                        
            //Elimina el usuario
            $user->delete();     
            
            //mensaje de exito
            Session::flash('success',trans('adminlte::adminlte.usuarioDelOk'));   
        }catch(QueryException $e){
            Session::flash('error','error -> '.$e);
        }//cath
        //redireccionamiento al index del modulo
        return redirect()->route('users.index');
    }
    
}
