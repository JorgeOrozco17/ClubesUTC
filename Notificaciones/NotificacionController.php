<?php
include_once __DIR__ . '/../Core/dbconexion.php';
include_once 'NotificacionModel.php';

class NotificacionController {
    private $model;

    public function __construct() {
        $this->model = new NotificacionModel();
    }

    // Método para obtener todas las noticias
    public function listarNoticias() {
        return $this->model->obtenerNoticias();
    }

    public function crearNoticia($club_id, $responsable, $contenido) {
        return $this->model->crearNoticia($club_id, $responsable, $contenido);
    }

    public function listarClubes() {
        return $this->model->obtenerClubes();
    }
}
?>