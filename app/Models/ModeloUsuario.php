<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use ModeloConection;

class ModeloUsuario
{
    private $conexion;
    function __construct()
    {
        require_once 'ModeloConection.php';
        $this->conexion = new ModeloConection();
        //abrir conexion
        $this->conexion->conexionPDO();
        //cerra conexion
        $this->conexion->cerrar_conexion();
    }

    function Credenciales($usuario, $passs)
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT
            usuario.id,
            usuario.estado
            FROM
            usuario where BINARY usuario.usuario = ? 
            and BINARY usuario.clave = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $usuario);
            $query->bindParam(2, $passs);
            $query->execute();
            $result = $query->fetch();
            $this->conexion->cerrar_conexion();
            return $result;
            //cerramos la conexion
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function ListarUsuario()
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT
            usuario.id, 
            usuario.nombre, 
            usuario.apellidos, 
            usuario.correo, 
            usuario.usuario, 
            usuario.clave, 
            usuario.foto, 
            usuario.estado, 
            usuario.rol_id, 
            rol.rol
            FROM
            usuario
            INNER JOIN
            rol
            ON 
            usuario.rol_id = rol.id ORDER BY usuario.id ASC";
            $query = $c->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            //cerramos la conexion
            $this->conexion->cerrar_conexion();
            return $result;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function RegistraUsuario($nombres, $apellidos, $correo, $usuario, $password, $rolid)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();


            $sql = "SELECT * FROM usuario where binary usuario = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $usuario);
            $query->execute();
            $data_u = $query->fetch();

            if (empty($data_u)) {

                $sql_b = "SELECT * FROM usuario where correo = ?  ";
                $query_b = $c->prepare($sql_b);
                $query_b->bindParam(1, $correo);
                $query_b->execute();
                $data_c = $query_b->fetch();

                if (empty($data_c)) {

                    $sql_a = "INSERT INTO usuario (nombre, apellidos, correo, usuario, clave, rol_id) VALUES (?,?,?,?,?,?)";
                    $querya = $c->prepare($sql_a);
                    $querya->bindParam(1, $nombres);
                    $querya->bindParam(2, $apellidos);
                    $querya->bindParam(3, $correo);
                    $querya->bindParam(4, $usuario);
                    $querya->bindParam(5, $password);
                    $querya->bindParam(6, $rolid);

                    if ($querya->execute()) {
                        $res = 1;
                    } else {
                        $res = 0;
                    }
                } else {
                    $res = 2;
                }
            } else {
                $res = 3;
            }

            $this->conexion->cerrar_conexion();
            return $res;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function EditUsaurio($valor)
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM usuario WHERE id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $valor);
            $query->execute();
            $result = $query->fetch();
            //cerramos la conexion
            $this->conexion->cerrar_conexion();
            return $result;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function UpdateUsuario($nombres, $apellidos, $correo, $usuario, $password, $id)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();

            $sql = "SELECT * FROM usuario where binary usuario = ? AND id != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $usuario);
            $query->bindParam(2, $id);
            $query->execute();
            $data_u = $query->fetch();

            if (empty($data_u)) {

                $sql_b = "SELECT * FROM usuario where correo = ? AND id != ?";
                $query_b = $c->prepare($sql_b);
                $query_b->bindParam(1, $correo);
                $query_b->bindParam(2, $id);
                $query_b->execute();
                $data_c = $query_b->fetch();

                if (empty($data_c)) {

                    $sql_a = "UPDATE usuario SET nombre = ?, apellidos = ?, correo = ?, usuario = ?, clave = ? WHERE id = ?";
                    $querya = $c->prepare($sql_a);
                    $querya->bindParam(1, $nombres);
                    $querya->bindParam(2, $apellidos);
                    $querya->bindParam(3, $correo);
                    $querya->bindParam(4, $usuario);
                    $querya->bindParam(5, $password);
                    $querya->bindParam(6, $id);

                    if ($querya->execute()) {
                        $res = 1;
                    } else {
                        $res = 0;
                    }
                } else {
                    $res = 2;
                }
            } else {
                $res = 3;
            }

            $this->conexion->cerrar_conexion();
            return $res;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function EstadoUsuario($id, $estado)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql_a = "UPDATE usuario SET estado = ? WHERE id = ?";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $estado); 
            $querya->bindParam(2, $id);

            if ($querya->execute()) {
                $res = 1;
            } else {
                $res = 0;
            }


            $this->conexion->cerrar_conexion();
            return $res;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }


    //// ROL DEL USUARIO
    function RegistrarRol($rol)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM rol where binary rol = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $rol);
            $query->execute();
            $data_u = $query->fetch();

            if (empty($data_u)) {
                $sql_a = "INSERT INTO rol (rol) VALUES (?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $rol);

                if ($querya->execute()) {
                    $res = 1;
                } else {
                    $res = 0;
                }
            } else {
                $res = 2;
            }

            $this->conexion->cerrar_conexion();
            return $res;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function ListarRol()
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM rol ORDER BY id ASC";
            $query = $c->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            //cerramos la conexion
            $this->conexion->cerrar_conexion();
            return $result;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function EditRol($valor)
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM rol WHERE id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $valor);
            $query->execute();
            $result = $query->fetch();
            //cerramos la conexion
            $this->conexion->cerrar_conexion();
            return $result;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function UpdateRol($rol, $id)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM rol where binary rol = ? AND id != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $rol);
            $query->bindParam(2, $id);
            $query->execute();
            $data_u = $query->fetch();
            if (empty($data_u)) {
                $sql_a = "UPDATE rol SET rol = ? WHERE id = ?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $rol);
                $querya->bindParam(2, $id);
                if ($querya->execute()) {
                    $res = 1;
                } else {
                    $res = 0;
                }
            } else {
                $res = 2;
            }

            $this->conexion->cerrar_conexion();
            return $res;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }
}
