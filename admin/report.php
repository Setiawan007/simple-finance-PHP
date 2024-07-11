<?php
require '../includes/db.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Periksa apakah pengguna sudah login
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data transaksi dari database
$sql = "SELECT * FROM transactions WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll();

// Generate PDF
if (isset($_GET['format']) && $_GET['format'] == 'pdf') {
    require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

    class MYPDF extends TCPDF {
        public function Header() {
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 15, 'Transaction Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        }
        public function Footer() {
            $this->SetY(-15);
            $this->SetFont('helvetica', 'I', 8);
            $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Transaction Report');
    $pdf->SetHeaderData('', '', 'Transaction Report', '');
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 10);
    $html = '<table border="1" cellspacing="3" cellpadding="4">';
    $html .= '<tr><th>ID</th><th>Type</th><th>Amount</th><th>Description</th><th>Date</th></tr>';
    foreach ($transactions as $transaction) {
        $html .= '<tr>';
        $html .= '<td>' . $transaction['id'] . '</td>';
        $html .= '<td>' . $transaction['type'] . '</td>';
        $html .= '<td>' . $transaction['amount'] . '</td>';
        $html .= '<td>' . $transaction['description'] . '</td>';
        $html .= '<td>' . $transaction['created_at'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output('transaction_report.pdf', 'I');
    exit;
}

// Generate Excel
if (isset($_GET['format']) && $_GET['format'] == 'excel') {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Type');
    $sheet->setCellValue('C1', 'Amount');
    $sheet->setCellValue('D1', 'Description');
    $sheet->setCellValue('E1', 'Date');

    $row = 2;
    foreach ($transactions as $transaction) {
        $sheet->setCellValue('A' . $row, $transaction['id']);
        $sheet->setCellValue('B' . $row, $transaction['type']);
        $sheet->setCellValue('C' . $row, $transaction['amount']);
        $sheet->setCellValue('D' . $row, $transaction['description']);
        $sheet->setCellValue('E' . $row, $transaction['created_at']);
        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'transaction_report.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="../assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/AdminLTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Generate Report</h3>
                                </div>
                                <div class="card-body">
                                    <a href="report.php?format=pdf" class="btn btn-primary">Download PDF</a>
                                    <a href="report.php?format=excel" class="btn btn-success">Download Excel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="../assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
