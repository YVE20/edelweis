<?php 

session_start();
include "KoneksiHome.php";

if($_POST['typeKeranjang'] == "count" || $_POST['typeKeranjang'] == "view"){
    $iduser = $_POST['iduser'];

    $sql = "select *from tbkeranjang where id_user = '$iduser' ";
    $query = mysqli_query($con,$sql);
    $row = mysqli_num_rows($query);

    if($row == 0){
        echo "kosong";
    }else {
        echo $row;
    }
}else if($_POST['typeKeranjang'] == "add"){
    //Add data ke tbkeranjang
    $iduser = $_POST['iduser'];
    $kode_barang = $_POST['kode_barang'];
    $jumlah = $_POST['qty'];
    
    //Logic cek data double
    $sql4 = "select *from tbkeranjang where kode_barang = '$kode_barang' ";
    $query4 = mysqli_query($con,$sql4);
    $row4 = mysqli_num_rows($query4);

    if($row4 == 0){
        //Cek harga di tbmenu
        $sql3 = "select *from tbmenu where kode_barang = '$kode_barang' ";
        $query3 = mysqli_query($con,$sql3);

        $subTotal = 0;
        while($re = mysqli_fetch_array($query3)){
            $subTotal = $re['harga_dk'] * $jumlah;
        }

        //Isi data baru
        $sql2 = "insert into tbkeranjang (kode_barang,subtotal,jumlah,id_user) values ('$kode_barang','$subTotal','$jumlah','$iduser')";
        $query2 = mysqli_query($con,$sql2);
    }else{
        //Cek harga di tbmenu
        $sql3 = "select *from tbmenu where kode_barang = '$kode_barang' ";
        $query3 = mysqli_query($con,$sql3);

        $hargaSatuan = 0;
        while($re = mysqli_fetch_array($query3)){
            $hargaSatuan = $re['harga_dk'];
        }

        //Get jumlah dari tbkeranjang
        $sql6 = "select *from tbkeranjang where kode_barang = '$kode_barang' ";
        $query6 = mysqli_query($con,$sql6);
        $jumlahBarang = 0;
        $subTotal = 0;

        while($re6 = mysqli_fetch_array($query6)){
            $jumlahBarang = $re6['jumlah'] + $jumlah;
            $subTotal = $hargaSatuan * $jumlahBarang;
        }
        

        //Update data
        $sql5 = "update tbkeranjang set jumlah = '$jumlahBarang', subtotal ='$subTotal' where kode_barang = '$kode_barang' ";
        $query5 = mysqli_query($con,$sql5);
    }
    echo "success";
}


?>