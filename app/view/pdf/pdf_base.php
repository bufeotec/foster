<?php
require 'app/view/pdf/fpdf/fpdf.php';

class PDF extends FPDF{

    //Cabecera de pagina
    function Header(){
        //Arial bold 15
        $this->SetFont('Arial','B',16);
        //Mover
        $this->Cell(30);
        //Titulo
        $this->Cell(130,10,'RUTA 57',0,1,'C');
        $this->Cell(30);
        $this->Cell(130,10,'CAFÉ RESTOBAR',0,1,'C');
        $this->SetFont('Arial','B',12);
        $this->Cell(190,10,'JR. FREYRE 1399',0,1,'C');
        $this->SetFont('Arial','B',12);
        $this->Cell(190,10,'----------------------------------------------------------------------------------------------------------------------',0,0,'C');
        $this->Image('media/logo/logo_ruta.png',16,11,30);
        //Salto de linea
        $this->Ln();
    }

    //Pie de pagina
    function Footer(){
        //Posicion: a 1.5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','I',8);
        //Numero de Ipagina
        $fecha = date('d-m-Y h:i:s');
        $this->Cell(0,10,'Pagina ' . $this->PageNo().'/{nb}'." "."|| Hora y fecha de descarga"." ".$fecha,0,0,'C');
    }
}
?>