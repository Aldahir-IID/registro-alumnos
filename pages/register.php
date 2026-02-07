<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Nuevo Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../static/css/style.css">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Registro de Nuevo Ingreso</h4>
                </div>
                <div class="card-body p-4">
                    
                    <?php if(isset($_GET['error'])): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                    <?php endif; ?>

                    <form action="../actions/register_student.php" method="POST" enctype="multipart/form-data" id="registroForm">
                        
                        <h5 class="mb-3 text-muted">Datos Académicos y de Cuenta</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Matrícula</label>
                                <input type="text" name="matricula" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Carrera</label>
                                <select name="carrera" class="form-select" required>
                                    <option value="">Selecciona...</option>
                                    <option value="Ingeniería en Biotecnología">Ing. Biotecnología</option>
                                    <option value="Ingeniería Ambiental">Ing. Ambiental y Sustentabilidad</option>
                                    <option value="Ingeniería Industrial">Ing. Industrial</option>
                                    <option value="Ingeniería en Tecnologías de la Información e Innovación Digital">Ing. en Tecnologías de la Información e Innovación Digital</option>                                    
                                    <option value="Ingeniería en Sistemas Electrónicos">Ing. Sistemas Electrónicos</option>
                                    <option value="Ingeniería Financiera">Ing. Financiera</option>
                                    <option value="Licenciatura en Administración">Lic. Administración</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cuatrimestre</label>
                                <select name="cuatrimestre" class="form-select" required>
                                    <?php for($i=1; $i<=10; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?>° Cuatrimestre</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Correo Institucional</label>
                                <input type="email" name="email" class="form-control" placeholder="@upemor.edu.mx" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contraseña</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3 text-muted">Información Personal</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre(s)</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">CURP</label>
                                <input type="text" name="curp" class="form-control" required style="text-transform: uppercase;" placeholder="18 caracteres" maxlength="18">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Dirección Completa</label>
                                <textarea name="direccion" class="form-control" rows="2" required placeholder="Calle, Número, Colonia, CP..."></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Teléfono Personal</label>
                                <input type="tel" name="telefono_personal" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tipo de Sangre</label>
                                <select name="tipo_sangre" class="form-select">
                                    <option value="O+">O+</option> <option value="O-">O-</option>
                                    <option value="A+">A+</option> <option value="A-">A-</option>
                                    <option value="B+">B+</option> <option value="B-">B-</option>
                                    <option value="AB+">AB+</option> <option value="AB-">AB-</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Seguro Médico (Institución)</label>
                                <input type="text" name="seguro_medico" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Número de Seguro (NSS)</label>
                                <input type="text" name="nss" class="form-control" placeholder="Opcional">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Foto de Perfil</label>
                                <input type="file" name="foto_perfil" class="form-control" accept="image/*" required>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3 text-muted">En caso de Emergencia</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Contacto de Emergencia (Nombre)</label>
                                <input type="text" name="contacto_emergencia" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono de Emergencia</label>
                                <input type="tel" name="telefono_emergencia" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alergias o Padecimientos</label>
                            <textarea name="alergias" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Completar Registro</button>
                            <a href="../index.php" class="btn btn-link text-center">Ya tengo cuenta, volver al login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../static/js/validations.js"></script>
</body>
</html>