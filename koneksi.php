<?php
 
$user_name = "postgres";
$password = "master";
$database = "pjunew";
$host_name = "192.168.99.194"; 
$port="5432";
 
//mysql_connect($host_name, $user_name, $password);
$db = pg_connect("host='$host_name' port='$port' dbname='$database' user='$user_name' password='$password'");
 /* if ($db) // Jika Ada Koneksi
    {
        echo "Koneksi Database Sukses";
    }
    else
    {
        echo "Koneksi Database Gagal";
    } */
?>