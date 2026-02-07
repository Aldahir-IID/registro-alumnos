<?php
session_start();
require_once '../../config/db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM students WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tel = $_POST['telefono_personal'];
    $contacto = $_POST['contacto_emergencia'];
    $tel_eme = $_POST['telefono_emergencia'];
    $alergias = $_POST['alergias'];
    
    $update = $conn->prepare("UPDATE students SET telefono_personal=?, contacto_emergencia=?, telefono_emergencia=?, alergias=? WHERE user_id=?");
    $update->bind_param("ssssi", $tel, $contacto, $tel_eme, $alergias, $user_id);
    
    if ($update->execute()) {
        header("Location: my_profile.php?msg=updated");
        exit;
    } else {
        $error = "Error al actualizar.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Mis Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../static/css/style.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h4 class="mb-0 text-center">Actualizar Datos de Contacto</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="alert alert-info">
                            <small>Nota: Para cambios de Nombre, Matrícula o Carrera, debes acudir con el administrador.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mi Teléfono Personal</label>
                            <input type="text" name="telefono_personal" class="form-control" value="<?= $student['telefono_personal'] ?>" required>
                        </div>

                        <hr>
                        <h5>En caso de Emergencia</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre del Contacto</label>
                                <input type="text" name="contacto_emergencia" class="form-control" value="<?= $student['contacto_emergencia'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono del Contacto</label>
                                <input type="text" name="telefono_emergencia" class="form-control" value="<?= $student['telefono_emergencia'] ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Alergias / Condiciones Médicas</label>
                            <textarea name="alergias" class="form-control" rows="3"><?= $student['alergias'] ?></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            <a href="my_profile.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>