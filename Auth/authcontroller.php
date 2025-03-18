<?php
session_start(); // Iniciar sesión

// Incluir la conexión a la base de datos
include_once __DIR__ . '/../Core/dbconexiona.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['user']); // Obtener el usuario
    $contraseña = trim($_POST['pass']); // Obtener la contraseña

    // Validar que los campos no estén vacíos
    if (empty($usuario) || empty($contraseña)) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>';
        echo 'Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Todos los campos son obligatorios",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "index.php"; // Redirigir al formulario de inicio de sesión
                });';
        echo '</script>';
        exit();
    }

    // Consulta para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el usuario existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if ($contraseña === $user['contraseña']) { // Comparación directa (si no estás usando password_hash)
            // Guardar datos del usuario en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_usuario'] = $user['usuario'];
            $_SESSION['user_rol'] = $user['rol']; // Guardar el rol del usuario

            // Redirigir según el rol del usuario
            if ($user['rol'] == 'admin') {
                header("Location: ../home.php"); // Redirigir a la página de admin
            } elseif ($user['rol'] == 'alumno') {
                header("Location: ../Public/views/homealumno.php"); // Redirigir a la página de alumno
            } else {
                // Si el rol no es reconocido, redirigir al login con un mensaje de error
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                echo '<script>';
                echo 'Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Rol de usuario no reconocido",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "index.php";
                        });';
                echo '</script>';
            }
            exit();
        } else {
            // Si la contraseña no coincide
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>';
            echo 'Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Contraseña incorrecta",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "index.php";
                    });';
            echo '</script>';
            exit();
        }
    } else {
        // Si el usuario no existe
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>';
        echo 'Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Usuario no encontrado",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "index.php";
                });';
        echo '</script>';
        exit();
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    // Si no se envió el formulario, redirigir al login
    header("Location: index.php");
    exit();
}
?>