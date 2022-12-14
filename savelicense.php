<?php
/**
 * Created By :    
 * User: Welly
 * Date: 11/02/2018
 * Time: 12:45
 */
    include "Koneksi.php";
    include "asset/vendor/samayo/bulletproof/src/bulletproof.php";
    session_start();

    $image = new Bulletproof\Image($_FILES);
    $image->setLocation('asset/img/');

    $tombol = $_POST['tombol'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    // $icon = $_POST['icon'];
    $minus = $_POST['minus'];
    $shift1 = $_POST['shift1'];
    $shift2 = $_POST['shift2'];
    $shift3 = $_POST['shift3'];
    $lembur = $_POST['lembur'];
    $instagram = $_POST['instagram'];
    $password = $_POST['password'];
    $idtoko = $_POST['idtoko'];
    $printer = $_POST['printer'];
    $ppn = $_POST['ppn'];
    $meja = $_POST['meja'];
    $icon = $_FILES['icon'];

    if($tombol == "edit"){

      //menghasilkan nama file yang unik, akan ada angka acak didepannya
      $namaFile = time().'_'.basename($_FILES["icon"]["name"]);
        
      //folder upload
      $targetDir = "asset/img/";
      $targetFilePath = $targetDir . $namaFile;
      
      //membolehkan ekstensiOk file tertentu
      $ekstensiFile = pathinfo($targetFilePath,PATHINFO_EXTENSION);
      $ekstensiOk = array('jpg','png','jpeg','gif');

      // cek gambar apakah kosong
      if ($_FILES["icon"]["name"]) {
        if(in_array($ekstensiFile, $ekstensiOk)){
       
          //upload file ke server
          // echo "aman";
            if(move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFilePath)){
                //memasukkan file data ke dalam database jika diperlukan
                //........                
                $sql = "update license set nama='$nama',alamat='$alamat',telp='$telp',icon='$namaFile',minus='$minus',shift1='$shift1',shift2='$shift2',shift3='$shift3',lembur='$lembur',idtoko='$idtoko',printer='$printer',ppn='$ppn',meja='$meja',instagram='$instagram',password='$password' where id='1'";
                $query = mysqli_query($con,$sql) or  die ($sql);

                $respon['status'] = 'ok';
            }else{
                $respon['status'] = 'err';
            }
        }else{
            $respon['status'] = 'type_err';
        }
      } else { //gambar kosong
        $sql = "update license set nama='$nama',alamat='$alamat',telp='$telp',minus='$minus',shift1='$shift1',shift2='$shift2',shift3='$shift3',lembur='$lembur',idtoko='$idtoko',printer='$printer',ppn='$ppn',meja='$meja',instagram='$instagram',password='$password' where id='1'";
        $query = mysqli_query($con,$sql) or  die ($sql);
      }
        // if (!isset($_POST['icon'])) {
        //   $sql = "update license set nama='$nama',alamat='$alamat',telp='$telp',minus='$minus',shift1='$shift1',shift2='$shift2',shift3='$shift3',lembur='$lembur',idtoko='$idtoko',printer='$printer',ppn='$ppn',meja='$meja',instagram='$instagram',password='$password' where id='1'";
        // } else {
        //     //echo("ndak kosong");
        //     $sql = "update license set nama='$nama',alamat='$alamat',telp='$telp',icon='$icon',minus='$minus',shift1='$shift1',shift2='$shift2',shift3='$shift3',lembur='$lembur',idtoko='$idtoko',printer='$printer',ppn='$ppn',meja='$meja',instagram='$instagram',password='$password' where id='1'";
            
        // }

        // print_r($namaFile);
        

        // $sql = "update license set nama='$nama',alamat='$alamat',telp='$telp',icon='$icon',minus='$minus',shift1='$shift1',shift2='$shift2',shift3='$shift3',lembur='$lembur',idtoko='$idtoko',printer='$printer',ppn='$ppn',meja='$meja',instagram='$instagram',password='$password' where id='1'";
        // $query = mysqli_query($con,$sql) or  die ($sql);
        $_SESSION['nama_perusahaan'] = $nama;
        $_SESSION['alamat_perusahaan'] = $alamat;
        $_SESSION['telp_perusahaan'] = $telp;
        $_SESSION['icon'] = $namaFile;
        $_SESSION['minus'] = $minus;
        $_SESSION['shift1'] = $shift1;
        $_SESSION['shift2'] = $shift2;
        $_SESSION['shift3'] = $shift3;
        $_SESSION['lembur'] = $lembur;
        $_SESSION['idtoko'] = $idtoko;
        $_SESSION['printer'] = $printer;
        $_SESSION['ppn'] = $ppn;
        $_SESSION['meja'] = $meja;
    }
    else if($tombol == "tampil"){
      $sql = "select * from license where id='1'";
      $query = mysqli_query($con,$sql) or die ($sql);

      $re = mysqli_fetch_array($query);
      $nama = $re['nama'];
      $alamat = $re['alamat'];
      $telp = $re['telp'];
      $icon = $re['icon'];
      $minus = $re['minus'];
      $shift1 = $re['shift1'];
      $shift2 = $re['shift2'];
      $shift3 = $re['shift3'];
      $idtoko = $re['idtoko'];
      $printer = $re['printer'];
      $ppn = $re['ppn'];
      $meja = $re['meja'];
      $instagram = $re['instagram'];
      $lembur = $re['lembur'];
      $password = $re['password'];

      echo "|".$nama."|".$alamat."|".$telp."|".$icon."|".$minus."|".$shift1."|".$shift2."|".$shift3."|".$idtoko."|".$printer."|".$ppn."|".$instagram."|".$lembur."|".$password."|".$meja."|";
    }