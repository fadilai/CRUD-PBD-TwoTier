<?php 
 function open_connection(){
    $hostname = "localhost";
    $username="root";
    $passwoard="";
    $dbname="db_akademik";
    $koneksi= mysqli_connect($hostname,$username,$passwoard,$dbname);
    return $koneksi;
 }
?>