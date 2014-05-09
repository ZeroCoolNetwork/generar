<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../librerias/class_mysql.php';
include '../librerias/config.php';
$guardar = new MySql();
if (isset($_POST['database'])) {
    $tabla = $_POST['table'];
    $database = $_POST['database'];
    echo $guardar->GuardarForm($tabla, $database);
    
}
?>
