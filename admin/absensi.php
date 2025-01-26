<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

// Initialize result variable
$result = null;

// Get selected date
$selected_date = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

try {
    // Query untuk mendapatkan data absensi
    $query = "SELECT m.npm, m.nama, a.tanggal, a.waktu, a.created_at 
              FROM absensi a 
              JOIN mahasiswa m ON a.mahasiswa_id = m.id 
              WHERE DATE(a.tanggal) = '$selected_date'
              ORDER BY a.created_at DESC";
    $result = mysqli_query($koneksi, $query);
    
    if (!$result) {
        throw new Exception(mysqli_error($koneksi));
    }
} catch (Exception $e) {
    $error_message = "Terjadi kesalahan: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi - UNISKA</title>
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
                <li>
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
                <li class="active">
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
                    <h2 class="mb-0 fw-bold">Data Absensi</h2>
                    <button id="sidebarCollapse" class="btn btn-primary d-md-none">
                        <i class='bx bx-menu'></i>
                    </button>
                </div>

                <?php if(isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
                <?php endif; ?>

                <!-- Filter and Print Button -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form action="" method="GET" class="d-flex">
                            <div class="input-group">
                                <input type="date" name="tanggal" class="form-control" value="<?php echo $selected_date; ?>" 
                                       onchange="this.form.submit()">
                                <button type="submit" class="btn btn-primary">
                                    <i class='bx bx-filter'></i>
                                    <span>Filter</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-success" onclick="printAbsensi()" 
                                <?php echo !$result || mysqli_num_rows($result) == 0 ? 'disabled' : ''; ?>>
                            <i class='bx bxs-file-pdf'></i>
                            <span>Cetak PDF</span>
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="data-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NPM</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($result && mysqli_num_rows($result) > 0): ?>
                                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['npm']); ?></td>
                                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                            <td><?php echo date('H:i', strtotime($row['waktu'])); ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class='bx bx-calendar-x fs-1 d-block mb-2'></i>
                                                    Tidak ada data absensi untuk tanggal ini
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });

        // Print Function
        function printAbsensi() {
            window.open('cetak_absensi_pdf.php?tanggal=<?php echo $selected_date; ?>', '_blank');
        }

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