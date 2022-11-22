<?php
require("koneksi.php");

$hub = open_connection();
if ($hub){
     echo ("Koneksi Berhasil :)");
} else {
    echo("Koneksi Gagal!!!!");
}

mysqli_close($hub);
?>