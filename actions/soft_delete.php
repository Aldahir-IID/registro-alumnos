<?php
// actions/soft_delete.php
session_start();
require_once '../config/db_connect.php';

// Verificar si es admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $conn->prepare("UPDATE students SET estatus = 'Baja' WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: ../pages/admin/dashboard.php?msg=deleted");
    } else {
        header("Location: ../pages/admin/dashboard.php?error=Error al eliminar");
    }
}
?>