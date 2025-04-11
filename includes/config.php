<?php
$host = 'localhost';
$dbname = 'inventario_laptops';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Error de Conexión: ' . $conn->connect_error);
}
?>
