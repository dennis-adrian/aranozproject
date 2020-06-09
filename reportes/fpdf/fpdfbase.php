<?php
//require('../lib/fpdf/fpdf.php');

class PDFBASE extends FPDF
{
  public function stTitulo()
  {
      $this->SetFont('Arial','B',15);
  }
  public function stSubTitulo()
  {
      $this->SetFont('Arial','',12);
  }
  public function stContenido()
  {
	  $this->SetFillColor(255);
	  $this->SetTextColor(0);
	  $this->SetFont('');
	  $this->SetFont('Arial','',10);
  }
   public function stContenidoPequeno()
  {
	  $this->SetFillColor(255);
	  $this->SetTextColor(0);
	  $this->SetFont('');
	  $this->SetFont('Arial','',8);
  }
  public function stContenidoResaltado()
  {
	  $this->SetFillColor(230,230,230);
	  $this->SetTextColor(0);
	  //$this->SetFont('');
	  $this->SetFont('Arial','B',10);
  }
  public function stCabezaTabla()
  {
      $this->SetFont('Helvetica','B',12);        
      $this->SetFillColor(230);
      $this->SetTextColor(0);
	  $this->SetDrawColor(0);
      $this->SetLineWidth(.3);
  }
  public function imprimirCabezaTabla($arrayTit,$arrayDim)
  {
      

	  //$a =$arrayDim[0]-5;
	  $this->stCabezaTabla();
	  for($i=0;$i<count($arrayTit);$i++)
	  {		 
         //$this->SetX($a);
         //$this->Cell($a);
		 $this->Cell($arrayDim[$i],7,$arrayTit[$i],1,0,'C',1);
		 //$a = $a +$arrayDim[$i];
	  }
	  $this->Ln();
  }
  //override
  function Footer()
  {
	//Go to 1.5 cm from bottom
	$this->SetY(-15);
	//Select Arial italic 8
	$this->SetFont('Arial','I',8);
  //Print centered page number
  
	$this->Cell(0,10,'Pagina Nro. '.$this->PageNo(),0,0,'C');
  }
}
?>