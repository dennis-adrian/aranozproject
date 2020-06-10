<?php

use classes\ctrl_sesion\ctrl_sesion;
use classes\producto\Producto;
use classes\conexion\Conexion;
use classes\detalleventa\DetalleVenta;
use classes\venta\Venta;
use classes\usuario\Usuario;

require_once("../classes/producto.php");
require_once("../classes/ctrl_sesion.php");
require_once("../classes/conexion.php");
require_once("../classes/array_list.php");
require_once("../classes/detalleventa.php");
require_once("../classes/venta.php");
require_once("../classes/usuario.php");



Ctrl_Sesion::verificar_inicio_sesion();

$cnx = new Conexion();
$mensaje = "";
//-*-------------------- PROGRAMANDO LA RECEPCION DEL PRODUCTO SELECCIONADO -----------
if (isset($_POST["btnAddCarrito"])) {
  $id_adicionar = $_POST["id-name"];
  $nombre_adicionar = $_POST["nombre-name"];
  $precio_adicionar = $_POST["precio-name"];
  $cantidadexistente_adicionar = $_POST["cantidad-name"];
  $cantidadadd_adicionar = $_POST["cantidadadd-name"];

  if (!isset($_SESSION["carrito"])) {
    $objCarrito = new ArrayList();
    $_SESSION["carrito"] = $objCarrito;
  }
  $objCarrito = $_SESSION["carrito"];

  $objDetalleProducto = new DetalleVenta($cnx);
  $objDetalleProducto->inicializar(0, $id_adicionar, 0, $cantidadadd_adicionar, $precio_adicionar, $nombre_adicionar);

  $objCarrito->Add($objDetalleProducto);
  $_SESSION["carrito"] = $objCarrito;
  $mensaje = "$nombre_adicionar adicionada correctamente ";
}
?>
<html lang="es">

<head>
  <?php include("incluir_estilos_encabezado.php"); ?>
  <title>Ventas</title>
</head>

<body>
  <?php include("incluir_menu_formularios.php"); ?>
  <div style="margin: 30px;">
    <h1>Listado Ventas</h1>
    <form class="form-inline my-2 my-lg-0" method="POST" action="frmventas.php">
      <input class="form-control mr-sm-2" type="search" name="txtCriterio" id="txtCriterio" placeholder="Id del usuario" aria-label="Buscar">
      <button class="btn btn-primary my-2 my-sm-0" type="submit" name="btnBuscar" id="btnBuscar">Buscar</button>
    </form>
    <?php
    $criterio = "";
    $objVenta = new Venta($cnx);
    $objUsuario = new Usuario($cnx);
    if (isset($_POST["btnBuscar"])) {
      $criterio = $_POST["txtCriterio"];
      $objUsuario->buscarPorId($criterio);
      $nombre = $objUsuario->getNombre();
      $username = $objUsuario->getLogin();
      echo "<h2 style='padding-top: 10px; '> Resultados de la busqueda</h2>";
      echo "<h4 style='padding-top: 10px; '>Cliente: $nombre Username: $username</h4>";
      $objVenta->mostrarVentasPorCliente($criterio, "../reportes/rpt_listaventas.php");
    } else {
      $objVenta->mostrarVentas("../reportes/rpt_listaventas.php");
    }

    echo "<h3> $mensaje </h3>";
    ?>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Adicionar Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="formAdicionarCarrito" method="post" action="frmventas.php">
              <div class="form-group">
                <label for="id-name" class="col-form-label">Id:</label>
                <input type="text" class="form-control" id="id-name" name="id-name">
              </div>
              <div class="form-group">
                <label for="nombre-name" class="col-form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre-name" name="nombre-name">
              </div>
              <div class="form-group">
                <label for="precio-name" class="col-form-label">Precio bs.:</label>
                <input type="text" class="form-control" id="precio-name" name="precio-name">
              </div>
              <div class="form-group">
                <label for="cantidad-name" class="col-form-label">Cantidad existente:</label>
                <input type="text" class="form-control" id="cantidad-name" name="cantidad-name">
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Cantidad a add:</label>
                <input type="text" class="form-control" id="cantidadadd-name" name="cantidadadd-name">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="btnAddCarrito">Adicionar</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
    <script>
      window.onload = function() {
        $('#exampleModal').on('show.bs.modal', function(event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var id = button.data('id')
          var nombre = button.data('nombre')
          var precio = button.data('precio')
          var cantidad = button.data('cantidad')

          $("#id-name").val(id)
          $("#nombre-name").val(nombre)
          $("#precio-name").val(precio)
          $("#cantidad-name").val(cantidad)
          $("#cantidadadd-name").val(1)

          // Extract info from data-* attributes
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          //var modal = $(this)
          //modal.find('.modal-title').text('New message para recipiente ' + recipient)
          //modal.find('.modal-body input').val(recipient)
        });
      }
    </script>

  </div>
  <?php include("incluir_estilos_pie.php"); ?>
</body>

</html>