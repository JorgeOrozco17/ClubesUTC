<?php
include_once __DIR__ . '/../Core/dbconexion.php';

class AlumnoModel {
    private $db;

    public function __construct() {
        $database = new Connection();
        $this->db = $database->open();
    }

    public function obtenerAlumnosPorClub($id) {
        $sql = $this->db->prepare("SELECT * FROM registros WHERE club_destino = ?");
        $sql->execute([$id]);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarAlumno($nombre, $carrera, $matricula, $club_id) {
        $sql = $this->db->prepare("INSERT INTO registros (nombre, carrera, matricula, club_destino) VALUES (?, ?, ?, ?)");
        return $sql->execute([$nombre, $carrera, $matricula, $club_id]);
    }
}
?>
