<?php
// Archivo: modelos/UsuarioModelo.php
// Objetivo: Gestionar la lógica de datos de la tabla UsuarioSistema

namespace Modelos;

// Usamos nuestra clase de conexión personalizada
use Modelos\Conexion;

class UsuarioModelo {
    private $db;

    public function __construct() {
        // Alinstanciar el modelo, obtenemos la conexión única a la base de datos
        $this->db = Conexion::obtenerConexion();
    }

    // MÉTODO: Consultar todos los usuarios activos (Operación: LECTURA)
    public function consultarTodos() {
        try {
            // Preparamos la consulta SQL para obtener solo usuarios activos (estatus = 1)
            $consulta = $this->db->prepare("
                SELECT idUsuario, nombreCompleto, rol, usuarioLogin, estatus 
                FROM usuario
                WHERE estatus = 1 
                ORDER BY nombreCompleto ASC
            ");
            
            // Ejecutamos la consulta preparada
            $consulta->execute();

            // Retornamos todos los registros encontrados
            return $consulta->fetchAll();

        } catch (\PDOException $error) {
            // En caso de error de base de datos, retornamos un arreglo vacío o manejamos el error
            error_log("Error al listar: " . $error->getMessage());
            return false;
        }
    }
    // MÉTODO: Obtener un usuario por su ID (Para pre-cargar en Modales de edición)
    public function obtenerPorId($idUsuario) {
        try {
            $consulta = $this->db->prepare("
                SELECT idUsuario, nombreCompleto, rol, usuarioLogin 
                FROM usuario
                WHERE idUsuario = :idUsuario 
                LIMIT 1
            ");
            $consulta->execute([':idUsuario' => (int) $idUsuario]);
            return $consulta->fetch();
        } catch (\PDOException $error) {
            return false;
        }
    }

    // MÉTODO: Insertar un nuevo usuario (Operación: CREACIÓN)
    public function insertar($nombreCompleto, $rol, $usuarioLogin, $passwordHash) {

        try {
            // Preparamos la consulta con parámetros nombrados (Seguridad anti-inyección SQL)
            $consulta = $this->db->prepare("
                INSERT INTO usuario (nombreCompleto, rol, usuarioLogin, passwordHash, estatus) 
                VALUES (:nombreCompleto, :rol, :usuarioLogin, :passwordHash, 1)
           ");

            // Ejecutamos la inserción pasando los valores reales a los parámetros
            $exito = $consulta->execute([
                ':nombreCompleto' => $nombreCompleto,
                ':rol' => $rol,
                ':usuarioLogin' => $usuarioLogin,
                ':passwordHash' => $passwordHash // Nota: En la Clase 4 enseñaremos a encriptar contraseñas
            ]);

            return $consulta->rowCount() > 0;

            return $exito;
        } catch (\PDOException $error) {
            // Si ocurre un error, por ejemplo, un usuario duplicado, lanzamos el error
            error_log("Error al insertar usuario: " . $error->getMessage());
            return false;
        }

        } 

        // MÉTODO: Actualizar un usuario existente (Operación: UPDATE)
    public function actualizar($idUsuario, $nombreCompleto, $rol, $usuarioLogin) {
        try {
            $consulta = $this->db->prepare("
                UPDATE usuario 
                SET nombreCompleto = :nombre, 
                    rol = :rol, 
                    usuarioLogin = :login 
                WHERE idUsuario = :idUsuario
            ");

            $exito = $consulta->execute([
                ':nombre' => $nombreCompleto,
                ':rol' => $rol,
                ':login' => $usuarioLogin,
                ':idUsuario' => (int) $idUsuario
            ]);

            return $exito;
        } catch (\PDOException $error) {
            error_log("Error al actualizar usuario: " . $error->getMessage());
            return false;
        }
    }
    }

