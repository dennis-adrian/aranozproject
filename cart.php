<?php
//seteamos la zona horaria por defecto para que al usar fechas el servidor use la hora de Bolivia
date_default_timezone_set("America/La_Paz");
//============uso de namespaces============
use classes\ctrl_sesion\Ctrl_Sesion;
use classes\producto\Producto;
use classes\conexion\Conexion;
use classes\detalleventa\DetalleVenta;
use classes\venta\Venta;
use classes\ctrl_venta\Ctrl_Venta;
use paypal\pago\Pay;

//=========================================
include_once 'classes/array_list.php';
include_once 'classes/ctrl_sesion.php';
include_once 'classes/conexion.php';
include_once 'classes/venta.php';
include_once 'classes/ctrl_venta.php';
include_once 'classes/detalleventa.php';
include_once 'classes/producto.php';


Ctrl_Sesion::verificar_inicio_sesion();
$nombre_usuario = Ctrl_Sesion::get_nombre_usuario();
//Ctrl_Sesion::activar_sesion();
$cnx = new Conexion();
$mensaje = "";

if (!isset($_GET["op"])) {
  header("location:index.php?msg=operacion incorrecta");
  die();
}
//=================Procesar Confirmar Venta
if ($_GET["op"] == "confirmar" && isset($_SESSION["carrito"])) {
  header('location:paypal/checkout.php?op=confirmar');
} else if (isset($_GET["op"]) && $_GET["op"] == "comprar" && !isset($_SESSION["carrito"])) {
  $mensaje = "El carrito está vacío, debe agregar productos al carrito";
}
if (isset($_SESSION["objVenta"]) && $_GET["op"] == "pagoconfirmado") {
  $objVenta = $_SESSION["objVenta"];
  $objCarrito = $_SESSION["carrito"];
  var_dump($objVenta);
  $id_venta = Ctrl_Venta::guardar_venta($cnx, $objVenta, $objCarrito);
  if ($id_venta > 0) {
    unset($_SESSION["carrito"]);
    unset($_SESSION["ojbVenta"]);
    unset($_SESSION["pago"]);
    header("location:index.php?msg=venta guardada correctamente, nro $id_venta");
  } else {
    $mensaje = "Error al guardar los datos de la compra";
  }
}
//=================Procesando Quitar del Carrito 
if (isset($_GET["key"])) {
  $key = $_GET["key"];
  $objCarrito = $_SESSION["carrito"];
  $objCarrito->remove($key);
  $_SESSION["carrito"] = $objCarrito;
}
?>
<!doctype html>
<html lang="zxx">

<head>
  <?php include 'head.php'; ?>
</head>

<body>
  <!--::header part start::-->
  <?php include 'header.php' ?>
  <!-- Header part end-->


  <!--================Home Banner Area =================-->
  <!-- breadcrumb start-->
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Cart Products</h2>
              <p>Home <span>-</span>Cart Products</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->

  <!--================Cart Area =================-->
  <section class="cart_area padding_top">
    <div class="container">
      <div class="cart_inner">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>

              <?php
              //aqui mostrar el carrito
              $nro = 1;
              $total = 0;
              $producto = new Producto($cnx);
              //iteramos sobre el carrito si es que el carrito tiene información
              if (isset($_SESSION["carrito"])) {
                $objCarrito = $_SESSION["carrito"];
                foreach ($objCarrito->list as $key => $registro) {
                  $id = $registro->getProducto_id();
                  $imagen = $producto->mostrar_imagen_id($id);
                  $nombre = $registro->getNombre();
                  $precio = $registro->getPrecio();
                  $cantidad = $registro->getCantidad();
                  $subtotal = $cantidad * $precio;
                  $total = $total + $subtotal;
                  $linkeliminar = "
                  <div class='product_count'>
                    <form action='cart.php' method='post'>
                      <input type='text' value='$cantidad'>
                      <a
                        class='btn_1' 
                        href='cart.php?key=$key&op=eliminar'>
                          <img id='img-trashbin' src='img/trash.png'>
                      </a>
                    </form>
                  </div>
                ";

                  echo "
                  <tr>
                    <td>
                      <div class='media'>
                        <div class='d-flex' style='width: 256px;'>
                          <img src='$imagen' alt=''/>
                        </div>
                        <div class='media-body'>
                          <p>$nombre</p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <h5>$$precio</h5>
                    </td>
                    <td>
                      $linkeliminar
                    </td>
                    <td>
                      <h5>$$subtotal</h5>
                    </td>
                  </tr>
                ";
                  $nro++;
                }
              }
              ?>
              <tr>
                <td></td>
                <td></td>
                <td>
                  <h5>Total</h5>
                </td>
                <td>
                  <h5>$<?php echo $total; ?></h5>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="checkout_btn_inner float-right">
            <a class="btn_1" href="category.php">Continue Shopping</a>
            <a class="btn_1 checkout_btn_1" href="cart.php?op=confirmar">Pay with PayPal</a>
          </div>
        </div>
      </div>
  </section>

  <!--================End Cart Area =================-->

  <!--::footer_part start::-->
  <?php include_once 'footer.php'; ?>
  <!--::footer_part end::-->

  <?php include_once 'jsincludes.php'; ?>
</body>

</html>