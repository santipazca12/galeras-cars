<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('refresh:0;url=index.html');
    exit();
}
//database connection
require('config/database.php');
//get data from form
$e_mail  = $_POST['email'];
$p_sword = $_POST['pswd'];
$enc_pass = md5($p_sword);

$sql = "SELECT * FROM users WHERE email = '$e_mail'";
$res = pg_query($local_conn, $sql);

if ($res){
    $num = pg_num_rows($res);
    $row = pg_fetch_assoc();
    if ($pg_num_rows($res) > 0){
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_name'] = $row['firstname'];
        $user = pg_fetch_assoc($res);
        if (password_verify($p_sword, $user['password'])) {
            header('Location: index.html');
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta')</script>";
                header('refresh:0;url=login.html');
        }
    } else {
        echo "<script>alert('Usuario no encontrado')</script>";
        header('refresh:0;url=login.html');
    }
}else{
    echo "<script>alert('Error en la consulta')</script>";
    header('refresh:0;url=login.html');
}

/*
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
}*/

/*//execute query
$res = pg_query($sql_login);
if ($res){
$num =pg_num_rows($res);
$row = $res->$fetch_assoc();
if ($num > 0){
    $_SESSION['user_id']

$}*/
?>