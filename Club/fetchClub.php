<?php
include_once 'Core/dbconexion.php';
$output = '';
$database = new Connection();
$db = $database->open();

try {
    $sql = $db->prepare('SELECT * FROM club WHERE status = "ACTIVO" ORDER BY nombre ASC');
    $sql->execute();
    $result = $sql->fetchAll();

    if ($result) {
        // Recorre los resultados y agrega cada fila de datos a la tabla
        foreach ($result as $value) {
            $output .= "<tr>";
            $output .= "<td>{$value['id']}</td>";
            $output .= "<td>{$value['nombre']}</td>";
            $output .= "<td>{$value['ubicacion']}</td>";
            $output .= "<td class=\"text-center\">{$value['titular']}</td>";
            $output .= "<td class=\"text-center\">{$value['status']}</td>";
            $output .= "<td class=\"text-center\">";
            $output .= "<button type=\"button\" class=\"btn btn-info btn-sm me-2\" title=\"Más información\" onclick=\"window.location.href='Public/views/clubInfo.php?id={$value['id']}'\">Info</button>";
            $output .= "<button type=\"button\" class=\"btn btn-danger btn-sm\" title=\"Eliminar\" onclick=\"eliminarClub({$value['id']})\">Eliminar</button>";
            $output .= "</td>";
            $output .= "</tr>";
        }
    } else {
        $output = "<div>No hay clubes activos.</div>";
    }
} catch (PDOException $e) {
    $output = '<div>Error al procesar la búsqueda: ' . $e->getMessage() . '</div>';
}

echo $output;
?>
