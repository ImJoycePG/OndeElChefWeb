<?php
require_once('../../Utils/fpdf185/fpdf.php');


$pdf = new FPDF('L');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(0, 10, 'Informe de productos', 0, 1, 'C');


$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);

require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();
$tableName = 'Product';
$data = $mysqlUtil->getAllData($tableName);

if ($data) {
    $pdf->Cell(20, 10, 'ID', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Costo', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Stock', 1, 0, 'C');
    $pdf->Cell(40, 10, 'ID-Categoria', 1, 0, 'C');
    $pdf->Cell(40, 10, 'F. de Vencimiento', 1, 0, 'C');
    $pdf->Cell(40, 10, 'F. de Ingreso', 1, 0, 'C');
    $pdf->Cell(30, 10, 'R. Proveedor', 1, 0, 'C');
    $pdf->Ln();

    foreach ($data as $supplier) {
        $pdf->Cell(20, 10, $supplier['idProduct'], 1, 0, 'C');
        $pdf->Cell(40, 10, $supplier['nameProduct'], 1, 0, 'C');
        $pdf->Cell(30, 10, $supplier['costProduct'], 1, 0, 'C');
        $pdf->Cell(20, 10, $supplier['stockProduct'], 1, 0, 'C');
        $pdf->Cell(40, 10, $supplier['idCategory'], 1, 0, 'C');
        $pdf->Cell(40, 10, $supplier['dueDate'], 1, 0, 'C');
        $pdf->Cell(40, 10, $supplier['joinDate'], 1, 0, 'C');
        $pdf->Cell(30, 10, $supplier['rucSupplier'], 1, 0, 'C');
        $pdf->Ln();
    }

    $pdf->Output('informe_productos.pdf', 'D');
} else {
    echo 'No hay datos disponibles para generar el informe.';
}
?>