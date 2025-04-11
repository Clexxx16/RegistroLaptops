<?php
require('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $procesador = $_POST['procesador'];
    $ram = $_POST['ram'];
    $almacenamiento = $_POST['almacenamiento'];
    $estado = $_POST['estado'];
    $descripcion = $_POST['descripcion'];

    $query = "INSERT INTO laptops (codigo, marca, modelo, procesador, ram, almacenamiento, estado, descripcion, creado_en) 
              VALUES ('$codigo', '$marca', '$modelo', '$procesador', '$ram', '$almacenamiento', '$estado', '$descripcion', NOW())";

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
    <title>Agregar Laptop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Estilos para los botones */
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
<body class="container mt-4">

    <h2 class="mb-4 text-center">Agregar Nueva Laptop</h2>

    <div class="card p-4">
        <form method="post" action="">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="codigo" class="form-label">Código:</label>
                    <input type="text" class="form-control" name="codigo" required>
                </div>
                <div class="col-md-6">
                    <label for="marca" class="form-label">Marca:</label>
                    <input type="text" class="form-control" name="marca" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="modelo" class="form-label">Modelo:</label>
                    <input type="text" class="form-control" name="modelo" required>
                </div>
                <div class="col-md-6">
                    <label for="procesador" class="form-label">Procesador:</label>
                    <input type="text" class="form-control" name="procesador" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ram" class="form-label">Memoria RAM (GB):</label>
                    <input type="number" class="form-control" name="ram" required>
                </div>
                <div class="col-md-6">
                    <label for="almacenamiento" class="form-label">Almacenamiento (GB):</label>
                    <input type="number" class="form-control" name="almacenamiento" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select class="form-select" name="estado" required>
                    <option value="Disponible">Disponible</option>
                    <option value="No Disponible">No Disponible</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" name="descripcion" rows="3"></textarea>
            </div>

            <!-- Botones centrados con ancho moderado -->
            <div class="d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-success btn-custom">Agregar Laptop</button>
                <a href="index.php" class="btn btn-secondary btn-custom">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
