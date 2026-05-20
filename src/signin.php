<?php
require('config/database.php');

$e_mail  = $_POST['email'];
$p_sword = $_POST['pswd'];

$sql = "SELECT * FROM users WHERE email = '$e_mail'";
$res = pg_query($local_conn, $sql);

if ($res && pg_num_rows($res) > 0) {
    $user = pg_fetch_assoc($res);
    if (password_verify($p_sword, $user['password'])) {
        header('Location: index.html');
        exit();
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.location='login.html';</script>";
    }
} else {
    echo "<script>alert('Usuario no encontrado'); window.location='login.html';</script>";
}
?>