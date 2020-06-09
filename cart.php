<?php
//seteamos la zona horaria por defecto para que al usar fechas el servidor use la hora de Bolivia
date_default_timezone_set("America/La_Paz");
//============uso de namespaces============
use classes\ctrl_session\Ctrl_Sesion;
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


// Ctrl_Sesion::verificar_inicio_sesion();
// $nombre_usuario = Ctrl_Sesion::get_nombre_usuario();
Ctrl_Sesion::activar_sesion();
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
  <footer class="footer_part">
    <div class="container">
      <div class="row justify-content-around">
        <div class="col-sm-6 col-lg-2">
          <div class="single_footer_part">
            <h4>Top Products</h4>
            <ul class="list-unstyled">
              <li><a href="">Managed Website</a></li>
              <li><a href="">Manage Reputation</a></li>
              <li><a href="">Power Tools</a></li>
              <li><a href="">Marketing Service</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-lg-2">
          <div class="single_footer_part">
            <h4>Quick Links</h4>
            <ul class="list-unstyled">
              <li><a href="">Jobs</a></li>
              <li><a href="">Brand Assets</a></li>
              <li><a href="">Investor Relations</a></li>
              <li><a href="">Terms of Service</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-lg-2">
          <div class="single_footer_part">
            <h4>Features</h4>
            <ul class="list-unstyled">
              <li><a href="">Jobs</a></li>
              <li><a href="">Brand Assets</a></li>
              <li><a href="">Investor Relations</a></li>
              <li><a href="">Terms of Service</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-lg-2">
          <div class="single_footer_part">
            <h4>Resources</h4>
            <ul class="list-unstyled">
              <li><a href="">Guides</a></li>
              <li><a href="">Research</a></li>
              <li><a href="">Experts</a></li>
              <li><a href="">Agencies</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4">
          <div class="single_footer_part">
            <h4>Newsletter</h4>
            <p>Heaven fruitful doesn't over lesser in days. Appear creeping
            </p>
            <div id="mc_embed_signup">
              <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe_form relative mail_part">
                <input type="email" name="email" id="newsletter-form-email" placeholder="Email Address" class="placeholder hide-on-focus" onfocus="this.placeholder = ''" onblur="this.placeholder = ' Email Address '">
                <button type="submit" name="submit" id="newsletter-submit" class="email_icon newsletter-submit button-contactForm">subscribe</button>
                <div class="mt-10 info"></div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="copyright_part">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="copyright_text">
              <P>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>
                  document.write(new Date().getFullYear());
                </script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              </P>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="footer_icon social_icon">
              <ul class="list-unstyled">
                <li><a href="#" class="single_social_icon"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#" class="single_social_icon"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#" class="single_social_icon"><i class="fas fa-globe"></i></a></li>
                <li><a href="#" class="single_social_icon"><i class="fab fa-behance"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--::footer_part end::-->

  <!-- jquery plugins here-->
  <!-- jquery -->
  <script src="js/jquery-1.12.1.min.js"></script>
  <!-- popper js -->
  <script src="js/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.min.js"></script>
  <!-- easing js -->
  <script src="js/jquery.magnific-popup.js"></script>
  <!-- swiper js -->
  <script src="js/swiper.min.js"></script>
  <!-- swiper js -->
  <script src="js/masonry.pkgd.js"></script>
  <!-- particles js -->
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <!-- slick js -->
  <script src="js/slick.min.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/contact.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.form.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/stellar.js"></script>
  <script src="js/price_rangs.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
</body>

</html>