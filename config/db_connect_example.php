<?php
$servername = "localhost";
$username = "USUARIO_DB"; // Ejemplo: root
$password = "CONTRASEÑA_DB"; 
$dbname = "NOMBRE_DE_TU_BD";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Fallo en la conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>