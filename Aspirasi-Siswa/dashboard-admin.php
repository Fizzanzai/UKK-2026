<?php
session_start();
include 'db.php';

if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

$recent = mysqli_query($conn, "
    SELECT i.*, a.status, k.ket_kategori, s.kelas
    FROM tb_input_aspirasi i
    JOIN tb_aspirasi a ON i.id_pelaporan = a.id_pelaporan
    JOIN tb_kategori k ON i.id_kategori = k.id_kategori
    JOIN tb_siswa s ON i.nis = s.nis
    ORDER BY i.created_at DESC
    LIMIT 5
");

/* ================= HITUNG DATA ================= */

$total = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM tb_input_aspirasi
"))['total'];

$menunggu = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM tb_input_aspirasi i
    JOIN tb_aspirasi a ON i.id_pelaporan = a.id_pelaporan
    WHERE a.status='Menunggu'
"))['total'];

$proses = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM tb_input_aspirasi i
    JOIN tb_aspirasi a ON i.id_pelaporan = a.id_pelaporan
    WHERE a.status='Proses'
"))['total'];

$selesai = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM tb_input_aspirasi i
    JOIN tb_aspirasi a ON i.id_pelaporan = a.id_pelaporan
    WHERE a.status='Selesai'
"))['total'];



?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>

<body>

    <header>
        <div class="container">
            <h1>Admin Aspirasi</h1>
            <ul>
                <li><a href="dashboard-admin.php">Dashboard</a></li>
                <li><a href="siswa-admin.php">Siswa</a></li>
                <li><a href="kategori-admin.php">Kategori</a></li>
                <li><a href="aspirasi-admin.php">Aspirasi</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <div class="section">
        <div class="container">
            <h3>Dashboard</h3>



            <div class="box">
                <div class="card-container">

                    <div class="card card-biru">
                        <h4>Total Aspirasi</h4>
                        <h2><?= $total ?></h2>
                    </div>

                    <div class="card card-merah">
                        <h4>Menunggu</h4>
                        <h2><?= $menunggu ?></h2>
                    </div>

                    <div class="card card-kuning">
                        <h4>Proses</h4>
                        <h2><?= $proses ?></h2>
                    </div>

                    <div class="card card-hijau">
                        <h4>Selesai</h4>
                        <h2><?= $selesai ?></h2>
                    </div>

                </div>
            </div>

            <h3>Aspirasi Terbaru</h3>

            <div class="box">
                <table border="1" class="table-center">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Laporan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_array($recent)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            
                            <td><?= $row['nis'] ?></td>
                            <td><?= $row['kelas'] ?></td>
                            <td><?= $row['ket_kategori'] ?></td>
                            <td><?= $row['lokasi'] ?></td>
                            <td><?= $row['ket'] ?></td>
                            <td>
                                <span class="badge 
                                        <?= $row['status'] == 'Menunggu' ? 'badge-merah' : '' ?>
                                        <?= $row['status'] == 'Proses' ? 'badge-kuning' : '' ?>
                                        <?= $row['status'] == 'Selesai' ? 'badge-hijau' : '' ?>
                                    ">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                            <td><?= date("d-m-Y H:i", strtotime($row['created_at'])) ?></td>
                        </tr>
                    <?php } ?>

                </table>
                <br>
                <a href="aspirasi-admin.php" class="btn">Lihat Semua</a>
            </div>



        </div>
    </div>

</body>

</html>