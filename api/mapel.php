<?php

$connect = mysqli_connect('localhost', 'root', '', 'e-raport');

if(function_exists($_GET['function'])) {
    $_GET['function']();
 }   

function get_mapel(){
    global $connect;
   // $data = array();
    if (!mysqli_connect_error()){
        $query = mysqli_query($connect, "SELECT * FROM mapel");
        while ($result = mysqli_fetch_object($query)){
            $data[] = $result;
        }
        $response = array(
            'status' =>1,
            'message'=>'Success',
            'data'=>$data
        );

        header('Content-Type: application/json');
        echo json_encode($response);    
    }
}
     
?>