<?php
include 'db.php';

if (isset($_POST['kirim'])) {

    $nis = $_POST['nis'];
    $kategori = $_POST['id_kategori'];
    $lokasi = $_POST['lokasi'];
    $ket = $_POST['ket'];



    /* INSERT KE tb_input_aspirasi */
    mysqli_query($conn, "
        INSERT INTO tb_input_aspirasi (nis,id_kategori,lokasi,ket) 
        VALUES ('$nis','$kategori','$lokasi','$ket')
    ");

    /* ambil id pelaporan */
    $id_pelaporan = mysqli_insert_id($conn);

    /* INSERT STATUS */
    mysqli_query($conn, "
        INSERT INTO tb_aspirasi (status,id_pelaporan) 
        VALUES ('Menunggu','$id_pelaporan')
    ");

    echo "<script>
    alert('Aspirasi berhasil dikirim');
    window.location='aspirasi-siswa.php';
</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Input Aspirasi</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>

<body>

    <header>
        <div class="container">
            <h1>Aspirasi Siswa</h1>

            <ul>
                <li><a href="aspirasi-siswa.php">Kembali</a></li>
            </ul>

        </div>
    </header>

    <div class="section">
        <div class="container">

            <h3>Form Input Aspirasi</h3>

            <div class="box">

                <form method="POST">

                    <select name="nis" id="nis" class="input-control" required onchange="setKelas()">
                        <option value="">-- Pilih NIS --</option>

                        <?php
                        $siswa = mysqli_query($conn, "SELECT * FROM tb_siswa");
                        while ($s = mysqli_fetch_array($siswa)) {
                        ?>
                            <option value="<?= $s['nis'] ?>" data-kelas="<?= $s['kelas'] ?>">
                                <?= $s['nis'] ?> - <?= $s['kelas'] ?>
                            </option>
                        <?php } ?>
                    </select>


                    <select name="id_kategori" class="input-control" required>

                        <option value="">-- Pilih Kategori --</option>

                        <?php
                        $kat = mysqli_query($conn, "SELECT * FROM tb_kategori");
                        while ($k = mysqli_fetch_array($kat)) {
                        ?>

                            <option value="<?= $k['id_kategori'] ?>">
                                <?= $k['ket_kategori'] ?>
                            </option>

                        <?php } ?>

                    </select>

                    <input type="text" name="lokasi" placeholder="Lokasi" class="input-control" required>

                    <textarea name="ket" placeholder="Keterangan" class="input-control" required></textarea>

                    <input type="submit" name="kirim" value="Kirim Aspirasi" class="btn">

                </form>

            </div>

        </div>
    </div>

    <script>
        function setKelas() {
            var select = document.getElementById("nis");
            var kelas = select.options[select.selectedIndex].getAttribute("data-kelas");
            document.getElementById("kelas").value = kelas;
        }
    </script>

    

</body>

</html>