<?php

use classes\ctrl_session\Ctrl_Sesion;
use classes\producto\Producto;
use classes\conexion\Conexion;
use classes\detalleventa\DetalleVenta;
//=========================================
include_once("classes/conexion.php");
include_once("classes/producto.php");
require_once("classes/detalleventa.php");
require_once("classes/array_list.php");
require_once("classes/ctrl_sesion.php");

Ctrl_Sesion::activar_sesion();
$objCarrito = $_SESSION["carrito"];
var_dump($objCarrito);
