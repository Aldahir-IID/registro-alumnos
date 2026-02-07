<?php
session_start();
require_once '../../config/db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../index.php");
    exit;
}

$sql = "SELECT * FROM students WHERE estatus = 'Activo'";

if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
    $busqueda = $conn->real_escape_string($_GET['busqueda']);
    $sql .= " AND (nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%' OR matricula LIKE '%$busqueda%')";
}
if (isset($_GET['filtro_carrera']) && !empty($_GET['filtro_carrera'])) {
    $carrera = $conn->real_escape_string($_GET['filtro_carrera']);
    $sql .= " AND carrera = '$carrera'";
}
if (isset($_GET['filtro_cuatri']) && !empty($_GET['filtro_cuatri'])) {
    $cuatri = $conn->real_escape_string($_GET['filtro_cuatri']);
    $sql .= " AND cuatrimestre = '$cuatri'";
}

$sql .= " ORDER BY apellidos ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../../static/css/style.css">

    <style>
        body {
            background-color: var(--color-bg) !important; 
            padding: 40px;
        }
        .header-report {
            border-bottom: 3px solid var(--color-accent); 
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="container mt-4">
    
    <div class="text-end mb-4 no-print">
        <button onclick="window.print()" class="btn btn-primary">Imprimir / Guardar como PDF</button>
        <button onclick="window.close()" class="btn btn-secondary">Cerrar</button>
    </div>

    <div class="header-report">
        <div>
            <h2 class="fw-bold">Universidad Politécnica del Estado de Morelos</h2>
            <h5>Departamento de Servicios Escolares</h5>
        </div>
        <div class="text-end">
            <small>Fecha de Emisión:</small><br>
            <strong><?= date('d/m/Y') ?></strong>
        </div>
    </div>

    <h4 class="text-center mb-4">Reporte de Alumnos Activos</h4>

    <div class="mb-3">
        <?php if(isset($_GET['filtro_carrera']) && !empty($_GET['filtro_carrera'])): ?>
            <span class="badge bg-light text-dark border">Carrera: <?= $_GET['filtro_carrera'] ?></span>
        <?php endif; ?>
        <?php if(isset($_GET['filtro_cuatri']) && !empty($_GET['filtro_cuatri'])): ?>
            <span class="badge bg-light text-dark border">Cuatrimestre: <?= $_GET['filtro_cuatri'] ?>°</span>
        <?php endif; ?>
    </div>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th style="width: 10%;">Matrícula</th>
                <th style="width: 10%;">Foto</th>
                <th style="width: 30%;">Nombre Completo</th>
                <th style="width: 30%;">Carrera</th>
                <th style="width: 10%;">Cuatri</th>
                <th style="width: 10%;">NSS</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="align-middle"><?= $row['matricula'] ?></td>
                        <td class="text-center align-middle">
                            <img src="../../img/<?= $row['foto_perfil'] ?>" width="40" height="40" style="object-fit: cover; border-radius: 50%;">
                        </td>
                        <td class="align-middle"><?= strtoupper($row['apellidos'] . " " . $row['nombre']) ?></td>
                        <td class="align-middle small"><?= $row['carrera'] ?></td>
                        <td class="text-center align-middle"><?= $row['cuatrimestre'] ?></td>
                        <td class="align-middle small"><?= $row['numero_seguro_social'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">No hay datos para mostrar.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-5 pt-5 text-center">
        <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto;"></div>
        <small>Firma del Responsable</small>
    </div>

</div>

</body>
</html>