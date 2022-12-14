<?php 
include "KoneksiHome.php";


if($_POST['page'] == "About"){
    $qty = $_POST['qty'];
    $kode_barang = $_POST['kode_barang'];

    //Cek Kode Barang
    $sql = "select *from tbmenu where kode_barang = '$kode_barang'";
    $query = mysqli_query($con,$sql);
    $num = mysqli_num_rows($query);

    if($num == 0){
        echo "kosong";
    }else{
        $qty = $_POST['qty'];
        $kode_barang = $_POST['kode_barang'];
        $sql2 = "Select *from tbmenu where kode_barang = '$kode_barang'";
        $query2 = mysqli_query($con,$sql2);

        while ($res2 = mysqli_fetch_array($query2)) {
            if($res2['jumlah'] == 0){
                echo "kosong";
            }else{
                $hitung = $res2['jumlah'] - $qty;
                //Stock : 10; Beli : 11 == 10 - 11
                if($hitung <= 0){
                    echo "minus";
                }else{
                    $qty = $_POST['qty'];
                    $kode_barang = $_POST['kode_barang'];
                    //Stock : 10, beli 3 == 10 - 3
                    $sql3 = "update tbmenu set jumlah = '$hitung' where kode_barang = '$kode_barang'";
                    $query3 = mysqli_query($con,$sql3);

                    //Isi tblogsmenu
                    //Notes : 0 => Konsumen diluar
                    $idmenu = $res2['id'];
                    $sql4 = "INSERT INTO tblogsmenu (idmenu,jumlah,kategori,iduser) VALUES ('$idmenu','$qty','keluar','0')";
                    $query4 =  mysqli_query($con, $sql4);
                    echo "sukses";
                }
            }
        }
    }
}else if($_POST['page'] == "Index"){
    $iduser = $_POST['iduser'];
    $sql = "select *from tbkeranjang where id_user ='$iduser' ";
    $query = mysqli_query($con,$sql);

    while($re = mysqli_fetch_array($query)){
        //Kurangin stock
        $kode_barang = $re['kode_barang'];
        $sql5 = "select *from tbmenu where kode_barang = '$kode_barang'";
        $query5 = mysqli_query($con,$sql5);
        $hitung = 0;

        while($re5 = mysqli_fetch_array($query5)){
            $hitung = $re5['jumlah'] - $re['jumlah'];
        }

        //Update tbmenu
        $sql6 = "update tbmenu set jumlah ='$hitung' where kode_barang = '$kode_barang'";
        $query6 = mysqli_query($con,$sql6);

        //Insert tblogs
        $idmenu = $re['id'];
        $qtyKeranjang = $re['jumlah'];
        $sql4 = "INSERT INTO tblogsmenu (idmenu,jumlah,kategori,iduser) VALUES ('$idmenu','$qtyKeranjang','keluar','0')";
        $query4 =  mysqli_query($con, $sql4);

        //Hapus tbkeranjang by id
        $sql7 = "delete from tbkeranjang where id_user ='$iduser'";
        $query7 = mysqli_query($con,$sql7);
    }

    echo "sukses";
}


?>