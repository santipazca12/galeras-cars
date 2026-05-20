<?php
include('../config/database.php');

// ── Recibir datos del formulario ─────────────────────────────────
$f_name  = trim($_POST['fname']);
$l_name  = trim($_POST['lname']);
$e_mail  = trim($_POST['email']);
$m_phone = trim($_POST['mphone']);
$p_sswd  = $_POST['password'];
$p_conf  = $_POST['password_confirm'];

// ── Feature1: Validar email único ────────────────────────────────
$res_email = pg_query_params($local_conn,
    "SELECT id FROM users WHERE email = $1", [$e_mail]);
if (pg_num_rows($res_email) > 0) {
    die("Error: el correo '$e_mail' ya está registrado. Por favor use uno diferente.");
}

// ── Feature2: Validar teléfono único ─────────────────────────────
$res_phone = pg_query_params($local_conn,
    "SELECT id FROM users WHERE mobile_phone = $1", [$m_phone]);
if (pg_num_rows($res_phone) > 0) {
    die("Error: el teléfono '$m_phone' ya está registrado. Por favor use uno diferente.");
}

// ── Validar que las contraseñas coincidan ────────────────────────
if ($p_sswd !== $p_conf) {
    die("Error: las contraseñas no coinciden.");
}

// ── Feature4: Encriptar contraseña con bcrypt ────────────────────
//$enc_pass = password_hash($p_sswd, PASSWORD_BCRYPT);
$enc_pass = md5($p_asswd);//inportante

$sql    = "INSERT INTO users (firstname, lastname, email, mobile_phone, password)
           VALUES ($1, $2, $3, $4, $5)";
$params = [$f_name, $l_name, $e_mail, $m_phone, $enc_pass];

// ── Feature3: Registro atómico local + Supabase ──────────────────
pg_query($local_conn, "BEGIN");

$res_local = pg_query_params($local_conn, $sql, $params);

if (!$res_local) {
    pg_query($local_conn, "ROLLBACK");
    die("Error: no se pudo registrar el usuario en la base de datos local.");
}

$res_supa = pg_query_params($supa_conn, $sql, $params);

if (!$res_supa) {
    pg_query($local_conn, "ROLLBACK");
    die("Error: no se pudo guardar en Supabase. El registro fue cancelado para mantener consistencia.");
}

pg_query($local_conn, "COMMIT");

echo "¡Registro exitoso! Usuario guardado correctamente en ambas bases de datos.";
header('refresh:2;url=login.html');
?>