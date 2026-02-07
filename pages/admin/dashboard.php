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

$sql .= " ORDER BY fecha_registro DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../static/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
        <div class="d-flex">
            <span class="navbar-text me-3">Bienvenido, Administrador</span>
            <a href="../../logout.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Alumnos</h2>
        <div>
            <a href="history.php" class="btn btn-secondary me-2">
                <i class="fas fa-history"></i> Historial / Bajas
            </a>
        </div>
    </div>

    <div class="card mb-4" style="border: 1px solid var(--color-accent);">
        <div class="card-header bg-white">
            <h5 class="mb-0" style="color: var(--color-primary);"><i class="fas fa-filter"></i> Buscar y Filtrar</h5>
        </div>
        <div class="card-body" style="background-color: var(--color-bg);">
            <form method="GET" action="dashboard.php" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="busqueda" class="form-control" 
                           placeholder="Nombre, Apellido o Matrícula..." 
                           value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>">
                </div>
                
                <div class="col-md-3">
                    <select name="filtro_carrera" class="form-select">
                        <option value="">Todas las Carreras</option>
                        <option value="Ingeniería en Biotecnología" <?= (isset($_GET['filtro_carrera']) && $_GET['filtro_carrera'] == 'Ingeniería en Biotecnología') ? 'selected' : '' ?>>Ing. Biotecnología</option>
                        <option value="Ingeniería Ambiental" <?= (isset($_GET['filtro_carrera']) && $_GET['filtro_carrera'] == 'Ingeniería Ambiental') ? 'selected' : '' ?>>Ing. Ambiental</option>
                        <option value="Ingeniería Industrial" <?= (isset($_GET['filtro_carrera']) && $_GET['filtro_carrera'] == 'Ingeniería Industrial') ? 'selected' : '' ?>>Ing. Industrial</option>
                        <option value="Ingeniería en Tecnologías de la Información e Innovación Digital" <?= (isset($_GET['filtro_carrera']) && $_GET['filtro_carrera'] == 'Ingeniería en Tecnologías de la Información e Innovación Digital') ? 'selected' : '' ?>>Ing. TIC e Innovación Digital</option>
                        <option value="Ingeniería en Sistemas Electrónicos" <?= (isset($_GET['filtro_carrera']) && $_GET['filtro_carrera'] == 'Ingeniería en Sistemas Electrónicos') ? 'selected' : '' ?>>Ing. Electrónica</option>
                        <option value="Ingeniería Financiera" <?= (isset($_GET['filtro_carrera']) && $_GET['filtro_carrera'] == 'Ingeniería Financiera') ? 'selected' : '' ?>>Ing. Financiera</option>
                        <option value="Licenciatura en Administración" <?= (isset($_GET['filtro_carrera']) && $_GET['filtro_carrera'] == 'Licenciatura en Administración') ? 'selected' : '' ?>>Lic. Administración</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="filtro_cuatri" class="form-select">
                        <option value="">Todos los Cuatrimestres</option>
                        <?php for($i=1; $i<=10; $i++): ?>
                            <option value="<?= $i ?>" <?= (isset($_GET['filtro_cuatri']) && $_GET['filtro_cuatri'] == $i) ? 'selected' : '' ?>>
                                <?= $i ?>° Cuatrimestre
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    <?php if(isset($_GET['busqueda']) || isset($_GET['filtro_carrera'])): ?>
                        <a href="dashboard.php" class="btn btn-outline-secondary" title="Limpiar filtros">X</a>
                    <?php endif; ?>
                </div>
            </form>

            <div class="row mt-3 border-top pt-3">
                <div class="col-12 text-end">
                    <a href="report_print.php?busqueda=<?= isset($_GET['busqueda'])?$_GET['busqueda']:'' ?>&filtro_carrera=<?= isset($_GET['filtro_carrera'])?$_GET['filtro_carrera']:'' ?>&filtro_cuatri=<?= isset($_GET['filtro_cuatri'])?$_GET['filtro_cuatri']:'' ?>" 
                       target="_blank" 
                       class="btn btn-dark">
                        <i class="fas fa-file-pdf"></i> Generar Reporte PDF / Imprimir
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-5">
        <div class="card-header">
            Resultados de Estudiantes Activos
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: var(--color-accent); color: white;">
                        <tr>
                            <th>Matrícula</th>
                            <th>Foto</th>
                            <th>Nombre Completo</th>
                            <th>Carrera</th>
                            <th>Cuatri</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="align-middle fw-bold"><?= $row['matricula'] ?></td>
                                    <td class="align-middle">
                                        <img src="../../img/<?= $row['foto_perfil'] ?>" alt="Foto" 
                                             class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    </td>
                                    <td class="align-middle">
                                        <?= $row['nombre'] . " " . $row['apellidos'] ?>
                                    </td>
                                    <td class="align-middle"><?= $row['carrera'] ?></td>
                                    <td class="align-middle text-center"><?= $row['cuatrimestre'] ?>°</td>
                                    <td class="align-middle">
                                        <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="../../actions/soft_delete.php?id=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('¿Estás seguro de dar de baja a este alumno?');" 
                                           title="Dar de Baja">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No se encontraron alumnos con esos criterios.
                                </td>
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