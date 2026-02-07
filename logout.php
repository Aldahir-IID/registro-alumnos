<?php
// logout.php
session_start();
session_unset();
session_destroy();

// Redirigir al login
header("Location: index.php");
exit;
?>