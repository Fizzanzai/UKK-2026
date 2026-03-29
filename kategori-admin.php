<?php
session_start();
include 'db.php';

if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

/* ===== TAMBAH KATEGORI ===== */
if (isset($_POST['tambah'])) {
    $nama = $_POST['kategori'];

    // CEK KATEGORI SUDAH ADA ATAU BELUM
    $cek = mysqli_query($conn, "
        SELECT * FROM tb_kategori 
        WHERE ket_kategori='$nama'
    ");

    if (mysqli_num_rows($cek) > 0) {

        // JIKA SUDAH ADA
        echo "<script>alert('Kategori sudah ada!');</script>";

    } else {

        // JIKA BELUM ADA
        mysqli_query($conn, "
            INSERT INTO tb_kategori (ket_kategori)
            VALUES ('$nama')
        ");

        echo "<script>
            alert('Kategori berhasil ditambahkan');
            window.location='kategori-admin.php';
        </script>";
    }
}

/* ===== HAPUS ===== */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // ambil semua id pelaporan berdasarkan kategori
    $q = mysqli_query($conn, "
        SELECT id_pelaporan 
        FROM tb_input_aspirasi 
        WHERE id_kategori='$id'
    ");

    while ($d = mysqli_fetch_array($q)) {
        $id_pelaporan = $d['id_pelaporan'];

        // hapus dari tb_aspirasi
        mysqli_query($conn, "
            DELETE FROM tb_aspirasi 
            WHERE id_pelaporan='$id_pelaporan'
        ");
    }

    // hapus dari input aspirasi
    mysqli_query($conn, "
        DELETE FROM tb_input_aspirasi 
        WHERE id_kategori='$id'
    ");

    // hapus kategori
    mysqli_query($conn, "
        DELETE FROM tb_kategori 
        WHERE id_kategori='$id'
    ");

    echo "<script>
        alert('Kategori dan semua aspirasi terkait berhasil dihapus');
        window.location='kategori-admin.php';
    </script>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kategori</title>
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

            <h3>Tambah Kategori</h3>

            <div class="box">
                <form method="POST">
                    <input type="text" name="kategori" placeholder="Nama Kategori" class="input-control" required>
                    <input type="submit" name="tambah" value="Tambah" class="btn">
                </form>
            </div>

            <h3>Daftar Kategori</h3>

            <div class="box">
                <table border="1" class="table-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>

                    <?php
                    $no = 1;
                    $q = mysqli_query($conn, "SELECT * FROM tb_kategori");
                    while ($r = mysqli_fetch_array($q)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $r['ket_kategori'] ?></td>
                            <td>
                                <a href="?hapus=<?= $r['id_kategori'] ?>"
                                    onclick="return confirm('Yakin hapus kategori?') && confirm('PERINGATAN! Semua aspirasi dengan kategori ini akan ikut terhapus!')"
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