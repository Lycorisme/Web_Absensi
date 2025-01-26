<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

// Proses tambah mahasiswa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'tambah') {
    $npm = mysqli_real_escape_string($koneksi, $_POST['npm']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    $query = "INSERT INTO mahasiswa (npm, nama, jurusan) VALUES ('$npm', '$nama', '$jurusan')";
    if(mysqli_query($koneksi, $query)) {
        $success = true;
    } else {
        $error = true;
    }
}

// Proses edit mahasiswa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $npm_lama = mysqli_real_escape_string($koneksi, $_POST['npm_lama']);
    $npm_baru = mysqli_real_escape_string($koneksi, $_POST['npm']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    $query = "UPDATE mahasiswa SET npm = '$npm_baru', nama = '$nama', jurusan = '$jurusan' WHERE npm = '$npm_lama'";
    if(mysqli_query($koneksi, $query)) {
        $edit_success = true;
    } else {
        $edit_error = true;
    }
}

// Pagination
$limit = 30;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$where = '';
if($search) {
    $where = "WHERE npm LIKE '%$search%' OR nama LIKE '%$search%'";
}

$query = "SELECT * FROM mahasiswa $where ORDER BY npm LIMIT $start, $limit";
$result = mysqli_query($koneksi, $query);

// Get total records for pagination
$query_total = "SELECT COUNT(*) as total FROM mahasiswa $where";
$result_total = mysqli_query($koneksi, $query_total);
$total_records = mysqli_fetch_assoc($result_total)['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa - UNISKA</title>
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
                <li class="active">
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
                    <h2 class="mb-0 fw-bold">Daftar Mahasiswa</h2>
                    <button id="sidebarCollapse" class="btn btn-primary d-md-none">
                        <i class='bx bx-menu'></i>
                    </button>
                </div>

                <!-- Search and Action Buttons -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form action="" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Cari NPM/Nama..." value="<?php echo $search; ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-search'></i>
                                <span>Cari</span>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-success me-2" onclick="window.open('cetak_mahasiswa_pdf.php', '_blank')">
                            <i class='bx bxs-file-pdf'></i>
                            <span>Cetak PDF</span>
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahMahasiswa">
                            <i class='bx bx-plus'></i>
                            <span>Tambah Mahasiswa</span>
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="data-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-clickable">
                                <thead>
                                    <tr>
                                        <th>NPM</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr data-npm="<?php echo $row['npm']; ?>" 
                                        data-nama="<?php echo $row['nama']; ?>" 
                                        data-jurusan="<?php echo $row['jurusan']; ?>">
                                        <td><?php echo $row['npm']; ?></td>
                                        <td><?php echo $row['nama']; ?></td>
                                        <td><?php echo $row['jurusan']; ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if($total_pages > 1): ?>
                        <nav class="mt-4">
                            <ul class="pagination justify-content-center">
                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Mahasiswa -->
    <div class="modal fade" id="tambahMahasiswa" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class='bx bx-plus-circle me-2'></i>
                        Tambah Mahasiswa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="tambah">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NPM</label>
                            <input type="text" class="form-control" name="npm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <select class="form-select" name="jurusan" required>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Sistem Informasi">Sistem Informasi</option>
                                <!-- ... other options remain the same ... -->
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class='bx bx-x'></i>
                            <span>Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-save'></i>
                            <span>Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Mahasiswa -->
    <div class="modal fade" id="editMahasiswa" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class='bx bx-edit-alt me-2'></i>
                        Edit Mahasiswa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="npm_lama" id="edit-npm-lama">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NPM</label>
                            <input type="text" class="form-control" name="npm" id="edit-npm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" id="edit-nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jurusan</label>
                            <select class="form-select" name="jurusan" id="edit-jurusan" required>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Sistem Informasi">Sistem Informasi</option>
                                <option value="Teknik Elektro">Teknik Elektro</option>
                                <option value="Teknik Industri">Teknik Industri</option>
                                <option value="Teknik Mesin">Teknik Mesin</option>
                                <option value="Teknik Sipil">Teknik Sipil</option>
                                <option value="Ilmu Administrasi Publik">Ilmu Administrasi Publik</option>
                                <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
                                <option value="Bimbingan dan Konseling">Bimbingan dan Konseling</option>
                                <option value="Pendidikan Bahasa Inggris">Pendidikan Bahasa Inggris</option>
                                <option value="Pendidikan Olahraga">Pendidikan Olahraga</option>
                                <option value="Pendidikan Kimia">Pendidikan Kimia</option>
                                <option value="Manajemen">Manajemen</option>
                                <option value="Agribisnis">Agribisnis</option>
                                <option value="Peternakan">Peternakan</option>
                                <option value="Hukum Ekonomi Syariah (Muamalah)">Hukum Ekonomi Syariah (Muamalah)</option>
                                <option value="Pendidikan Guru Madrasah Ibtidaiyah">Pendidikan Guru Madrasah Ibtidaiyah</option>
                                <option value="Ekonomi Syariah">Ekonomi Syariah</option>
                                <option value="Kesehatan Masyarakat">Kesehatan Masyarakat</option>
                                <option value="Ilmu Hukum">Ilmu Hukum</option>
                                <option value="Farmasi">Farmasi</option>
                                <option value="Magister Ilmu Administrasi Publik">Magister Ilmu Administrasi Publik</option>
                                <option value="Magister Ilmu Komunikasi">Magister Ilmu Komunikasi</option>
                                <option value="Magister Manajemen">Magister Manajemen</option>
                                <option value="Magister Manajemen Pendidikan Tinggi">Magister Manajemen Pendidikan Tinggi</option>
                                <option value="Magister Peternakan">Magister Peternakan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class='bx bx-x'></i>
                            <span>Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-save'></i>
                            <span>Simpan</span>
                        </button>
                    </div>
                </form>
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

        // Row Click Handler for Edit
        document.querySelectorAll('.table-clickable tbody tr').forEach(row => {
            row.addEventListener('click', function() {
                const npm = this.dataset.npm;
                const nama = this.dataset.nama;
                const jurusan = this.dataset.jurusan;

                document.getElementById('edit-npm-lama').value = npm;
                document.getElementById('edit-npm').value = npm;
                document.getElementById('edit-nama').value = nama;
                document.getElementById('edit-jurusan').value = jurusan;

                var editModal = new bootstrap.Modal(document.getElementById('editMahasiswa'));
                editModal.show();
            });
        });

        // Success Alert
        <?php if(isset($success)): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data mahasiswa berhasil ditambahkan',
            timer: 1500,
            showConfirmButton: false
        }).then(function() {
            window.location.href = 'daftar_mahasiswa.php';
        });
        <?php endif; ?>

        // Edit Success Alert
        <?php if(isset($edit_success)): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data mahasiswa berhasil diubah',
            timer: 1500,
            showConfirmButton: false
        }).then(function() {
            window.location.href = 'daftar_mahasiswa.php';
        });
        <?php endif; ?>

        // Error Alert
        <?php if(isset($error)): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menambahkan data',
            timer: 1500,
            showConfirmButton: false
        });
        <?php endif; ?>

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