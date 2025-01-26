<?php 
include 'koneksi.php';
session_start();

// Proses form jika ada POST request 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $npm = mysqli_real_escape_string($koneksi, $_POST['npm']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);

    // Cek apakah ini admin yang login
    $query_admin = "SELECT a.* FROM admin a 
                   WHERE a.nama = '$npm' AND a.password = '$nama'";
    $result_admin = mysqli_query($koneksi, $query_admin);

    if(mysqli_num_rows($result_admin) > 0) {
        // Jika login sebagai admin
        $admin = mysqli_fetch_assoc($result_admin);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nama'] = $admin['nama'];
        
        $status = "success_admin";
        $message = "Login Admin Berhasil!";
    } else {
        // Jika bukan admin, cek sebagai mahasiswa
        $query = "SELECT * FROM mahasiswa WHERE npm = '$npm' AND nama = '$nama'";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            // Mahasiswa terdaftar, simpan absensi
            $mahasiswa = mysqli_fetch_assoc($result);
            $mahasiswa_id = $mahasiswa['id'];
            
            $query_absensi = "INSERT INTO absensi (mahasiswa_id, tanggal, waktu) 
                             VALUES ('$mahasiswa_id', CURDATE(), CURTIME())";
            mysqli_query($koneksi, $query_absensi);
            
            $status = "success";
            $message = "Absensi berhasil tercatat";
        } else {
            $status = "error";
            $message = "NPM atau Nama tidak valid";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Perpustakaan UNISKA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card absensi-card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="IMG/logo-uniska.png" alt="UNISKA Logo" class="logo-img">
                            <h2 class="mt-3">Absensi Perpustakaan</h2>
                            <p class="text-muted">Universitas Islam Kalimantan</p>
                        </div>
                        <form method="POST">
                            <div class="form-group mb-3">
                                <label for="npm" class="form-label">NPM Mahasiswa</label>
                                <input type="text" class="form-control" id="npm" name="npm" required 
                                       placeholder="Masukkan NPM">
                            </div>
                            <div class="form-group mb-4">
                                <label for="nama" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" id="nama" name="nama" required 
                                       placeholder="Masukkan Nama">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if(isset($status)): ?>
    <script>
        Swal.fire({
            position: 'center',
            icon: '<?php echo $status == "success_admin" ? "success" : $status; ?>',
            title: '<?php echo $message; ?>',
            showConfirmButton: false,
            timer: 3000,
            background: '#e8f5e9',
            iconColor: '<?php echo $status == "error" ? "#f44336" : "#4CAF50"; ?>',
            titleColor: '#2e7d32'
        }).then(function() {
            <?php if($status == "success_admin"): ?>
                window.location.href = 'admin/dashboard.php';
            <?php else: ?>
                window.location.href = 'index.php';
            <?php endif; ?>
        });
    </script>
    <?php endif; ?>
</body>
</html>