<?php
require('../includes/config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegura que el ID sea un número entero válido

    // Preparar la consulta para mayor seguridad
    $query = "DELETE FROM laptops WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        header('Location: index.php?mensaje=eliminado');
        exit();
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
} else {
    echo "ID no proporcionado.";
}
?>
