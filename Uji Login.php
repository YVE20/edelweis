

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

    $username = $_POST['txtusername'];
    $password = $_POST['txtpassword'];
    $password = encryptIt($password);

    $sql = "select * from tbuser where username='$username' and password='$password'";
    $query = mysqli_query($con,$sql);
    $hitung = mysqli_num_rows($query);

    if($hitung == 0)
    {
       echo "0";
    }
    else
    {
        while($re = mysqli_fetch_array($query))
        {
            $sql2 = "select * from license where id='1'";
            $query2 = mysqli_query($con,$sql2);
            $res = mysqli_fetch_array($query2);

            $_SESSION['iduser'] = $re['iduser'];
            $_SESSION['username'] = $re['username'];
            $_SESSSION['password'] = $re['password'];
            $_SESSION['status'] = $re['status'];
            $_SESSION['nama'] = $re['nama'];
            $_SESSION['ujilogin'] = "yes";
            $_SESSION['nama_perusahaan'] = $res['nama'];
            $_SESSION['alamat_perusahaan'] = $res['alamat'];
            $_SESSION['telp_perusahaan'] = $res['telp'];
            $_SESSION['icon'] = $res['icon'];
            $_SESSION['minus'] = $res['minus'];
            $_SESSION['shift1'] = $res['shift1'];
            $_SESSION['shift2'] = $res['shift2'];
            $_SESSION['shift3'] = $res['shift3'];
            $_SESSION['lembur'] = $res['lembur'];
            $_SESSION['idtoko'] = $res['idtoko'];
            $_SESSION['printer'] = $res['printer'];
            $_SESSION['password'] = $res['password'];
            $_SESSION['ppn'] = $res['ppn'];
            $_SESSION['meja'] = $res['meja'];
            
           
        }

        echo $_SESSION['status'];
    }
?>

