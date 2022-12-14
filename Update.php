<?php
/**
 * Created By :    
 * User: Welly
 * Date: 29/06/18
 * Time: 01.20
 */

include "Koneksi.php";

$sql = "";
$query = mysqli_query($con,$sql);

header("location:Login.php");