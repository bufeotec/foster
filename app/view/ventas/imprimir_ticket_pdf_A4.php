<?php
/**
 * Created by PhpStorm
 * User: LuisSalazar
 * Date: 22/02/2022
 * Time: 09:32 a. m.
 */

//LLAMAMOS A LA LIBRERIA que está en la vista de report
//require 'app/view/report/pdf_base.php';
//llamamos a la clase pdf_base.php que esta en la vista sellgas
//require_once 'pdf_base_ticket.php';
//se llama directo a la libreria
require 'app/view/pdf/fpdf/fpdf.php';
//require 'app/view/report/pdf_base.php';
// creamos el objeto
$pdf = new FPDF('P', 'mm', 'A4');
//Define el marcador de posición usado para insertar el número total de páginas en el documento
$pdf->AddPage();
//CABECERA DEL ARCHIVO
//Logo
$pdf->Image(_SERVER_.'media/logo/logo.png',30,6, '50', '25', 'png');
$pdf->Ln(5);
$pdf->SetFillColor(220,220,220);
$pdf->SetFont('Helvetica','',9);
//$pdf->Cell(60,4, "$dato_pago->empresa_nombrecomercial",0,1,'C',0);
//$pdf->Cell(60,4,"$dato_venta->empresa_nombre",0,1,'C');
//$pdf->Cell(60,4, "EMPRESA DE SERVICIOS PARA EL ",0,1,'C',0);
//$pdf->Cell(60,4, "DESARROLLO HUMANO",0,1,'C',0);
$pdf->SetFont('Helvetica','',10);
$pdf->Cell(120,0,'','',0);
$pdf->Cell(60,0,'','T',1,'R');
$pdf->Cell(120,8,'','',0);
$pdf->Cell(60,8, "RUC $dato_venta->empresa_ruc",'LR',1,'C',0);
//$pdf->Cell(60,4, "DESARROLLO HUMANO",0,1,'C',0);
$pdf->Cell(120,8,"",0,0,'R',0);
$pdf->Cell(60,8,"$tipo_comprobante",'LR',1,'C',1);
$pdf->Cell(120,8,'','',0);
$pdf->Cell(60,8,"$serie_correlativo",'LR',1,'C',0);
$pdf->Cell(120,0,'','',0);
$pdf->Cell(60,0,'','T',1,'R');
$pdf->Ln(3);
$pdf->SetFont('Helvetica','B',9);
$pdf->Cell(90,4,"$dato_venta->empresa_nombrecomercial",0,1,'C');
$pdf->SetFont('Helvetica','B',8);
$pdf->Cell(90,4,"DE: $dato_venta->empresa_razon_social",0,1,'C');
$pdf->SetFont('Helvetica','',7);
$pdf->Cell(90,4,"$dato_venta->empresa_domiciliofiscal",0,1,'C');
$pdf->Cell(90,4,"$dato_venta->empresa_departamento - $dato_venta->empresa_provincia - $dato_venta->empresa_distrito",0,1,'C');
$pdf->Cell(90,4,"Cel. 976985600",0,1,'C');
$pdf->Cell(90,4,"contacto@fireathletics.pe",0,1,'C');
$pdf->Ln(3);
$pdf->Cell(180,0,'','T',1,'R');
$pdf->Ln(3);
$pdf->SetFont('Helvetica','B',8);
$pdf->Cell(20,4,"Cliente:",0,0,'L');
if($dato_venta->id_tipodocumento != 4){
    $pdf->SetFont('Helvetica','',8);
    $pdf->Cell(160,4, "$dato_venta->cliente_nombre",0,1,'L',false);
}else{
    $pdf->SetFont('Helvetica','',8);
    $pdf->Cell(160,4, "$dato_venta->cliente_razonsocial",0,1,'L',false);
}
$pdf->Ln(2);

