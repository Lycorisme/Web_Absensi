<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

// Query untuk mendapatkan data mahasiswa
$query = "SELECT * FROM mahasiswa ORDER BY npm";
$result = mysqli_query($koneksi, $query);

require '../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);

$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Mahasiswa UNISKA</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 3cm 2cm 2cm 2cm;
            color: #2D3748;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }
        h2 {
            margin: 0;
            padding: 10px;
            color: #1a365d;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .subtitle {
            font-size: 14px;
            color: #4a5568;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            font-size: 12px;
        }
        th {
            background-color: #4299e1;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) {
            background-color: #f7fafc;
        }
        tr:hover {
            background-color: #ebf4ff;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            padding-right: 50px;
            color: #4a5568;
        }
        .page-number {
            text-align: center;
            font-size: 10px;
            color: #718096;
            margin-top: 20px;
        }
        .signature-line {
            border-bottom: 1px solid #CBD5E0;
            width: 200px;
            margin-left: auto;
            margin-bottom: 10px;
        }
        .document-info {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 10px;
            color: #718096;
        }
        .info-table {
            margin-bottom: 20px;
            width: auto;
            border: none;
        }
        .info-table td {
            border: none;
            padding: 4px;
            font-size: 11px;
            color: #4a5568;
        }
    </style>
</head>
<body>
    <div class="document-info">
        Generated on: '.date('d/m/Y H:i:s').'
    </div>

    <div class="header">
        <h2>DAFTAR MAHASISWA</h2>
        <div class="subtitle">UNIVERSITAS ISLAM KALIMANTAN (UNISKA)</div>
        <div class="subtitle">MUHAMMAD ARSYAD AL BANJARI</div>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 120px;">Tanggal Cetak</td>
            <td>: '.date('d/m/Y').'</td>
        </tr>
        <tr>
            <td>Total Mahasiswa</td>
            <td>: '.mysqli_num_rows($result).' Orang</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NPM</th>
                <th width="45%">Nama</th>
                <th width="35%">Jurusan</th>
            </tr>
        </thead>
        <tbody>';

$no = 1;
while($row = mysqli_fetch_assoc($result)) {
    $html .= '
            <tr>
                <td style="text-align: center;">'.$no++.'</td>
                <td>'.htmlspecialchars($row['npm']).'</td>
                <td>'.htmlspecialchars($row['nama']).'</td>
                <td>'.htmlspecialchars($row['jurusan']).'</td>
            </tr>';
}

$html .= '
        </tbody>
    </table>

    <div class="footer">
        <p>Banjarmasin, '.date('d/m/Y').'</p>
        <div class="signature-line"></div>
        <p><strong>Admin UNISKA</strong></p>
    </div>
</body>
</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("daftar_mahasiswa.pdf", array("Attachment" => false));
exit();
?>