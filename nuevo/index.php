<?php
// Archivo: index.php
// Objetivo: Punto de entrada único del sistema (Controlador Frontal)

// Cargamos el sistema de carga de clases automático (Autoloader)
require_once __DIR__ . '/vendor/autoload.php';

// Redirigir a la vista de usuarios por defecto en esta fase del proyecto
header("Location: vistas/usuarios/vista_usuarios.php");
exit;
