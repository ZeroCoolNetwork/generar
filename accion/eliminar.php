<?php
error_reporting(E_ALL ^ E_NOTICE);
include '../librerias/class_mysql.php';
include '../librerias/config.php';

$accion= new MySql();

if(isset($_GET['database'])){
    $tabla = $_GET['table'];
    $database = $_GET['database'];
    $id = $_GET['id'];
   echo  $accion->EliminarDatos($tabla, $id, $database);
   
}

