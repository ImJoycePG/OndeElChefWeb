<?php
require_once('../../Utils/fpdf185/fpdf.php');

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$descripcion = $_POST['descripcion'];
$presupuesto = $_POST['presupuesto'];

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, 'Datos del formulario', 0, 1);
$pdf->Cell(40, 10, 'Nombre:', 0);
$pdf->Cell(0, 10, $nombre, 0, 1);
$pdf->Cell(40, 10, 'Email:', 0);
$pdf->Cell(0, 10, $email, 0, 1);
$pdf->Cell(40, 10, 'Teléfono:', 0);
$pdf->Cell(0, 10, $telefono, 0, 1);
$pdf->Cell(40, 10, 'Descripción:', 0);
$pdf->MultiCell(0, 10, $descripcion, 0);
$pdf->Cell(40, 10, 'Presupuesto:', 0);
$pdf->Cell(0, 10, $presupuesto, 0, 1);

$pdf->Output('Propuestas_Y_Presupuesto.pdf', 'D');

?>
