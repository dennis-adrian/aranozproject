<?php
date_default_timezone_set("America/La_Paz");
require_once("../classes/conexion.php");
include("fpdf/mc_table.php");
//define('FPDF_FONTPATH', 'font/');
use classes\conexion\Conexion;

class rpt_listaventas extends PDF_MC_Table
{
   private $criterio;
   private $cnx;
   private $nombreCliente;
   function __construct($idventa)
   {
      parent::__construct();
      $this->criterio = $idventa;
      $this->nombreCliente = "";
      $this->cnx = new Conexion();
   }

   function Header()
   {
      //$this->SetFont('Arial','B',15);
      parent::stTitulo();
      $this->Cell(0, 10, 'NOTA de VENTAS', 0, 0, 'C');
      $fe = date("d/m/Y");
      $he = date("H:i:s");
      $this->Ln(); //salto de linea

      parent::stSubTitulo();
      $this->Cell(190, 7, "Fecha y hora de emision:  $fe $he", 0, 0, 'C');
      $this->Ln();
      /************************CONSULTA SQL*******/
      $idventa = $this->criterio;
      $sql = "SELECT 
         c.nombre,
         c.direccion,
         c.email,
         c.telefono,
         v.estado,
         v.fecha
         from venta v inner join usuario c 
         on v.cliente_id = c.id where v.id = $idventa ";
      $resultado = $this->cnx->execute($sql);
      $registro = $this->cnx->next($resultado);
      $this->nombreCliente = $registro[0];
      $nombre = $this->nombreCliente;
      $direccion = $registro[1];
      $email = $registro[2];
      $telefono = $registro[3];
      $estado = $registro[4];
      $fecha = $registro[5];
      $idventa = $this->criterio; //el id_venta esta parametrizado criterio
      /*******************************/
      $this->Cell(190, 7, "Nro.Venta: $idventa  Estado: $estado ", 0, 0, 'L');
      $this->Ln();

      $this->Cell(190, 7, "Fecha: $fecha", 0, 0, 'L');
      $this->Ln();

      $this->Cell(190, 7, "Cliente: $nombre Direccion: $direccion ", 0, 0, 'L');
      $this->Ln();

      $this->Cell(190, 7, "Email: $email Telefono: $telefono ", 0, 0, 'L');
      $this->Ln();
      //$this->Ln(15); 

   }

   function GenerarReporte()
   {
      $idventa = $this->criterio;
      //cuerpo del reporte
      //  $objProducto = new producto($this->cnx);
      $sql = "SELECT dv.producto_id,
               p.nombre,
               p.descripcion,
               dv.precio,
               dv.cantidad
            FROM detalleventa dv inner join producto p on dv.producto_id = p.id
            where dv.venta_id = $idventa
      ";
      $datos = $this->cnx->execute($sql);
      //el tamano max. ancho de la tabla es 190
      parent::imprimirCabezaTabla(
         array("#", "Id", "Producto", "Descripcion", "Precio U. (Bs)", "Cant.", "Total bs."),
         array(10, 10, 40, 70, 30, 15, 15)
      );

      /* ********* */
      $nrofila = 1;
      $subtotal = 0;
      $total = 0;


      while ($reg = $this->cnx->next($datos)) {
         //calculamos cantidad * precio
         $subtotal = $reg[3] * $reg[4];
         $total = $total + $subtotal;

         parent::stContenido();
         parent::SetWidths(array(10, 10, 40, 70, 30, 15, 15));
         parent::SetAligns(array('L', 'L', 'L', 'L', 'R', 'R', 'R'));
         @parent::Row(
            array(
               utf8_decode($nrofila),
               utf8_decode($reg[0]),
               utf8_decode($reg[1]),
               utf8_decode($reg[2]),
               utf8_decode($reg[3]),
               utf8_decode($reg[4]),
               utf8_decode($subtotal)
            )
         );
         $nrofila++;
      }
      parent::stContenidoResaltado();
      parent::SetWidths(array(170, 20));
      parent::SetAligns(array('R', 'R'));
      @parent::Row(
         array(
            utf8_decode("Total bs.:"),
            utf8_decode($total)
         )
      );
      //----------------------------------------------------------------
      parent::stSubTitulo();
      $this->Ln();
      $this->Ln();
      $this->Ln();
      $this->Ln();
      $this->Cell(0, 10, '_______________________', 0, 0, 'C');
      $this->Ln(); //salto de linea
      $nombre = $this->nombreCliente;
      $this->Cell(0, 10, "$nombre", 0, 0, 'C');
   }
}
//************** PRINCIPAL **********************************************************
$criterio = "";
if (isset($_GET["id"])) {
   $criterio = $_GET["id"];
}
$pdfReporte = new rpt_listaventas($criterio);
$pdfReporte->AddPage();
$pdfReporte->GenerarReporte();
$pdfReporte->Output();
//-------------------------------
$pdfReporte->Close();
