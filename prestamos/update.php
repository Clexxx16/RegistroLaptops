<?php
require('../includes/config.php');

// Verificar si se recibió un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID no válido.");
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $laptop_id = $_POST['laptop_id'];
    $usuario_id = $_POST['usuario_id'];
    $prestado_a = $_POST['prestado_a'];
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $entregado_por = $_POST['entregado_por'];
    $devuelto = $_POST['devuelto'];
    $fecha_devolucion = !empty($_POST['fecha_devolucion']) ? $_POST['fecha_devolucion'] : null;
    $devuelto_por = !empty($_POST['devuelto_por']) ? $_POST['devuelto_por'] : null;

    $query = "UPDATE prestamos SET 
                laptop_id = ?, 
                usuario_id = ?, 
                prestado_a = ?, 
                fecha_prestamo = ?, 
                entregado_por = ?, 
                devuelto = ?, 
                fecha_devolucion = ?, 
                devuelto_por = ? 
              WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisssissi", $laptop_id, $usuario_id, $prestado_a, $fecha_prestamo, $entregado_por, $devuelto, $fecha_devolucion, $devuelto_por, $id);

    if ($stmt->execute()) {
        header('Location: index.php?mensaje=actualizado');
        exit();
    } else {
        $error = "Error al actualizar: " . $conn->error;
    }

    $stmt->close();
} else {
    $query = "SELECT * FROM prestamos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $prestamo = $result->fetch_assoc();

    if (!$prestamo) {
        die("Préstamo no encontrado.");
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Préstamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            width: 50%;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .btn-custom:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .btn-custom:active {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Editar Préstamo</h2>
        <div class="card shadow">
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="laptop_id" class="form-label">ID Laptop:</label>
                            <input type="number" class="form-control" name="laptop_id" value="<?php echo htmlspecialchars($prestamo['laptop_id']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="usuario_id" class="form-label">ID Usuario:</label>
                            <input type="number" class="form-control" name="usuario_id" value="<?php echo htmlspecialchars($prestamo['usuario_id']); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="prestado_a" class="form-label">Prestado a:</label>
                        <input type="text" class="form-control" name="prestado_a" value="<?php echo htmlspecialchars($prestamo['prestado_a']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_prestamo" class="form-label">Fecha de Préstamo:</label>
                        <input type="datetime-local" class="form-control" name="fecha_prestamo" value="<?php echo htmlspecialchars($prestamo['fecha_prestamo']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="entregado_por" class="form-label">Entregado por:</label>
                        <input type="text" class="form-control" name="entregado_por" value="<?php echo htmlspecialchars($prestamo['entregado_por']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="devuelto" class="form-label">¿Devuelto?</label>
                        <select class="form-select" name="devuelto" required>
                            <option value="0" <?php if ($prestamo['devuelto'] == 0) echo 'selected'; ?>>No</option>
                            <option value="1" <?php if ($prestamo['devuelto'] == 1) echo 'selected'; ?>>Sí</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_devolucion" class="form-label">Fecha de Devolución:</label>
                        <input type="datetime-local" class="form-control" name="fecha_devolucion" value="<?php echo htmlspecialchars($prestamo['fecha_devolucion'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="devuelto_por" class="form-label">Devuelto por:</label>
                        <input type="text" class="form-control" name="devuelto_por" value="<?php echo htmlspecialchars($prestamo['devuelto_por'] ?? ''); ?>">
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" class="btn btn-success btn-custom">Actualizar Préstamo</button>
                        <a href="index.php" class="btn btn-secondary btn-custom">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>