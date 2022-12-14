<?php
/**
 * Created By :    
 * User: Welly
 * Date: 08/02/2017
 * Time: 18.32
 */
    session_start();
    session_destroy();
    header("location:Login.php");