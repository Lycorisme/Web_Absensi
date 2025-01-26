<?php
session_start();
include '../koneksi.php';

// Cek apakah sudah login
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

// Hitung total mahasiswa
$query_total = "SELECT COUNT(*) as total FROM mahasiswa";
$result_total = mysqli_query($koneksi, $query_total);
$total_mahasiswa = mysqli_fetch_assoc($result_total)['total'];

// Hitung absensi hari ini
$query_today = "SELECT COUNT(DISTINCT mahasiswa_id) as total FROM absensi WHERE DATE(tanggal) = CURDATE()";
$result_today = mysqli_query($koneksi, $query_today);
$absensi_today = mysqli_fetch_assoc($result_today)['total'];

// Data untuk grafik 7 hari terakhir
$query_week = "SELECT DATE(tanggal) as tanggal, COUNT(DISTINCT mahasiswa_id) as total 
               FROM absensi 
               WHERE tanggal >= DATE(NOW()) - INTERVAL 7 DAY 
               GROUP BY DATE(tanggal) 
               ORDER BY tanggal DESC";
$result_week = mysqli_query($koneksi, $query_week);
$weekly_data = array();
while($row = mysqli_fetch_assoc($result_week)) {
    $weekly_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UNISKA</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>UNISKA</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="dashboard.php">
                        <i class='bx bxs-dashboard'></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="daftar_mahasiswa.php">
                        <i class='bx bxs-user-detail'></i>
                        <span>Daftar Mahasiswa</span>
                    </a>
                </li>
                <li>
                    <a href="absensi.php">
                        <i class='bx bxs-calendar-check'></i>
                        <span>Absensi</span>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="confirmLogout()">
                        <i class='bx bxs-log-out'></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0 fw-bold">Dashboard Overview</h2>
                    <button id="sidebarCollapse" class="btn btn-primary d-md-none">
                        <i class='bx bx-menu'></i>
                    </button>
                </div>
                
                <!-- Info Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="stats-card primary-card" onclick="window.location.href='daftar_mahasiswa.php'">
                            <div class="card-body">
                                <h5 class="card-title">Total Mahasiswa</h5>
                                <h2 class="card-text"><?php echo $total_mahasiswa; ?></h2>
                                <i class='bx bxs-user icon'></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stats-card secondary-card" onclick="window.location.href='absensi.php'">
                            <div class="card-body">
                                <h5 class="card-title">Absensi Hari Ini</h5>
                                <h2 class="card-text"><?php echo $absensi_today; ?></h2>
                                <i class='bx bxs-calendar-check icon'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weekly Chart -->
                <div class="chart-card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Absensi 7 Hari Terakhir</h5>
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });

        // Chart initialization
        const ctx = document.getElementById('weeklyChart').getContext('2d');
        const weeklyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column(array_reverse($weekly_data), 'tanggal')); ?>,
                datasets: [{
                    label: 'Jumlah Absensi',
                    data: <?php echo json_encode(array_column(array_reverse($weekly_data), 'total')); ?>,
                    borderColor: 'rgba(67, 97, 238, 1)',
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgba(67, 97, 238, 1)',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Logout confirmation
        function confirmLogout() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-primary mx-2",
                    cancelButton: "btn btn-danger mx-2"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Konfirmasi Logout",
                text: "Apakah anda yakin ingin keluar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Keluar",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        }
    </script>
</body>
</html>