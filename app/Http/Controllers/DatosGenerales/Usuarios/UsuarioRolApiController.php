<?php

namespace App\Http\Controllers\DatosGenerales\Usuarios;

use App\DatosGenerales\Usuarios\UsuariosRoles;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsuarioRolApiController extends Controller
{
    public function cargarRoles()
    {

        try {
            $roles = UsuariosRoles::where('USUARIOSROLES_LOGIC_ESTADO', 'A')->orderBy('USROL_NOM', 'asc')->get();
            return  response()->json(['roles' => $roles], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function cargarRolesComboBox()
    {

        try {
            $roles = UsuariosRoles::where('USUARIOSROLES_LOGIC_ESTADO', 'A')->where('USROL_ACTIVO', 'S')->orderBy('USROL_NOM', 'asc')->get();
            return  response()->json(['roles' => $roles], 200);
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function guardarRol(Request $request)
    {
        $estado = 'I';
        $request->validate([
            'rol_cod' => "required|string|max:250|unique:usuarios_roles,USROL_COD" . $estado . ",USUARIOSROLES_LOGIC_ESTADO",
            'nombre' => "required|string|max:250|unique:usuarios_roles,USROL_NOM" . $estado . ",USUARIOSROLES_LOGIC_ESTADO",
            'activo' => 'required|string|max:10',
            'observacion' => 'string|max:20',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            UsuariosRoles::Create(
                [
                    'USROL_COD' => $request->input('rol_cod'),
                    'USROL_NOM' => $request->input('nombre'),
                    'USROL_ACTIVO' => $request->input('activo'),
                    'USROL_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'USUARIOSROLES_LOGIC_ESTADO' => 'A'
                ]
            );
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function modificarRol(Request $request)
    {
        $request->validate([
            'rol_cod' => 'required|string|max:250',
            'activo' => 'required|string|max:10',
            'observacion' => 'nullable|string|max:250',

        ]);

        try {
            DB::beginTransaction();
            $user = Auth::user();
            $fecha = getFecha();
            $time = getTime();
            UsuariosRoles::where('USROL_COD', $request->input('rol_cod'))->update([
                'USROL_ACTIVO' => $request->input('activo'),
                'USROL_OBS' => is_null($request->input('observacion'))  ? '' : $request->input('observacion'),
                'FECHA' => $fecha,
                'HORA' => $time,
                'TIPO' => $user->TIPO,
                'USUARIO' => $user->US_COD,
                'USUARIOSROLES_LOGIC_ESTADO' => 'A'
            ]);
            DB::commit();
            return response()->json(['msg' => 'OK'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
    public function eliminarRol($id)
    {

        try {
            DB::beginTransaction();
            if ($id !== '' && isset($id)) {
                $user = Auth::user();
                $fecha = getFecha();
                $time = getTime();
                UsuariosRoles::where('USROL_COD', $id)->update([
                    'FECHA' => $fecha,
                    'HORA' => $time,
                    'TIPO' => $user->TIPO,
                    'USUARIO' => $user->US_COD,
                    'USUARIOSROLES_LOGIC_ESTADO' => 'I'
                ]);
                DB::commit();
                return response()->json(['msg' => 'OK'], 200);
            } else {
                DB::rollBack();
                return response()->json(['mensaje' => 'El id deL rol es requerido'], 500);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
