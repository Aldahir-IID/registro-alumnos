<?php
session_start();
require_once '../config/db_connect.php';

if ($_POST) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            redirectUser($user['role']);
        } 
        
        elseif ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            redirectUser($user['role']);
        } 
        else {
            header("Location: ../index.php?error=pass");
            exit;
        }
    } else {
        header("Location: ../index.php?error=user");
        exit;
    }
}

function redirectUser($role) {
    if ($role === 'admin') {
        header("Location: ../pages/admin/dashboard.php");
    } else {
        header("Location: ../pages/student/my_profile.php");
    }
    exit;
}
?>