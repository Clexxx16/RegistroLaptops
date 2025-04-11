<?php
require('../includes/config.php');

// Verificar si se recibió un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID no válido.");
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = trim($_POST['codigo']);
    $marca = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $procesador = trim($_POST['procesador']);
    $ram = trim($_POST['ram']);
    $almacenamiento = trim($_POST['almacenamiento']);
    $estado = trim($_POST['estado']);
    $descripcion = trim($_POST['descripcion']);

    if (empty($codigo) || empty($marca) || empty($modelo) || empty($procesador) || empty($ram) || empty($almacenamiento) || empty($estado) || empty($descripcion)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $query = "UPDATE laptops SET codigo=?, marca=?, modelo=?, procesador=?, ram=?, almacenamiento=?, estado=?, descripcion=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssssi", $codigo, $marca, $modelo, $procesador, $ram, $almacenamiento, $estado, $descripcion, $id);

        if ($stmt->execute()) {
            header('Location: index.php?mensaje=actualizado');
            exit();
        } else {
            $error = "Error al actualizar: " . $conn->error;
        }

        $stmt->close();
    }
} else {
    $query = "SELECT * FROM laptops WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $laptop = $result->fetch_assoc();

    if (!$laptop) {
        die("Laptop no encontrada.");
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Laptop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Estilos personalizados */
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
        <h2 class="text-center">Editar Laptop</h2>
        <div class="card shadow">
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="codigo" class="form-label">Código:</label>
                            <input type="text" class="form-control" name="codigo" value="<?php echo htmlspecialchars($laptop['codigo']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="marca" class="form-label">Marca:</label>
                            <input type="text" class="form-control" name="marca" value="<?php echo htmlspecialchars($laptop['marca']); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modelo" class="form-label">Modelo:</label>
                            <input type="text" class="form-control" name="modelo" value="<?php echo htmlspecialchars($laptop['modelo']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="procesador" class="form-label">Procesador:</label>
                            <input type="text" class="form-control" name="procesador" value="<?php echo htmlspecialchars($laptop['procesador']); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ram" class="form-label">Memoria RAM (GB):</label>
                            <input type="text" class="form-control" name="ram" value="<?php echo htmlspecialchars($laptop['ram']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="almacenamiento" class="form-label">Almacenamiento (GB):</label>
                            <input type="text" class="form-control" name="almacenamiento" value="<?php echo htmlspecialchars($laptop['almacenamiento']); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado:</label>
                        <select class="form-select" name="estado" required>
                            <option value="Disponible" <?php if ($laptop['estado'] == 'Disponible') echo 'selected'; ?>>Disponible</option>
                            <option value="En uso" <?php if ($laptop['estado'] == 'En uso') echo 'selected'; ?>>En uso</option>
                            <option value="Mantenimiento" <?php if ($laptop['estado'] == 'Mantenimiento') echo 'selected'; ?>>Mantenimiento</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" name="descripcion" required><?php echo htmlspecialchars($laptop['descripcion']); ?></textarea>
                    </div>

                    <!-- Botones centrados con ancho moderado -->
                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" class="btn btn-success btn-custom">Actualizar Laptop</button>
                        <a href="index.php" class="btn btn-secondary btn-custom">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