$pdf->SetFont('Helvetica','B',8);
$pdf->Cell(20,4,"$dnni:",0,0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(110,4, "$documento",0,0,'L',false);

$pdf->SetFont('Helvetica','B',8);
$pdf->Cell(15,4, "Fecha:",0,0,'L',false);
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(35,4, "$fecha_hoy",0,1,'L',false);
$pdf->Ln(2);

$pdf->SetFont('Helvetica','B',8);
$pdf->Cell(20,4,"Dirección:",0,0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->MultiCell(160,4,"$dato_venta->cliente_direccion",0,1,'');
$pdf->Ln(2);

$pdf->SetFont('Helvetica','B',8);
$pdf->Cell(20,4,"Atendido por:",0,0,'L');
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(110,4,"FOSTER",0,0,'L');
$pdf->SetFont('Helvetica','B',8);
$pdf->Cell(15,4, "Pago:",0,0,'L',false);
$pdf->SetFont('Helvetica','',8);
$pdf->Cell(35,4, "$dato_venta->tipo_pago_nombre",0,1,'L',false);
$pdf->Ln(2);

$pdf->Cell(180,0,'','T',1,'R');
$pdf->SetFillColor(180,180,180);
$pdf->Ln(7);
$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(10, 10, 'ITEM', 1,'0','C',1);
$pdf->Cell(15, 10, 'CANT',1,0,'C',1);
$pdf->Cell(100, 10, 'DESCRIPCION', 1,'0','C',1);
$pdf->Cell(20, 10, 'P.U.',1,0,'C',1);
$pdf->Cell(15, 10, 'IGV',1,0,'C',1);
$pdf->Cell(20, 10, 'P.VENTA',1,1,'C',1);

$pdf->SetWidths(array(10,15,100,20,15,20));
//PRODUCTOS
$aa=1;
$filas_tot = 0;
foreach ($detalle_venta as $f){
    $cant = strlen($f->venta_detalle_nombre_producto);
    $filas = ceil($cant / 65);
    if($filas==0){$filas=1;}
    $filas_tot+=$filas;
    $he = 4 * $filas;
    $pdf->SetFont('Helvetica', '', 7);
    $venta_detalle_precio_unitario = number_format($f->venta_detalle_precio_unitario, 2);
    $venta_detalle_valor_total = number_format($f->venta_detalle_valor_total, 2);
    $pdf->Row(array($aa, $f->venta_detalle_cantidad , $f->venta_detalle_nombre_producto, $venta_detalle_precio_unitario, $f->venta_detalle_total_igv, $venta_detalle_valor_total));

}
$pdf->Ln(7);
$pdf->Cell(70,3,'','T',0,'R');
$pdf->Cell(70,0,'',0,0,'L');
$pdf->Cell(40,3,'','T',1,'R');
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(70, 3, "Son: $montoLetras", 0,0,'C');
$pdf->Cell(110, 1, "Descuento: $dato_venta->simbolo $dato_venta->venta_totaldescuento", 0,1,'R');
$pdf->Ln(7);
if($dato_venta->venta_tipo != "20"){
	$pdf->Cell(70,1,'BIENES TRANSFERIDOS EN LA AMAZONIA',0,0,'C');
}else{
	$pdf->Cell(70,1,'ESTE NO ES UN COMPROBANTE VALIDO',0,0,'C');
}
$pdf->Cell(110, 1, "Op.Grat: $dato_venta->simbolo $dato_venta->venta_totalgratuita", 0,1,'R');
$pdf->Ln(3);
if($dato_venta->venta_tipo != "20"){
	$pdf->Cell(70,1,'PARA SER CONSUMIDOS EN LA MISMA',0,0,'C');
}else{
	$pdf->Cell(70,1,'PARA SUNAT SI REQUIERE UNA BOLETA O FACTURA, ',0,0,'C');
}
$pdf->Cell(110, 1, "Op.Exon: $dato_venta->simbolo $dato_venta->venta_totalexonerada", 0,1,'R');
$pdf->Ln(3);
if($dato_venta->venta_tipo != "20"){
	$pdf->Cell(70,1,'',0,0,'C');
}else{
	$pdf->Cell(70,1,'SOLICÍTELO',0,0,'C');
}
$pdf->Cell(110, 1, "Op.Inaf: $dato_venta->simbolo $dato_venta->venta_totalinafecta", 0,1,'R');
$pdf->Ln(3);
$pdf->Cell(180, 1, "Op.Grav: $dato_venta->simbolo $dato_venta->venta_totalgravada", 0,1,'R');
$pdf->Ln(3);
$pdf->Cell(180, 1, "IGV: $dato_venta->simbolo $dato_venta->venta_totaligv", 0,1,'R');
$pdf->Ln(3);
$pdf->SetFont('Helvetica', '', 7);
$pdf->Cell(70,0,'',0,0,'C');
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->Cell(110, 1, "TOTAL: $dato_venta->simbolo $dato_venta->venta_total", 0,'1','R');
$pdf->SetFont('Helvetica', '', 7);
$pdf->Ln(3);
$pdf->Cell(60,0,'',0,1,'C');
$pdf->Ln(20);
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(70,0,'Bufeo Tec Company - Digitalízate',0,0,'C');
$pdf->Ln(3);
$pdf->Cell(70,0,'bufeotec.com',0,1,'C');
$pdf->Ln(3);
$pdf->Cell(70,3,'','T',0,'R');
$pdf->Cell(70,0,'',0,0,'L');
$pdf->Cell(40,3,'','T',1,'R');

// PIE DE PAGINA
$pdf->Ln();
if($dato_venta->venta_observaciones!=""){
    $pdf->Cell(180,3,'','T',1,'R');
    $pdf->MultiCell(180,8,"OBSERVACIONES: $dato_venta->venta_observaciones",0,1,'');
    $pdf->Cell(180,3,'','T',1,'R');
}

$pdf->Ln(15);
$pdf->SetFont('Helvetica', '', 8);
$fecha = date('d/m/Y');
$hora = date('H:i:s');
$pdf->Cell(0,4,"Para consultar la validez del comprobante ingrese a: https://ww3.sunat.gob.pe/ol-ti-itconsvalicpe/ConsValiCpe.htm",0,1,'C');
$pdf->Ln(2);
$pdf->Cell(0,4,"Fecha de Impresión: "." ".$fecha." ".$hora,0,1,'C');

if($filas_tot<4) {
    $hei = 140 + (5 * $filas_tot);
}else{
    $hei = 140 + (5 * $filas_tot);
}
if ($dato_venta->venta_tipo != "20") {
    $pdf->Image("$ruta_qr",'30',$hei, '30', '30', '', '');
}

//$ruta_guardado = 'media/comprobantes/'."$serie_correlativo-" .date('Ymd').'.pdf';
$pdf->Output("$dato_venta->empresa_ruc-$serie_correlativo", 'I');
?>
