<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\products;
use App\Models\products_comments;
use App\Models\personas;
use App\Models\vw_users;
use App\Models\vw_products;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function index()
    {
        return view('main.index');
    }

    public function usuarios(){
        $records_usuarios = vw_users::all(); 
        $records_usuarios = json_encode($records_usuarios);
        $records_usuarios = str_replace('"','|', $records_usuarios);
        return view('processes.viewUsuarios', compact('records_usuarios'));
    }

    public function registro_usuarios(Request $request){
        try {
            if($request->hidden_id_user == 0){
                $item_user = new users();
                $item_user->name = $request->nombre_usuario;
                $item_user->full_name = $request->nombre_completo;
                $item_user->password = Hash::make($request->contraseña);
                $item_user->email = $request->correo;
                $item_user->created_at = date('Y-m-d');
                $item_user->updated_at = date('Y-m-d');
                $item_user->email_verified_at = date('Y-m-d');
                $item_user->timestamps = false;
                $item_user->save();
    
                $result['tittle']  = __('Registro realizado');
                $result['type']    = __('success');
                $result['message'] = __('');
                return Redirect::to('usuarios')->with('msg', $result)->withInput();
            }else{
                $item_editar_user = users::find($request->hidden_id_user);
                if($item_editar_user !== null){
                    $item_editar_user->password = Hash::make($request->contraseña);
                    $item_editar_user->created_at = date('Y-m-d');
                    $item_editar_user->updated_at = date('Y-m-d');
                    $item_editar_user->email_verified_at = date('Y-m-d');
                    $item_editar_user->save();

                    $result['tittle']  = __('Registro actualizado');
                    $result['type']    = __('success');
                    $result['message'] = __('');
                    return Redirect::to('usuarios')->with('msg', $result)->withInput();
                }
            }

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = __('Datos duplicados');
            return Redirect::to('usuarios')->with('msg', $result)->withInput();
        }
    }
    public function buscar_usuario(Request $request){
        try {
            $model = vw_users::where('name', $request->nombre_usuario);
            $result = $model->get()->toArray();
            return $result;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('bancos')->with('msg', $result)->withInput();
        }
    }
    public function buscar_correo(Request $request){
        try {
            $model = vw_users::where('email', $request->correo);
            $result = $model->get()->toArray();
            return $result;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('bancos')->with('msg', $result)->withInput();
        }
    }
    public function buscar_edicion_user(Request $request){
        try {
            $model = vw_users::where('id', $request->id);
            $result = $model->get()->toArray();
            return $result;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('bancos')->with('msg', $result)->withInput();
        }
    }

    public function productos(){
        $records_productos = vw_products::all(); 
        $records_productos = json_encode($records_productos);
        $records_productos = str_replace('"','|', $records_productos);
        return view('processes.viewProductos', compact('records_productos'));
    }

    public function registro_productos(Request $request){
        try{
                $item_productos = new products();
                $item_productos->name         = $request->name;
                $item_productos->price      = $request->price;
                $item_productos->save();
    
                $result['tittle']  = __('Registro realizado');
                $result['type']    = __('success');
                $result['message'] = __('');
                return Redirect::to('productos')->with('msg', $result)->withInput();

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('productos')->with('msg', $result)->withInput();
        }

    }

    public function products_comment(Request $request){
        try{
                $item_productos1 = new products_comments();
                $item_productos1->id_products         = $request->id;
                $item_productos1->description      = $request->description;
                $item_productos1->save();
    
                $result['tittle']  = __('Registro realizado');
                $result['type']    = __('success');
                $result['message'] = __('');
               
                return true;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('productos')->with('msg', $result)->withInput();
        }

    }

    public function buscar_codigo_producto(Request $request){
        try {
            $model = vw_products::where('id', $request->id);
            $result = $model->get(['id'])->toArray();
            return $result;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('productos')->with('msg', $result)->withInput();
        }
    }
    public function buscar_descripcion_producto(Request $request){
        try {
            $model = vw_products::where('id', $request->id);
            $result = $model->get(['id'])->toArray();
            return $result;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('productos')->with('msg', $result)->withInput();
        }
    }
    
    public function buscar_edicion_producto(Request $request){
        try {
            $model = vw_products::where('id', $request->id);
            $result = $model->get()->toArray();
            return $result;

        }catch (\Exception $e) {
            $result['tittle']  = __('Ha ocurrido un error');
            $result['type']    = __('error');
            $result['message'] = $e->getMessage();
            return Redirect::to('productos')->with('msg', $result)->withInput();
        }
    }

}