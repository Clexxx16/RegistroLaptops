<?php
require('../includes/config.php');
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(230, 230, 250);
        $this->Cell(0, 8, 'Lista de Laptops', 0, 1, 'C', true);
        $this->Ln(3);

        // Encabezado de la tabla
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(50, 50, 50);
        $this->SetTextColor(255);

        $this->Cell(8, 6, 'ID', 1, 0, 'C', true);
        $this->Cell(15, 6, 'Codigo', 1, 0, 'C', true);
        $this->Cell(18, 6, 'Marca', 1, 0, 'C', true);
        $this->Cell(23, 6, 'Modelo', 1, 0, 'C', true);
        $this->Cell(25, 6, 'Procesador', 1, 0, 'C', true);
        $this->Cell(10, 6, 'RAM', 1, 0, 'C', true);
        $this->Cell(15, 6, 'Almac.', 1, 0, 'C', true);
        $this->Cell(18, 6, 'Estado', 1, 0, 'C', true);
        $this->Cell(35, 6, 'Descripcion', 1, 0, 'C', true);
        $this->Cell(22, 6, 'Creado en', 1, 1, 'C', true);
        
    }

    function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(0, 5, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 6);

$query = "SELECT id, codigo, marca, modelo, procesador, ram, almacenamiento, estado, descripcion, creado_en FROM laptops";
$result = $conn->query($query);

$pdf->SetFillColor(245, 245, 245);
$pdf->SetTextColor(0);
$fill = false;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $estado = !empty($row['estado']) ? $row['estado'] : 'No disponible';
        $creado_en = date('d/m/Y H:i', strtotime($row['creado_en']));

        $pdf->Cell(8, 5, $row['id'], 1, 0, 'C', $fill);
        $pdf->Cell(15, 5, $row['codigo'], 1, 0, 'L', $fill);
        $pdf->Cell(18, 5, $row['marca'], 1, 0, 'L', $fill);
        $pdf->Cell(23, 5, $row['modelo'], 1, 0, 'L', $fill);
        $pdf->Cell(25, 5, $row['procesador'], 1, 0, 'L', $fill);
        $pdf->Cell(10, 5, $row['ram'] . ' GB', 1, 0, 'C', $fill);
        $pdf->Cell(15, 5, $row['almacenamiento'] . ' GB', 1, 0, 'C', $fill);
        $pdf->Cell(18, 5, $estado, 1, 0, 'C', $fill);
        $pdf->Cell(35, 5, substr($row['descripcion'], 0, 35) . '...', 1, 0, 'L', $fill);
        $pdf->Cell(22, 5, $creado_en, 1, 0, 'C', $fill);
        $pdf->Ln();
        $fill = !$fill;
    }
} else {
    $pdf->Cell(0, 5, 'No hay laptops registradas.', 1, 1, 'C');
}

$conn->close();

$pdf->Output('D', 'laptops.pdf');
?>
