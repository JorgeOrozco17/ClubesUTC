<?php
// Definición de la clase Connection para manejar la conexión a la base de datos
class Connection
{

    // Propiedades privadas para almacenar los datos de conexión
    private $server = "mysql:host=localhost;dbname=clubes"; // Cadena de conexión al servidor y base de datos
    private $username = "root"; // Nombre de usuario de la base de datos
    private $password = ""; // Contraseña del usuario de la base de datos
    private $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Configura PDO para que lance excepciones en caso de error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Configura PDO para que devuelva los resultados como un array asociativo
    );

    // Propiedad protegida para almacenar la instancia de la conexión PDO
    protected $conn;

    // Método para abrir la conexión a la base de datos
    public function open()
    {
        try {
            // Intenta crear una nueva instancia de PDO usando los datos de conexión
            $this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
            return $this->conn; // Devuelve la instancia de PDO si la conexión es exitosa
        } catch (PDOException $e) {
            // Captura cualquier excepción y muestra un mensaje de error
            echo "Ocurrió un problema con la conexión: " . $e->getMessage();
        }
    }

    // Método para cerrar la conexión a la base de datos
    public function close()
    {
        $this->conn = null; // Establece la propiedad $conn a null para cerrar la conexión
    }

    // Métodos para obtener los datos de conexión
    public function getHost()
    {
        return str_replace('mysql:host=', '', explode(';', $this->server)[0]);
    }

    public function getDbName()
    {
        return str_replace('dbname=', '', explode(';', $this->server)[1]);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
