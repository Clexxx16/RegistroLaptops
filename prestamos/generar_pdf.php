<?php
require('../includes/config.php');
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(230, 230, 250);
        $this->Cell(0, 8, utf8_decode('Lista de Préstamos'), 0, 1, 'C', true);
        $this->Ln(3);

        // Encabezado de la tabla
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(50, 50, 50);
        $this->SetTextColor(255);

        $this->Cell(8, 6, 'ID', 1, 0, 'C', true);
        $this->Cell(15, 6, 'Laptop ID', 1, 0, 'C', true);
        $this->Cell(15, 6, 'Usuario ID', 1, 0, 'C', true);
        $this->Cell(30, 6, utf8_decode('Prestado a'), 1, 0, 'C', true);
        $this->Cell(22, 6, utf8_decode('F. Préstamo'), 1, 0, 'C', true);
        $this->Cell(30, 6, utf8_decode('Entregado por'), 1, 0, 'C', true);
        $this->Cell(12, 6, 'Devuelto', 1, 0, 'C', true);
        $this->Cell(22, 6, utf8_decode('F. Devolución'), 1, 0, 'C', true);
        $this->Cell(35, 6, utf8_decode('Devuelto por'), 1, 1, 'C', true);
    }

    function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(0, 5, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 6);

$query = "SELECT id, laptop_id, usuario_id, prestado_a, fecha_prestamo, entregado_por, devuelto, fecha_devolucion, devuelto_por FROM prestamos";
$result = $conn->query($query);

$pdf->SetFillColor(245, 245, 245);
$pdf->SetTextColor(0);
$fill = false;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $devuelto = $row['devuelto'] ? 'Sí' : 'No';
        $fecha_devolucion = $row['fecha_devolucion'] ? date('d/m/Y H:i', strtotime($row['fecha_devolucion'])) : 'Pendiente';

        $pdf->Cell(8, 5, utf8_decode($row['id']), 1, 0, 'C', $fill);
        $pdf->Cell(15, 5, utf8_decode($row['laptop_id']), 1, 0, 'C', $fill);
        $pdf->Cell(15, 5, utf8_decode($row['usuario_id']), 1, 0, 'C', $fill);
        $pdf->Cell(30, 5, utf8_decode($row['prestado_a']), 1, 0, 'L', $fill);
        $pdf->Cell(22, 5, utf8_decode(date('d/m/Y H:i', strtotime($row['fecha_prestamo']))), 1, 0, 'C', $fill);
        $pdf->Cell(30, 5, utf8_decode($row['entregado_por']), 1, 0, 'L', $fill);
        $pdf->Cell(12, 5, utf8_decode($devuelto), 1, 0, 'C', $fill);
        $pdf->Cell(22, 5, utf8_decode($fecha_devolucion), 1, 0, 'C', $fill);
        $pdf->Cell(35, 5, utf8_decode($row['devuelto_por'] ?: 'N/A'), 1, 0, 'L', $fill);
        $pdf->Ln();
        $fill = !$fill;
    }
} else {
    $pdf->Cell(0, 5, utf8_decode('No hay préstamos registrados.'), 1, 1, 'C');
}

$conn->close();

$pdf->Output('D', 'prestamos.pdf');
?>