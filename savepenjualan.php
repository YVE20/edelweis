<?php
/**
 * Created By :
 * User: Welly
 * Date: 11/02/2018
 * Time: 12:45
 */
    include "Koneksi.php";
    include "asset/function/function.php";
    date_default_timezone_set("Asia/Jakarta");


    $tombol = $_POST['tombol'];
    $idjual = $_POST['idjual'];
    $idjual_awal = $_POST['idjual_awal'];
    $idjual_ganti = $_POST['idjual_ganti'];
    $id = $_POST['id'];
    $idkonsumen = $_POST['idkonsumen'];
    $kodecanvas = $_POST['kodecanvas'];
    $idsales = $_POST['idsales'];
    $value_status = $_POST['value'];
    $tiperetur = $_POST['tipe'];
    $kelayakanretur = $_POST['kelayakan'];
    $jlhretur = $_POST['jlhretur'];
    $tgltransaksi = $_POST['tgltransaksi'];
    
    $menu = $_POST['menu'];
    $metodepembayaran = $_POST['metodepembayaran'];
    $jatuhtempo = $_POST['jatuhtempo'];
    $namatabnya = $_POST['tabnya'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $total = $_POST['total'];
    $act = $_POST['act'];
    $idkaryawan = $_POST['idkaryawan'];
    $meja = $_POST['meja'];
    $subtotal = $_POST['subtotal'];
    $diskon = $_POST['diskon'];
    $pajak = $_POST['pajak'];
    $jlhdiskon = $_POST['jlhdiskon'];
    $jlhpajak = $_POST['jlhpajak'];
    $grandtotal = $_POST['grandtotal'];
    $note = $_POST['note'];
    $shiftkaryawan = $_POST['shiftkaryawan'];
    $alasan = $_POST['alasan'];
    $subtotal_ = $harga * $jumlah;
    $subtotaldetil = $jumlah * (($harga-$jlhdiskon)+$jlhpajak);
    $kategori = $_POST['kategori'];
    $cash = $_POST['cash'];
    $kembalian = $_POST['kembalian'];
    $printer_kat = $_POST['printer_kat'];

    $tanggal = $_POST['tanggal'];

    $totalSementara = "";

    // untuk fungsi pencarian
    $tab = $_POST['tab'];
    $value_cari = $_POST['value'];

    $minus = $_SESSION['minus'];
    $iduser = $_SESSION['iduser'];
    $role_ = $_SESSION['status'];

    if ($tombol == "simpan") {
        $sql1 = "SELECT * FROM tempjualdetil WHERE idjual='$idjual' AND idmenu='$menu'";
        $query1 = mysqli_query($con, $sql1);
        $num1 = mysqli_num_rows($query1);
        if ($num1 == 0) {
            $sqlmenu = "SELECT * FROM tbmenu where id='$menu'";
            $querymenu = mysqli_query($con, $sqlmenu);
            $cekjumlah = mysqli_fetch_assoc($querymenu);
            if (empty($kodecanvas)) {
                if ($minus == 'Y') {
                    $sql = "INSERT INTO tempjualdetil (idjual,kodecanvas,idkonsumen,idsales,idmenu,iduser,jumlah,harga,total,pajak,jlhpajak,diskon,jlhdiskon,subtotal,note) VALUES ('$idjual','$kodecanvas','$idkonsumen','$idsales','$menu','$iduser','$jumlah','$harga','$subtotaldetil','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotal_','$note')";
                    $query = mysqli_query($con, $sql) or die($sql);

                    echo "sukses";
                } else {
                    if ($cekjumlah['jumlah'] >= $jumlah) {
                        $sql = "INSERT INTO tempjualdetil (idjual,kodecanvas,idkonsumen,idsales,idmenu,iduser,jumlah,harga,total,pajak,jlhpajak,diskon,jlhdiskon,subtotal,note) VALUES ('$idjual','$kodecanvas','$idkonsumen','$idsales','$menu','$iduser','$jumlah','$harga','$subtotaldetil','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotal_','$note')";
                        $query = mysqli_query($con, $sql) or die($sql);

                        echo "sukses";
                    } else {
                        echo "kosong";
                    }
                }
            } else {
                $sql = "INSERT INTO tempjualdetil (idjual,kodecanvas,idkonsumen,idsales,idmenu,iduser,jumlah,harga,total,pajak,jlhpajak,diskon,jlhdiskon,subtotal,note) VALUES ('$idjual','$kodecanvas','$idkonsumen','$idsales','$menu','$iduser','$jumlah','$harga','$subtotaldetil','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotal_','$note')";
                $query = mysqli_query($con, $sql) or die($sql);

                echo "sukses";
            }
        } else { //else cek tempjual
            echo "sudah ada";
        }
    } elseif ($tombol == "edit") {
        if ($act=="edit") {
            $sqlmenu = "SELECT * FROM tbmenu where id='$menu'";
            $querymenu = mysqli_query($con, $sqlmenu);
            $cekjumlah = mysqli_fetch_assoc($querymenu);

            if ($minus == 'Y') {
                $sql = "UPDATE tbjualdetil SET idkonsumen='$idkonsumen',idsales='$idsales',iduser='$iduser',jumlah='$jumlah',harga='$harga',total='$subtotaldetil',pajak='$pajak',jlhpajak='$jlhpajak',diskon='$diskon',jlhdiskon='$jlhdiskon',subtotal='$subtotal_',note='$note' WHERE id='$id'  AND idmenu='$menu'";
                $query = mysqli_query($con, $sql) or die($sql);

                echo "sukses";
            } else {
                if ($cekjumlah['jumlah'] >= $jumlah) {
                    // $jlhdiskon = $jlhdiskon * $jumlah;
                    $sql = "UPDATE tbjualdetil SET idkonsumen='$idkonsumen',idsales='$idsales',iduser='$iduser',jumlah='$jumlah',harga='$harga',total='$subtotaldetil',pajak='$pajak',jlhpajak='$jlhpajak',diskon='$diskon',jlhdiskon='$jlhdiskon',subtotal='$subtotal_',note='$note' WHERE id='$id'  AND idmenu='$menu'";
                    $query = mysqli_query($con, $sql) or die($sql);

                    echo "sukses";
                } else {
                    echo "kosong";
                }
            }
        } else {
            $subtotaldetil = $total + $jlhpajak -$jlhdiskon;
            $sqlmenu = "SELECT * FROM tbmenu where id='$menu'";
            $querymenu = mysqli_query($con, $sqlmenu);
            $cekjumlah = mysqli_fetch_assoc($querymenu);
            if ($minus == 'Y') {
                $sql = "UPDATE tempjualdetil SET idkonsumen='$idkonsumen',idsales='$idsales',iduser='$iduser',jumlah='$jumlah',harga='$harga',total='$subtotaldetil',pajak='$pajak',jlhpajak='$jlhpajak',diskon='$diskon',jlhdiskon='$jlhdiskon',subtotal='$subtotal_',note='$note' WHERE id='$id' AND idmenu='$menu'";
                $query = mysqli_query($con, $sql) or die($sql);

                echo "sukses";
            } else {
                if ($cekjumlah['jumlah'] >= $jumlah) {
                    // $jlhdiskon = $jlhdiskon * $jumlah;
                    $sql = "UPDATE tempjualdetil SET idkonsumen='$idkonsumen',idsales='$idsales',iduser='$iduser',jumlah='$jumlah',harga='$harga',total='$subtotaldetil',pajak='$pajak',jlhpajak='$jlhpajak',diskon='$diskon',jlhdiskon='$jlhdiskon',subtotal='$subtotal_',note='$note' WHERE id='$id' AND idmenu='$menu'";
                    $query = mysqli_query($con, $sql) or die($sql);

                    echo "sukses";
                } else {
                    echo "kosong";
                }
            }
        }
    } elseif ($tombol == "proses") {
        $sqlcek = "SELECT *,SUM(subtotal) AS subtotal_,SUM(total) AS grandtotal_ FROM tempjualdetil WHERE idjual='$idjual'";
        $querycek = mysqli_query($con, $sqlcek);
        $rescek = mysqli_fetch_array($querycek);
        $numcek = mysqli_num_rows($querycek);
        if ($numcek > 0) {
            if ($act == "edit") {
                $sql = "UPDATE tbjual SET subtotal='$rescek[subtotal_]',grandtotal='$rescek[grandtotal_]' WHERE id='$idjual'";
                $query = mysqli_query($con, $sql);
            }
            if ($act == "new") {
                if ($metodepembayaran == 'Cash') {
                    $sql = "INSERT INTO tbjual (id,kodecanvas,iduser,idkonsumen,idsales,tanggal,metode_pembayaran,shift,subtotal,diskon,pajak,grandtotal,cash,kembalian,status_antar) VALUES ('$idjual','$kodecanvas','$iduser','$rescek[idkonsumen]','$rescek[idsales]','$tgltransaksi','$metodepembayaran','1','$subtotal','$rescek[jlhdiskon]','$rescek[jlhpajak]','$grandtotal','$cash','$kembalian','no')";
                    $query = mysqli_query($con, $sql);
                } else {
                    $sql = "INSERT INTO tbjual (id,kodecanvas,iduser,idkonsumen,idsales,tanggal,metode_pembayaran,jatuh_tempo,shift,subtotal,diskon,pajak,grandtotal,cash,kembalian,status_antar) VALUES ('$idjual','$kodecanvas','$iduser','$rescek[idkonsumen]','$rescek[idsales]','$tgltransaksi','$metodepembayaran','$jatuhtempo','1','$subtotal','$rescek[jlhdiskon]','$rescek[jlhpajak]','$grandtotal','$cash','$kembalian','no')";
                    $query = mysqli_query($con, $sql);

                    $sql = "INSERT INTO tbpiutang (id_penjualan,jumlah,sisa,jatuh_tempo) VALUES ('$idjual','$jumlah','$grandtotal','$jatuhtempo')";
                    $query = mysqli_query($con, $sql);
                }
            }
            if ($act == "bayar") {
                $sql = "UPDATE tbjual SET iduser='$iduser',idkonsumen='$rescek[idkonsumen]',metode_pembayaran='$metodepembayaran',jatuh_tempo='$jatuhtempo',idsales='$rescek[idsales]',subtotal='$subtotal',diskon='$rescek[jlhdiskon]',pajak='$rescek[jlhpajak]',grandtotal='$grandtotal', cash ='$cash' ,kembalian='$kembalian',status_antar = 'no' WHERE id='$idjual'";
                $query = mysqli_query($con, $sql);
            }
            // end if act

            // Select data dari tempjualdetil
            $sql2 = "SELECT * FROM tempjualdetil WHERE idjual='$idjual'";
            $query2 = mysqli_query($con, $sql2) or die($sql2);
            while ($res2 = mysqli_fetch_array($query2)) {
                $id = $res2['id'];
                // $jual = $res2['idjual'];
                $idmenu = $res2['idmenu'];
                $iduser = $res2['iduser'];
                $jumlah = $res2['jumlah'];
                $harga = $res2['harga'];
                $diskon = $res2['diskon'];
                $jlhdiskon = $res2['jlhdiskon'];
                $pajak = $res2['pajak'];
                $jlhpajak = $res2['jlhpajak'];
                $total = $res2['total'];
                $subtotaldetil = $res2['subtotal'];
                $note = $res2['note'];

                // Mendapatkan jumlah tbjualdetil
                $sqljumlahdetil = "SELECT * FROM tbjualdetil WHERE idjual='$idjual' AND idmenu = '$res2[idmenu]'";
                $queryjumlahdetil = mysqli_query($con, $sqljumlahdetil);
                $resjumlahdetil = mysqli_fetch_array($queryjumlahdetil);

                $selisihjumlah = (int) $jumlah - (int) $resjumlahdetil['jumlah'];
                // echo $jumlah.' - '.$resjumlahdetil['jumlah'].' ==> '.$selisihjumlah;
                $nilaiselisihjumlah = abs($selisihjumlah);

                // Mendapatkan jumlah
                $sqljumlah = "SELECT * FROM tbmenu WHERE id='$idmenu'";
                $queryjumlah = mysqli_query($con, $sqljumlah);
                $resjumlah = mysqli_fetch_array($queryjumlah);
                $getjumlah = $resjumlah['jumlah'];

                $subtotal_new = (int) $jumlah * (int) $harga;
                $total_new = $subtotal_new + $jlhpajak - $jlhdiskon;

                if ($act == "edit") {
                    $sql = "UPDATE tbjualdetil SET jumlah='$res2[jumlah]', subtotal='$res2[subtotal]',total='$res2[total]' WHERE idjual='$idjual' AND idmenu = '$res2[idmenu]'";
                    $query = mysqli_query($con, $sql)or die($sql);

                    // $sqlretur = "SELECT * FROM tbretur WHERE idjual='$idjual' AND idmenu = '$idmenu'";
                    // $queryretur = mysqli_query($con, $sqlretur) or die($sqlretur);
                    // $resretur = mysqli_fetch_assoc($queryretur);
                    
                    // $jumlahretur = (float) $resretur['jumlah'];
                    if ($selisihjumlah < 0) {
                        $sqlmenu = "UPDATE tbmenu SET jumlah = jumlah + '$nilaiselisihjumlah' WHERE id = '$idmenu'";
                        $querymenu = mysqli_query($con, $sqlmenu) or die($sql);
    
                        $sql = "INSERT INTO tblogsmenu (idmenu,jumlah,kategori,iduser) VALUES ('$idmenu','$nilaiselisihjumlah','masuk','$iduser')";
                        $query =  mysqli_query($con, $sql) or die($sql);
                    }

                    if ($selisihjumlah > 0) {
                        $sqlmenu = "UPDATE tbmenu SET jumlah = jumlah - '$nilaiselisihjumlah' WHERE id = '$idmenu'";
                        $querymenu = mysqli_query($con, $sqlmenu) or die($sql);
    
                        $sql = "INSERT INTO tblogsmenu (idmenu,jumlah,kategori,iduser) VALUES ('$idmenu','$nilaiselisihjumlah','keluar','$iduser')";
                        $query =  mysqli_query($con, $sql) or die($sql);
                    }
                    

                    if ($metodepembayaran == 'credit') {
                        $sql3 = "SELECT (jumlah - $res2[total]) AS selisih FROM tbpiutang WHERE id_penjualan='$idjual'";
                        $query3 = mysqli_query($con, $sql3) or die($sql3);
                        $res3 = mysqli_fetch_array($query3);

                        $sqlpiutang = "UPDATE tbpiutang SET jumlah ='$res2[total]',sisa = sisa - '$res3[selisih]' WHERE id_penjualan = '$idjual'";
                        $querymenu = mysqli_query($con, $sqlpiutang) or die($sql);
                    }
                } else {
                    // Mengurangi jumlah
                    if ($kodecanvas == '') {
                        $jumlahterpakai = $getjumlah - $jumlah;
                        $sqlupdatejumlah = "UPDATE tbmenu SET jumlah='$jumlahterpakai' WHERE id='$idmenu'";
                        $queryupdatejumlah = mysqli_query($con, $sqlupdatejumlah);
                    }

                    $sql3 = "INSERT INTO tbjualdetil (idjual,idmenu,jumlah,harga,total,pajak,jlhpajak,diskon,jlhdiskon,subtotal,note) VALUES ('$idjual','$idmenu','$jumlah','$harga','$total_new','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotal_new','$note')";
                    $query3 = mysqli_query($con, $sql3) or die($sql3);

                    $sql = "INSERT INTO tblogsmenu (idmenu,jumlah,kategori,iduser) VALUES ('$idmenu','$res2[jumlah]','keluar','$iduser')";
                    $query =  mysqli_query($con, $sql) or die($sql);
                }
            }
            // end While tempjualdetil

            // $sql4 = "DELETE FROM tbretur WHERE idjual='$idjual'";
            // $query4 = mysqli_query($con, $sql4) or die($sql4);

            $sql4 = "DELETE FROM tempjualdetil WHERE idjual='$idjual'";
            $query4 = mysqli_query($con, $sql4) or die($sql4);
            echo "sukses";
        } else {
            echo "kosong";
        }
    } elseif ($tombol == "hapus") {
        if ($act == "join") {
            $sql = "SELECT * FROM tbjualdetil where idjual='$idjual' AND idmenu = '$menu'";
            $query = mysqli_query($con, $sql);
            $res = mysqli_fetch_array($query);

            $pajak = $res['jlhpajak'];
            $subtotal = $res['subtotal'];
            $total = $res['total'];
            $diskon = $res['jlhdiskon'];

            $sql = "SELECT * FROM tbjual where id='$idjual'";
            $query = mysqli_query($con, $sql);
            $res = mysqli_fetch_array($query);

            $pajak_ = $res['pajak'] - $pajak;
            $subtotal_ = $res['subtotal'] - $subtotal;
            $grandtotal_ = $res['grandtotal'] - $total;
            $diskon_ = $res['diskon'] - $diskon;

            // print_r($grandtotal_);
            $sqldelupdate = "UPDATE tbjual SET subtotal = '$subtotal_', diskon = '$diskon_',pajak = '$pajak_', grandtotal = '$grandtotal_'  where id='$idjual'";
            $query = mysqli_query($con, $sqldelupdate) or die($sqldelupdate);

            $sql = "delete from tbjualdetil where id='$id'";
            $query = mysqli_query($con, $sql) or die($sql);
        } else {
            $sql = "delete from tempjualdetil where id='$id'";
            $query = mysqli_query($con, $sql) or die($sql);
        }
    } elseif ($tombol == "edittransaksi") {
        $sqlhapus = "DELETE FROM tempjualdetil WHERE idjual='$idjual'";
        $queryhapus = mysqli_query($con, $sqlhapus);

        $sql3 = "SELECT * FROM tbjual WHERE id='$idjual'";
        $query3 = mysqli_query($con, $sql3);
        $res3 = mysqli_fetch_array($query3);
        $idkonsumen = $res3['idkonsumen'];
        $idsales = $res3['idsales'];
        $kodecanvas = $res3['kodecanvas'];

        $sql1 = "SELECT * FROM tbjualdetil WHERE idjual='$idjual'";
        $query1 = mysqli_query($con, $sql1);
        while ($res1 = mysqli_fetch_array($query1)) {
            $idmenu = $res1['idmenu'];
            $jumlah = $res1['jumlah'];
            $harga = $res1['harga'];
            $pajak = $res1['pajak'];
            $jlhpajak = $res1['jlhpajak'];
            $diskon = $res1['diskon'];
            $jlhdiskon = $res1['jlhdiskon'];
            $subtotal = $res1['subtotal'];
            $total = $res1['total'];

            $sql2 = "INSERT INTO tempjualdetil (idjual,kodecanvas,idmenu,idkonsumen,idsales,iduser,jumlah,harga,pajak,jlhpajak,diskon,jlhdiskon,subtotal,total) VALUES ('$idjual','$kodecanvas','$idmenu','$idkonsumen','$idsales','$iduser','$jumlah','$harga','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotal','$total')";
            $query2 = mysqli_query($con, $sql2);
        }

        
        echo "|".$idkonsumen."|".$idsales."|";
    } elseif ($tombol == "hapustransaksi") {
        // Menambah kembali jumlah bahan
        $sqlseldet = "SELECT * FROM tbjualdetil where idjual='$idjual'";
        $queryseldet = mysqli_query($con, $sqlseldet);
        while ($resseldet = mysqli_fetch_array($queryseldet)) {
            $idmenu = $resseldet['idmenu'];
            $jumlahmenu = $resseldet['jumlah'];

            $sqlmenu = "UPDATE tbmenu SET jumlah = jumlah + '$resseldet[jumlah]' WHERE id = '$resseldet[idmenu]'";
            $querymenu = mysqli_query($con, $sqlmenu) or die($sql);

            $sql = "INSERT INTO tblogsmenu (idmenu,jumlah,kategori,iduser) VALUES ('$resseldet[idmenu]','$resseldet[jumlah]','masuk','$iduser')";
            $query =  mysqli_query($con, $sql) or die($sql);
        }

        // Masukkan ke trashjualdetil
        $sqlseldetil = "SELECT * FROM tbjualdetil where idjual='$idjual'";
        $queryseldetil = mysqli_query($con, $sqlseldetil);
        while ($resseldetil = mysqli_fetch_array($queryseldetil)) {
            $idjualdetil = $resseldetil['idjual'];
            $idmenudetil = $resseldetil['idmenu'];
            $jumlahmenudetil = $resseldetil['jumlah'];
            $hargadetil = $resseldetil['harga'];
            $totaldetil = $resseldetil['total'];
            $diskon = $resseldetil['diskon'];
            $jlhdiskon = $resseldetil['jlhdiskon'];
            $pajak = $resseldetil['pajak'];
            $jlhpajak = $resseldetil['jlhpajak'];
            $subtotal = $resseldetil['subtotal'];

            $sqltrashdetil = "insert into trashjualdetil (idjual,idmenu,iduser,jumlah,harga,total,diskon,jlhdiskon,pajak,jlhpajak,subtotal) values ('$idjualdetil','$idmenudetil','$iduser','$jumlahmenudetil','$hargadetil','$totaldetil','$diskon','$jlhdiskon','$pajak','$jlhpajak','$subtotal')";
            $querytrashdetil = mysqli_query($con, $sqltrashdetil);
        }

        // Masukkan ke trashjual
        $sqlseljual = "SELECT * FROM tbjual where id='$idjual'";
        $queryseljual = mysqli_query($con, $sqlseljual);
        while ($resseljual = mysqli_fetch_array($queryseljual)) {
            $idkaryawanjual = $resseljual['idkaryawan'];
            $tanggaljual = $resseljual['tanggal'];
            $shiftjual = $resseljual['shift'];
            $mejajual = $resseljual['meja'];
            $subtotaljual = $resseljual['subtotal'];
            $diskonjual = $resseljual['diskon'];
            $pajakjual = $resseljual['pajak'];
            $grandtotaljual = $resseljual['grandtotal'];
            $cashjual = $resseljual['cash'];
            $kembalianjual = $resseljual['kembalian'];

            $sqltrashjual = "insert into trashjual (id,iduser,idkaryawan,tanggal,shift,meja,subtotal,diskon,pajak,grandtotal,cash,kembalian,alasan) values ('$idjual','$iduser','$idkaryawanjual','$tanggaljual','$shiftjual','$mejajual','$subtotaljual','$diskonjual','$pajakjual','$grandtotaljual','$cashjual','$kembalianjual','$alasan')";
            $querytrashjual = mysqli_query($con, $sqltrashjual);
        }


        // Hapus data tbjualdetil
        $sqldel = "DELETE FROM tbjualdetil WHERE idjual='$idjual'";
        $querydel = mysqli_query($con, $sqldel);

        // Hapus data tbjual
        $sqldel2 = "DELETE FROM tbjual WHERE id='$idjual'";
        $querydel2 = mysqli_query($con, $sqldel2);
    } elseif ($tombol == "hapustransaksi_table") {
        // Hapus data tbjualdetil
        $sqldel = "delete from tempjualdetil where idjual='$idjual'";
        $querydel = mysqli_query($con, $sqldel);

        // Hapus data tbjual
        $sqldel2 = "delete from tbjual where id='$idjual'";
        $querydel2 = mysqli_query($con, $sqldel2);
    } elseif ($tombol == "periksapenjualan") {
        // if(strlen($idjual) == 4) {
        //     $sqlid = "SELECT id FROM tbjual WHERE id='$idjual'";
        //     $queryid = mysqli_query($con, $sqlid);
        //     $resid = mysqli_fetch_array($queryid);
        //     $idjual = $resid['id'];
        // }

        $sql = "SELECT * FROM tbjual WHERE id='$idjual'";
        $query = mysqli_query($con, $sql);
        $num = mysqli_num_rows($query);
        if ($num == "0") {
            echo "no|";
        } else {
            echo "yes|".$idjual;
        }
    } elseif ($tombol == "loadreview") {
        $sql = "select SUM(jlhpajak) as pajak, SUM(jlhdiskon) as diskon, SUM(subtotal) as subtotal, SUM(total) as total from tempjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query);


            
        $subtotal = $res['subtotal'];
        $diskon = $res['diskon'];
        $pajak = $res['pajak'];
        $grandtotal = $res['total'];
        // $meja = $res['meja'];

        $sql = "select meja from tbjual where id='$idjual'";
        $query = mysqli_query($con, $sql);
        $ress = mysqli_fetch_array($query);
        echo "|".$subtotal."|".$diskon."|".$pajak."|".$grandtotal."|".$ress['meja']."|";
    } elseif ($tombol == "tampilreview") {
        ?>
<table class="table table-review table-striped" style="display:block; table-layout: fixed;border-collapse: collapse;">
    <thead>
        <tr>
            <th style="width:8px;">No</th>
            <th style="width:170px;">Menu</th>
            <th style="width:60px;">Harga</th>
            <th style="width:35px;">Qty</th>
            <th class="pri-2" style="width:90px;">Diskon</th>
            <th class="pri-2" style="width:90px;">Pajak</th>

            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody style="display:block;min-height: 300px;overflow-y: auto;overflow-x: hidden;">
        <?php
                    $no=1;
        $sqlreview = "select tempjualdetil.*,tbmenu.nama from tempjualdetil join tbmenu ON tempjualdetil.idmenu=tbmenu.id where idjual = '$idjual' order by tbmenu.nama asc";
        $queryreview = mysqli_query($con, $sqlreview);
        while ($res = mysqli_fetch_array($queryreview)) {
            ?>
        <tr>
            <td style="width:8px;"><?php echo $no++ ?>
            </td>
            <td style="width:170px;"><?php echo $res['nama'] ?>
            </td>
            <td style="width:60px;"><?php echo uang($res['harga']) ?>
            </td>
            <td style="width:40px;"><?php echo $res['jumlah'] ?>
            </td>
            <td class="pri-2" style="width:90px;"><?php echo $res['diskon'] ?>% (Rp.
                <?php echo(($res['diskon']/100) * $res['harga']); ?>)
            </td>
            <td class="pri-2" style="width:90px;"><?php echo $res['pajak'] ?>% (Rp.
                <?php echo(($res['jlhpajak'])); ?>)
            </td>
            <td style="width:90px;"><?php echo uang($res['total']); ?>
            </td>
        </tr>
        <?php
        } ?>
    </tbody>
    <tfoot style="display:block;">
        <?php
                    $sql = "select sum(subtotal) from tempjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query); ?>
    </tfoot>
</table>
<?php
    } elseif ($tombol == "tampiledit") {
        $sql = "SELECT tempjualdetil.*, tbmenu.isi_kemasan,tbmenu.satuan FROM tempjualdetil LEFT JOIN tbmenu ON tempjualdetil.idmenu = tbmenu.id WHERE tempjualdetil.id='$id'";
        $query = mysqli_query($con, $sql) or die($sql);

        $re = mysqli_fetch_array($query);
        $menu = $re['idmenu'];
        $idkonsumen = $re['idkonsumen'];
        $idsales = $re['idsales'];
        $jumlah = $re['jumlah'];
        $harga = $re['harga'];
        $total = $re['total'];
        $diskon = $re['diskon'];
        $jlhdiskon = $re['jlhdiskon'];
        $pajak = $re['pajak'];
        $jlhpajak = $re['jlhpajak'];
        $note = $re['note'];
        $isi_kemasan = $re['isi_kemasan'];
        $satuan = $re['satuan'];


        echo "|".$id."|".$menu."|".$idkonsumen."|".$idsales."|".$jumlah."|".$harga."|".$total."|".$diskon."|".$jlhdiskon."|".$pajak."|".$jlhpajak."|".$note."|".$isi_kemasan."|".$satuan."|";
    } elseif ($tombol == "hitungtotal") {
        $sql = "select sum(total), sum(jlhdiskon), sum(jlhpajak), sum(subtotal) from tempjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query);
        $totalharga = $res[0];
        $totaldiskon = $res[1];
        $totalpajak = $res[2];
        $totalsubtotal = $res[3];
        $totalSementara = $res[3];
        echo $totalharga."|".$totaldiskon."|".$totalpajak."|".$totalsubtotal;
    } elseif ($tombol == "hitungtotaltbjual") {
        $sql = "select sum(total), sum(jlhdiskon), sum(jlhpajak), sum(subtotal) from tbjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query);
        $totalharga = $res[0];
        $totaldiskon = $res[1];
        $totalpajak = $res[2];
        $totalsubtotal = $res[3];
        $totalSementara = $res[3];
        echo $totalharga."|".$totaldiskon."|".$totalpajak."|".$totalsubtotal;
    } elseif ($tombol == "cancel") {
        $sql = "delete from tempjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        echo mysqli_error($con);
    } elseif ($tombol == "cekkonsumen") {
        $sql = "SELECT * FROM tbkonsumen WHERE id=$idkonsumen";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query);
        $nama = $res['nama'];
        $wilayah = $res['wilayah'];
        $kategori = $res['kategori'];
        $rate_pajak = $res['rate_pajak'];
        $max_hutang = $res['max_hutang'];

        echo "|".$nama."|".$wilayah."|".$kategori."|".$rate_pajak."|".$max_hutang;
    } elseif ($tombol == "tampilmenu") {
        $sql = "SELECT * FROM tbmenu where id='$menu'";
        $query = mysqli_query($con, $sql) or die($sql);
  
        $re = mysqli_fetch_array($query);
        $id = $re['id'];
        $menu = $re['nama'];
        $wilayah = $re['wilayah'];
        $jenis = $re['jenis_market'];
        $hargadk = $re['harga_dk'];
        $hargalk = $re['harga_lk'];
        $hargadepo = $re['harga_depo'];
        $hargamodern = $re['harga_modern'];
        $hargatradisional = $re['harga_tradisional'];
        $hargaagen = $re['harga_agen'];
        $hargauser = $re['harga_user'];
        $diskon = $re['diskon'];
        $pajak = $re['pajak'];
        $satuan = $re['satuan'];
        $kategori = $re['kategori'];
        $jumlah = $re['jumlah'];
        $isikemasan = $re['isi_kemasan'];
        
        echo "|".$id."|".$menu."|".$wilayah."|".$jenis."|".$hargadk."|".$hargalk."|".$hargadepo."|".$hargamodern."|".$hargatradisional."|".$hargaagen."|".$hargauser."|".$diskon."|".$pajak."|".$satuan."|".$kategori."|".$jumlah."|".$isikemasan."|";
    } elseif ($tombol == "tampidetailcanvas") {
    } elseif ($tombol == "tampiljoinview") {
        ?>
<table id="datatable-fixed-header" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><span style="display: none;">a</span></th>
            <th>No</th>
            <th>Menu</th>
            <th>Harga</th>
            <th>Qty</th>
            <th><span style="display: none;"></span></th>
        </tr>
    </thead>

    <tbody>
        <?php
          if ($act == "join") {
              $trash = "";
          } else {
              $trash = "";
          }
        $no = 1;
        $sqlsel = "select tbjualdetil.*,tbmenu.nama from tbjualdetil left join tbmenu on tbjualdetil.idmenu=tbmenu.id where idjual='$idjual'";
        $querysel = mysqli_query($con, $sqlsel);
        while ($res = mysqli_fetch_array($querysel)) {
            $id = $res['id'];
            $idmenu_ = $res['idmenu'];
            $menu = $res['nama'];
            $jumlah = $res['jumlah'];
            $harga = $res['harga'];
            $total = $res['total'];
            $diskon = $res['diskon'];
            $jlhdiskon = $res['jlhdiskon'];
            $pajak = $res['pajak'];
            $jlhpajak = $res['jlhpajak'];
            $subtotal = $res['subtotal'];
            $note = $res['note']; ?>
        <tr id="<?php echo $no; ?>">
            <td rowspan='2' class='align-middle'><button <?php echo $trash; ?> type='button' class='btn
                    btn-circle
                    btn-mn btn-danger'
                    onclick='f_hapus("<?php echo $no; ?>","<?php echo $id; ?>","<?php echo $idmenu_; ?>")'><span style='font-size:10px'
                        class='oi oi-trash'></span></button></td>
            <td rowspan='2' class='align-middle'><?php echo $no; ?>
            </td>
            <td class=''><?php echo $menu; ?>
            </td>
            <td class=''><?php echo "Rp ".uang($harga); ?>
            </td>
            <td rowspan='2' class='align-middle text-center'>
                <!-- <span style='font-size: 2rem' id='qty<?php //echo $no;?>'
                class='badge badge-primary'><?php //echo $jumlah;?></span> -->
                <input
                    style="width: 50px;height: 50px;font-size: 2rem;padding: 0px;text-align: center; background-color:#f4f4f4 ;border:none"
                    type="text" id="qty<?php echo $no; ?>" name="qty"
                    value="<?php echo $jumlah; ?>">
            </td>
            <td rowspan='2' class='align-middle'>
                <div class='btn-group-vertical'>
                    <button type='button' id="btnPlus"
                        onclick='tambahQty("<?php echo $no; ?>","<?php echo $harga; ?>","<?php echo $id; ?>")'
                        class='btn btn-circle btn-mn btn-primary'><span style='font-size:10px'
                            class='oi oi-plus'></span></button>
                    <button type='button' id="btnMin"
                        onclick='kurangQty("<?php echo $no; ?>","<?php echo $harga; ?>","<?php echo $id; ?>")'
                        class='btn btn-circle  btn-mn btn-primary'><span style='font-size:10px'
                            class='oi oi-minus'></span></button>
                </div>
            </td>
        </tr>
        <tr id="<?php //echo $no;?>" style="display: none;"></tr>
        <tr id="<?php echo $no; ?>_ch">
            <td style="display: none;"></td>
            <td style="display: none;"></td>
            <td colspan='2' class='align-middle text-center' style='padding-left:0px;padding-right:0px;'>
                <div class='row'>
                    <button onclick='diskon("<?php echo $id; ?>")'
                        class='btn btn-outline btn-primary btn-sm col-4'><small>Disc</small><span
                            class='badge badge-primary'><?php echo $diskon."%"; ?></span></small></button>

                    <button
                        onclick='hitungpajak("<?php echo $id; ?>")'
                        class='btn btn-outline btn-success btn-sm col-3'><small>Pajak</small><span
                            class='badge badge-success'><?php echo $pajak." %"; ?></span></button>
                    <button onclick='note("<?php echo $id; ?>")'
                        class='btn btn-outline btn-default btn-sm col-4'><small>Note</small></button>
                </div>
            </td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
        </tr>
        <?php
            $no++;
        } ?>
    </tbody>
</table>
<script>
    $('#datatable-fixed-header').DataTable({
        fixedHeader: true,
        "searching": false, // Search Box will Be Disabled
        //"ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled
        "info": true, // Will show "1 to n of n entries" Text at bottom
        "paging": false,
        "lengthChange": false // Will Disabled Record number per page
    });
</script>
<?php
    } elseif ($tombol == "tampil") {
        ?>
<table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
    width="100%">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php
                    $sqlsel = "SELECT tempjualdetil.*,tbmenu.nama,tbmenu.kode_barang FROM tempjualdetil LEFT JOIN tbmenu ON tempjualdetil.idmenu=tbmenu.id WHERE idjual='$idjual'";
        $querysel = mysqli_query($con, $sqlsel);
        while ($res = mysqli_fetch_array($querysel)) {
            $id = $res['id'];
            $menu = $res['nama'];
            $kodebarang = $res['kode_barang'];
            $jumlah = $res['jumlah'];
            $harga = $res['harga'];
            $total = $res['total']; ?>
        <tr>
            <td><?php echo $kodebarang." - ".$menu; ?>
            </td>
            <td><?php echo $jumlah; ?>
            </td>
            <td><?php echo "Rp ".uang($harga); ?>
            </td>
            <td><?php echo "Rp ".uang($total); ?>
            </td>
            <td>
                <button class="btn btn-xs btn-warning"
                    onclick="f_edit('<?php echo $id; ?>')">Edit</button>
                <button class="btn btn-xs btn-danger"
                    onclick="f_hapus('<?php echo $id; ?>')">Hapus</button>
            </td>
        </tr>
        <?php
        } ?>
    </tbody>
</table>
<script>
    $('#datatable-fixed-header').DataTable({
        fixedHeader: true,
        "searching": false, // Search Box will Be Disabled
        "paging": false,
        "info": false, // Will show "1 to n of n entries" Text at bottom
        "lengthChange": false // Will Disabled Record number per page
    });
</script>
<?php
    } elseif ($tombol == "print_faktur") {
        $sql = "SELECT * FROM tbstatprinter where kategori_printer='$printer_kat'";
        $query = mysqli_query($con, $sql) or die($sql);
  
        $re = mysqli_fetch_array($query);
        $stat = $re['status_printer'];
        $ip = $re['ip_printer'];
        echo "|".$stat."|".$ip."|";
    } elseif ($tombol == "print_faktur1") {
        $sql = "SELECT * FROM tbstatprinter where kategori_printer='$printer_kat'";
        $query = mysqli_query($con, $sql) or die($sql);
  
        $re = mysqli_fetch_array($query);
        $stat = $re['status_printer'];
        $ip = $re['ip_printer'];
        echo "|".$stat."|".$ip."|";
    } elseif ($tombol == 'awal') {
        $sqlmenu = "SELECT * FROM tbmenu where kategori != 'Paket' order by nama asc";
        $querymenu = mysqli_query($con, $sqlmenu);
        while ($res = mysqli_fetch_array($querymenu)) {
            // echo $res['harga'];?>
<div class="col-md-6" style="padding:10px;"
    onclick="myPesan('<?php echo $res['id']; ?>','<?php echo $res['nama']; ?>','<?php echo $res['harga']; ?>')">
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:0px">
            <?php
                            $img_url=$res['img_url'];
            // cek gambar kosong
            if (empty($img_url)) {
                $img_url="dummy.jpeg";
            } else {
                $img_url=$res['img_url'];
            } ?>
            <img src="asset/img/<?php echo $img_url; ?>"
                class="card-img img-responsive" alt="Cinque Terre">
            <div class="card-img-overlay">
                <h4 class="card-title text-wrap text-left"><span class="label label-primary"><?php echo $res['nama'] ?></span>
                </h4>

                <h3 class="card-text"><span class="label label-warning">
                        Rp. <?php echo uang($res['harga']); ?></span>
                    <?php
                                                if ($res['diskon'] !=  0) {
                                                    echo "<span class='badge badge-danger'> Disc ".$res['diskon']."%</span>";
                                                } ?>
                </h3>
            </div>
        </div>
    </div>
</div>
<?php
        }
        // end while
    } elseif ($tombol == 'awalPaket') {
        $sqlmenu = "SELECT * FROM tbmenu where kategori = '$namatabnya' order by nama asc";
        $querymenu = mysqli_query($con, $sqlmenu);
        while ($res = mysqli_fetch_array($querymenu)) {
            // echo $res['harga'];?>
<div class="col-md-6" style="padding:10px;"
    onclick="myPesan('<?php echo $res['id']; ?>','<?php echo $res['nama']; ?>','<?php echo $res['harga']; ?>')">
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:0px">
            <?php
                            $img_url=$res['img_url'];
            // cek gambar kosong
            if (empty($img_url)) {
                $img_url="dummy.jpeg";
            } else {
                $img_url=$res['img_url'];
            } ?>
            <img src="asset/img/<?php echo $img_url; ?>"
                class="card-img img-responsive" alt="Cinque Terre">
            <div class="card-img-overlay">
                <h4 class="card-title text-wrap text-left">
                    <span class="label label-primary"><?php echo $res['nama'] ?>
                </h4>
                <h3 class="card-text"><span class="label label-warning">
                        Rp. <?php echo uang($res['harga']) ?></span>
                    <?php
                                                if ($res['diskon'] !=  0) {
                                                    echo "<span class='badge badge-danger'> Disc ".$res['diskon']."%</span>";
                                                } ?>

                    <h3>
            </div>
        </div>
    </div>
</div>
<?php
        }
        // end while
    } elseif ($tombol == 'awalPromo') {
        $sqlmenu = "SELECT * FROM tbmenu where diskon != '0' order by nama asc";
        $querymenu = mysqli_query($con, $sqlmenu);
        while ($res = mysqli_fetch_array($querymenu)) {
            // echo $res['harga'];?>

<div class="col-md-6" style="padding:10px;"
    onclick="myPesan('<?php echo $res['id']; ?>','<?php echo $res['nama']; ?>','<?php echo $res['harga']; ?>')">
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:0px">
            <?php
                            $img_url=$res['img_url'];
            // cek gambar kosong
            if (empty($img_url)) {
                $img_url="dummy.jpeg";
            } else {
                $img_url=$res['img_url'];
            } ?>
            <img src="asset/img/<?php echo $img_url; ?>"
                class="card-img img-responsive" alt="Cinque Terre">
            <div class="card-img-overlay">
                <h4 class="card-title text-wrap text-left">
                    <span class="label label-primary"><?php echo $res['nama'] ?>
                </h4>
                <h3 class="card-text"><span class="label label-warning">
                        Rp. <?php echo uang($res['harga']) ?></span>
                    <span class="badge badge-danger"> Disc
                        <?php echo $res['diskon']; ?>%</span>
                    <h3>
            </div>
        </div>
    </div>
</div>

<?php
        }
        // end while
    } elseif ($tombol == "cari") {
        if ($tab == "All") {
            //  Pencarian Menu
            $sqlmenu = "SELECT * FROM tbmenu where nama like '%$value_cari%' and kategori != 'Paket'";
            $querymenu = mysqli_query($con, $sqlmenu);
            while ($res = mysqli_fetch_array($querymenu)) {
                ?>
<div class="col-md-6" style="padding:10px;"
    onclick="myPesan('<?php echo $res['id']; ?>','<?php echo $res['nama']; ?>','<?php echo $res['harga']; ?>')">
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:0px">
            <?php
                        $img_url=$res['img_url'];
                // cek gambar kosong
                if (empty($img_url)) {
                    $img_url="dummy.jpeg";
                } else {
                    $img_url=$res['img_url'];
                } ?>
            <img src="asset/img/<?php echo $img_url; ?>"
                class="card-img img-responsive" alt="Cinque Terre">
            <div class="card-img-overlay">
                <h4 class="card-title text-wrap text-left">
                    <span class="label label-primary"><?php echo $res['nama'] ?>
                </h4>
                <h3 class="card-text"><span class="label label-warning">
                        Rp. <?php echo uang($res['harga']) ?></span>

                    <?php
                                    if ($res['diskon']!='0') {
                                        echo '<span class="badge badge-danger"> Disc '.$res['diskon'].'</span>';
                                    } ?>
                    <h3>
            </div>
        </div>
    </div>
</div>
<?php
            }
        } else {
            // Pencarian Paket
            $sqlmenu = "SELECT * FROM tbmenu where kategori='$tab' and nama like '%$value_cari%'";
            $querymenu = mysqli_query($con, $sqlmenu);
            while ($res = mysqli_fetch_array($querymenu)) {
                ?>
<div class="col-md-6" style="padding:10px;"
    onclick="myPesan('<?php echo $res['id']; ?>','<?php echo $res['nama']; ?>','<?php echo $res['harga']; ?>')">
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:0px">
            <?php
                        $img_url=$res['img_url'];
                // cek gambar kosong
                if (empty($img_url)) {
                    $img_url="dummy.jpeg";
                } else {
                    $img_url=$res['img_url'];
                } ?>
            <img src="asset/img/<?php echo $img_url; ?>"
                class="card-img img-responsive" alt="Cinque Terre">
            <div class="card-img-overlay">
                <h4 class="card-title text-wrap text-left">
                    <span class="label label-primary"><?php echo $res['nama'] ?>
                </h4>
                <h3 class="card-text"><span class="label label-warning">
                        Rp. <?php echo uang($res['harga']) ?></span>
                    <h3>
            </div>
        </div>
    </div>
</div>
<?php
            }
        }
    } elseif ($tombol == "load_detail_firebase") {
        if ($value_status == "bayar") {
            $sql = "SELECT tbmenu.kategori FROM tbjualdetil JOIN tbmenu ON tbjualdetil.idmenu=tbmenu.id where tbjualdetil.idjual='$idjual' GROUP BY tbmenu.kategori ORDER BY tbmenu.kategori ASC";
            $query = mysqli_query($con, $sql);
            while ($res_j_det = mysqli_fetch_array($query)) {
                $kategori = $res_j_det['kategori'];

                $sql2 = "SELECT tbjualdetil.*,tbmenu.nama FROM tbjualdetil JOIN tbmenu ON tbjualdetil.idmenu=tbmenu.id where tbjualdetil.idjual='$idjual' AND tbmenu.kategori ='$kategori' ORDER BY tbmenu.nama ASC";
                $query2 = mysqli_query($con, $sql2);
                while ($res_j = mysqli_fetch_array($query2)) {
                    $detail .= $res_j['nama'].'#'.$res_j['harga'].'#'.$res_j['jumlah'].'#'.$res_j['subtotal'].'#'.$res_j['note']."_";
                }

                substr($detail, 0, -1);
                $detail.= "%";
            }
            // end while
        } else {
            $sql = "SELECT tbmenu.kategori FROM tempjualdetil JOIN tbmenu ON tempjualdetil.idmenu=tbmenu.id where tempjualdetil.idjual='$idjual' GROUP BY tbmenu.kategori ORDER BY tbmenu.kategori ASC";
            $query = mysqli_query($con, $sql);
            while ($res_j_det = mysqli_fetch_array($query)) {
                $kategori = $res_j_det['kategori'];

                $sql2 = "SELECT tempjualdetil.*,tbmenu.nama FROM tempjualdetil JOIN tbmenu ON tempjualdetil.idmenu=tbmenu.id where tempjualdetil.idjual='$idjual' AND tbmenu.kategori ='$kategori' ORDER BY tbmenu.nama ASC";
                $query2 = mysqli_query($con, $sql2);
                while ($res_j = mysqli_fetch_array($query2)) {
                    $detail .= $res_j['nama'].'#'.$res_j['harga'].'#'.$res_j['jumlah'].'#'.$res_j['subtotal'].'#'.$res_j['note']."_";
                }
                substr($detail, 0, -1);
                $detail.= "%";
            }
            // end while
        }
        // end if cek status pembayaran bayar atau simpan

        $sql_tbjual = "SELECT tbjual.*, tbuser.nama, tbkaryawan.nama AS nama_k FROM tbjual JOIN tbuser ON tbjual.iduser=tbuser.iduser JOIN tbkaryawan ON tbjual.idkaryawan = tbkaryawan.id where tbjual.id='$idjual'";
        $query_tbjual = mysqli_query($con, $sql_tbjual);
        $resJual = mysqli_fetch_assoc($query_tbjual);

        echo "|".$detail."|".$resJual['subtotal']."|".$resJual['diskon']."|".$resJual['pajak']."|".$resJual['grandtotal']."|".$resJual['cash']."|".$resJual['kembalian']."|".$resJual['nama_k']."|".$resJual['meja']."|".$resJual['nama']."|";

    // END tombol load_detail_firebase
    } elseif ($tombol == "loaddetail") {
        $sql = "select tbjual.*, tbuser.nama from tbjual join tbuser ON tbjual.iduser=tbuser.iduser where id='$idjual'";
        $query = mysqli_query($con, $sql);
        $resJual = mysqli_fetch_array($query); ?>

<div class="row" style="margin-bottom:30px;">
    <div class="col-xs-6">
        <h5>No. Transaksi</h5>
        <h5 style="font-style:italic;"><span class="fas fa-hand-holding-usd"
                style="margin-right:10px;"></span><strong>#<?php echo $resJual['id'] ?></strong>
        </h5>
        <h5>User</h5>
        <p><span class="fas fa-user" style="margin-right:10px;"></span><?php echo $resJual['nama'] ?>
        </p>
    </div>
    <div class="col-xs-6">
        <h5>Tanggal</h5>
        <p><span class="fas fa-calendar-alt" style="margin-right:10px;"></span><?php echo $resJual['tanggal'] ?>
        </p>

        <h5>Meja</h5>
        <h4 class="label label-primary" style="font-size:2rem;font-style:italic;"><?php echo $resJual['meja'] ?>
        </h4>
    </div>
</div>

<table id="table_detail" class="table display" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Menu</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Diskon</th>
            <th>Subtotal</th>
        </tr>
        <div class="clearfix"></div>
    </thead>
    <tbody>
        <?php
                    $no=1;
        $sqlreview = "select tbjualdetil.*,tbmenu.nama from tbjualdetil join tbmenu ON tbjualdetil.idmenu=tbmenu.id where idjual = '$idjual' order by tbmenu.nama asc";
        $queryreview = mysqli_query($con, $sqlreview);
        while ($res = mysqli_fetch_array($queryreview)) {
            ?>
        <tr>
            <td><?php echo $no++ ?>
            </td>
            <td><?php echo $res['nama'] ?>
            </td>
            <td><?php echo uang($res['harga']) ?>
            </td>
            <td><?php echo $res['jumlah'] ?>
            </td>
            <td><?php echo $res['diskon'] ?>%
                (Rp. <?php echo(($res['diskon']/100) * $res['harga']); ?>)
            </td>
            <td><?php echo uang($res['subtotal']); ?>
            </td>
        </tr>
        <?php
        } ?>
    </tbody>

    <tfoot>
        <?php
                    $sql = "select sum(subtotal) from tbjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query); ?>

    </tfoot>
</table>
<script>
    $('#table_detail').DataTable({
        "scrollY": "50vh",
        "scrollCollapse": true,
        "paging": false,
        "fixedHeader": false,
        "searching": false
    });
</script>
<?php
    } elseif ($tombol == "joinbill") {
        ?>
<table class="table table-striped" id="tablejoinbill">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>User</th>
            <th>Meja</th>
            <th>Total</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $sqlreview = "SELECT * FROM tbjual where statbayar = 'belum' AND id!='$idjual'";
        $queryreview = mysqli_query($con, $sqlreview);
        while ($res = mysqli_fetch_array($queryreview)) {
            $id = $res['id'];
            $user = $res['iduser'];
            $meja = $res['meja'];
            $grandtotal = $res['grandtotal']; ?>
        <tr>
            <td></td>
            <td><?php echo $id ?>
            </td>
            <td><?php echo $user ?>
            </td>
            <td><?php echo $meja ?>
            </td>
            <td><?php echo uangRp($grandtotal) ?>
            </td>
        </tr>
        <?php
        } ?>
    </tbody>
</table>

<script>
    var table = $('#tablejoinbill').DataTable({
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        order: [
            [1, 'asc']
        ],

        "searching": false, // Search Box will Be Disabled
        //"ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled
        "info": true, // Will show "1 to n of n entries" Text at bottom
        "paging": false,
        "lengthChange": false // Will Disabled Record number per page
    });

    //  var rows_selected = table.column(0).checkboxes.selected();

    $('#tablejoinbill tbody').on('click', 'tr', function() {
        var datas = table.row(this).data();
        idJual_join = datas[1];

        reviewbill(idJual_join);
    });
</script>
<?php
    } elseif ($tombol == "prosesjoinbill") {
        // print_r($_POST);
        $sqljoin = "SELECT * FROM tempjualdetil where idjual='$idjual_ganti'";
        $queryjoin = mysqli_query($con, $sqljoin);
        while ($res = mysqli_fetch_array($queryjoin)) {
            //   $data[] = $res;
            $idtempjual_ganti = $res['id'];
            // echo($idtempjual_ganti);
            $sqljoinupdate = "UPDATE tempjualdetil SET idjual = '$idjual_awal' where id='$idtempjual_ganti'";
            $query = mysqli_query($con, $sqljoinupdate) or die($sqljoinupdate);
        }

        // echo "1".mysqli_error($con);

        // select idjual yang akan dihapus/diganti
        $sqljoin = "SELECT * FROM tbjual where id='$idjual_ganti'";
        $query = mysqli_query($con, $sqljoin);
        $resjoin = mysqli_fetch_array($query);
        $subtotal_ganti =$resjoin['subtotal'];
        $diskon_ganti =$resjoin['diskon'];
        $pajak_ganti =$resjoin['pajak'];
        $grandtotal_ganti =$resjoin['grandtotal'];

        // select idjual yang dijoin bill
        $sqlawal = "SELECT * FROM tbjual where id='$idjual_awal'";
        $query = mysqli_query($con, $sqlawal);
        $resawal = mysqli_fetch_array($query);
        $subtotal_awal =(int)$resawal['subtotal'] + (int)$subtotal_ganti;
        $diskon_awal =(int)$resawal['diskon'] + (int)$diskon_ganti;
        $pajak_awal =(int)$resawal['pajak'] + (int)$pajak_ganti;
        $grandtotal_awal =(int)$resawal['grandtotal'] + (int)$grandtotal_ganti;

        //update diskon,pajak,subtotal,grandtotal tbjual
        $sqljualupdate = "UPDATE tbjual SET subtotal = '$subtotal_awal',diskon = '$diskon_awal', pajak = '$pajak_awal',grandtotal = '$grandtotal_awal' where id='$idjual_awal'";
        $query = mysqli_query($con, $sqljualupdate) or die($sqljualupdate);

        //Delete from tbjual where idjual yang lama
        $sqljualdelete = "DELETE FROM tbjual where id='$idjual_ganti'";
        $query = mysqli_query($con, $sqljualdelete) or die($sqljualdelete);
        

    // print_r($data);
    } elseif ($tombol == "cekstok") {
        $sqlmenu = "SELECT * FROM tbmenu where id='$menu'";
        $querymenu = mysqli_query($con, $sqlmenu);
        $resmenu = mysqli_fetch_array($querymenu);

        if ($kategori == "Paket") {
            $sqlmenu = "SELECT * FROM tbdetailpaket where id_paket='$menu'";
            $querymenu = mysqli_query($con, $sqlmenu);
            $y = 0;
            while ($resmenu = mysqli_fetch_array($querymenu)) {
                $id_menu = $resmenu['id_menu'];
                $jumlah_paket = $resmenu['jumlah'];

                $sqlbahan = "SELECT * FROM tbresep where idmenu='$id_menu'";
                $querybahan = mysqli_query($con, $sqlbahan);
                
                while ($resbahan = mysqli_fetch_array($querybahan)) {
                    $idbahan = $resbahan['idbahan'];
                    $jumlahbahan = $resbahan['jumlah'];

                    $jumlahterpakai = $jumlah * ($jumlah_paket * $jumlahbahan);
                    $sqlcekbahan = "select jumlah-$jumlahterpakai from tbbahan where id='$idbahan'";
                    $querycekbahan = mysqli_query($con, $sqlcekbahan);
                    $rescek = mysqli_fetch_array($querycekbahan);
                    $hasilperiksa = $rescek[0];
                    if ($hasilperiksa<0) {
                        $y++;
                    }
                }
            }
        } else {
            $sqlbahan = "SELECT * FROM tbresep where idmenu='$menu'";
            $querybahan = mysqli_query($con, $sqlbahan);
            $y = 0;
            while ($resbahan = mysqli_fetch_array($querybahan)) {
                $idbahan = $resbahan['idbahan'];
                $jumlahbahan = $resbahan['jumlah'];

                $jumlahterpakai = $jumlah * $jumlahbahan;
                $sqlcekbahan = "select jumlah-$jumlahterpakai from tbbahan where id='$idbahan'";
                $querycekbahan = mysqli_query($con, $sqlcekbahan);
                $rescek = mysqli_fetch_array($querycekbahan);
                $hasilperiksa = $rescek[0];
                if ($hasilperiksa<0) {
                    $y++;
                }
            }
        }
        // end if kategori paket
    } elseif ($tombol == "print_faktur_recta") {
        $sql_license = "select * from license where id='1'";
        $query_license = mysqli_query($con, $sql_license);
        $res = mysqli_fetch_array($query_license);

        $nama_perusahaan = $res['nama'];
        $alamat_perusahaan = $res['alamat'];
        $telp_perusahaan = $res['telp'];
        $icon = $res['icon'];
        $minus = $res['minus'];
        $shift1 = $res['shift1'];
        $shift2 = $res['shift2'];
        $shift3 = $res['shift3'];
        $idtoko = $res['idtoko'];
        $printer = $res['printer'];
        $instagram = $res['instagram'];

        $sqljual = "select * from tbjual where id='$idjual'";
        $queryjual = mysqli_query($con, $sqljual);
        $resjual = mysqli_fetch_array($queryjual);

        $subtotal = $resjual['subtotal'];
        $diskon = $resjual['diskon'];
        $pajak = $resjual['pajak'];
        $grandtotal = $resjual['grandtotal'];
        $meja = $resjual['meja'];
        $idkaryawan = $resjual['idkaryawan'];

        $sqlkaryawan = "select * from tbkaryawan where id='$idkaryawan'";
        $querykaryawan = mysqli_query($con, $sqlkaryawan);
        $reskaryawan = mysqli_fetch_array($querykaryawan);

        $namakaryawan = $reskaryawan['nama'];

        $detil = "";
        $detil2 = "";
        
        $sqlsel = "select tbjualdetil.*,tbmenu.nama from tbjualdetil left join tbmenu on tbjualdetil.idmenu=tbmenu.id where idjual = '$idjual'";
        $querysel = mysqli_query($con,$sqlsel);
        // $res_sela = mysqli_fetch_array($querysel);

        // print_r($res_sela);
        while($res = mysqli_fetch_array($querysel)) {
            $id = $res['id'];
            $menu = $res['nama'];
            $jumlah = $res['jumlah'];
            $harga = $res['harga'];
            $total = $res['total'];

            $detil .= $menu."#".$jumlah."#".uang($harga)."#".uang($total)."*";
            $detil2 .= $menu."#";
        }

        echo "|".$printer."|".$nama_perusahaan."|".date("d M Y  H:i:s")."|".$meja."|".$namakaryawan."|".$detil."|".uang($grandtotal)."|".$instagram."|".$alamat_perusahaan."|".$telp_perusahaan."|".$detil2."|";
    } elseif ($tombol == "cekpiutang") {
        $sqljual = "SELECT * FROM `tbpiutang` LEFT JOIN tbjual ON tbpiutang.id_penjualan=tbjual.id WHERE tbpiutang.sisa > 0 AND tbjual.idkonsumen = '$idkonsumen'";
        $query = mysqli_query($con, $sqljual);
        $num = mysqli_num_rows($query);
        
        echo $num;
    } elseif ($tombol == "tampillistpenjualan") {
        ?>
<table id="datatable-fixed-header" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Penjualan</th>
            <th>Tanggal</th>
            <th>User Input</th>
            <!-- <th>Sales</th> -->
            <th>Konsumen</th>
            <th>Grandtotal</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php
        
            $no = 1;
        $sqlsel = "SELECT tbjual.*,tbsales.nama AS nama_sales, tbkonsumen.nama AS nama_konsumen, tbuser.nama AS nama_user FROM tbjual LEFT JOIN tbsales ON tbjual.idsales=tbsales.id LEFT JOIN tbuser ON tbjual.iduser=tbuser.iduser LEFT JOIN tbkonsumen ON tbjual.idkonsumen=tbkonsumen.id WHERE DATE(tbjual.tanggal) = '$tanggal' ORDER BY tbjual.created_at DESC";

        $querysel = mysqli_query($con, $sqlsel);
        while ($res = mysqli_fetch_array($querysel)) {
            $id = $res['id'];
            $idjual = $res['id'];
            $supplier = $res['nama_sales'];
            $user = $res['nama_user'];
            $referensi = $res['nama_konsumen'];
            $metodepembayaran = $res['metode_pembayaran'];
            $jatuhtempo = $res['jatuh_tempo'];
            $grandtotal = $res['grandtotal'];
            $status = $res['status_antar'];
            $tanggal = $res['tanggal']; ?>
        <tr>
            <td> <?php echo $no; ?>. </td>
            <td> <?php echo $idjual; ?>
            </td>
            <td> <?php echo date("d-m-Y", strtotime($tanggal)); ?>
            </td>
            <td> <?php echo $user; ?>
            </td>
            <!-- <td> <?php echo $supplier; ?> -->
            </td>
            <td> <?php echo $referensi; ?>
            </td>
            <td> <?php echo "Rp. ".number_format($grandtotal, 0, ',', '.'); ?>
            </td>
            <td>
                <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Print"
                    onclick="f_print('<?php echo $id; ?>')"><span
                        class="fa fa-print"></span></button>
                <?php
                        if ($role_ == 'Owner' || $role_ == 'Admin') {
                            ?>
                <button class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit Penjualan"
                    onclick="location.href='frmpenjualan.php?act=edit&id=<?php echo $id; ?>'"><span
                        class="fa fa-reply"></span></button>
                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"
                    onclick="location.href='frmpenjualan.php?act=hapus&id=<?php echo $id; ?>'"><span
                        class="fa fa-trash-o"></span></button>
                <?php
                        } ?>
            </td>
        </tr>
        <?php
                $no++;
        } ?>
    </tbody>
</table>
<script>
    $('#datatable-fixed-header').DataTable({
        fixedHeader: true,
        "searching": true, // Search Box will Be Disabled
        "info": true, // Will show "1 to n of n entries" Text at bottom
        "paging": true,
        "lengthChange": true // Will Disabled Record number per page
    });
</script>
<?php
    } elseif ($tombol == "prosesretur") {

        // if ($kelayakanretur == 'layak') {
        // $sqlmenu = "UPDATE tbmenu SET jumlah = jumlah + '$jlhretur' WHERE id = '$menu'";
        // $querymenu = mysqli_query($con, $sqlmenu) or die ($sql);
        $sqlmenu = "INSERT INTO tbretur (idjual,idmenu,iduser,jumlah,kelayakan) VALUES ('$idjual','$menu','$iduser','$jlhretur','$kelayakanretur')";
        $querymenu = mysqli_query($con, $sqlmenu) or die($sql);
        // }
        
        $sqljualdetil = "SELECT * FROM tempjualdetil WHERE idjual='$idjual' AND idmenu = '$menu'";
        $querydetil = mysqli_query($con, $sqljualdetil);
        $result_temp = mysqli_fetch_assoc($querydetil);
        
        $jumlah = $result_temp['jumlah'] - $jlhretur;
        $subtotal = $result_temp['harga'] * $jumlah;
        $total = $subtotal + $result_temp['jlhpajak'] - $result_temp['jlhdiskon'];

        $sql = "UPDATE tempjualdetil SET jumlah=jumlah - '$jlhretur',subtotal = '$subtotal', total = '$total' WHERE idjual='$idjual' AND idmenu='$menu'";
        $query = mysqli_query($con, $sql) or die($sql);

        echo "sukses";
    } elseif ($tombol == "tampilmenucanvas") {
        if ($kodecanvas) {
            ?>
<div class="form-group" style="margin-top:10px;">
    <label style="top:-10px;">Produk</label>
    <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-focus-off="true"
        data-size="5" name="cmbmenu" id="cmbmenu" onchange="loadmenu()" <?php if ($act == 'edit') {
                echo 'disabled';
            } ?>>
        <option value="" disabled selected> --Pilih Produk-- </option>
        <?php
                        $sqlmenu = "SELECT tbcanvasdetil.*,tbmenu.kode_barang,tbmenu.nama FROM tbcanvasdetil LEFT JOIN tbmenu ON tbcanvasdetil.idbarang = tbmenu.id WHERE kodecanvas = '$kodecanvas' ORDER BY nama ASC";
            $querymenu = mysqli_query($con, $sqlmenu);
            while ($res = mysqli_fetch_array($querymenu)) {
                $id = $res['idbarang'];
                $kodebarang = $res['kode_barang'];
                $nama = $res['nama']; ?>
        <option value="<?php echo $id; ?>"> <?php echo $kodebarang; ?> - <strong><?php echo $nama; ?></strong> </option>
        <?php
            } ?>
    </select>
</div>
<?php
        } else {
            ?>
<div class="form-group" style="margin-top:10px;">
    <label style="top:-10px;">Produk</label>
    <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-focus-off="true"
        data-size="5" name="cmbmenu" id="cmbmenu" onchange="loadmenu()" <?php if ($act == 'edit') {
                echo 'disabled';
            } ?>>
        <option value="" disabled selected> --Pilih Produk-- </option>
        <?php
                        $sqlmenu = "select * from tbmenu order by nama asc";
            $querymenu = mysqli_query($con, $sqlmenu);
            while ($res = mysqli_fetch_array($querymenu)) {
                $id = $res['id'];
                $kodebarang = $res['kode_barang'];
                $nama = $res['nama']; ?>
        <option value="<?php echo $id; ?>"
            id="<?php echo $kodebarang; ?>"> <?php echo $kodebarang; ?> - <strong><?php echo $nama; ?></strong>
        </option>
        <?php
            } ?>
    </select>
</div>
<?php
        }
    } elseif ($tombol == "tampildatacanvas") {
        $sqljual = "SELECT * FROM tbcanvas WHERE kodecanvas = '$kodecanvas'";
        $query = mysqli_query($con, $sqljual);
        $canvas=json_encode(mysqli_fetch_assoc($query));
        
        echo "|".$canvas."|";
    } elseif ($tombol == "tampildatamenucanvas") {
        $sqljual = "SELECT * FROM tbcanvasdetil WHERE kodecanvas = '$kodecanvas' AND idbarang = '$menu'";
        $query = mysqli_query($con, $sqljual);
        $canvas=json_encode(mysqli_fetch_assoc($query));
        
        echo "|".$canvas."|";
    }
