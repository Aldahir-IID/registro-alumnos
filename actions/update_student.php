<?php
// actions/update_student.php
require_once '../config/db_connect.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibir datos
    $id = $_POST['id'];
    $matricula = trim($_POST['matricula']);
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    
    $curp = isset($_POST['curp']) ? strtoupper(trim($_POST['curp'])) : '';
    $fecha_nac = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : NULL;
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';

    $cuatrimestre = $_POST['cuatrimestre'];
    $carrera = $_POST['carrera'];
    $telefono_p = $_POST['telefono_personal'];
    $seguro = $_POST['seguro_medico'];
    $nss = isset($_POST['nss']) ? $_POST['nss'] : ''; 
    $tipo_sangre = $_POST['tipo_sangre'];
    $contacto_eme = $_POST['contacto_emergencia'];
    $telefono_eme = $_POST['telefono_emergencia'];
    
    // Lógica de la FOTO
    $nombre_foto = $_POST['foto_actual'];

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
        $foto_anterior = $_POST['foto_actual'];
        $ruta_anterior = "../img/" . $foto_anterior;
        if ($foto_anterior != 'default.png' && file_exists($ruta_anterior)) {
            unlink($ruta_anterior);
        }

        $directorio = "../img/";
        if (!is_dir($directorio)) mkdir($directorio, 0777, true);
        
        $ext = pathinfo($_FILES["foto_perfil"]["name"], PATHINFO_EXTENSION);
        $nombre_foto = time() . "_" . $matricula . "." . $ext;
        move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $directorio . $nombre_foto);
    }

    $sql = "UPDATE students SET 
            matricula=?, nombre=?, apellidos=?, curp=?, fecha_nacimiento=?, direccion=?, 
            cuatrimestre=?, carrera=?, telefono_personal=?, seguro_medico=?, 
            numero_seguro_social=?, tipo_sangre=?, contacto_emergencia=?, 
            telefono_emergencia=?, foto_perfil=? 
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    
    
    $stmt->bind_param("ssssssissssssssi", 
        $matricula, $nombre, $apellidos, $curp, $fecha_nac, $direccion,
        $cuatrimestre, $carrera, $telefono_p, $seguro, 
        $nss, $tipo_sangre, $contacto_eme, $telefono_eme, $nombre_foto, 
        $id
    );

    if ($stmt->execute()) {
        header("Location: ../pages/admin/dashboard.php?msg=updated");
        exit;
    } else {
        echo "<h1>Error al guardar:</h1>";
        echo $conn->error;
        echo "<br><br>Query: " . $sql;
    }
} else {
    header("Location: ../pages/admin/dashboard.php");
    exit;
}
?>