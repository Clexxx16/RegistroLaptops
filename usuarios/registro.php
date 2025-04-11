<?php
require '../includes/config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    if (empty($nombre) || empty($correo) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $verificar_sql = "SELECT id FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($verificar_sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $error = "El correo ya está registrado.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nombre, correo, contraseña) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nombre, $correo, $password_hash);

            if ($stmt->execute()) {
                header("Location: ../login.php");
                exit();
            } else {
                $error = "Error al registrar usuario: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="text-center text-success mb-4">Registro de Usuario</h2>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" onsubmit="return validarFormulario()">
                            <div class="mb-3">
                                <label class="form-label">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Correo:</label>
                                <input type="email" class="form-control" name="correo" id="correo" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Registrar</button>
                        </form>

                        <p class="text-center mt-3">
                            ¿Ya tienes cuenta? <a href="../login.php">Inicia sesión aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validarFormulario() {
            let nombre = document.getElementById("nombre").value.trim();
            let correo = document.getElementById("correo").value.trim();
            let password = document.getElementById("password").value.trim();

            if (nombre === "" || correo === "" || password === "") {
                alert("Todos los campos son obligatorios.");
                return false;
            }

            if (password.length < 6) {
                alert("La contraseña debe tener al menos 6 caracteres.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
