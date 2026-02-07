<?php
session_start();
require_once '../../config/db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}

if (isset($_GET['restore_id'])) {
    $restore_id = $_GET['restore_id'];
    $conn->query("UPDATE students SET estatus = 'Activo' WHERE id = $restore_id");
    header("Location: history.php?msg=restored");
    exit;
}

$sql = "SELECT * FROM students WHERE estatus = 'Baja' ORDER BY fecha_registro DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Bajas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php">Admin Panel</a>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver al Dashboard
        </a>
    </div>
</nav>

<div class="container">
    
    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted_forever'): ?>
        <div class="alert alert-dark text-center">
            <i class="fas fa-check-circle"></i> Alumno y sus archivos eliminados permanentemente.
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-history"></i> Historial de Alumnos dados de Baja</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: var(--color-accent); color: white;">
                        <tr>
                            <th>Matrícula</th>
                            <th>Nombre</th>
                            <th>Carrera</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="align-middle fw-bold"><?= $row['matricula'] ?></td>
                                    <td class="align-middle"><?= $row['nombre'] . " " . $row['apellidos'] ?></td>
                                    <td class="align-middle"><?= $row['carrera'] ?></td>
                                    <td class="align-middle">
                                        
                                        <a href="history.php?restore_id=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-success me-2"
                                           title="Reactivar Alumno">
                                            <i class="fas fa-undo"></i> Reactivar
                                        </a>

                                        <a href="../../actions/hard_delete.php?id=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-dark" 
                                           style="background-color: #000; border-color: #000;"
                                           onclick="return confirm('ADVERTENCIA DE SEGURIDAD\n\n¿Estás seguro de eliminar PERMANENTEMENTE a este alumno?\n\n- Se borrará de la base de datos.\n- Se borrará su foto del servidor.\n- NO SE PUEDE RECUPERAR.');"
                                           title="Eliminar Definitivamente">
                                            <i class="fas fa-times-circle"></i> Borrar Todo
                                        </a>

                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">No hay alumnos en el historial de bajas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>