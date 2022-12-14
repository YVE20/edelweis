<?php
/**
 * Created By :    
 * User: Welly
 * Date: 08/02/2017
 * Time: 15.50
 */

    session_start();
    include "Koneksi.php";
    // include "";
    include "asset/function/function.php";

    echo "Username : Admin ".decryptIt("aXRjc3N1a3Nlcw==");
    echo "Username : test ".decryptIt("MTIzNDU2");
    
?>

