<?php
include 'db.php';

$total = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM tb_input_aspirasi
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

/* LANGSUNG AMBIL SEMUA DATA */
$query = mysqli_query($conn, "
    SELECT i.*, a.status, a.feedback, k.ket_kategori, s.kelas
    FROM tb_input_aspirasi i
    JOIN tb_aspirasi a ON i.id_pelaporan = a.id_pelaporan
    JOIN tb_kategori k ON i.id_kategori = k.id_kategori
    JOIN tb_siswa s ON i.nis = s.nis
    ORDER BY i.created_at DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Aspirasi Siswa</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>

<body>

    <header>
        <div class="container">
            <h1>Aspirasi Siswa</h1>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="aspirasi-siswa.php">Aspirasi</a></li>
                <li><a href="login.php">Login Admin</a></li>
            </ul>
        </div>
    </header>

    <div class="section">
        <div class="container">

            <h3>Semua Data Aspirasi</h3>

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


            <div class="box">
                <a href="kirim-aspirasi.php" class="btn-submit">+ Kirim Aspirasi</a>
                <br><br>
                <table border="1" class="table-center">

                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Penyelesaian</th>
                        <th>Dikirim</th>
                    </tr>

                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
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
                            <td><?= $row['feedback'] ?></td>
                            <td><?= date("d-m-Y H:i:s", strtotime($row['created_at'])) ?></td>
                        </tr>
                    <?php } ?>

                </table>
            </div>

        </div>
    </div>

<!-- FOOTER -->
    <footer>
        <small>© 2026 - Aspirasi Siswa</small>
    </footer>
</body>

</html>