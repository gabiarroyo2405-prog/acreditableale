<?php
// Archivo: modelos/UsuarioModelo-soft-deletes.php
// Objetivo: Gestionar la lógica de datos usando técnica de BORRADO LÓGICO (Soft Delete)

namespace Modelos;

use Modelos\Conexion;

class UsuarioModeloSoftDeletes {
    private $db;

    public function __construct() {
        $this->db = Conexion::obtenerConexion();
    }

    public function consultarTodos() {
        try {
            // El read filtra automáticamente aquellos con estatus 1 (ACTIVOS)
            $consulta = $this->db->prepare("
                SELECT idUsuario, nombreCompleto, rol, usuarioLogin, estatus 
                FROM UsuarioSistema 
                WHERE estatus = 1 
                ORDER BY nombreCompleto ASC
            ");
            $consulta->execute();
            return $consulta->fetchAll();
        } catch (\PDOException $error) {
            return [];
        }
    }
    
    public function obtenerPorId($idUsuario) {
        try {
            $consulta = $this->db->prepare("
                SELECT idUsuario, nombreCompleto, rol, usuarioLogin 
                FROM UsuarioSistema 
                WHERE idUsuario = :idUsuario 
                LIMIT 1
            ");
            $consulta->execute([':idUsuario' => (int) $idUsuario]);
            return $consulta->fetch();
        } catch (\PDOException $error) {
            return false;
        }
    }

    public function insertar($nombreCompleto, $rol, $usuarioLogin, $contrasena) {
        try {
            $consulta = $this->db->prepare("
                INSERT INTO UsuarioSistema (nombreCompleto, rol, usuarioLogin, passwordHash, estatus) 
                VALUES (:nombre, :rol, :login, :password, 1)
            ");
            $exito = $consulta->execute([
                ':nombre' => $nombreCompleto,
                ':rol' => $rol,
                ':login' => $usuarioLogin,
                ':password' => $contrasena
            ]);
            return $exito;
        } catch (\PDOException $error) {
            return false;
        }
    }
    
    public function actualizar($idUsuario, $nombreCompleto, $rol, $usuarioLogin) {
        try {
            $consulta = $this->db->prepare("
                UPDATE UsuarioSistema 
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
            return false;
        }
    }
    
    // ===================================================
    // D — SOFT DELETE: Desactivar un usuario (NO borra de la Base de Datos)
    // ===================================================
    public function desactivar($idUsuario) {
        try {
            // No usamos DELETE FROM. En su lugar, hacemos un UPDATE al parámetro estatus
            $consulta = $this->db->prepare("
                UPDATE UsuarioSistema 
                SET estatus = 0
                WHERE idUsuario = :idUsuario
            ");

            $consulta->execute([':idUsuario' => (int) $idUsuario]);
            return $consulta->rowCount() > 0;
            
        } catch (\PDOException $error) {
            return false;
        }
    }
    
    // ===================================================
    // R — REACTIVAR: Recuperar un usuario desactivado ('Undelete')
    // ===================================================
    public function reactivar($idUsuario) {
        try {
            // Cambiamos el estatus a 1 (Activo)
            $consulta = $this->db->prepare("
                UPDATE UsuarioSistema 
                SET estatus = 1
                WHERE idUsuario = :idUsuario
            ");

            $consulta->execute([':idUsuario' => (int) $idUsuario]);
            return $consulta->rowCount() > 0;
            
        } catch (\PDOException $error) {
            return false;
        }
    }
}
