<?php

require_once __DIR__ . '/vendor/autoload.php';

use Modelos\Conexion;

try {
    $conexion = Conexion::obtenerInstancia();
    echo "Conexión exitosa a la base de datos.";
} catch (Exception $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}