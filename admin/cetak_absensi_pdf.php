<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

// Get selected date
$selected_date = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Query untuk mendapatkan data absensi
$query = "SELECT m.npm, m.nama, a.tanggal, a.waktu 
          FROM absensi a 
          JOIN mahasiswa m ON a.mahasiswa_id = m.id 
          WHERE DATE(a.tanggal) = ?";

// Using prepared statement
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $selected_date);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

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
    <title>Laporan Absensi UNISKA</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 3cm 2cm 2cm 2cm;
            color: #2D3748;
            line-height: 1.6;
            position: relative;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(203, 213, 224, 0.3);
            z-index: -1;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(to right, #4299e1, #667eea);
            color: white;
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
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }
        .info-card {
            background: #f7fafc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }
        .info-grid {
            display: block;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #4a5568;
            font-size: 11px;
            margin-right: 10px;
        }
        .info-value {
            color: #2d3748;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            font-size: 12px;
        }
        th {
            background: #4299e1;
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
        .signature-area {
            margin-top: 30px;
        }
        .signature-line {
            border-bottom: 1px solid #CBD5E0;
            width: 200px;
            margin-left: auto;
            margin-bottom: 10px;
        }
        .page-number {
            text-align: center;
            font-size: 10px;
            color: #718096;
            margin-top: 20px;
        }
        .summary-box {
            background: #EBF8FF;
            border: 1px solid #BEE3F8;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 12px;
            color: #2B6CB0;
        }
        .timestamp {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 10px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="watermark">UNISKA</div>
    
    <div class="timestamp">
        Generated: '.date('d/m/Y H:i:s').'
    </div>

    <div class="header">
        <h2>LAPORAN ABSENSI MAHASISWA</h2>
        <div class="subtitle">UNIVERSITAS ISLAM KALIMANTAN (UNISKA)</div>
        <div class="subtitle">MUHAMMAD ARSYAD AL BANJARI</div>
    </div>

    <div class="info-card">
        <div class="info-grid">
            <span class="info-label">Tanggal Absensi:</span>
            <span class="info-value">'.date('d/m/Y', strtotime($selected_date)).'</span>
        </div>
        <div class="info-grid">
            <span class="info-label">Total Kehadiran:</span>
            <span class="info-value">'.mysqli_num_rows($result).' Mahasiswa</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NPM</th>
                <th width="50%">Nama</th>
                <th width="30%">Waktu Absen</th>
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
                <td style="text-align: center;">'.date('H:i', strtotime($row['waktu'])).' WIB</td>
            </tr>';
}

if ($no == 1) {
    $html .= '
            <tr>
                <td colspan="4" style="text-align: center; color: #718096;">
                    Tidak ada data absensi untuk tanggal ini
                </td>
            </tr>';
}

$html .= '
        </tbody>
    </table>

    <div class="summary-box">
        Total Kehadiran: '.(mysqli_num_rows($result)).' Mahasiswa
    </div>

    <div class="footer">
        <p>Banjarmasin, '.date('d/m/Y').'</p>
        <div class="signature-area">
            <div class="signature-line"></div>
            <p><strong>Admin UNISKA</strong></p>
        </div>
    </div>
</body>
</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_absensi.pdf", array("Attachment" => false));
exit();
?>