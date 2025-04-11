<?php
require('../includes/config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegura que el ID sea un número entero válido

    $query = "DELETE FROM laptops WHERE id = $id";

    if ($conn->query($query)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
} else {
    echo "ID no proporcionado.";
}
?>
