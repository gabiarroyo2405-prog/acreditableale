<?php
// Archivo: controladores/UsuarioControlador.php
// Objetivo: Coordinar las peticiones de los usuarios con la lógica del modelo

namespace Controladores;

// Importamos el modelo necesario para las operaciones
use Modelos\UsuarioModelo;

class UsuarioControlador
{
    private $modelo;

    public function __construct()
    {
        // Al instanciar el controlador, creamos un objeto del modelo de usuarios
        $this->modelo = new UsuarioModelo();
    }

    // ACCIÓN: Listar todos los usuarios activos
    public function obtenerLista()
    {
        // Obtenemos los datos del modelo y los enviamos a la vista
        return $this->modelo->consultarTodos();
    }
    
    // ACCIÓN: Obtener un solo usuario mediante su ID
    public function obtenerUsuario($idUsuario)
    {
        return $this->modelo->obtenerPorId($idUsuario);
    }

    // ACCIÓN: Gestionar el registro de un nuevo usuario
    public function registrar()
    {
        // Verificamos si se envió el formulario por método POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Recogemos y limpiamos los datos del formulario
            $nombre = trim($_POST['nombreCompleto'] ?? '');
            $rol = trim($_POST['rol'] ?? '');
            $login = trim($_POST['usuarioLogin'] ?? '');
            $password = trim($_POST['passwordHash'] ?? '');

            // VALIDACIÓN: Comprobar que no haya campos vacíos
            if (!empty($nombre) && !empty($rol) && !empty($login) && !empty($password)) {

                // Pedimos al modelo que inserte el nuevo usuario
                $resultado = $this->modelo->insertar($nombre, $rol, $login, $password);

                if ($resultado) {
                    // Si se guardó correctamente, redirigimos a la vista con mensaje de éxito (exito=1)
                    header("Location: ../vistas/usuarios/vista_usuarios.php?exito=1");
                } else {
                    // Si falló por algún error de base de datos (ej. login repetido)
                    header("Location: ../vistas/usuarios/vista_usuarios.php?error=db");
                }
            } else {
                // Si faltan campos obligatorios
                header("Location: ../vistas/usuarios/vista_usuarios.php?error=campos");
            }
            exit;
        }
    }
    
    // ACCIÓN: Gestionar la modificación de un usuario existente
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $idUsuario = $_POST['idUsuario'] ?? 0;
            $nombre    = trim($_POST['nombreCompleto'] ?? '');
            $rol       = trim($_POST['rol'] ?? '');
            $login     = trim($_POST['usuarioLogin'] ?? '');

            // Comprobamos la presencia de un ID válido además de los campos
            if ($idUsuario > 0 && !empty($nombre) && !empty($rol) && !empty($login)) {
                
                $resultado = $this->modelo->actualizar($idUsuario, $nombre, $rol, $login);

                if ($resultado) {
                    header("Location: ../vistas/usuarios/vista_usuarios.php?editado=1");
                } else {
                    header("Location: ../vistas/usuarios/vista_usuarios.php?error=db_update");
                }
            } else {
                header("Location: ../vistas/usuarios/vista_usuarios.php?error=campos");
            }
            exit;
        }
    }
    
    // ACCIÓN: Ejecutar el borrado FÍSICO (Hard delete) del usuario
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUsuario = $_POST['idUsuario'] ?? 0;

            if ($idUsuario > 0) {
                $resultado = $this->modelo->eliminar($idUsuario);

                if ($resultado) {
                    header("Location: ../vistas/usuarios/vista_usuarios.php?eliminado=1");
                } else {
                    header("Location: ../vistas/usuarios/vista_usuarios.php?error=db_delete");
                }
            } else {
                header("Location: ../vistas/usuarios/vista_usuarios.php?error=campos");
            }
            exit;
        }
    }
}

// --------------------------------------------------------------------------
// PROCESADO DE ACCIONES: Este bloque permite manejar peticiones directas POST al archivo
// --------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    // Si la petición proviene de un formulario externo, cargamos manualmente el cargador automático
    require_once __DIR__ . '/../vendor/autoload.php';

    $controlador = new UsuarioControlador();
    $accion = $_POST['accion'];

    // Selección de la lógica según la acción recibida del formulario
    switch ($accion) {
        case 'guardar':
            $controlador->registrar();
            break;
        case 'actualizar':
            $controlador->actualizar();
            break;
        case 'eliminar':
            $controlador->eliminar();
            break;
    }
}
