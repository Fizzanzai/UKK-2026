<?php
session_start();
include 'db.php';

/* ================= CEK LOGIN ================= */
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

/* ================= FILTER ================= */
$tgl1 = isset($_GET['tgl1']) ? $_GET['tgl1'] : '';
$tgl2 = isset($_GET['tgl2']) ? $_GET['tgl2'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$nis = isset($_GET['nis']) ? $_GET['nis'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';

$where = "";

if ($tgl1 && $tgl2) {
    $where .= " AND DATE(i.created_at) BETWEEN '$tgl1' AND '$tgl2'";
}

if ($kategori) {
    $where .= " AND i.id_kategori='$kategori'";
}

if ($nis) {
    $where .= " AND i.nis='$nis'";
}

if ($kelas) {
    $where .= " AND s.kelas='$kelas'";
}

if ($bulan) {
    $where .= " AND MONTH(i.created_at)='$bulan'";
}


/* ================= UPDATE ================= */
if (isset($_POST['update'])) {

    $status = $_POST['status'];
    $feedback = $_POST['feedback'];
    $id = $_POST['id'];

    mysqli_query($conn, "
        UPDATE tb_aspirasi 
        SET status='$status',
            feedback='$feedback'
        WHERE id_pelaporan='$id'
    ");

    echo "<script>window.location='aspirasi-admin.php'</script>";
}

/* ================= HAPUS ================= */
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    mysqli_query($conn, "DELETE FROM tb_aspirasi WHERE id_pelaporan='$id'");
    mysqli_query($conn, "DELETE FROM tb_input_aspirasi WHERE id_pelaporan='$id'");

    echo "<script>window.location='aspirasi-admin.php'</script>";
}

/* ================= QUERY ================= */
$query = mysqli_query($conn, "
SELECT i.*, a.status, a.feedback, k.ket_kategori, s.kelas
FROM tb_input_aspirasi i
JOIN tb_aspirasi a ON i.id_pelaporan = a.id_pelaporan
JOIN tb_kategori k ON i.id_kategori = k.id_kategori
JOIN tb_siswa s ON i.nis = s.nis
WHERE 1=1 $where
ORDER BY i.created_at DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manajemen Aspirasi</title>
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

            <h3>Filter Aspirasi</h3>

            <div class="box">
                <form method="GET" class="filter-box">

                    <!-- TANGGAL -->
                    <div class="filter-group">
                        <label>Dari Tanggal</label>
                        <input type="date" name="tgl1" value="<?= $tgl1 ?>" class="input-control kecil">
                    </div>

                    <div class="filter-group">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="tgl2" value="<?= $tgl2 ?>" class="input-control kecil">
                    </div>

                    <!-- KATEGORI -->
                    <div class="filter-group">
                        <label>Kategori</label>
                        <select name="kategori" class="input-control kecil">
                            <option value="">Semua</option>
                            <?php
                            $kat = mysqli_query($conn, "SELECT * FROM tb_kategori");
                            while ($k = mysqli_fetch_array($kat)) {
                            ?>
                                <option value="<?= $k['id_kategori'] ?>"
                                    <?= $kategori == $k['id_kategori'] ? 'selected' : '' ?>>
                                    <?= $k['ket_kategori'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- NIS -->
                    <div class="filter-group">
                        <label>NIS</label>
                        <select name="nis" class="input-control kecil">
                            <option value="">Semua</option>
                            <?php
                            $ns = mysqli_query($conn, "SELECT * FROM tb_siswa");
                            while ($n = mysqli_fetch_array($ns)) {
                            ?>
                                <option value="<?= $n['nis'] ?>"
                                    <?= $nis == $n['nis'] ? 'selected' : '' ?>>
                                    <?= $n['nis'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- KELAS -->
                    <div class="filter-group">
                        <label>Kelas</label>
                        <select name="kelas" class="input-control kecil">
                            <option value="">Semua</option>
                            <?php
                            $kl = mysqli_query($conn, "SELECT DISTINCT kelas FROM tb_siswa");
                            while ($kls = mysqli_fetch_array($kl)) {
                            ?>
                                <option value="<?= $kls['kelas'] ?>"
                                    <?= $kelas == $kls['kelas'] ? 'selected' : '' ?>>
                                    <?= $kls['kelas'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- BULAN -->
                    <div class="filter-group">
                        <label>Bulan</label>
                        <select name="bulan" class="input-control kecil">
                            <option value="">Semua</option>
                            <option value="1">Jan</option>
                            <option value="2">Feb</option>
                            <option value="3">Mar</option>
                            <option value="4">Apr</option>
                            <option value="5">Mei</option>
                            <option value="6">Jun</option>
                            <option value="7">Jul</option>
                            <option value="8">Agu</option>
                            <option value="9">Sep</option>
                            <option value="10">Okt</option>
                            <option value="11">Nov</option>
                            <option value="12">Des</option>
                        </select>
                    </div>

                    <!-- BUTTON -->
                    <div class="filter-full">
                        <button type="submit" class="btn">Filter</button>
                        <a href="aspirasi-admin.php" class="btn-reset">Reset</a>
                    </div>

                </form>
            </div>

            <h3>Keluhan & Saran Siswa</h3>

            <!-- TABLE -->
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
                        <th>Tanggal & Waktu</th>
                        <th>Aksi</th>
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


                            <form method="POST">

                                <td>
                                    <span class="badge 
                                        <?= $row['status'] == 'Menunggu' ? 'badge-merah' : '' ?>
                                        <?= $row['status'] == 'Proses' ? 'badge-kuning' : '' ?>
                                        <?= $row['status'] == 'Selesai' ? 'badge-hijau' : '' ?>
                                    ">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>

                                <td>
                                    <?= date("d-m-Y H:i:s", strtotime($row['created_at'])) ?>
                                </td>

                                <td>
                                    <a href="balas-aspirasi.php?id=<?= $row['id_pelaporan'] ?>"
                                        class="btn-aksi btn-view">Balas</a>

                                    <br><br>
                                
                                    <a href="?hapus=<?= $row['id_pelaporan'] ?>"
                                        onclick="return confirm('Yakin hapus?')"
                                        class="btn-aksi btn-hapus">Hapus</a>
                                </td>

                            </form>

                        </tr>

                    <?php } ?>

                </table>

            </div>

        </div>
    </div>

</body>

</html>