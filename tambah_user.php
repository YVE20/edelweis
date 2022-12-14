<?php
/**
 * Created By :    
 * User: Welly
 * Date: 12/06/2018
 * Time: 09:54
 */
$user = $_GET['user'];
$limit_uptime = $_GET['limit'];
$ip = $_GET['ip'];
$user_mikrotik = $_GET['user_mikrotik'];
$pass_mikrotik = $_GET['pass_mikrotik'];
require('asset/routeros_mikrotik/routeros_api.class.php');

// Ubah sesuai setting mikrotik hotspot Anda
define('SERVER', 'all');
define('PROFILE', 'default');

$API = new RouterosAPI();

// Aktifkan debug
// $API->debug = true;

if ($API->connect(''.$ip, ''.$user_mikrotik, ''.$pass_mikrotik))
{
    // Data user dan password hotspot
        $username="=name=";
        $username.=$user;

        $pass="=password=";
        $pass.=$user;

        $uptime="=limit-uptime=";
        $uptime.=$limit_uptime;

        $server="=server=";
        $server.=SERVER;

        $profile="=profile=";
        $profile.=PROFILE;

        $API->write('/ip/hotspot/user/add',false);
        $API->write($username, false);
        $API->write($pass, false);
        $API->write($uptime,false);
        $API->write($server, false);
        $API->write($profile);

        $ARRAY = $API->read();

    $API->disconnect();
}