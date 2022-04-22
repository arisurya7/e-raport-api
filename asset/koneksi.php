<?php
//atur koneksi ke database
$host_db    = "localhost";
$user_db    = "root";
$pass_db    = "";
$nama_db    = "eraport";
$koneksi    = mysqli_connect($host_db,$user_db,$pass_db,$nama_db);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
// else{
//     echo "Connected successfully";
// }
?>