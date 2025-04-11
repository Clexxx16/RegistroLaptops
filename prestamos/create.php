<?php
require('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $laptop_id = $_POST['laptop_id'];
    $usuario_id = $_POST['usuario_id'];
    $prestado_a = $_POST['prestado_a'];
    $fecha_prestamo = $_POST['fecha_prestamo'];
    $entregado_por = $_POST['entregado_por'];
    $devuelto = $_POST['devuelto'];
    $fecha_devolucion = !empty($_POST['fecha_devolucion']) ? "'" . $_POST['fecha_devolucion'] . "'" : "NULL";
    $devuelto_por = !empty($_POST['devuelto_por']) ? "'" . $_POST['devuelto_por'] . "'" : "NULL";

    $query = "INSERT INTO prestamos (laptop_id, usuario_id, prestado_a, fecha_prestamo, devuelto, fecha_devolucion, entregado_por, devuelto_por) 
              VALUES ('$laptop_id', '$usuario_id', '$prestado_a', '$fecha_prestamo', '$devuelto', $fecha_devolucion, '$entregado_por', $devuelto_por)";

    if ($conn->query($query)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Préstamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Animación de entrada */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated-form {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Estilo de los botones */
        .btn {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            width: 100%;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn:active {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="container mt-4">

    <h2 class="mb-4 text-center">Registrar Nuevo Préstamo</h2>

    <div class="card p-4 animated-form">
        <form method="post" action="" class="needs-validation" novalidate>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="laptop_id" class="form-label">ID Laptop:</label>
                    <input type="number" class="form-control" name="laptop_id" required>
                </div>
                <div class="col-md-6">
                    <label for="usuario_id" class="form-label">ID Usuario:</label>
                    <input type="number" class="form-control" name="usuario_id" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="prestado_a" class="form-label">Prestado a:</label>
                <input type="text" class="form-control" name="prestado_a" required>
            </div>

            <div class="mb-3">
                <label for="fecha_prestamo" class="form-label">Fecha de Préstamo:</label>
                <input type="datetime-local" class="form-control" name="fecha_prestamo" required>
            </div>

            <div class="mb-3">
                <label for="entregado_por" class="form-label">Entregado por:</label>
                <input type="text" class="form-control" name="entregado_por" required>
            </div>

            <div class="mb-3">
                <label for="devuelto" class="form-label">¿Devuelto?</label>
                <select class="form-select" name="devuelto" required>
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_devolucion" class="form-label">Fecha de Devolución:</label>
                <input type="datetime-local" class="form-control" name="fecha_devolucion">
            </div>

            <div class="mb-3">
                <label for="devuelto_por" class="form-label">Devuelto por:</label>
                <input type="text" class="form-control" name="devuelto_por">
            </div>

            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">Registrar Préstamo</button>
                </div>
                <div class="col-md-6">
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
