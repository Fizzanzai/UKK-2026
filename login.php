<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = md5($_POST['password']); // enkripsi md5

    $cek = mysqli_query($conn, "
        SELECT * FROM tb_admin 
        WHERE username='$username' 
        AND password='$password'
    ");

    if (mysqli_num_rows($cek) > 0) {

        $data = mysqli_fetch_object($cek);

        $_SESSION['status_login'] = true;
        $_SESSION['admin'] = $data;

        echo "<script>window.location='dashboard-admin.php'</script>";

    } else {
        echo "<script>alert('Login gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body id="bd-login">

<div class="box-login">
    <h2>Login Admin</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" class="input-control" required>
        <input type="password" name="password" placeholder="Password" class="input-control" required>
        <input type="submit" name="login" value="Login" class="btn">
    </form>
</div>

</body>
</html>