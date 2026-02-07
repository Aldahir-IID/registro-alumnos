<?php
// pages/admin/edit_student.php
session_start();
require_once '../../config/db_connect.php';

// Verificar Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}

// Verificar que venga un ID
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    echo "Alumno no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../static/css/style.css">
</head>
<body>

<div class="container py-5">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white">Editar Información del Alumno</h4>
            <a href="dashboard.php" class="btn btn-sm btn-light text-dark">Volver</a>
        </div>
        <div class="card-body">
            
            <form action="../../actions/update_student.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $student['id'] ?>">
                <input type="hidden" name="foto_actual" value="<?= $student['foto_perfil'] ?>">

                <div class="row mb-3">
                    <div class="col-md-4 text-center">
                        <label class="form-label d-block fw-bold">Foto Actual</label>
                        <img src="../../img/<?= $student['foto_perfil'] ?>" class="img-thumbnail mb-2" style="height: 150px; object-fit: cover;">
                        <input type="file" name="foto_perfil" class="form-control form-control-sm">
                        <small class="text-muted">Sube una nueva foto solo si deseas cambiarla.</small>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Matrícula</label>
                                <input type="text" name="matricula" class="form-control" value="<?= $student['matricula'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Carrera</label>
                                <select name="carrera" class="form-select">
                                    <option value="<?= $student['carrera'] ?>" selected><?= $student['carrera'] ?> (Actual)</option>
                                    <option value="Ingeniería en Biotecnología">Ing. Biotecnología</option>
                                    <option value="Ingeniería Ambiental">Ing. Ambiental</option>
                                    <option value="Ingeniería Industrial">Ing. Industrial</option>
                                    <option value="Ingeniería en Tecnologías de la Información e Innovación Digital">Ing. en Tecnologías de la Información e Innovación Digital</option>
                                    <option value="Ingeniería en Sistemas Electrónicos">Ing. Sistemas Electrónicos</option>
                                    <option value="Ingeniería Financiera">Ing. Financiera</option>
                                    <option value="Licenciatura en Administración">Lic. Administración</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nombre(s)</label>
                                <input type="text" name="nombre" class="form-control" value="<?= $student['nombre'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control" value="<?= $student['apellidos'] ?>" required>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label">Cuatrimestre</label>
                                <select name="cuatrimestre" class="form-select">
                                    <?php for($i=1; $i<=10; $i++): ?>
                                        <option value="<?= $i ?>" <?= $student['cuatrimestre'] == $i ? 'selected' : '' ?>>
                                            <?= $i ?>° Cuatrimestre
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">CURP</label>
                        <input type="text" name="curp" class="form-control" value="<?= $student['curp'] ?>" style="text-transform: uppercase;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control" value="<?= $student['fecha_nacimiento'] ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Dirección / Domicilio</label>
                        <textarea name="direccion" class="form-control" rows="2"><?= $student['direccion'] ?></textarea>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Teléfono Personal</label>
                        <input type="text" name="telefono_personal" class="form-control" value="<?= $student['telefono_personal'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Seguro Médico</label>
                        <input type="text" name="seguro_medico" class="form-control" value="<?= $student['seguro_medico'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">NSS (Número Seguro)</label>
                        <input type="text" name="nss" class="form-control" value="<?= isset($student['numero_seguro_social']) ? $student['numero_seguro_social'] : '' ?>">
                    </div>
                </div>
                
                <div class="row mb-3">
                     <div class="col-md-4">
                        <label class="form-label">Tipo Sangre</label>
                        <input type="text" name="tipo_sangre" class="form-control" value="<?= $student['tipo_sangre'] ?>">
                    </div>
                     <div class="col-md-4">
                        <label class="form-label">Contacto Emergencia</label>
                        <input type="text" name="contacto_emergencia" class="form-control" value="<?= $student['contacto_emergencia'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Teléfono Emergencia</label>
                        <input type="text" name="telefono_emergencia" class="form-control" value="<?= $student['telefono_emergencia'] ?>">
                    </div>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>