<?php

	$data = $_POST['data'];

	$data = json_decode($data);

	$cmd = $data->cmd;
	$host = $data->host;
	$user = $data->user;
	$pass = $data->pass;
	$database = $data->database;

	if($cmd == "Simpan"){
        $obj = array();
        $json = array();

        $json[] = array("host"=>$host,"user"=>$user,"pass"=>$pass,"database"=>$database);

        $obj['data'] = $json;

        $fp = fopen('data.json', 'w');
        fwrite($fp, json_encode($obj));
        fclose($fp);
	}