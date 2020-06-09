<?php
require_once("classes/conexion.php");
require_once("classes/cliente.php");
//conexoin
$cnx = new Conexion();

$ci = $_POST["clientCi"];
$nombre = $_POST["clientName"];
$direccion = $_POST["clientAddress"];
$telefono = $_POST["clientPhone"];
$email = $_POST["clientEmail"];
$cliente = new Cliente($cnx);
//$cliente->inicializar(0, $ci, $nombre, $direccion, $telefono, $email);
if ($cliente->guardar())
   echo "guardo correctamente";
else
   echo "error al guardar";
