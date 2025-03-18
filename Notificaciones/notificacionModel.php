<?php
include_once __DIR__ . '/../Core/dbconexion.php';

class NotificacionModel {
    private $db;

    public function __construct() {
        $database = new Connection();
        $this->db = $database->open();
    }

    // Método para obtener todas las noticias
    public function obtenerNoticias() {
        $sql = $this->db->prepare("SELECT n.id, c.nombre AS club, n.responsable, n.contenido 
                                  FROM noticias n 
                                  JOIN club c ON n.club = c.id 
                                  ORDER BY n.id DESC");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearNoticia($club, $responsable, $contenido) {
        $sql = $this->db->prepare("INSERT INTO noticias (club, responsable, contenido) VALUES (?, ?, ?)");
        return $sql->execute([$club, $responsable, $contenido]);
    }

    public function obtenerClubes() {
        $sql = $this->db->prepare("SELECT id, nombre FROM club WHERE status = 'ACTIVO' ORDER BY nombre ASC");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>