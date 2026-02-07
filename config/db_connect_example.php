<?php

$servername = "localhost";
$username = "root";      
$password = "";          
$dbname = "registro_db_n";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Fallo en la conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>