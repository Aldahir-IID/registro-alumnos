<?php
session_start();
require_once '../config/db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT foto_perfil FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $foto = $row['foto_perfil'];
        $ruta_foto = "../img/" . $foto;
        
        if ($foto != 'default.png' && file_exists($ruta_foto)) {
            unlink($ruta_foto); // Esta función borra el archivo
        }
    }

    
    $stmt_user = $conn->prepare("SELECT user_id FROM students WHERE id = ?");
    $stmt_user->bind_param("i", $id);
    $stmt_user->execute();
    $res_user = $stmt_user->get_result();
    $user_row = $res_user->fetch_assoc();
    
    $delete_student = $conn->prepare("DELETE FROM students WHERE id = ?");
    $delete_student->bind_param("i", $id);
    $delete_student->execute();

    if($user_row){
        $delete_user = $conn->prepare("DELETE FROM users WHERE id = ?");
        $delete_user->bind_param("i", $user_row['user_id']);
        $delete_user->execute();
    }

    header("Location: ../pages/admin/history.php?msg=deleted_forever");
}
?>