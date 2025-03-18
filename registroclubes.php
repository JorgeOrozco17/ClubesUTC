<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirige al login
    exit(); // Detiene la ejecución del script
}

include_once 'Core/dbconexion.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clubes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">  
    
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Arial', sans-serif;
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
            margin-top: 100px;
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            font-weight: bold;
        }
        
        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
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
        <h1>Registro de Clubes</h1>
        <form id="clubForm">
            <div class="form-group">
                <label for="Nombre">Nombre del Club:</label>
                <input type="text" id="Nombre" name="Nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="Titular">Líder del Club:</label>
                <input type="text" id="Titular" name="Titular" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="Ubicacion">Ubicación:</label>
                <input type="text" id="Ubicacion" name="Ubicacion" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="Status">Estatus del Club:</label>
                <select id="Status" name="Status" class="form-control" required>
                    <option value="" disabled selected>Selecciona un estatus</option>
                    <option value="ACTIVO">Activo</option>
                    <option value="INACTIVO">Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Club</button>
        </form>
    </div>
    
    <script>
        document.getElementById("clubForm").addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            fetch("Club/ClubController.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Club registrado correctamente!");
                    document.getElementById("clubForm").reset();
                } else {
                    alert("Error al registrar el club.");
                }
            })
            .catch(error => console.error("Error en el fetch:", error));
        });
    </script>
</body>
</html>
