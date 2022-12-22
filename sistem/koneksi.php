<?php 
 function open_connection(){
    $hostname = "localhost";
    $username="root";
    $passwoard="";
    $dbname="db_akademik";
    return $pdo = new PDO("mysql:hostname=$hostname;dbname=$dbname", $username, $passwoard, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
 }
?>