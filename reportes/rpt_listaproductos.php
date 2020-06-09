<?php
date_default_timezone_set("America/La_Paz");
require_once("../classes/conexion.php");
require_once("../classes/producto.php");
include("fpdf/mc_table.php");
//define('FPDF_FONTPATH', 'font/');
use classes\conexion\Conexion;
use classes\producto\Producto;
class rpt_listaproductos extends PDF_MC_Table
{
    private $criterio;
    private $cnx;
    function __construct($criterio)
    {
	   parent::__construct();
	   $this->criterio = $criterio;
	   $this->cnx=new Conexion(); 
    }
	
    function Header()
    {
       //$this->SetFont('Arial','B',15);
      parent::stTitulo();
      $this->Cell(0,10,'REPORTE DE PRODUCTOS',0,0,'C');
      $fe = date("d-m-Y");
      $he = date("H:i:s");
      $this->Ln();
      
      parent::stSubTitulo();
      $this->Cell(190,7,"Fecha y hora de emision:  $fe $he",0,0,'C');
      $this->Ln();
      $this->Cell(190,7,"Productos:$this->criterio",0,0,'C');
      $this->Ln();
      //$this->Ln(15);  
     }
	
     function GenerarReporte()
     {
         //cuerpo del reporte
          //  $objProducto = new producto($this->cnx);
	    $sql = "select * from productos where nombre like '%$this->criterio%'";
	    $datos = $this->cnx->execute($sql);
  	     //el tamano max. ancho de la tabla es 190
        parent::imprimirCabezaTabla(array("Cod.","Nombre","Precio bs.","Cantidad"),
        array(30,100,30,30));
             
	     while($reg = $this->cnx->next($datos))
	     {
            parent::stContenido();
            parent::SetWidths(array(30,100,30,30));
            parent::SetAligns(array('L','L','R','R'));
            @parent::Row(
               array(utf8_decode($reg[0]),
                              utf8_decode($reg[1]),
                              utf8_decode($reg[2]),
                              utf8_decode($reg[3])
                              ));				
	     }  
             
	}
}
//************** PRINCIPAL **********************************************************
$criterio = "";
if(isset($_GET["criterio"]))
{
   $criterio = $_GET["criterio"];
}
$pdfReporte=new rpt_listaproductos($criterio);
$pdfReporte->AddPage();
$pdfReporte->GenerarReporte();
$pdfReporte->Output(); 	 	  
//-------------------------------
$pdfReporte->Close();