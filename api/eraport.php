<?php

$connect = mysqli_connect('localhost', 'root', '', 'eraport');

if(function_exists($_GET['function'])) {
    $_GET['function']();
 }   

 //LOGIN
 function loginUser(){
    global $connect;

    $check = array('username'=>'', 'password'=>'');
    $check_match = count(array_intersect_key($_POST, $check));

    if($check_match == count($check)){

        $user=[];
        $query = mysqli_query($connect, "SELECT user.id_user AS id_user, user.id_sekolah AS id_sekolah, user.email AS email, user.username AS username, user.password AS 'password', user.firstname AS firstname, user.lastname AS lastname, user.role AS 'role', sekolah.nama_sekolah AS nama_sekolah, sekolah.alamat AS alamat FROM user JOIN sekolah USING (id_sekolah) WHERE user.username= '$_POST[username]' AND user.password= '$_POST[password]'");
        while ($result = mysqli_fetch_object($query)){
            $user[] = $result;
        }
       
        if($user){
            $response = array(
                'status'=>1,
                'message'=>'Login Success',
                'user'=>$user
            );
        }else{
            $response = array(
                'status'=>0,
                'message'=>'Login Failed.'
            );
        }
    } else{
        $response = array(
            'status'=>0,
            'message'=>'Wrong Parameter'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function updateUser(){
    global $connect;

    parse_str(file_get_contents('php://input'), $value);

    $check = array('id_user'=>'', 'id_sekolah'=>'', 'email'=>'', 'username'=>'','password'=>'', 'firstname'=>'', 'lastname'=>'', 'role'=>'');
    $check_match = count(array_intersect_key($value, $value));

    if($check_match == count($check)){
        //Update data
        $result = mysqli_query($connect, "UPDATE `user` SET
        `id_user`= $value[id_user],
        `id_sekolah`= $value[id_sekolah],
        `email`= '$value[email]',
        `username`= '$value[username]',
        `password`= '$value[password]',
        `firstname`= '$value[firstname]',
        `lastname`= '$value[lastname]',
        `role`= '$value[role]'
        WHERE
        `id_user` = $value[id_user]
        ");

        if($result){
            $response = array(
                'status'=>1,
                'message'=>'Success Update'
            );
        }else{
            $response = array(
                'status'=>0,
                'message'=>'Failed Update.'
            );
        }

    } else{
        $response = array(
            'status'=>0,
            'message'=>'Wrong Parameter'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);


}

//SEKOLAH
function getAllSekolah(){
    global $connect;

    if(!mysqli_connect_error()){
        $query = mysqli_query($connect, "SELECT * FROM sekolah");
        if(mysqli_num_rows($query)>0){
            while ($result = mysqli_fetch_object($query)){
                $sekolah[] = $result;
            }
    
            $response = array(
                'status' =>1,
                'message'=>'Success',
                'sekolah'=>$sekolah
            );
    
            header('Content-Type: application/json');
            echo json_encode($response); 
        }else{
            $response = array(
                'status' =>0,
                'message'=>'Failed',
                'sekolah'=>[]
            );
    
            header('Content-Type: application/json');
            echo json_encode($response); 
        }
    }
}


//SISWA
function getSiswaSekolah(){
    global $connect;

    if (!empty($_GET["id_user"])) {
        $id_user = (int) $_GET["id_user"];      
    }else{
        $response = array(
            'status'=>0,
            'message'=>'Error, need id_user',
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){

        $query = mysqli_query($connect, "SELECT id_sekolah FROM user WHERE id_user=$id_user");
        if(mysqli_num_rows($query)>0){
            while ($result = mysqli_fetch_object($query)){
                $user[] = $result;
            }
            $id_sekolah = $user[0]->id_sekolah;
    
            $query = mysqli_query($connect, "SELECT * FROM siswa WHERE id_sekolah=$id_sekolah");
            while ($result = mysqli_fetch_object($query)){
                $data[] = $result;
            }
    
            $response = array(
                'status' =>1,
                'message'=>'Success',
                'siswa'=>$data
            );
    
            header('Content-Type: application/json');
            echo json_encode($response); 
        }else{
            $response = array(
                'status' =>0,
                'message'=>'Failed',
                'siswa'=>[]
            );
    
            header('Content-Type: application/json');
            echo json_encode($response); 
        }
    }
}

//MATA PELAJARAN
function getMapel(){
    global $connect;
    if (!mysqli_connect_error()){
        $query = mysqli_query($connect, "SELECT * FROM mapel");
        while ($result = mysqli_fetch_object($query)){
            $data[] = $result;
        }
        $response = array(
            'status' =>1,
            'message'=>'Success',
            'mapels'=>$data
        );

        header('Content-Type: application/json');
        echo json_encode($response);    
    }else{
        $response = array(
            'status' =>0,
            'message'=>'Failed',
            'mapels'=>[]
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

function getDetailMapel(){
}

//NILAI SIKAP SPIRITUAL
function getNilaiAkhirSikapSpiritual(){
    global $connect;

    if (!empty($_GET["id_siswa"])) {
        $id_siswa = (int) $_GET["id_siswa"];      
    }else{
        $response = array(
            'status'=>0,
            'message'=>'Error, need id_siswa'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){

        $query = mysqli_query($connect, "SELECT semester, tahun_ajaran FROM siswa WHERE id_siswa = $id_siswa");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;

        $data = [];
        $query = mysqli_query($connect, "SELECT * FROM sikap_spiritual WHERE id_siswa = '$id_siswa' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");
        while ($result = mysqli_fetch_object($query)){
            $data[] = $result;
        }

        $response = array(
            'status' =>1,
            'message'=>'Success',
            'sikapspiritual'=>$data
        );

        header('Content-Type: application/json');
        echo json_encode($response);    
         
    }
}

function getSikapSpritualSiswa(){
    global $connect;

    if (!empty($_GET["id_user"])) {
        $id_user = (int) $_GET["id_user"];      
    }else{
        $response = array(
            'status'=>0,
            'message'=>'Error, need id_user'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){

        $query = mysqli_query($connect, "SELECT id_sekolah FROM user WHERE id_user=$id_user");
        while ($result = mysqli_fetch_object($query)){
            $user[] = $result;
        }
        $id_sekolah = $user[0]->id_sekolah;

        $query = mysqli_query($connect, "SELECT siswa.id_siswa, siswa.nama_siswa, sikap_spiritual.deskripsi FROM siswa LEFT JOIN sikap_spiritual USING (id_siswa) WHERE siswa.id_sekolah=$id_sekolah");
        while ($result = mysqli_fetch_object($query)){
            $data[] = $result;
        }

        $response = array(
            'status' =>1,
            'message'=>'Success',
            'nilaisikap'=>$data
        );

        header('Content-Type: application/json');
        echo json_encode($response);    
         
    }
}

function getDetailSikapSpritualSiswa(){
    global $connect;

    if (!empty($_GET["id_siswa"])) {
        $id_siswa = (int) $_GET["id_siswa"];      
    }else{
        $response = array(
            'status'=>0,
            'message'=>'Error, need id_siswa'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){

        $query = mysqli_query($connect, "SELECT * FROM siswa WHERE id_siswa=$id_siswa");
        while ($result = mysqli_fetch_object($query)){
            $user[] = $result;
        }
        $semester = $user[0]->semester;
        $tahun_ajaran = $user[0]->tahun_ajaran;

        $query = mysqli_query($connect, "SELECT * FROM sikap_spiritual WHERE id_siswa=$id_siswa AND semester='$semester' AND tahun_ajaran='$tahun_ajaran'");
        while ($result = mysqli_fetch_object($query)){
            $data[] = $result;
        }

        if(isset($data)){
            $response = array(
                'status' =>1,
                'message'=>'Success',
                'nilai'=>$data
            );
        }else{
            $response = array(
                'status' =>0,
                'message'=>'Failed'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);    
         
    }
}

function createNilaiSpiritual(){
    global $connect;

    $check = array('id_siswa'=>'', 'ketaatan_beribadah'=>'', 'berprilaku_bersyukur'=>'', 'berdoa'=>'', 'toleransi'=>'');
    $check_match = count(array_intersect_key($_POST, $check));

    if($check_match == count($check)){
        $query = mysqli_query($connect, "SELECT semester, tahun_ajaran, nama_panggilan FROM siswa WHERE id_siswa = $_POST[id_siswa]");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;
        $nickname = $siswa[0]->nama_panggilan;

        $penilaian = [
            'ketaatan beribadah'=>$_POST['ketaatan_beribadah'], 
            'berprilaku bersyukur'=>$_POST['berprilaku_bersyukur'], 
            'berdoa sebelum dan sesudah melakukan kegiatan'=>$_POST['berdoa'], 
            'toleransi beribadah'=>$_POST['toleransi']
        ];

        //Membuat kalimat per penilaian
        $sentance_sangat_baik = '';
        $sentance_baik = '';
        $sentance_perlu_bimbingan = '';
        foreach ($penilaian as $key => $value){
            if($value=='SB') $sentance_sangat_baik = $sentance_sangat_baik .$key.", ";
            if($value=='B') $sentance_baik = $sentance_baik .$key.", ";
            if($value=='PB') $sentance_perlu_bimbingan = $sentance_perlu_bimbingan .$key.", ";
        }
       
        //Slice tanda koma di akhir
        $sentance_sangat_baik = substr($sentance_sangat_baik, 0, -2);
        $sentance_baik = substr($sentance_baik, 0, -2);
        $sentance_perlu_bimbingan = substr($sentance_perlu_bimbingan, 0, -2);

        //Menggabungkan deskripsi
        $deskripsi = '';
        if($sentance_sangat_baik && $sentance_perlu_bimbingan){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . '. Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }else if($sentance_sangat_baik && $sentance_baik){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . ', baik dalam '. $sentance_baik . '. ';
         }else if($sentance_baik && $sentance_perlu_bimbingan){
            $deskripsi = $nickname. ' baik dalam '. $sentance_baik . '. Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }else if ($sentance_sangat_baik){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . '.';
         }else if ($sentance_baik){
            $deskripsi = $nickname. ' baik dalam '. $sentance_baik . '.';
         }else if ($sentance_perlu_bimbingan){
            $deskripsi = 'Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }

        //Insert data
        $result = mysqli_query($connect, "INSERT INTO sikap_spiritual SET
        id_siswa = '$_POST[id_siswa]',
        semester = '$semester',
        tahun_ajaran = '$tahun_ajaran',
        ketaatan_beribadah = '$_POST[ketaatan_beribadah]',
        berprilaku_bersyukur = '$_POST[berprilaku_bersyukur]',
        berdoa = '$_POST[berdoa]',
        toleransi = '$_POST[toleransi]',
        deskripsi = '$deskripsi'
        ");

        if($result){
            $response = array(
                'status'=>1,
                'message'=>'Insert Success'
            );
        }else{
            $response = array(
                'status'=>0,
                'message'=>'Insert Failed.'
            );
        }
    } else{
        $response = array(
            'status'=>0,
            'message'=>'Wrong Parameter'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function updateNilaiSpiritual(){
    global $connect;
    
    //Mengambil parameter PUT
    parse_str(file_get_contents('php://input'), $value);
    $id_siswa = (int) $value["id_siswa"];
    $ketaatan_beribadah = $value["ketaatan_beribadah"];
    $berprilaku_bersyukur = $value["berprilaku_bersyukur"];
    $berdoa = $value["berdoa"];
    $toleransi = $value["toleransi"];

    $check = array('ketaatan_beribadah'=>'', 'berprilaku_bersyukur'=>'', 'berdoa'=>'', 'toleransi'=>'');
    $check_match = count(array_intersect_key($value, $check));
    
    $query = mysqli_query($connect, "SELECT semester, tahun_ajaran, nama_panggilan FROM siswa WHERE id_siswa = $id_siswa");
    while ($result = mysqli_fetch_object($query)){
        $siswa[] = $result;
    }
    $semester = (int) $siswa[0]->semester;
    $tahun_ajaran = $siswa[0]->tahun_ajaran;
    $nickname = $siswa[0]->nama_panggilan;
        
    $query = mysqli_query($connect, "SELECT * FROM sikap_spiritual WHERE id_siswa = '$id_siswa' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");

    if($check_match == count($check) && mysqli_num_rows($query)>0){
        $penilaian = [
            'ketaatan beribadah'=>$value['ketaatan_beribadah'], 
            'berprilaku bersyukur'=>$value['berprilaku_bersyukur'], 
            'berdoa sebelum dan sesudah melakukan kegiatan'=>$value['berdoa'], 
            'toleransi beribadah'=>$value['toleransi']
        ];

        //Membuat kalimat per penilaian
        $sentance_sangat_baik = '';
        $sentance_baik = '';
        $sentance_perlu_bimbingan = '';
        foreach ($penilaian as $key => $value){
            if($value=='SB') $sentance_sangat_baik = $sentance_sangat_baik .$key.", ";
            if($value=='B') $sentance_baik = $sentance_baik .$key.", ";
            if($value=='PB') $sentance_perlu_bimbingan = $sentance_perlu_bimbingan .$key.", ";
        }
       
        //Slice tanda koma di akhir
        $sentance_sangat_baik = substr($sentance_sangat_baik, 0, -2);
        $sentance_baik = substr($sentance_baik, 0, -2);
        $sentance_perlu_bimbingan = substr($sentance_perlu_bimbingan, 0, -2);

        //Menggabungkan deskripsi
        $deskripsi = '';
        if($sentance_sangat_baik && $sentance_perlu_bimbingan){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . '. Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }else if($sentance_sangat_baik && $sentance_baik){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . ', baik dalam '. $sentance_baik . '. ';
         }else if($sentance_baik && $sentance_perlu_bimbingan){
            $deskripsi = $nickname. ' baik dalam '. $sentance_baik . '. Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }else if ($sentance_sangat_baik){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . '.';
         }else if ($sentance_baik){
            $deskripsi = $nickname. ' baik dalam '. $sentance_baik . '.';
         }else if ($sentance_perlu_bimbingan){
            $deskripsi = 'Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }

        //Update data
        $result = mysqli_query($connect, "UPDATE sikap_spiritual SET
        ketaatan_beribadah = '$ketaatan_beribadah',
        berprilaku_bersyukur = '$berprilaku_bersyukur',
        berdoa = '$berdoa',
        toleransi = '$toleransi',
        deskripsi = '$deskripsi' 
        WHERE id_siswa = $id_siswa AND semester = $semester AND tahun_ajaran = '$tahun_ajaran'
        ");

        if($result){
            $response = array(
                'status'=>1,
                'message'=>'Update Success'
            );
        }else{
            $response = array(
                'status'=>0,
                'message'=>'Update Failed.'
            );
        }
    } else{
        $response = array(
            'status'=>0,
            'message'=>'Wrong parameter or data has not been added'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

//NILAI SIKAP SOSIAL
function getNilaiAkhirSikapSosial(){
    global $connect;

    if (!empty($_GET["id_siswa"])) {
        $id_siswa = (int) $_GET["id_siswa"];      
    }else{
        $response = array(
            'status'=>0,
            'message'=>'Error, need id_siswa'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){

        $query = mysqli_query($connect, "SELECT semester, tahun_ajaran FROM siswa WHERE id_siswa = $id_siswa");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;

        $data = [];
        $query = mysqli_query($connect, "SELECT * FROM sikap_sosial WHERE id_siswa = '$id_siswa' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");
        while ($result = mysqli_fetch_object($query)){
            $data[] = $result;
        }

        $response = array(
            'status' =>1,
            'message'=>'Success',
            'sikapsosial'=>$data
        );

        header('Content-Type: application/json');
        echo json_encode($response);    
         
    }
}

function getDetailSikapSosialSiswa(){
    global $connect;

    if (!empty($_GET["id_siswa"])) {
        $id_siswa = (int) $_GET["id_siswa"];      
    }else{
        $response = array(
            'status'=>0,
            'message'=>'Error, need id_siswa'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){

        $query = mysqli_query($connect, "SELECT * FROM siswa WHERE id_siswa=$id_siswa");
        while ($result = mysqli_fetch_object($query)){
            $user[] = $result;
        }
        $semester = $user[0]->semester;
        $tahun_ajaran = $user[0]->tahun_ajaran;

        $query = mysqli_query($connect, "SELECT * FROM sikap_sosial WHERE id_siswa=$id_siswa AND semester='$semester' AND tahun_ajaran='$tahun_ajaran'");
        while ($result = mysqli_fetch_object($query)){
            $data[] = $result;
        }

        if(isset($data)){
            $response = array(
                'status' =>1,
                'message'=>'Success',
                'nilai'=>$data
            );
        }else{
            $response = array(
                'status' =>0,
                'message'=>'Failed'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);    
         
    }
}

function getSikapSosialSiswa(){
    global $connect;

    if (!empty($_GET["id_user"])) {
        $id_user = (int) $_GET["id_user"];      
    }else{
        $response = array(
            'status'=>0,
            'message'=>'Error, need id_user'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){

        $query = mysqli_query($connect, "SELECT id_sekolah FROM user WHERE id_user=$id_user");
        while ($result = mysqli_fetch_object($query)){
            $user[] = $result;
        }
        $id_sekolah = $user[0]->id_sekolah;

        $query = mysqli_query($connect, "SELECT siswa.id_siswa, siswa.nama_siswa, sikap_sosial.deskripsi FROM siswa LEFT JOIN sikap_sosial USING (id_siswa) WHERE siswa.id_sekolah=$id_sekolah");
        while ($result = mysqli_fetch_object($query)){
            $data[] = $result;
        }

        $response = array(
            'status' =>1,
            'message'=>'Success',
            'nilaisikap'=>$data
        );

        header('Content-Type: application/json');
        echo json_encode($response);    
         
    }
}

function createNilaiSosial(){
    global $connect;

    $check = array('id_siswa'=>'', 'jujur'=>'', 'disiplin'=>'', 'tanggung_jawab'=>'', 'santun'=>'', 'peduli'=>'','percaya_diri'=>'');
    $check_match = count(array_intersect_key($_POST, $check));

    if($check_match == count($check)){
        $query = mysqli_query($connect, "SELECT semester, tahun_ajaran, nama_panggilan FROM siswa WHERE id_siswa = $_POST[id_siswa]");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;
        $nickname = $siswa[0]->nama_panggilan;

        $penilaian = [
            'jujur'=>$_POST['jujur'], 
            'disiplin'=>$_POST['disiplin'], 
            'tanggung jawab'=>$_POST['tanggung_jawab'], 
            'santun'=>$_POST['santun'],
            'peduli'=>$_POST['peduli'],
            'percaya diri'=>$_POST['percaya_diri']
        ];

        //Membuat kalimat per penilaian
        $sentance_sangat_baik = '';
        $sentance_baik = '';
        $sentance_perlu_bimbingan = '';
        foreach ($penilaian as $key => $value){
            if($value=='SB') $sentance_sangat_baik = $sentance_sangat_baik .$key.", ";
            if($value=='B') $sentance_baik = $sentance_baik .$key.", ";
            if($value=='PB') $sentance_perlu_bimbingan = $sentance_perlu_bimbingan .$key.", ";
        }
       
        //Slice tanda koma di akhir
        $sentance_sangat_baik = substr($sentance_sangat_baik, 0, -2);
        $sentance_baik = substr($sentance_baik, 0, -2);
        $sentance_perlu_bimbingan = substr($sentance_perlu_bimbingan, 0, -2);

        //Menggabungkan deskripsi
        $deskripsi = '';
        if($sentance_sangat_baik && $sentance_perlu_bimbingan){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . '. Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }else if($sentance_sangat_baik && $sentance_baik){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . ', baik dalam '. $sentance_baik . '. ';
         }else if($sentance_baik && $sentance_perlu_bimbingan){
            $deskripsi = $nickname. ' baik dalam '. $sentance_baik . '. Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }else if ($sentance_sangat_baik){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . '.';
         }else if ($sentance_baik){
            $deskripsi = $nickname. ' baik dalam '. $sentance_baik . '.';
         }else if ($sentance_perlu_bimbingan){
            $deskripsi = 'Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }

        //Insert data
        $result = mysqli_query($connect, "INSERT INTO sikap_sosial SET
        id_siswa = '$_POST[id_siswa]',
        semester = '$semester',
        tahun_ajaran = '$tahun_ajaran',
        jujur = '$_POST[jujur]',
        disiplin = '$_POST[disiplin]',
        tanggung_jawab = '$_POST[tanggung_jawab]',
        santun = '$_POST[santun]',
        peduli = '$_POST[peduli]',
        percaya_diri = '$_POST[percaya_diri]',
        deskripsi = '$deskripsi'
        ");

        if($result){
            $response = array(
                'status'=>1,
                'message'=>'Insert Success'
            );
        }else{
            $response = array(
                'status'=>0,
                'message'=>'Insert Failed.'
            );
        }
    } else{
        $response = array(
            'status'=>0,
            'message'=>'Wrong Parameter'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function updateNilaiSosial(){
    global $connect;
    
    //Mengambil parameter PUT
    parse_str(file_get_contents('php://input'), $value);
    $id_siswa = (int) $value["id_siswa"];
    $jujur = $value["jujur"];
    $disiplin = $value["disiplin"];
    $tanggung_jawab = $value["tanggung_jawab"];
    $santun = $value["santun"];
    $peduli = $value["peduli"];
    $percaya_diri = $value["percaya_diri"];
    
    $check = array('jujur'=>'', 'disiplin'=>'', 'tanggung_jawab'=>'', 'santun'=>'', 'peduli'=>'', 'percaya_diri'=>'');
    $check_match = count(array_intersect_key($value, $check));

    $query = mysqli_query($connect, "SELECT semester, tahun_ajaran, nama_panggilan FROM siswa WHERE id_siswa = $id_siswa");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = (int) $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;
        $nickname = $siswa[0]->nama_panggilan;
        
    $query = mysqli_query($connect, "SELECT * FROM sikap_sosial WHERE id_siswa = '$id_siswa' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");

    if($check_match == count($check) && mysqli_num_rows($query)>0){
        $penilaian = [
            'jujur'=>$value['jujur'], 
            'disiplin'=>$value['disiplin'], 
            'tanggung jawab'=>$value['tanggung_jawab'], 
            'santun'=>$value['santun'],
            'peduli'=>$value['peduli'],
            'percaya diri'=>$value['percaya_diri'],
        ];

        //Membuat kalimat per penilaian
        $sentance_sangat_baik = '';
        $sentance_baik = '';
        $sentance_perlu_bimbingan = '';
        foreach ($penilaian as $key => $value){
            if($value=='SB') $sentance_sangat_baik = $sentance_sangat_baik .$key.", ";
            if($value=='B') $sentance_baik = $sentance_baik .$key.", ";
            if($value=='PB') $sentance_perlu_bimbingan = $sentance_perlu_bimbingan .$key.", ";
        }
       
        //Slice tanda koma di akhir
        $sentance_sangat_baik = substr($sentance_sangat_baik, 0, -2);
        $sentance_baik = substr($sentance_baik, 0, -2);
        $sentance_perlu_bimbingan = substr($sentance_perlu_bimbingan, 0, -2);

        //Menggabungkan deskripsi
        $deskripsi = '';
        if($sentance_sangat_baik && $sentance_perlu_bimbingan){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . '. Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }else if($sentance_sangat_baik && $sentance_baik){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . ', baik dalam '. $sentance_baik . '. ';
         }else if($sentance_baik && $sentance_perlu_bimbingan){
            $deskripsi = $nickname. ' baik dalam '. $sentance_baik . '. Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }else if ($sentance_sangat_baik){
            $deskripsi = $nickname. ' sangat baik dalam '. $sentance_sangat_baik . '.';
         }else if ($sentance_baik){
            $deskripsi = $nickname. ' baik dalam '. $sentance_baik . '.';
         }else if ($sentance_perlu_bimbingan){
            $deskripsi = 'Dengan bimbingan dan pendampingan yang lebih, ' . $nickname. ' akan mampu meningkatkan sikap ' . $sentance_perlu_bimbingan . '.';
         }

        //Update data
        $result = mysqli_query($connect, "UPDATE sikap_sosial SET
        jujur = '$jujur',
        disiplin = '$disiplin',
        tanggung_jawab = '$tanggung_jawab',
        santun = '$santun',
        peduli = '$peduli',
        percaya_diri = '$percaya_diri',
        deskripsi = '$deskripsi' 
        WHERE id_siswa = $id_siswa AND semester = $semester AND tahun_ajaran = '$tahun_ajaran'
        ");

        if($result){
            $response = array(
                'status'=>1,
                'message'=>'Update Success'
            );
        }else{
            $response = array(
                'status'=>0,
                'message'=>'Update Failed.'
            );
        }
    } else{
        $response = array(
            'status'=>0,
            'message'=>'Wrong parameter or data has not been added'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

// NILAI PENGETAHUAN
function getNilaiFinalPengetahuan(){
    global $connect;

    if (!empty($_GET["id_siswa"])) {
        $id_siswa = (int) $_GET["id_siswa"];      
    }else{
        $response = array(
            'status'=>0,
            'message'=>'Error, need id_siswa'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){

        $query = mysqli_query($connect, "SELECT semester, tahun_ajaran FROM siswa WHERE id_siswa = $id_siswa");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;

        $data = [];
        $query = mysqli_query($connect, "SELECT * FROM final_nilai_pengetahuan WHERE id_siswa = '$id_siswa' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");
        while ($result = mysqli_fetch_object($query)){
            $data[] = $result;
        }

        $response = array(
            'status' =>1,
            'message'=>'Success',
            'nilaifinalpengetahuan'=>$data
        );

        header('Content-Type: application/json');
        echo json_encode($response);    
         
    }else{
        $response = array(
            'status' =>0,
            'message'=>'Failed',
            'nilaifinalpengetahuan'=>[]
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }



}

function getNilaiPengetahuanSiswa(){ 
    global $connect;
    //Cek Parameter
    if ($_GET["kategori_mapel"] && $_GET["id_mapel"] && $_GET["id_siswa"]) {  
        $kategori_mapel = $_GET["kategori_mapel"];      
        $id_mapel = $_GET["id_mapel"];      
        $id_siswa = $_GET["id_siswa"];   
        $is_nph = $_GET["is_nph"];   
        $is_npts = $_GET["is_npts"];   
        $is_npas = $_GET["is_npas"]; 
    }else{  
        $response = array(
            'status'=>0,
            'message'=>'Error, need parameter',
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){

        $query = mysqli_query($connect, "SELECT * FROM mapel WHERE id_mapel=$id_mapel");
        while ($result = mysqli_fetch_object($query)){
            $mapel[] = $result;
        }
        
        $query = mysqli_query($connect, "SELECT semester, tahun_ajaran FROM siswa WHERE id_siswa = $id_siswa");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;

        $query = mysqli_query($connect, "SELECT * FROM nilai_pengetahuan WHERE id_siswa = '$id_siswa' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran' AND id_mapel = '$id_mapel'");
        while ($result = mysqli_fetch_object($query)){
            $nilai_pengetahuan[] = $result;
        }

        //Mapel Agama Hindu dan Mulok
        if($id_mapel == 1 || $mapel[0]->is_mulok == 1){
            $query = mysqli_query($connect, "SELECT kompetensi_dasar.id_kd, kompetensi_dasar.kode_kd from kompetensi_dasar WHERE kategori_kd = '$kategori_mapel' AND id_mapel = $id_mapel");
            while ($result = mysqli_fetch_object($query)){
                $data[] = $result;
            }

            foreach($data as $key => $value){
                $data[$key]->id_siswa = $id_siswa;
                $data[$key]->id_mapel = $id_mapel;
                $data[$key]->nama_tema = '';      //mapel agama dan mulok tidak punya tema
                $data[$key]->id_tema = '0';       //mapel agama dan mulok tidak punya tema
                $data[$key]->is_nph = $is_nph;
                $data[$key]->is_npts = $is_npts;
                $data[$key]->is_npas = $is_npas;
                $data[$key]->nilai_kd = '0';
                if(isset($nilai_pengetahuan)){
                    foreach($nilai_pengetahuan as $key_np => $value_np){
                        if( ($data[$key]->is_nph == $nilai_pengetahuan[$key_np]->is_nph) && ($data[$key]->is_npts == $nilai_pengetahuan[$key_np]->is_npts) && ($data[$key]->is_npas == $nilai_pengetahuan[$key_np]->is_npas) && ($data[$key]->id_kd == $nilai_pengetahuan[$key_np]->id_kd) ){
                            $data[$key]->nilai_kd = $nilai_pengetahuan[$key_np]->nilai_kd;
                        }
                    }
                }                
            }

            $response = array(
                'status' =>1,
                'message'=>'Success',
                'siswa'=>$data
            );
    
            header('Content-Type: application/json');
            echo json_encode($response);

        }

        //Mapel selain mulok
        else{
            $query = mysqli_query($connect, 
            "SELECT tema.id_tema, tema.nama_tema, kompetensi_dasar.id_kd, kompetensi_dasar.kode_kd 
            FROM tema_mapel JOIN tema USING(id_tema) JOIN kompetensi_dasar USING(id_kd) 
            WHERE (tema_mapel.id_mapel = $id_mapel AND kompetensi_dasar.kategori_kd = '$kategori_mapel') AND (tema.is_nph = '$is_nph' OR tema.is_npts = '$is_npts' OR tema.is_npas = '$is_npas')"
            );
            while ($result = mysqli_fetch_object($query)){
                $data[] = $result;
            }

            foreach($data as $key => $value){
                $data[$key]->id_siswa = $id_siswa;
                $data[$key]->id_mapel = $id_mapel;
                $data[$key]->is_nph = $is_nph;
                $data[$key]->is_npts = $is_npts;
                $data[$key]->is_npas = $is_npas;
                $data[$key]->nilai_kd = '0';
                if(isset($nilai_pengetahuan)){
                    foreach($nilai_pengetahuan as $key_np => $value_np){
                        if( ($data[$key]->is_nph == $nilai_pengetahuan[$key_np]->is_nph) && ($data[$key]->is_npts == $nilai_pengetahuan[$key_np]->is_npts) && ($data[$key]->is_npas == $nilai_pengetahuan[$key_np]->is_npas) && ($data[$key]->id_kd == $nilai_pengetahuan[$key_np]->id_kd) && ($data[$key]->id_tema == $nilai_pengetahuan[$key_np]->id_tema) ){
                            $data[$key]->nilai_kd = $nilai_pengetahuan[$key_np]->nilai_kd;
                        }
                    }
                }                
            }

            $response = array(
                'status' =>1,
                'message'=>'Success',
                'siswa'=>$data
            );
    
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}

function createNilaiPengetahuan(){
    global $connect;

    $check = array('id_siswa'=>'', 'id_mapel'=>'', 'id_tema'=>'', 'id_kd'=>'','is_nph'=>'', 'is_npts'=>'', 'is_npas'=>'', 'nilai_kd'=>'');
    $check_match = count(array_intersect_key($_POST, $check));
    $queryKD = mysqli_query($connect, "SELECT * FROM kompetensi_dasar WHERE id_kd = $_POST[id_kd] AND id_mapel = $_POST[id_mapel]");
    
    if($check_match == count($check) && mysqli_num_rows($queryKD)>0){
        $query = mysqli_query($connect, "SELECT * FROM siswa WHERE id_siswa = $_POST[id_siswa]");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;
        $nickname = $siswa[0]->nama_panggilan;
        
        //Insert data
        $result = mysqli_query($connect, "INSERT INTO nilai_pengetahuan SET
        id_siswa = '$_POST[id_siswa]',
        semester = '$semester',
        tahun_ajaran = '$tahun_ajaran',
        id_mapel = '$_POST[id_mapel]',
        id_tema = '$_POST[id_tema]',
        id_kd = '$_POST[id_kd]',
        is_nph = '$_POST[is_nph]',
        is_npts = '$_POST[is_npts]',
        is_npas = '$_POST[is_npas]',
        nilai_kd = '$_POST[nilai_kd]'
        ");

        if($result){
            $response = array(
                'status'=>1,
                'message'=>'Success Insert'
            );
        }else{
            $response = array(
                'status'=>0,
                'message'=>'Failed Insert.'
            );
        }

        $query = mysqli_query($connect, "SELECT * FROM final_nilai_pengetahuan WHERE id_siswa = '$_POST[id_siswa]'AND id_mapel = '$_POST[id_mapel]' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");
        if(mysqli_num_rows($query)>0){           
            $dataFinal = UpdateValueNilaiFinalPengetahuan($_POST['id_siswa'], $nickname, $semester, $tahun_ajaran,$_POST['id_mapel']);
            if($dataFinal){
                mysqli_query($connect, "UPDATE final_nilai_pengetahuan SET
                    id_siswa = '$_POST[id_siswa]',
                    id_mapel = '$_POST[id_mapel]',
                    semester = '$semester',
                    tahun_ajaran = '$tahun_ajaran',
                    nilai_akhir = '$dataFinal[nilai_akhir]',
                    predikat = '$dataFinal[predikat]',
                    deskripsi = '$dataFinal[desc]'
                    WHERE id_siswa = '$_POST[id_siswa]' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran' AND id_mapel = '$_POST[id_mapel]'
                ");
                $response['message'] = $response['message']. ' and Success Update Nilai Akhir';
            }else{
                $response['message'] = $response['message']. ' and Failed Update Nilai Akhir';
            }
            
        }else{
            $dataFinal = UpdateValueNilaiFinalPengetahuan($_POST['id_siswa'], $nickname, $semester, $tahun_ajaran,$_POST['id_mapel']);
            if($dataFinal){
                mysqli_query($connect, "INSERT INTO final_nilai_pengetahuan SET
                    id_siswa = '$_POST[id_siswa]',
                    id_mapel = '$_POST[id_mapel]',
                    semester = '$semester',
                    tahun_ajaran = '$tahun_ajaran',
                    nilai_akhir = '$dataFinal[nilai_akhir]',
                    predikat = '$dataFinal[predikat]',
                    deskripsi = '$dataFinal[desc]'
                ");

                $response['message'] = $response['message']. ' and  Success Insert Nilai Akhir';
            }else{
                $response['message'] = $response['message']. ' and  Failed Insert Nilai Akhir';
            }
            
            
        }

    } else{
        $response = array(
            'status'=>0,
            'message'=>'Wrong Parameter or KD'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function updateNilaiPengetahuan(){
    global $connect;

    parse_str(file_get_contents('php://input'), $value);

    $check = array('id_siswa'=>'', 'id_mapel'=>'', 'id_tema'=>'', 'id_kd'=>'','is_nph'=>'', 'is_npts'=>'', 'is_npas'=>'', 'nilai_kd'=>'');
    $check_match = count(array_intersect_key($value, $check));
    $queryKD = mysqli_query($connect, "SELECT * FROM kompetensi_dasar WHERE id_kd = $value[id_kd] AND id_mapel = $value[id_mapel]");
    
    if($check_match == count($check) && mysqli_num_rows($queryKD)>0){
        $query = mysqli_query($connect, "SELECT * FROM siswa WHERE id_siswa = $value[id_siswa]");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;
        $nickname = $siswa[0]->nama_panggilan;
        
        //Update data
        $result = mysqli_query($connect, "UPDATE nilai_pengetahuan SET
        nilai_kd = '$value[nilai_kd]'
        WHERE
        id_siswa = '$value[id_siswa]' AND
        semester = '$semester' AND
        tahun_ajaran = '$tahun_ajaran' AND
        id_mapel = '$value[id_mapel]' AND
        id_tema = '$value[id_tema]' AND
        id_kd = '$value[id_kd]' AND
        is_nph = '$value[is_nph]' AND
        is_npts = '$value[is_npts]' AND
        is_npas = '$value[is_npas]'
        ");

        if($result){
            $response = array(
                'status'=>1,
                'message'=>'Success Update'
            );
        }else{
            $response = array(
                'status'=>0,
                'message'=>'Failed Update.'
            );
        }

        $query = mysqli_query($connect, "SELECT * FROM final_nilai_pengetahuan WHERE id_siswa = '$value[id_siswa]'AND id_mapel = '$value[id_mapel]' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");
        if(mysqli_num_rows($query)>0){           
            $dataFinal = UpdateValueNilaiFinalPengetahuan($value['id_siswa'], $nickname, $semester, $tahun_ajaran,$value['id_mapel']);
            if($dataFinal){
                mysqli_query($connect, "UPDATE final_nilai_pengetahuan SET
                    id_siswa = '$value[id_siswa]',
                    id_mapel = '$value[id_mapel]',
                    semester = '$semester',
                    tahun_ajaran = '$tahun_ajaran',
                    nilai_akhir = '$dataFinal[nilai_akhir]',
                    predikat = '$dataFinal[predikat]',
                    deskripsi = '$dataFinal[desc]'
                    WHERE id_siswa = '$value[id_siswa]' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran' AND id_mapel = '$value[id_mapel]'
                ");
                $response['message'] = $response['message']. ' and Success Update Nilai Akhir';
            }else{
                $response['message'] = $response['message']. ' and Failed Update Nilai Akhir';
            }         

        }

    } else{
        $response = array(
            'status'=>0,
            'message'=>'Wrong Parameter or KD'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function UpdateValueNilaiFinalPengetahuan($id_siswa, $nickname, $semester, $tahun_ajaran, $id_mapel){
    global $connect;
    $query = mysqli_query($connect, "SELECT * FROM kompetensi_dasar WHERE id_mapel = '$id_mapel' AND kategori_kd = 'pengetahuan'");
    
    if(mysqli_num_rows($query)>0){
        while ($result = mysqli_fetch_assoc($query)){
            $kompensi_dasar[] = $result;
        }
    
        $sum_na = 0;
        $devide_na = 0;
        $maxi_kd = 0;
        $maxi_desc = '';
        $mini_kd = 0;
        $mini_desc = '';
    
        foreach ($kompensi_dasar as $key => $data){
            $query = mysqli_query($connect, "SELECT AVG(nilai_kd) AS 'NilaiAkhirKD' FROM `nilai_pengetahuan` WHERE id_siswa='$id_siswa' AND id_mapel='$id_mapel' AND id_kd='$data[id_kd]' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");
            $na_kd = mysqli_fetch_assoc($query);
            $kompensi_dasar[$key]['nilai_kd'] = $na_kd['NilaiAkhirKD'];
    
            if($na_kd['NilaiAkhirKD']){
                $sum_na+=$na_kd['NilaiAkhirKD'];
                $devide_na++;
            }
            
            if($key==0){
                $mini_kd = $na_kd['NilaiAkhirKD'];
                $mini_desc = $kompensi_dasar[$key]['deskripsi_kd'];
            }
            
            if($na_kd['NilaiAkhirKD']>$maxi_kd){
                $maxi_kd = $na_kd['NilaiAkhirKD'];
                $maxi_desc = $kompensi_dasar[$key]['deskripsi_kd'];
            }
            
            if($na_kd['NilaiAkhirKD']<$mini_kd && $na_kd['NilaiAkhirKD']!=NULL){
                $mini_kd = $na_kd['NilaiAkhirKD'];
                $mini_desc = $kompensi_dasar[$key]['deskripsi_kd'];
            }             
        }
    
        $nilai_akhir = $sum_na/$devide_na;
        $predikat = checkPredikatScore($nilai_akhir)[0];
        $final_desc = $nickname.' '. checkPredikatScore($maxi_kd)[1]. ' dalam ' .$maxi_desc .', ' .checkPredikatScore($mini_kd)[1] .' dalam ' . $mini_desc .'.';
        return ['nilai_akhir'=>$nilai_akhir, 'predikat'=>$predikat, 'desc'=>$final_desc];
    }    

}


// NILAI KETERAMPILAN
function getNilaiFinalKeterampilan(){
    global $connect;

    if (!empty($_GET["id_siswa"])) {
        $id_siswa = (int) $_GET["id_siswa"];      
    }else{
        $response = array(
            'status'=>0,
            'message'=>'Error, need id_siswa'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){

        $query = mysqli_query($connect, "SELECT semester, tahun_ajaran FROM siswa WHERE id_siswa = $id_siswa");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;

        $data = [];
        $query = mysqli_query($connect, "SELECT * FROM final_nilai_keterampilan WHERE id_siswa = '$id_siswa' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");
        while ($result = mysqli_fetch_object($query)){
            $data[] = $result;
        }

        $response = array(
            'status' =>1,
            'message'=>'Success',
            'nilaifinalketerampilan'=>$data
        );

        header('Content-Type: application/json');
        echo json_encode($response);    
         
    }else{
        $response = array(
            'status' =>0,
            'message'=>'Failed',
            'nilaifinalketerampilan'=>[]
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

function getNilaiKeterampilanSiswa(){ 
    global $connect;
    //Cek Parameter
    if ($_GET["id_mapel"] && $_GET["id_siswa"]) {      
        $id_mapel = $_GET["id_mapel"];      
        $id_siswa = $_GET["id_siswa"];    
    }else{  
        $response = array(
            'status'=>0,
            'message'=>'Error, need parameter',
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    if(!mysqli_connect_error()){
        
        $query = mysqli_query($connect, "SELECT semester, tahun_ajaran FROM siswa WHERE id_siswa = $id_siswa");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;

        $query = mysqli_query($connect, "SELECT * FROM nilai_keterampilan WHERE id_siswa = '$id_siswa' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran' AND id_mapel = '$id_mapel'");
        while ($result = mysqli_fetch_object($query)){
            $nilai_keterampilan[] = $result;
        }

        $query = mysqli_query($connect, "SELECT * from keterampilan");
        while ($result = mysqli_fetch_object($query)){
            $keterampilan[] = $result;
        }

        $query = mysqli_query($connect, "SELECT kompetensi_dasar.id_kd, kompetensi_dasar.kode_kd from kompetensi_dasar WHERE kategori_kd = 'keterampilan' AND id_mapel = $id_mapel");
        while ($result = mysqli_fetch_object($query)){
            $kd_keterampilan[] = $result;
        }

        $data=[];
        foreach($kd_keterampilan as $key => $kd){
            foreach($keterampilan as $kt){
                array_push($data,['id_mapel'=>$id_mapel, 'id_kd'=>$kd->id_kd, 'kode_kd'=>$kd->kode_kd, 'id_kt'=>$kt->id_kt, 'nama_keterampilan'=>$kt->nama_keterampilan, 'nilai_kt'=>'0']);
            }
        }

        foreach($data as $key => $value){
            if(isset($nilai_keterampilan)){
                foreach($nilai_keterampilan as $key_nk => $value_np){
                    if( ($data[$key]['id_kd'] == $nilai_keterampilan[$key_nk]->id_kd) && ($data[$key]['id_kt'] == $nilai_keterampilan[$key_nk]->id_kt) ){
                        $data[$key]['nilai_kt'] = $nilai_keterampilan[$key_nk]->nilai_kt;
                    }
                }
            }                
        }

        $response = array(
            'status' =>1,
            'message'=>'Success',
            'siswa'=>$data
        );

        header('Content-Type: application/json');
        echo json_encode($response);        
    }
}

function createNilaiKeterampilan(){
    global $connect;

    $check = array('id_siswa'=>'', 'id_mapel'=>'', 'id_kd'=>'', 'id_kt'=>'', 'nilai_kt'=>'');
    $check_match = count(array_intersect_key($_POST, $check));
    $queryKD = mysqli_query($connect, "SELECT * FROM kompetensi_dasar WHERE id_kd = $_POST[id_kd] AND id_mapel = $_POST[id_mapel]");
    
    if($check_match == count($check) && mysqli_num_rows($queryKD)>0){
        $query = mysqli_query($connect, "SELECT * FROM siswa WHERE id_siswa = $_POST[id_siswa]");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;
        $nickname = $siswa[0]->nama_panggilan;
        
        //Insert data
        $result = mysqli_query($connect, "INSERT INTO nilai_keterampilan SET
        id_siswa = '$_POST[id_siswa]',
        semester = '$semester',
        tahun_ajaran = '$tahun_ajaran',
        id_mapel = '$_POST[id_mapel]',
        id_kd = '$_POST[id_kd]',
        id_kt = '$_POST[id_kt]',
        nilai_kt = '$_POST[nilai_kt]'
        ");

        if($result){
            $response = array(
                'status'=>1,
                'message'=>'Success Insert'
            );
        }else{
            $response = array(
                'status'=>0,
                'message'=>'Failed Insert.'
            );
        }

        $query = mysqli_query($connect, "SELECT * FROM final_nilai_keterampilan WHERE id_siswa = '$_POST[id_siswa]'AND id_mapel = '$_POST[id_mapel]' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");
        if(mysqli_num_rows($query)>0){           
            $dataFinal = UpdateValueNilaiFinalKeterampilan($_POST['id_siswa'], $nickname, $semester, $tahun_ajaran,$_POST['id_mapel']);
            if($dataFinal){
                mysqli_query($connect, "UPDATE final_nilai_keterampilan SET
                    id_siswa = '$_POST[id_siswa]',
                    id_mapel = '$_POST[id_mapel]',
                    semester = '$semester',
                    tahun_ajaran = '$tahun_ajaran',
                    nilai_akhir = '$dataFinal[nilai_akhir]',
                    predikat = '$dataFinal[predikat]',
                    deskripsi = '$dataFinal[desc]'
                    WHERE id_siswa = '$_POST[id_siswa]' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran' AND id_mapel = '$_POST[id_mapel]'
                ");
                $response['message'] = $response['message']. ' and Success Update Nilai Akhir';
            }else{
                $response['message'] = $response['message']. ' and Failed Update Nilai Akhir';
            }
            
        }else{
            $dataFinal = UpdateValueNilaiFinalKeterampilan($_POST['id_siswa'], $nickname, $semester, $tahun_ajaran,$_POST['id_mapel']);
            if($dataFinal){
                mysqli_query($connect, "INSERT INTO final_nilai_keterampilan SET
                    id_siswa = '$_POST[id_siswa]',
                    id_mapel = '$_POST[id_mapel]',
                    semester = '$semester',
                    tahun_ajaran = '$tahun_ajaran',
                    nilai_akhir = '$dataFinal[nilai_akhir]',
                    predikat = '$dataFinal[predikat]',
                    deskripsi = '$dataFinal[desc]'
                ");

                $response['message'] = $response['message']. ' and  Success Insert Nilai Akhir';
            }else{
                $response['message'] = $response['message']. ' and  Failed Insert Nilai Akhir';
            }
            
            
        }

    } else{
        $response = array(
            'status'=>0,
            'message'=>'Wrong Parameter or KD'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function updateNilaiKeterampilan(){
    global $connect;

    parse_str(file_get_contents('php://input'), $value);

    $check = array('id_siswa'=>'', 'id_mapel'=>'', 'id_kd'=>'', 'id_kt'=>'', 'nilai_kt'=>'');
    $check_match = count(array_intersect_key($value, $check));
    $queryKD = mysqli_query($connect, "SELECT * FROM kompetensi_dasar WHERE id_kd = $value[id_kd] AND id_mapel = $value[id_mapel]");
    
    if($check_match == count($check) && mysqli_num_rows($queryKD)>0){
        $query = mysqli_query($connect, "SELECT * FROM siswa WHERE id_siswa = $value[id_siswa]");
        while ($result = mysqli_fetch_object($query)){
            $siswa[] = $result;
        }
        $semester = $siswa[0]->semester;
        $tahun_ajaran = $siswa[0]->tahun_ajaran;
        $nickname = $siswa[0]->nama_panggilan;
        
        //Update data
        $result = mysqli_query($connect, "UPDATE nilai_keterampilan SET
        nilai_kt = '$value[nilai_kt]'
        WHERE
        id_siswa = '$value[id_siswa]' AND
        semester = '$semester' AND
        tahun_ajaran = '$tahun_ajaran' AND
        id_mapel = '$value[id_mapel]' AND
        id_kd = '$value[id_kd]' AND
        id_kt = '$value[id_kt]'       
        ");

        if($result){
            $response = array(
                'status'=>1,
                'message'=>'Success Update'
            );
        }else{
            $response = array(
                'status'=>0,
                'message'=>'Failed Update.'
            );
        }

        $query = mysqli_query($connect, "SELECT * FROM final_nilai_keterampilan WHERE id_siswa = '$value[id_siswa]'AND id_mapel = '$value[id_mapel]' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");
        if(mysqli_num_rows($query)>0){           
            $dataFinal = UpdateValueNilaiFinalKeterampilan($value['id_siswa'], $nickname, $semester, $tahun_ajaran, $value['id_mapel']);
            if($dataFinal){
                mysqli_query($connect, "UPDATE final_nilai_keterampilan SET
                    id_siswa = '$value[id_siswa]',
                    id_mapel = '$value[id_mapel]',
                    semester = '$semester',
                    tahun_ajaran = '$tahun_ajaran',
                    nilai_akhir = '$dataFinal[nilai_akhir]',
                    predikat = '$dataFinal[predikat]',
                    deskripsi = '$dataFinal[desc]'
                    WHERE id_siswa = '$value[id_siswa]' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran' AND id_mapel = '$value[id_mapel]'
                ");
                $response['message'] = $response['message']. ' and Success Update Nilai Akhir';
            }else{
                $response['message'] = $response['message']. ' and Failed Update Nilai Akhir';
            }         

        }

    } else{
        $response = array(
            'status'=>0,
            'message'=>'Wrong Parameter or KD'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function UpdateValueNilaiFinalKeterampilan($id_siswa, $nickname, $semester, $tahun_ajaran, $id_mapel){
    global $connect;
    $query = mysqli_query($connect, "SELECT * FROM kompetensi_dasar WHERE id_mapel = '$id_mapel' AND kategori_kd = 'keterampilan'");
    
    if(mysqli_num_rows($query)>0){
        while ($result = mysqli_fetch_assoc($query)){
            $kompensi_dasar[] = $result;
        }
    
        $sum_na = 0;
        $devide_na = 0;
        $maxi_kd = 0;
        $maxi_desc = '';
        $mini_kd = 0;
        $mini_desc = '';
    
        foreach ($kompensi_dasar as $key => $data){
            $query = mysqli_query($connect, "SELECT AVG(nilai_kt) AS 'NilaiAkhirKD' FROM `nilai_keterampilan` WHERE id_siswa='$id_siswa' AND id_mapel='$id_mapel' AND id_kd='$data[id_kd]' AND semester = '$semester' AND tahun_ajaran = '$tahun_ajaran'");
            $na_kd = mysqli_fetch_assoc($query);
            $kompensi_dasar[$key]['nilai_kd'] = $na_kd['NilaiAkhirKD'];
    
            if($na_kd['NilaiAkhirKD']){
                $sum_na+=$na_kd['NilaiAkhirKD'];
                $devide_na++;
            }
            
            if($key==0){
                $mini_kd = $na_kd['NilaiAkhirKD'];
                $mini_desc = $kompensi_dasar[$key]['deskripsi_kd'];
            }
            
            if($na_kd['NilaiAkhirKD']>$maxi_kd){
                $maxi_kd = $na_kd['NilaiAkhirKD'];
                $maxi_desc = $kompensi_dasar[$key]['deskripsi_kd'];
            }
            
            if($na_kd['NilaiAkhirKD']<$mini_kd && $na_kd['NilaiAkhirKD']!=NULL){
                $mini_kd = $na_kd['NilaiAkhirKD'];
                $mini_desc = $kompensi_dasar[$key]['deskripsi_kd'];
            }             
        }
    
        $nilai_akhir = $sum_na/$devide_na;
        $predikat = checkPredikatScore($nilai_akhir)[0];
        $final_desc = $nickname.' '. checkPredikatScore($maxi_kd)[1]. ' dalam ' .$maxi_desc .', ' .checkPredikatScore($mini_kd)[1] .' dalam ' . $mini_desc .'.';
        return ['nilai_akhir'=>$nilai_akhir, 'predikat'=>$predikat, 'desc'=>$final_desc];
    }    

}

//CEK PREDIKAT
function checkPredikatScore($score){ 
    $score = round($score,0,PHP_ROUND_HALF_UP);
    if($score >= 88){
       return ['A','sangat baik'];
    }else if ($score >= 74 && $score <= 87){
       return ['B','baik'];
    }else if ($score >= 60 && $score <= 73){
       return ['C','cukup'];
    }else if ($score <= 59){
       return ['D','perlu bimbingan'];
    }
 }
     
?>