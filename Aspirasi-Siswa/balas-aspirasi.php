<?php
session_start();
include 'db.php';

$id = $_GET['id'];

/* AMBIL DATA */
$data = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT i.*, a.status, a.feedback
    FROM tb_input_aspirasi i
    JOIN tb_aspirasi a ON i.id_pelaporan = a.id_pelaporan
    WHERE i.id_pelaporan='$id'
"));

/* UPDATE */
if (isset($_POST['simpan'])) {
    $status = $_POST['status'];
    $feedback = $_POST['feedback'];

    mysqli_query($conn, "
        UPDATE tb_aspirasi 
        SET status='$status',
            feedback='$feedback'
        WHERE id_pelaporan='$id'
    ");

    echo "<script>
        alert('Berhasil diupdate');
        window.location='aspirasi-admin.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Balas Aspirasi</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>

<body>

    <header>
        <div class="container">
            <h1>Balas Aspirasi</h1>
            <ul>
                <li><a href="aspirasi-admin.php">Kembali</a></li>

            </ul>
        </div>
    </header>

    <div class="section">
        <div class="container">

            <div class="box">
                <h3 style="margin-bottom:10px;">Detail Aspirasi</h3>
                <form method="POST">

                    <div class="detail-box">
                        <div class="detail-row">
                            <span class="label">NIS</span>
                            <span class="value"><?= $data['nis'] ?></span>
                        </div>

                        <div class="detail-row">
                            <span class="label">Lokasi</span>
                            <span class="value"><?= $data['lokasi'] ?></span>
                        </div>

                        <div class="detail-row">
                            <span class="label">Keterangan</span>
                            <span class="value"><?= $data['ket'] ?></span>
                        </div>
                    </div>



                    <label>Status</label>
                    <select name="status" class="input-control" required>
                        <option value="Menunggu" <?= $data['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="Proses" <?= $data['status'] == 'Proses' ? 'selected' : '' ?>>Proses</option>
                        <option value="Selesai" <?= $data['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>

                    <label>Penyelesaian</label>
                    <textarea name="feedback" class="input-control"><?= $data['feedback'] ?></textarea>

                    <br>

                    <button type="submit" name="simpan" class="btn">Simpan</button>

                </form>

            </div>

        </div>
    </div>

</body>

</html>