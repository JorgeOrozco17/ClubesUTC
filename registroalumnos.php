<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirige al login
    exit(); // Detiene la ejecución del script
}

include_once 'Club/ClubController.php';
include_once 'Club/AlumnoController.php';

$clubNombre = "";
$clubId = null;
$mensaje = "";

if (isset($_GET['club_id'])) {
    $clubController = new ClubController();
    $club = $clubController->verClub($_GET['club_id']); // Obtiene la info del club
    if ($club) {
        $clubNombre = $club['nombre'];
        $clubId = $_GET['club_id'];
    }
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $carrera = $_POST['carrera'];
    $matricula = $_POST['matricula'];
    $club_id = $_POST['club_id'];

    $alumnoController = new AlumnoController();
    if ($alumnoController->registrarAlumno($nombre, $carrera, $matricula, $club_id)) {
        $mensaje = "<div class='alert alert-success'>Alumno registrado correctamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al registrar el alumno.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 120px;
            max-width: 500px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .navbar .navbar-brand {
            color: #f5f5f5;
            font-weight: bold;
        }
        .navbar .nav-link {
            color: rgb(2, 2, 2);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
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
                        <li class="nav-item"><a class="nav-link" href="../../logout.php">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Formulario -->
    <div class="container">
        <h2 class="text-center">Registro de Alumnos</h2>
        <p class="text-center">Completa el formulario para unirte a un club.</p>
        
        <?= $mensaje; ?> <!-- Mensaje de éxito o error -->

        <form method="POST" id="registroForm">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="carrera" class="form-label">Carrera:</label>
                <input type="text" id="carrera" name="carrera" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="matricula" class="form-label">Matrícula:</label>
                <input type="text" id="matricula" name="matricula" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Club Destino:</label>
                <?php if ($clubNombre): ?>
                    <input type="text" class="form-control" value="<?= $clubNombre ?>" readonly>
                    <input type="hidden" name="club_id" value="<?= $clubId ?>">
                <?php else: ?>
                    <select id="club" name="club_id" class="form-control" required>
                        <option value="" disabled selected>Selecciona un club</option>
                        <option value="1">Club Deportivo</option>
                        <option value="2">Club Cultural</option>
                        <option value="3">Club Académico</option>
                        <option value="4">Club de Esports</option>
                    </select>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
            <div class="text-center">
            <a href="../../Clubes/Public/views/clubInfo.php?id=<?= $club['id'] ?>" class="btn btn-warning">Regresar</a>
        </div>
        </form>
    </div>
</body>
</html>
