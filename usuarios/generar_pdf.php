<?php
require('../includes/config.php');
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    // Encabezado
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor(230, 230, 250);
        $this->Cell(0, 10, 'Lista de Usuarios', 0, 1, 'C', true);
        $this->Ln(10);

        // Encabezado de la tabla
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(169, 169, 169);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(20, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(80, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(90, 10, 'Email', 1, 0, 'C', true);
        $this->Ln();
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$query = "SELECT id, nombre, email FROM usuarios";
$result = $conn->query($query);

$pdf->SetFillColor(245, 245, 245);
$pdf->SetTextColor(0);
$fill = false;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(20, 10, $row['id'], 1, 0, 'C', $fill);
        $pdf->Cell(80, 10, $row['nombre'], 1, 0, 'L', $fill);
        $pdf->Cell(90, 10, $row['email'], 1, 0, 'L', $fill);
        $pdf->Ln();
        $fill = !$fill; // Alternar color de fondo
    }
} else {
    $pdf->Cell(0, 10, 'No hay usuarios registrados.', 1, 1, 'C');
}

$conn->close();

$pdf->Output('D', 'usuarios.pdf');
?>
