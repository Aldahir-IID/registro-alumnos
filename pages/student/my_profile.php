<?php
// pages/student/my_profile.php
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
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo "Error: No se encontró tu perfil.";
    exit;
}

if ($student['estatus'] === 'Baja') {
    echo "<div class='alert alert-danger m-5'>Tu estatus actual es BAJA.</div>";
    echo "<a href='../../logout.php'>Cerrar Sesión</a>";
    exit;
}

$fecha_nac = new DateTime($student['fecha_nacimiento']);
$hoy = new DateTime();
$edad = $hoy->diff($fecha_nac);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil de Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../static/css/style.css">
    <style>
        .profile-header {
            background-color: var(--color-primary);
            color: var(--color-white);
            padding: 30px 0;
            margin-bottom: 20px;
            border-bottom: 5px solid var(--color-accent);
        }
        .info-label {
            font-weight: bold;
            color: var(--color-primary);
            font-size: 0.9rem;
        }
        .info-data {
            color: #555;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">
        <span class="navbar-brand mb-0 h1 fw-bold">Portal del Alumno</span>
        <a href="../../logout.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="card shadow-lg overflow-hidden">
                
                <div class="profile-header text-center">
                    <img src="../../img/<?= $student['foto_perfil'] ?>" 
                         alt="Foto Perfil" 
                         class="rounded-circle border border-4 border-white shadow"
                         style="width: 150px; height: 150px; object-fit: cover;">
                    <h2 class="mt-3"><?= $student['nombre'] . " " . $student['apellidos'] ?></h2>
                    <p class="mb-0 text-white-50"><?= $student['matricula'] ?></p>
                    <span class="badge bg-warning text-dark mt-2"><?= $student['estatus'] ?></span>
                </div>

                <div class="card-body p-4">
                    
                    <h5 class="border-bottom pb-2 mb-4 text-muted">Información Académica</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-label">Carrera</div>
                            <div class="info-data"><?= $student['carrera'] ?></div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-label">Cuatrimestre</div>
                            <div class="info-data"><?= $student['cuatrimestre'] ?>°</div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-label">Ingreso</div>
                            <div class="info-data"><?= date('d/m/Y', strtotime($student['fecha_registro'])) ?></div>
                        </div>
                    </div>

                    <h5 class="border-bottom pb-2 mb-4 mt-4 text-muted">Datos Personales y Salud</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-label">CURP</div>
                            <div class="info-data text-uppercase"><?= $student['curp'] ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Fecha Nacimiento / Edad</div>
                            <div class="info-data">
                                <?= date('d/m/Y', strtotime($student['fecha_nacimiento'])) ?> 
                                <span class="badge bg-light text-dark border ms-2"><?= $edad->y ?> años</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="info-label">Dirección / Domicilio</div>
                            <div class="info-data border-bottom mb-3 pb-2">
                                <?= !empty($student['direccion']) ? $student['direccion'] : '<span class="text-muted fst-italic">Sin dirección registrada</span>' ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-label">Teléfono Personal</div>
                            <div class="info-data"><?= $student['telefono_personal'] ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Tipo de Sangre</div>
                            <div class="info-data text-danger fw-bold"><?= $student['tipo_sangre'] ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Seguro Médico (NSS)</div>
                            <div class="info-data">
                                <?= $student['seguro_medico'] ?> 
                                <br><small class="text-muted"><?= isset($student['numero_seguro_social']) ? $student['numero_seguro_social'] : '' ?></small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="info-label">Alergias / Padecimientos</div>
                            <div class="alert alert-light border">
                                <?= empty($student['alergias']) ? 'Ninguna registrada.' : $student['alergias'] ?>
                            </div>
                        </div>
                    </div>

                    <h5 class="border-bottom pb-2 mb-4 mt-4 text-muted">En caso de Emergencia</h5>
                    <div class="row bg-light p-3 rounded">
                        <div class="col-md-6">
                            <div class="info-label">Contactar a:</div>
                            <div class="info-data mb-0"><?= $student['contacto_emergencia'] ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Teléfono de Emergencia:</div>
                            <div class="info-data mb-0 fw-bold"><?= $student['telefono_emergencia'] ?></div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-5">
                        <button onclick="window.print()" class="btn btn-outline-secondary btn-lg">
                            Imprimir Ficha
                        </button>
                        <a href="update_info.php" class="btn btn-primary btn-lg">
                            Actualizar mis Datos de Contacto
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>