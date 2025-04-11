<?php
require('../includes/config.php');
require('../includes/header_p.php');

// Consulta los datos de los préstamos
$query = "SELECT * FROM prestamos";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Préstamos</title>
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
<body class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <a href="../dashboard.php" class="btn btn-secondary">🏠 Inicio</a>
        <div>
            <a href="generar_pdf.php" class="btn btn-success">📄 Generar Reporte</a>
            <a href="create.php" class="btn btn-primary">➕ Agregar Nuevo Préstamo</a>
        </div>
    </div>
    
    <!-- Tabla de préstamos con animación -->
    <div class="table-responsive animated-table">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>ID Laptop</th>
                    <th>ID Usuario</th>
                    <th>Prestado a</th>
                    <th>Fecha Préstamo</th>
                    <th>Devuelto</th>
                    <th>Fecha Devolución</th>
                    <th>Entregado por</th>
                    <th>Devuelto por</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo isset($row['id']) ? $row['id'] : 'N/A'; ?></td>
                    <td><?php echo isset($row['laptop_id']) ? $row['laptop_id'] : 'N/A'; ?></td>
                    <td><?php echo isset($row['usuario_id']) ? $row['usuario_id'] : 'N/A'; ?></td>
                    <td><?php echo isset($row['prestado_a']) ? $row['prestado_a'] : 'N/A'; ?></td>
                    <td><?php echo isset($row['fecha_prestamo']) ? date('d/m/Y H:i', strtotime($row['fecha_prestamo'])) : 'N/A'; ?></td>
                    <td>
                        <span class="badge <?php echo (isset($row['devuelto']) && $row['devuelto'] == 1) ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo (isset($row['devuelto']) && $row['devuelto'] == 1) ? 'Sí' : 'No'; ?>
                        </span>
                    </td>
                    <td><?php echo !empty($row['fecha_devolucion']) ? date('d/m/Y H:i', strtotime($row['fecha_devolucion'])) : 'Pendiente'; ?></td>
                    <td><?php echo isset($row['entregado_por']) ? $row['entregado_por'] : 'No registrado'; ?></td>
                    <td><?php echo isset($row['devuelto_por']) ? $row['devuelto_por'] : 'No registrado'; ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                        <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?php echo $row['id']; ?>)">🗑️ Eliminar</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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
