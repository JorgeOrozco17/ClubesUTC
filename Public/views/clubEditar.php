<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirige al login
    exit(); // Detiene la ejecución del script
}

include_once '../../Club/ClubController.php';
$controller = new ClubController();

if (isset($_GET['id'])) {
    $club = $controller->verClub($_GET['id']);
} else {
    echo "ID no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .container {
            max-width: 600px;
            margin-top: 100px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border-radius: 5px;
        }
        .btn-secondary {
            border-radius: 5px;
        }

        .navbar {
            background-color: #007bff !important;
            padding: 10px 20px;
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
<nav class="navbar bg-body-tertiary fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="../../clubes.php">Clubes</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" id="offcanvasNavbar">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Menú</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="home.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="clubes.php">Clubes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Cerrar Sesion</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

    <div class="container">
        <h2 class="text-center">Editar Club</h2>
        <form action="../../Club/ClubController.php" method="POST">
            <input type="hidden" name="id" value="<?= $club['id'] ?>">
            
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?= $club['nombre'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ubicación</label>
                <input type="text" class="form-control" name="ubicacion" value="<?= $club['ubicacion'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Titular</label>
                <input type="text" class="form-control" name="titular" value="<?= $club['titular'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Estatus</label>
                <select class="form-control" name="status">
                    <option value="ACTIVO" <?= $club['status'] == 'ACTIVO' ? 'selected' : '' ?>>ACTIVO</option>
                    <option value="INACTIVO" <?= $club['status'] == 'INACTIVO' ? 'selected' : '' ?>>INACTIVO</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="clubInfo.php?id=<?= $club['id'] ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
