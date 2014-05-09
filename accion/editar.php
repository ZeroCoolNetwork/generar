<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../librerias/config.php';
include '../librerias/class_mysql.php';
$accion = new MySql();
if (isset($_POST['database'])){
    $tabla = $_POST['table'];
    $database = $_POST['database'];
    $id = $_POST['id'];
   echo $accion->Editar($tabla, $id, $database);
}