<?php
/**
 * Created By :    
 * User: Welly
 * Date: 08/02/2017
 * Time: 15.39
 */
 
    $str = file_get_contents('data.json');

    $json = json_decode($str, true);

    error_reporting(E_ERROR | E_PARSE);


    $host = $json['data'][0]['host'];
    $user = $json['data'][0]['user'];
    $pass = $json['data'][0]['pass'];
    $db = $json['data'][0]['database'];


    $con = mysqli_connect($host,$user,$pass,$db);

    date_default_timezone_set("Asia/Jakarta");
    setlocale(LC_TIME, "id_ID");

    $tgl_lengkap = strftime("%Y-%m-%d %X");
    $tgl_jak = strftime("%Y-%m-%d");

    session_start();

    ?>