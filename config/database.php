<?php
//databace configuration

//local database configuration
$local_host     = 'localhost'; //127.0.0.1
$local_dbname   = 'app_beta';
$local_username = 'postgres';
$local_password = '@CTra^s5xc!zG';
$local_port     = '5432';
//supabase database configuration
$supa_host      = 'aws-1-us-east-1.pooler.supabase.com';
$supa_dbname    = 'postgres';
$supa_username  = "postgres.usqcmlgwktafkcslajdk";
$supa_password  = "UNICESMAG69";
$supa_port      = "6543";

$local_data_connection ="
host = $local_host
dbname = $local_dbname
user = $local_username
password = $local_password
port = $local_port
";
$supa_data_connection ="
host = $supa_host
dbname = $supa_dbname
user = $supa_username
password = $supa_password
port = $supa_port";
//connection

//local connection
$local_conn = pg_connect($local_data_connection);
if(!$local_conn)
{
    echo "Error: unable to connect to Local database.";
    exit();
}else
{
    echo" Local Success connection !!!";
}
//supa connection
$supa_conn = pg_connect($supa_data_connection);

if(!$supa_conn)
{
    echo "Error: unable to connect to supabase database.";
    exit();
}else
{
    echo" supabase Success connection !!!";
}
?>