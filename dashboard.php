<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Efecto al pasar el cursor */
        .btn {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Efecto al hacer clic */
        .btn:active {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-body text-center">
                        <h2 class="text-primary mt-3">Bienvenido, <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?>!</h2>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <a href="laptops/index.php" class="btn btn-info w-100 mb-2">📌 Gestionar Laptops</a>
                            </div>
                            <div class="col-md-6">
                                <a href="prestamos/index.php" class="btn btn-success w-100 mb-2">📋 Gestionar Préstamos</a>
                            </div>
                        </div>

                        <a href="logout.php" class="btn btn-secondary mt-3">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
