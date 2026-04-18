<?php
// Archivo: modelos/Conexion.php
// Objetivo: Gestionar una única conexión segura a la base de datos (Patrón Singleton)

namespace Modelos;

// Importamos las clases nativas de PHP para manejo de bases de datos
use PDO;
use PDOException;

class Conexion {
    // Variable estática que guardará la única instancia de la conexión
    private static $instancia = null;

    // Configuración de la base de datos (Los estudiantes deben ajustar estos valores)
    private $servidor = "localhost";
    private $nombreBaseDatos = "db_iglesia";
    private $usuario = "root";
    private $contrasena = "";

    // Constructor privado para evitar que se creen múltiples objetos de conexión
    private function __construct() {
        try {
            // DSN: Nombre de la fuente de datos (Data Source Name)
            // Configuramos charset utf8mb4 para el correcto manejo de acentos y la letra ñ
            $dsn = "mysql:host={$this->servidor};dbname={$this->nombreBaseDatos};charset=utf8mb4";
            
            // Opciones de configuración de PDO para seguridad y rendimiento
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Reportar errores como excepciones
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Devolver resultados como arreglos asociativos
                PDO::ATTR_EMULATE_PREPARES => false, // Desactivar emulación de consultas preparadas para mayor seguridad
            ];

            // Creamos el objeto PDO que manejará la comunicación con MySQL
            self::$instancia = new PDO($dsn, $this->usuario, $this->contrasena, $opciones);

        } catch (PDOException $error) {
            // Si hay un fallo de conexión, se detiene la ejecución y se reporta el error
            die("Error de conexión a la base de datos: " . $error->getMessage());
        }
    }

    // Método estático para obtener la conexión en cualquier parte del sistema
    public static function obtenerConexion() {
        if (self::$instancia === null) {
            new self();
        }
        return self::$instancia;
    }
}
