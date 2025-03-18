<?php
include_once 'AlumnoModel.php';

class AlumnoController {
    private $model;

    public function __construct() {
        $this->model = new AlumnoModel();
    }

    public function listarAlumnos($club_id) {
        return $this->model->obtenerAlumnosPorClub($club_id);
    }

    public function registrarAlumno($nombre, $carrera, $matricula, $club_id) {
        return $this->model->registrarAlumno($nombre, $carrera, $matricula, $club_id);
    }
}
?>
