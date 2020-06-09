<?php
date_default_timezone_set("America/La_Paz");
//============uso de namespaces============
use classes\ctrl_session\Ctrl_Sesion;
use classes\producto\Producto;
use classes\conexion\Conexion;
use classes\detalleventa\DetalleVenta;
use classes\venta\Venta;
use classes\ctrl_venta\Ctrl_Venta;
//=========================================
require_once("../classes/ctrl_sesion.php");
require_once("../classes/producto.php");
require_once("../classes/conexion.php");
require_once("../classes/detalleventa.php");
require_once("../classes/array_list.php");
require_once("../classes/venta.php");
require_once("../classes/ctrl_venta.php");

Ctrl_Sesion::activar_sesion();
//Ctrl_Sesion::verificar_inicio_sesion();
//$nombre_usuario = Ctrl_Sesion::get_nombre_usuario();
$cnx = new Conexion();
$mensaje = "";
//=================Procesar Confirmar Venta
if (isset($_GET["op"], $_GET["pagoid"]) && $_GET["op"] == "pagoconfirmado" && isset($_SESSION["carrito"])) {
    $objCarrito = $_SESSION["carrito"];
    if ($objCarrito->Size() >= 1) {
        $objVenta = new Venta($cnx);
        //$objVenta->setCliente_id(Ctrl_Sesion::get_id_usuario());
        $objVenta->setCliente_id(1);
        $objVenta->setEstado("P");
        $fecha  = date("Y/m/d H:i:s");
        $objVenta->setFecha($fecha);
        echo '<hr>';
        echo '<hr>';
        $id_venta = Ctrl_Venta::guardar_venta($cnx, $objVenta, $objCarrito);
        if ($id_venta > 0) {
            unset($_SESSION["carrito"]);
            unset($_SESSION["paymentId"]);
            unset($_SESSION["PayerID"]);
            header("location:../index.php?msg=venta guardada  correctamente&idventa=$id_venta");
        } else {
            $mensaje = "Error al guardar los datos de la compra";
        }
    } else {
        $mensaje = "Carrito vacío";
    }
} else if (isset($_GET["op"]) && $_GET["op"] == "confirmar" && !isset($_SESSION["carrito"])) {
    header('location:../index.php?msg=Error al guardar la venta');
}
echo $mensaje;
