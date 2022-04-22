<?php 
session_start();
if(!isset($_SESSION['session_username'])){
    header("location:login.php");
    exit();
}
error_reporting(0);
	
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>siswa diri siswa</title>
</head>
<body>
<!-- As a heading -->
    <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">SIRAM</span>
        <a class="btn btn-danger" href="logout.php" role="button">keluar</a>
    </div>
    </nav>
    <div class="container">
        <table class="table-primary">
            <tr class="table-primary">
                <td class="table-primary">Nama</td>
                <?php
                    $siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE username = '$_SESSION[session_username]'");
                    $tampil = mysqli_fetch_array($siswa);
                    echo "<td class='table-primary'>: $tampil[nama_siswa]</td>";
                ?>
            </tr>
            <tr class="table-primary">
                <td class="table-primary">NISN</td>
                <?php
                    echo "<td class='table-primary'>: $tampil[nisn]</td>";
                ?>
            </tr>
            <tr class="table-primary">
                <td class="table-primary">NIS</td>
                <?php
                    echo "<td class='table-primary'>: $tampil[nis]</td>";
                ?>
            </tr>
            <tr class="table-primary">
                <td class="table-primary">sekolah</td>
                <?php
                    $sekolah = mysqli_query($koneksi, "SELECT * FROM sekolah WHERE id_sekolah = '$tampil[id_sekolah]'");
                    $tampil_sekolah = mysqli_fetch_array($sekolah);
                    echo "<td class='table-primary'>: $tampil_sekolah[nama_sekolah]</td>";
                ?>
            </tr>
            <tr class="table-primary">
                <td class="table-primary">kelas</td>
                <?php
                    echo "<td class='table-primary'>: $tampil[kelas]</td>";
                ?>
            </tr>
            <tr class="table-primary">
                <td class="table-primary">semester</td>
                <?php
                    echo "<td class='table-primary'>: $tampil[semester]</td>";
                ?>
            </tr>
            <tr class="table-primary">
                <td class="table-primary">tahun ajaran</td>
                <?php
                    echo "<td class='table-primary'>: $tampil[tahun_ajaran]</td>";
                ?>
            </tr>
        </table>
        <br>
        <h3>Nilai sikap & spiritual</h3>
        <table class="table table-striped">
            <tr class="table-light">
                <th class="table-light" width="150px">sikap sosial</th>
                <?php
                    $deskripsi_sosial = mysqli_query($koneksi, "SELECT deskripsi FROM sikap_sosial WHERE id_siswa = '$tampil[id_siswa]'");
                    $tampil_sosial = mysqli_fetch_array($deskripsi_sosial);
                    echo "<td class='table-light'>: $tampil_sosial[deskripsi]</td>";
                ?>
            </tr>
            <tr class="table-light">
                <th class="table-light" width="150px">sikap spiritual</th>
                <?php
                    $deskripsi_spiritual = mysqli_query($koneksi, "SELECT deskripsi FROM sikap_spiritual WHERE id_siswa = '$tampil[id_siswa]'");
                    $tampil_spiritual = mysqli_fetch_array($deskripsi_spiritual);
                    echo "<td class='table-light'>: $tampil_spiritual[deskripsi]</td>";
                ?>
            </tr>
        </table>
        <h3>Nilai Mata pelajaran</h3>
        <table class="table table-primary" style=" text-align: center; vertical-align: middle;">
            <tr class="table-primary">
                <th class="table-primary">Nama MAPEL</th>
                <th class="table-primary">Nilai Pengetahuan</th>
                <th class="table-primary">Predikat Pengetahuan</th>
                <th class="table-primary">Keterangan Pengetahuan</th>
                <th class="table-primary">Nilai Keterampilan</th>
                <th class="table-primary">Predikat Keterampilan</th>
                <th class="table-primary">Keterangan keterampilan</th>
            </tr>

                <?php
                    $qri = "SELECT * FROM mapel 
                            LEFT JOIN final_nilai_pengetahuan ON mapel.id_mapel = final_nilai_pengetahuan.id_mapel 
                            WHERE is_mulok = 0 AND id_siswa = '$tampil[id_siswa]'";
                    $mapel = mysqli_query($koneksi,$qri);
                    $qri = "SELECT * FROM mapel 
                            LEFT JOIN final_nilai_pengetahuan ON mapel.id_mapel = final_nilai_pengetahuan.id_mapel 
                            WHERE is_mulok = 0 AND id_siswa = '$tampil[id_siswa]'";
                    $keterampilan = mysqli_query($koneksi,$qri);
                    $tampil_keterampilan = mysqli_fetch_array($keterampilan);
                    while ($tampil_mapel = mysqli_fetch_array($mapel)){
                ?>         
                        <tr class="table-primary">
                            <td class="table-primary"><?=$tampil_mapel['nama_mapel']?></td>
                            <td class="table-primary"><?=$tampil_mapel['nilai_akhir']?></td>
                            <td class="table-primary"><?=$tampil_mapel['predikat']?></td>
                            <td class="table-primary"><?=$tampil_mapel['deskripsi']?></td>
                            <td class="table-primary"><?=$tampil_keterampilan['nilai_akhir']?></td>
                            <td class="table-primary"><?=$tampil_keterampilan['predikat']?></td>
                            <td class="table-primary"><?=$tampil_keterampilan['deskripsi']?></td>
                        </tr>
                <?php } ?>
        </table>
        <h3>Nilai Mata pelajaran (MULOK)</h3>
        <table class="table table-primary" style=" text-align: center; vertical-align: middle;">
            <tr class="table-primary">
                <th class="table-primary">Nama MAPEL</th>
                <th class="table-primary">Nilai Pengetahuan</th>
                <th class="table-primary">Predikat Pengetahuan</th>
                <th class="table-primary">Keterangan Pengetahuan</th>
                <th class="table-primary">Nilai Keterampilan</th>
                <th class="table-primary">Predikat Keterampilan</th>
                <th class="table-primary">Keterangan keterampilan</th>
            </tr>

                <?php
                    $qri = "SELECT * FROM mapel 
                            LEFT JOIN final_nilai_pengetahuan ON mapel.id_mapel = final_nilai_pengetahuan.id_mapel 
                            WHERE is_mulok = 1 AND id_siswa = '$tampil[id_siswa]'";
                    $mapel = mysqli_query($koneksi,$qri);
                    while ($tampil_mapel = mysqli_fetch_array($mapel)){
                ?>         
                        <tr class="table-primary">
                            <td class="table-primary"><?=$tampil_mapel['nama_mapel']?></td>
                            <td class="table-primary"><?=$tampil_mapel['nilai_akhir']?></td>
                            <td class="table-primary"><?=$tampil_mapel['predikat']?></td>
                            <td class="table-primary"><?=$tampil_mapel['deskripsi']?></td>
                            <td class="table-primary">tes</td>
                            <td class="table-primary"></td>
                            <td class="table-primary"></td>
                        </tr>
                <?php } ?>
        </table>
    </div>
</body>
</html>