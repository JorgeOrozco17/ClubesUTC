<?php
include_once 'ClubModel.php';

class ClubController {
    private $model;

    public function __construct() {
        $this->model = new ClubModel();
    }

    public function verClub($id) {
        return $this->model->obtenerClubPorId($id);
    }

    public function editarClub($id, $nombre, $ubicacion, $titular, $status) {
        return $this->model->actualizarClub($id, $nombre, $ubicacion, $titular, $status);
    }

    public function eliminarClub($id) {
        return $this->model->eliminarClub($id);
    }

    public function registrarClub($nombre, $titular, $ubicacion, $status) {
        return $this->model->registrarClub($nombre, $titular, $ubicacion, $status);
    }
}

// Manejo de peticiones
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new ClubController();

    // Si la solicitud es para eliminar un club
    if (isset($_POST['id']) && isset($_POST['eliminar'])) {
        $resultado = $controller->eliminarClub($_POST['id']);
        echo json_encode(["success" => $resultado]);
        exit();
    }

    // Si la solicitud es para editar un club
    if (isset($_POST['id'], $_POST['nombre'], $_POST['ubicacion'], $_POST['titular'], $_POST['status'])) {
        $resultado = $controller->editarClub($_POST['id'], $_POST['nombre'], $_POST['ubicacion'], $_POST['titular'], $_POST['status']);

        // Redirigir a home solo si la edición fue exitosa
        if ($resultado) {
            header("Location: ../clubes.php");
            exit();
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar los datos."]);
        }
    }

    // Si la  solicitud es para agregar un club
    if (isset($_POST['Nombre'], $_POST['Titular'], $_POST['Ubicacion'], $_POST['Status'])) {
        $nombre = trim($_POST['Nombre']);
        $titular = trim($_POST['Titular']);
        $ubicacion = trim($_POST['Ubicacion']);
        $status = trim($_POST['Status']);

        $resultado = $controller->registrarClub($nombre, $titular, $ubicacion, $status);
        echo json_encode(["success" => $resultado]);
        exit();
    }

}

// Si se envía una petición GET para obtener información de un club
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $controller = new ClubController();
    $club = $controller->verClub($_GET['id']);
}
