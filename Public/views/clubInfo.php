<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirige al login
    exit(); // Detiene la ejecución del script
}

include_once '../../Club/ClubController.php';
include_once '../../Club/AlumnoController.php'; 

$clubController = new ClubController();
$alumnoController = new AlumnoController(); 

if (isset($_GET['id'])) {
    $club = $clubController->verClub($_GET['id']);
    $alumnos = $alumnoController->listarAlumnos($_GET['id']);
} else {
    echo "ID no proporcionado.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 100px;
            max-width: 700px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table {
            margin-top: 20px;
        }
        
        .btn-warning {
            background-color: #ffc107;
            border: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .navbar .navbar-brand {
            color: #f5f5f5;
            font-weight: bold;
        }

        .navbar .nav-link {
            color:rgb(2, 2, 2);
        }
    </style>
</head>
<body>
    <nav class="navbar bg-primary navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../clubes.php">Clubes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" id="offcanvasNavbar">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Menú</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="../../home.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="../../clubes.php">Clubes</a></li>
                        <li class="nav-item"><a class="nav-link" href="../../logout.php">Cerrar Sesion</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="text-center">Información del Club</h2>
        <table class="table table-bordered">
            <tr><th>ID</th><td><?= $club['id'] ?></td></tr>
            <tr><th>Nombre</th><td><?= $club['nombre'] ?></td></tr>
            <tr><th>Ubicación</th><td><?= $club['ubicacion'] ?></td></tr>
            <tr><th>Titular</th><td><?= $club['titular'] ?></td></tr>
            <tr><th>Estatus</th><td><?= $club['status'] ?></td></tr>
        </table>
        <div class="text-center">
            <a href="clubEditar.php?id=<?= $club['id'] ?>" class="btn btn-warning">Editar</a>
        </div>
        <br>
        <div class="">
            <a href="../../clubes.php" class="btn btn-warning">Regresar</a>
        </div>
    </div>

    <div class="container">
    <div class="mt-3 text-end">
        <a href="../../registroalumnos.php?club_id=<?= $club['id'] ?>" class="btn btn-success">Agregar Nuevo Alumno</a>
    </div>
    <h3 class="text-center mt-4">Alumnos Registrados</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Matricula</th>
                    <th>Carrera</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alumnos as $alumno): ?>
                    <tr>
                        <td><?= $alumno['id'] ?></td>
                        <td><?= $alumno['nombre'] ?></td>
                        <td><?= $alumno['matricula'] ?></td>
                        <td><?= $alumno['carrera']?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
