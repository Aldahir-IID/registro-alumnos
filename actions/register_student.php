<?php
require_once '../config/db_connect.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibir y limpiar datos
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    
    $matricula = trim($_POST['matricula']);
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    
    $curp = strtoupper(trim($_POST['curp']));
    $fecha_nac = $_POST['fecha_nacimiento'];
    $direccion = trim($_POST['direccion']); 

    $carrera = $_POST['carrera'];

    $cuatrimestre = $_POST['cuatrimestre'];
    $telefono_p = $_POST['telefono_personal'];
    $tipo_sangre = $_POST['tipo_sangre'];
    $seguro = $_POST['seguro_medico'];
    $nss = isset($_POST['nss']) ? $_POST['nss'] : '';
    $contacto_eme = $_POST['contacto_emergencia'];
    $telefono_eme = $_POST['telefono_emergencia'];
    $alergias = $_POST['alergias'];

    // Manejo de la FOTO
    $directorio_destino = "../img/";
    if (!is_dir($directorio_destino)) {
        mkdir($directorio_destino, 0777, true);
    }
    
    $nombre_archivo = "default.png"; 
    if (isset($_FILES["foto_perfil"]) && $_FILES["foto_perfil"]["error"] == 0) {
        $ext = pathinfo($_FILES["foto_perfil"]["name"], PATHINFO_EXTENSION);
        $nombre_archivo = time() . "_" . $matricula . "." . $ext;
        move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $directorio_destino . $nombre_archivo);
    }

    // Inserción en Base de Datos
    $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if($check->num_rows > 0) {
        header("Location: ../pages/register.php?error=El correo ya está registrado");
        exit;
    }

    $conn->begin_transaction();

    try {
        // A) Insertar en users
        $stmt1 = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'student')");
        $stmt1->bind_param("ss", $email, $password);
        $stmt1->execute();
        $user_id = $conn->insert_id;

        // B) Insertar en students
        // ORDEN EXACTO DE COLUMNAS:
        // 1.user_id, 2.matricula, 3.nombre, 4.apellidos, 5.curp, 6.fecha_nacimiento, 
        // 7.direccion, 8.carrera, 9.cuatrimestre, 10.tipo_sangre, 11.telefono_personal, 
        // 12.telefono_emergencia, 13.contacto_emergencia, 14.seguro_medico, 
        // 15.numero_seguro_social, 16.alergias, 17.foto_perfil

        $query_student = "INSERT INTO students 
            (user_id, matricula, nombre, apellidos, curp, fecha_nacimiento, direccion, carrera, cuatrimestre, tipo_sangre, telefono_personal, telefono_emergencia, contacto_emergencia, seguro_medico, numero_seguro_social, alergias, foto_perfil) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt2 = $conn->prepare($query_student);
        
        // ORDEN EXACTO DE VARIABLES EN BIND_PARAM:
        // Tipos: i (int), s (string)...
        // Total variables: 17
        // String de tipos: isssssssissssssss
        
        $stmt2->bind_param("isssssssissssssss", 
            $user_id,       // 1. i
            $matricula,     // 2. s
            $nombre,        // 3. s
            $apellidos,     // 4. s
            $curp,          // 5. s
            $fecha_nac,     // 6. s
            $direccion,     // 7. s
            $carrera,       // 8. s (AQUÍ ESTABA EL POSIBLE ERROR)
            $cuatrimestre,  // 9. i
            $tipo_sangre,   // 10. s
            $telefono_p,    // 11. s
            $telefono_eme,  // 12. s
            $contacto_eme,  // 13. s
            $seguro,        // 14. s
            $nss,           // 15. s
            $alergias,      // 16. s
            $nombre_archivo // 17. s
        );
        
        $stmt2->execute();

        $conn->commit();
        
        echo "<script>
                alert('¡Registro exitoso! Ahora puedes iniciar sesión.');
                window.location.href='../index.php';
              </script>";

    } catch (Exception $e) {
        $conn->rollback();
        // Esto te ayudará a ver el error exacto si vuelve a fallar
        die("Error en el registro: " . $e->getMessage()); 
    }
}
?>