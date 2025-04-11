<?php
require('../includes/config.php');
require('../includes/header.php'); // Incluye el encabezado

$query = "SELECT * FROM laptops";
$result = $conn->query($query);

// Verifica si la consulta fue exitosa
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Laptops</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .animated-table {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Animación en botones */
        .btn {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
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
<body>

    <div class="container mt-4">
        <!-- Botones de acciones -->
        <div class="d-flex justify-content-between mb-3">
            <a href="../dashboard.php" class="btn btn-secondary">🏠 Inicio</a>
            <div>
                <a href="./generar_pdf.php" class="btn btn-success">📄 Generar Reporte</a>
                <a href="create.php" class="btn btn-primary">➕ Agregar Nueva Laptop</a>
            </div>
        </div>

        <!-- Tabla de Laptops con animación -->
        <div class="table-responsive animated-table">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Procesador</th>
                        <th>RAM</th>
                        <th>Almacenamiento</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                        <th>Creado en</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['codigo']; ?></td>
                        <td><?php echo $row['marca']; ?></td>
                        <td><?php echo $row['modelo']; ?></td>
                        <td><?php echo $row['procesador']; ?></td>
                        <td><?php echo $row['ram']; ?> GB</td>
                        <td><?php echo $row['almacenamiento']; ?> GB</td>
                        <td>
                            <span class="badge <?php echo (strtolower($row['estado']) == 'disponible') ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo (!empty($row['estado']) && strtolower($row['estado']) == 'disponible') ? 'Disponible' : 'No disponible'; ?>
                            </span>
                        </td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['creado_en'])); ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                            <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?php echo $row['id']; ?>)">🗑️ Eliminar</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function confirmarEliminacion(id) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete.php?id=" + id;
            }
        });
    }
    </script>

</body>
</html>
