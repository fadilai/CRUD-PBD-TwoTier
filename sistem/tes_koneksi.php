<?php
require("koneksi.php");

$pdo = open_connection();
if ($pdo){
     echo ("Koneksi Berhasil :)");
} else {
    echo("Koneksi Gagal!!!!");
}

?>