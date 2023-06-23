<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// LLAMO EL MODELO USUARIO
use App\Models\ModeloUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ControladorUsuario extends BaseController
{
    protected $usuario;
    public function __construct()
    {
        session_start();
        $this->usuario = new ModeloUsuario();
    }

    public function Index()
    {
        if (!isset($_SESSION["iduser"])) {
            return view('login/login');
        } else {
            return redirect()->route('Admin');
        }
    }

    public function Admin()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');
        } else {
            return view('Admin/index');
        }
    }

    public function Cerrar()
    {
        session_destroy();
        return redirect()->route('/');
    }

    public function Credenciales(Request $request)
    {
        //$metodo = $request->method();
        //valido si es POST
        if ($request->isMethod('post')) {
            //validar si por ajax
            if ($request->ajax()) {
                // $usuario = $request->input("usuario");
                // $clave = $request->input("clave");
                $usuario = $request->usuario;
                $clave = $request->clave;
                $repuesta_create = $this->usuario->Credenciales($usuario, $clave);
                if (!empty($repuesta_create)) {
                    echo json_encode($repuesta_create, JSON_UNESCAPED_UNICODE);
                    exit();
                } else {
                    echo 0;
                    exit();
                }
            }
        }
    }

    public function Token(Request $request)
    {
        if ($request->isMethod('post')) {
            $_SESSION["iduser"] = $request->token_session;
            echo 1;
            exit();
        }
    }

    //// VITAS DEL ADMINISTRADOR
    public function Usuario($valor)
    {
        if (isset($_SESSION["iduser"])) {
            if ($valor == "Create") {
                $rol = $this->usuario->ListarRol();
                $data = [
                    'massage' =>  '',
                    'status' =>  '',
                    'values' =>  [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => 0],
                    'rol' =>  $rol,
                ];
                return view('Admin.usuario.create', $data);
            } else if ($valor == "Lista") {
                $lista = $this->usuario->ListarUsuario();
                $data = [
                    'lista' =>  $lista
                ];
                return view('Admin.usuario.lista', $data);
            }
        } else {
            return redirect()->route('/');
        }
    }

    ///// CAPA DATOS DEL ADMINISTRADOR
    public function RegisterUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $rol = $this->usuario->ListarRol();

            $nombres = $request->nombre_completos;
            $apellidos = $request->apellidos_completos;
            $correo = $request->correo_usuario;
            $usuario = $request->usuario_completo;
            $password = $request->passworduser;
            $rolid = $request->rol_user;

            $mesnaje = $this->usuario->RegistraUsuario($nombres, $apellidos, $correo, $usuario, $password, $rolid);
            if ($mesnaje == 1) {
                $succes = "Usuario registrado con exito";
                $status = "success";
                $valores = [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => 0];
            } else if ($mesnaje == 2) {
                $succes = "Correo '" . $correo . "' ya se encuentra registrado";
                $status = "warning";
                $valores = [0 => $nombres, 1 => $apellidos, 2 => $correo, 3 => $usuario, 4 => $password, 5 => $rolid];
            } else if ($mesnaje == 3) {
                $succes = "El usuario '" . $usuario . "' ya se encuentra registrado";
                $status = "warning";
                $valores = [0 => $nombres, 1 => $apellidos, 2 => $correo, 3 => $usuario, 4 => $password, 5 => $rolid];
            } else {
                $succes = "Error:" . $mesnaje;
                $status = "danger";
                $valores = [0 => $nombres, 1 => $apellidos, 2 => $correo, 3 => $usuario, 4 => $password, 5 => $rolid];
            }

            $data = [
                'massage' =>  $succes,
                'status' =>  $status,
                'values' =>  $valores,
                'rol' =>  $rol,
            ];
            return view('Admin.usuario.create', $data);
        }
    }

    public function EditarUsuario($valor)
    {
        if (isset($_SESSION["iduser"])) {
            $valor = $this->usuario->EditUsaurio($valor);
            if (!empty($valor)) {

                $rol = $this->usuario->ListarRol();

                $data = [
                    'massage' =>  "",
                    'status' =>  "",
                    'values' =>  $valor,
                    'rol' =>  $rol,
                    'booton' =>  true,

                ];
                return view('Admin.usuario.edit', $data);
            } else {
                return redirect()->route('Admin.Usuario', ['valor' => 'Lista']);
            }
        } else {
            return redirect()->route('/');
        }
    }

    public function UpdateUsuario(Request $request)
    {
        if ($request->isMethod('post')) {

            $rol = $this->usuario->ListarRol();

            $id = $request->iduser;
            $nombres = $request->nombre_completos;
            $apellidos = $request->apellidos_completos;
            $correo = $request->correo_usuario;
            $usuario = $request->usuario_completo;
            $password = $request->passworduser;
            $rolid = $request->rol_user;

            $mesnaje = $this->usuario->UpdateUsuario($nombres, $apellidos, $correo, $usuario, $password, $id);
            if ($mesnaje == 1) {
                $succes = "Usuario editado con exito";
                $status = "success";
                $valores = [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 8 => 0];
                $boton = false;
            } else if ($mesnaje == 2) {
                $succes = "Correo '" . $correo . "' ya se encuentra registrado";
                $status = "warning";
                $valores = [0 => $id, 1 => $nombres, 2 => $apellidos, 3 => $correo, 4 => $usuario, 5 => $password, 8 => $rolid];
                $boton = true;
            } else if ($mesnaje == 3) {
                $succes = "El usuario '" . $usuario . "' ya se encuentra registrado";
                $status = "warning";
                $valores = [0 => $id, 1 => $nombres, 2 => $apellidos, 3 => $correo, 4 => $usuario, 5 => $password, 8 => $rolid];
                $boton = true;
            } else {
                $succes = "Error:" . $mesnaje;
                $status = "danger";
                $valores = [0 => $id, 1 => $nombres, 2 => $apellidos, 3 => $correo, 4 => $usuario, 5 => $password, 8 => $rolid];
                $boton = true;
            }
            $data = [
                'massage' =>  $succes,
                'status' =>  $status,
                'values' =>  $valores,
                'rol' =>  $rol,
                'booton' =>  $boton,
            ];
            return view('Admin.usuario.edit', $data);
        }
    }

    public function EstadoUsuario(Request $request)
    {

        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $id = $request->id;
                $estado = $request->estado;

                $repuesta_create = $this->usuario->EstadoUsuario($id, $estado);
                echo $repuesta_create;
                exit();
            }
        }
    }

    //// VITAS DEL ADMINISTRADOR
    public function Rol($valor)
    {
        if (isset($_SESSION["iduser"])) {
            if ($valor == "Create") {
                $data = [
                    'massage' =>  '',
                    'status' =>  '',
                    'values' =>  [0 => ''],
                ];
                return view('Admin.usuario.createrol', $data);
            } else if ($valor == "Lista") {
                $lista = $this->usuario->ListarRol();
                $data = [
                    'lista' =>  $lista
                ];
                return view('Admin.usuario.listarol', $data);
            }
        } else {
            return redirect()->route('/');
        }
    }

    ///// CAPA DATOS DEL ADMINISTRADOR
    public function RegisterRol(Request $request)
    {
        if ($request->isMethod('post')) {

            $rol = $request->nombre_rol;

            $mesnaje = $this->usuario->RegistrarRol($rol);
            if ($mesnaje == 1) {
                $succes = "Rol registrado con exito";
                $status = "success";
                $valores = [0 => ''];
            } else if ($mesnaje == 2) {
                $succes = "El rol '" . $rol . "' ya se encuentra registrado";
                $status = "warning";
                $valores = [0 => $rol];
            } else {
                $succes = "Error:" . $mesnaje;
                $status = "danger";
                $valores = [0 => $rol];
            }
            $data = [
                'massage' =>  $succes,
                'status' =>  $status,
                'values' =>  $valores,
            ];
            return view('Admin.usuario.createrol', $data);
        }
    }

    public function EditarRol($valor)
    {
        if (isset($_SESSION["iduser"])) {
            if ($valor == 1) {
                return redirect()->route('Admin.Rol', ['valor' => 'Lista']);
            } else {
                $valor = $this->usuario->EditRol($valor);
                if (!empty($valor)) {
                    $data = [
                        'massage' =>  "",
                        'status' =>  "",
                        'values' =>  $valor,
                        'booton' =>  true,
                    ];
                    return view('Admin.usuario.editRol', $data);
                } else {
                    return redirect()->route('Admin.Rol', ['valor' => 'Lista']);
                }
            }
        } else {
            return redirect()->route('/');
        }
    }

    public function UpdateRol(Request $request)
    {
        if ($request->isMethod('post')) {

            $id = $request->idrol;
            $rol = $request->nombre_rol_edit;

            $mesnaje = $this->usuario->UpdateRol($rol, $id);
            if ($mesnaje == 1) {
                $succes = "Rol editado con exito";
                $status = "success";
                $valores = [0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => ''];
                $boton = false;
            } else if ($mesnaje == 2) {
                $succes = "Rol '" . $rol . "' ya se encuentra registrado";
                $status = "warning";
                $valores = [0 => $id, 1 => $rol];
                $boton = true;
            } else {
                $succes = "Error:" . $mesnaje;
                $status = "danger";
                $valores = [0 => $id, 1 => $rol];
                $boton = true;
            }
            $data = [
                'massage' =>  $succes,
                'status' =>  $status,
                'values' =>  $valores,
                'booton' =>  $boton,
            ];
            return view('Admin.usuario.editRol', $data);
        }
    }
}
