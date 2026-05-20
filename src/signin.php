<?php 
//database connection
require('../config/database.php');
//get data from login form
$e_mail =$_POST['email'];
$p_asswd = $_POST['pswd'];
$enc_pass = md5($p_asswd);
//query 
$sql_login = "SELECT u.* FROM users  u WHERE u.email = '$e_mail' AND u.password = '$enc_pass'";

//execute query
$res = pg_query($sql_login);

if($res){
    $tnum= pg_num_rows($res);
    if($tnum > 0){
        header('refresh:0;url=index.html');
    }
}else{
    echo "<script>alert('Email or password not found')</script>";
    header('refresh:0;url=login.html');
}else{
    echo "query error: ".pg_last_error();
}

?>
