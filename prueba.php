<?php

require_once __DIR__ . '/vendor/autoload.php';

use Modelos\Conexion;
use Controladores\UsuarioControlador;

try {
    $conexion = Conexion::obtenerConexion();
    echo "Conexión exitosa a la base de datos.";
    $controlador = new UsuarioControlador();
    $usuarios = $controlador->obtenerLista();
    echo $usuarios;
} catch (Exception $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}