<?php
// Archivo: controladores/UsuarioControlador-soft-deletes.php
// Objetivo: Controlador implementando Técnica de Soft Delete sobre los modelos.

namespace Controladores;

use Modelos\UsuarioModeloSoftDeletes;

class UsuarioControladorSoftDeletes
{
    private $modelo;

    public function __construct()
    {
        // Instanciamos específicamente el modelo de borrado lógico
        $this->modelo = new UsuarioModeloSoftDeletes();
    }

    public function obtenerLista()
    {
        return $this->modelo->consultarTodos();
    }
    
    public function obtenerUsuario($idUsuario)
    {
        return $this->modelo->obtenerPorId($idUsuario);
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombreCompleto'] ?? '');
            $rol = trim($_POST['rol'] ?? '');
            $login = trim($_POST['usuarioLogin'] ?? '');
            $password = trim($_POST['passwordHash'] ?? '');

            if (!empty($nombre) && !empty($rol) && !empty($login) && !empty($password)) {
                $resultado = $this->modelo->insertar($nombre, $rol, $login, $password);
                if ($resultado) {
                    header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?exito=1");
                } else {
                    header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?error=db");
                }
            } else {
                header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?error=campos");
            }
            exit;
        }
    }
    
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUsuario = $_POST['idUsuario'] ?? 0;
            $nombre    = trim($_POST['nombreCompleto'] ?? '');
            $rol       = trim($_POST['rol'] ?? '');
            $login     = trim($_POST['usuarioLogin'] ?? '');

            if ($idUsuario > 0 && !empty($nombre) && !empty($rol) && !empty($login)) {
                $resultado = $this->modelo->actualizar($idUsuario, $nombre, $rol, $login);
                if ($resultado) {
                    header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?editado=1");
                } else {
                    header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?error=db_update");
                }
            } else {
                header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?error=campos");
            }
            exit;
        }
    }
    
    // ACCIÓN: Borrado Lógico (Desactivar)
    public function desactivar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUsuario = $_POST['idUsuario'] ?? 0;

            if ($idUsuario > 0) {
                // En lugar de borrar, desactivamos.
                $resultado = $this->modelo->desactivar($idUsuario);
                if ($resultado) {
                    header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?desactivado=1");
                } else {
                    header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?error=db_desactivar");
                }
            } else {
                header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?error=campos");
            }
            exit;
        }
    }
    
    // ACCIÓN: Reactivar (Opcional - solo demostrativo)
    public function reactivar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUsuario = $_POST['idUsuario'] ?? 0;

            if ($idUsuario > 0) {
                $resultado = $this->modelo->reactivar($idUsuario);
                if ($resultado) {
                    header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?reactivado=1");
                } else {
                    header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?error=db_reactivar");
                }
            } else {
                header("Location: ../vistas/usuarios/vista_usuarios-soft-deletes.php?error=campos");
            }
            exit;
        }
    }
}

// --------------------------------------------------------------------------
// PROCESADO DE ACCIONES
// --------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    
    // Ajuste de autoload si estamos usando un archivo clonado dentro de este workspace
    require_once __DIR__ . '/../vendor/autoload.php';
    
    // Dado que el sistema PSR-4 requiere mapear estrictamente los archivos por nombre de clase
    // Y no hemos añadido este archivo clon al composer, para que esto funcione en entorno educativo
    // y no colapse la plantilla estándar, requeriremos instanciar haciendo requiere directo de los modelos de soft deletes
    require_once __DIR__ . '/../modelos/UsuarioModelo-soft-deletes.php';
    
    $controlador = new UsuarioControladorSoftDeletes();
    $accion = $_POST['accion'];

    switch ($accion) {
        case 'guardar':
            $controlador->registrar();
            break;
        case 'actualizar':
            $controlador->actualizar();
            break;
        case 'desactivar':
            $controlador->desactivar();
            break;
        case 'reactivar':
            $controlador->reactivar();
            break;
    }
}
