<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirigir al login si no ha iniciado sesión
    exit();
}

// Incluir el controlador de notificaciones
include_once 'Notificaciones/NotificacionController.php';

// Crear una instancia del controlador
$notificacionController = new NotificacionController();

// Procesar el formulario de nueva noticia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear_noticia'])) {
    $club_id = trim($_POST['club']);
    $responsable = $_SESSION['user_usuario']; // Obtener el nombre del responsable de la sesión
    $contenido = trim($_POST['contenido']);

    if (empty($club_id) || empty($contenido)) {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        if ($notificacionController->crearNoticia($club_id, $responsable, $contenido)) {
            $mensaje = "Noticia creada correctamente.";
        } else {
            $mensaje = "Error al crear la noticia.";
        }
    }
}

// Obtener las noticias
$noticias = $notificacionController->listarNoticias();

// Obtener la lista de clubes
$clubes = $notificacionController->listarClubes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Notificaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1rem;
            color: #555;
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

        .container {
            margin-top: 80px;
        }
    </style>
</head>
<body>
    <header>
    <nav class="navbar bg-body-tertiary fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">Clubes</a>
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
    </header>

    <div class="container">
        <h2 class="text-center mb-4">Notificaciones Recientes</h2>
    </div>

    <div class="container mt-5">
        <!-- Formulario para crear una nueva noticia -->
        <div class="mb-5">
            <h3>Crear Nueva Noticia</h3>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="club" class="form-label">Club</label>
                    <select class="form-control" id="club" name="club" required>
                        <option value="" disabled selected>Selecciona un club</option>
                        <?php foreach ($clubes as $club): ?>
                            <option value="<?= htmlspecialchars($club['id']) ?>"><?= htmlspecialchars($club['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea class="form-control" id="contenido" name="contenido" rows="3" required></textarea>
                </div>
                <button type="submit" name="crear_noticia" class="btn btn-primary">Publicar</button>
            </form>
            <?php if (isset($mensaje)): ?>
                <div class="alert alert-info mt-3"><?= $mensaje ?></div>
            <?php endif; ?>
        </div>

        <!-- Mostrar noticias existentes -->
        <div class="row">
            <?php if (!empty($noticias)): ?>
                <?php foreach ($noticias as $noticia): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($noticia['club']) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Responsable: <?= htmlspecialchars($noticia['responsable']) ?></h6>
                                <p class="card-text"><?= htmlspecialchars($noticia['contenido']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">No hay notificaciones disponibles.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>