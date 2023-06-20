<?php
require_once('../../Utils/fpdf185/fpdf.php');
require_once '../../Utils/SQLUtil.php';
$mysqlUtil = new MySQLUtil();
$tableName = 'Product';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $pdf = new FPDF('L');
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 16);

    $pdf->Cell(0, 10, 'Productos Semanales', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);

    if (!empty($data)) {
        $pdf->Cell(60, 10, 'Nombre del producto', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
        $pdf->Ln();

        foreach ($data as $row) {
            $pdf->Cell(60, 10, $row['nombre'], 1, 0, 'C');
            $pdf->Cell(30, 10, $row['costo'], 1, 0, 'C');
            $pdf->Ln();
        }

        $pdf->Output('informe_productos_semanales.pdf', 'D');
    } else {
        echo 'No se recibieron datos para generar el informe.';
    }
} else {
    echo 'Método no permitido.';
}
?>
