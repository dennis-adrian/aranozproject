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
    function __construct($idventa)
    {
	   parent::__construct();
	   $this->criterio = $idventa;
	   $this->cnx=new Conexion(); 
    }
	
    function Header()
    {
       //$this->SetFont('Arial','B',15);
      parent::stTitulo();
      $this->Cell(0,10,'NOTA de VENTAS',0,0,'C');
      $fe = date("d/m/Y");
      $he = date("H:i:s");
      $this->Ln();
      
      parent::stSubTitulo();
      $this->Cell(190,7,"Fecha y hora de emision:  $fe $he",0,0,'C');
      $this->Ln();
      $sql ="select c.nombre,c.direccion,c.email,c.telefono,v.estado,v.fecha from ventas inner join clientes on v.cliente_id= c.id";
      $resultado= $this->cnx->execute($sql);
      $registro= $this->cnx->next($resultado);
      $nombre= $registro[0];
      $direccion=$registro[1];
      $email=$registro[2];
      $telefono=$registro[3];
      $estado=$registro[4];
      $fecha=$registro[5];

      

      $this->Cell(190,7,"Ventas en general:$this->criterio",0,0,'C');
      $this->Ln();
      //$this->Ln(15);  
     }
	
     function GenerarReporte()
     {
         //cuerpo del reporte
          //  $objProducto = new producto($this->cnx);
       $sql = "select v.id,v.estado,v.fecha,c.nombre from ventas v inner join
        clientes c on(v.cliente_id = c.id) where v.id=$this->criterio";
	    $datos = $this->cnx->execute($sql);
  	     //el tamano max. ancho de la tabla es 190
        parent::imprimirCabezaTabla(array("Id","Nombre","Fecha","Estado"),
        array(30,110,30,20));
             
	     while($reg = $this->cnx->next($datos))
	     {
            parent::stContenido();
            parent::SetWidths(array(30,110,30,20));
            parent::SetAligns(array('L','L','L','L'));
            @parent::Row(
               array(
                              utf8_decode($reg[0]),
                              utf8_decode($reg[3]),
                              utf8_decode($reg[2]),
                              utf8_decode($reg[1])
                     ));				
	     }  
             
	}
}
//************** PRINCIPAL **********************************************************
$criterio = "";
if(isset($_GET["id"]))
{
   $criterio = $_GET["id"];
}
$pdfReporte=new rpt_listaventas($criterio);
$pdfReporte->AddPage();
$pdfReporte->GenerarReporte();
$pdfReporte->Output(); 	 	  
//-------------------------------
$pdfReporte->Close();