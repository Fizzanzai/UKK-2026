<?php
session_start();
include 'db.php';

if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

$nis_filter = isset($_GET['nis']) ? $_GET['nis'] : '';
$kelas_filter = isset($_GET['kelas']) ? $_GET['kelas'] : '';

$where = "";
if ($nis_filter) {
    $where .= " AND nis='$nis_filter'";
}
if ($kelas_filter) {
    $where .= " AND kelas='$kelas_filter'";
}

/* TAMBAH SISWA */
if (isset($_POST['tambah'])) {

    $nis = $_POST['nis'];
    $kelas = $_POST['kelas'];

    // CEK NIS SUDAH ADA ATAU BELUM
    $cek = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nis='$nis'");

    if (mysqli_num_rows($cek) > 0) {

        // JIKA SUDAH ADA
        echo "<script>alert('NIS sudah terdaftar!');</script>";

    } else {

        // JIKA BELUM ADA
        mysqli_query($conn, "
            INSERT INTO tb_siswa (nis, kelas)
            VALUES ('$nis', '$kelas')
        ");

        echo "<script>
            alert('Siswa berhasil ditambahkan');
            window.location='siswa-admin.php';
        </script>";
    }
}

/* HAPUS */
if (isset($_GET['hapus'])) {
    $nis = $_GET['hapus'];

    // ambil semua id pelaporan milik siswa
    $q = mysqli_query($conn, "SELECT id_pelaporan FROM tb_input_aspirasi WHERE nis='$nis'");

    while ($d = mysqli_fetch_array($q)) {
        $id = $d['id_pelaporan'];

        // hapus dari tb_aspirasi
        mysqli_query($conn, "DELETE FROM tb_aspirasi WHERE id_pelaporan='$id'");
    }

    // hapus semua input aspirasi
    mysqli_query($conn, "DELETE FROM tb_input_aspirasi WHERE nis='$nis'");

    // hapus siswa
    mysqli_query($conn, "DELETE FROM tb_siswa WHERE nis='$nis'");

    echo "<script>
        alert('Siswa dan semua aspirasinya berhasil dihapus');
        window.location='siswa-admin.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Siswa</title>
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


            <h3>Tambah Siswa</h3>

            <div class="box">
                <form method="POST">
                    <input type="number" name="nis" placeholder="NIS" class="input-control" required>
                    <input type="text" name="kelas" placeholder="Kelas" class="input-control" required>
                    <input type="submit" name="tambah" value="Tambah Siswa" class="btn">
                </form>
            </div>

            <h3>Filter</h3>

            <!-- FILTER -->
            <div class="box">
                <form method="GET">
                    <select name="kelas" class="input-control">
                        <option value="">-- Semua Kelas --</option>
                        <?php
                        $kl = mysqli_query($conn, "SELECT DISTINCT kelas FROM tb_siswa");
                        while ($kls = mysqli_fetch_array($kl)) {
                        ?>
                            <option value="<?= $kls['kelas'] ?>"
                                <?= $kelas_filter == $kls['kelas'] ? 'selected' : '' ?>>
                                <?= $kls['kelas'] ?>
                            </option>
                        <?php } ?>
                    </select>

                    <input type="submit" value="Filter" class="btn">
                    <a href="siswa.php" class="btn-reset">Reset</a>

                </form>
            </div>

            <h3>Daftar Siswa</h3>

            <div class="box">
                <table border="1" class="table-center">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>

                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE 1=1 $where");
                        $no = 1;
                        while ($r = mysqli_fetch_array($q)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $r['nis'] ?></td>
                            <td><?= $r['kelas'] ?></td>
                            <td>
                                <a href="?hapus=<?= $r['nis'] ?>"
                                    onclick="return confirm('Yakin hapus siswa?') && confirm('PERINGATAN! Semua aspirasi dari siswa ini akan ikut terhapus!')"
                                    class="btn-aksi btn-hapus">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

        </div>
    </div>

</body>

</html>