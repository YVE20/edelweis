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
    setlocale(LC_TIME, "id_ID");
    
    $tombol = $_POST['tombol'];
    $idpembelian = $_POST['idpembelian'];
    $act = $_POST['act'];
    $id = $_POST['id'];
    $idsupplier = $_POST['idsupplier'];
    $tanggal = $_POST['tanggal'];
    $referensi = $_POST['referensi'];
    $metodepembayaran = $_POST['metodepembayaran'];
    $jatuhtempo = $_POST['jatuhtempo'];
    $subtotalakhir = $_POST['subtotalakhir'];
    $diskonakhir = $_POST['diskonakhir'];
    $pajakakhir = $_POST['pajakakhir'];
    $grandtotalakhir = $_POST['grandtotalakhir'];
    
    $menu = $_POST['menu'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $diskon = $_POST['diskon'];
    $pajak = $_POST['pajak'];
    $jlhdiskon = $_POST['jlhdiskon'];
    $jlhpajak = $_POST['jlhpajak'];
    $subtotal = $_POST['total'];
    
    $iduser = $_SESSION['iduser'];
    
    if($tombol == "simpan"){
        $sql = "insert into temppembeliandetil (id_pembelian,id_menu,jumlah,harga,pajak,jlhpajak,diskon,jlhdiskon,subtotal) values ('$idpembelian','$menu','$jumlah','$harga','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotal')";
        $query = mysqli_query($con,$sql) or die ($sql);
        
        echo "sukses";
    }else if($tombol == "edit"){
        $sql = "update temppembeliandetil set id_menu='$menu',jumlah='$jumlah',harga='$harga',pajak='$pajak',jlhpajak='$jlhpajak',diskon='$diskon',jlhdiskon='$jlhdiskon',subtotal='$subtotal' where id='$id'";
        $query = mysqli_query($con,$sql) or die ($sql);
    
        echo "sukses";
    }else if($tombol == "hapus"){
        $sql = "delete from temppembeliandetil where id='$id'";
        $query = mysqli_query($con,$sql) or die ($sql);
    
        echo "sukses";
    }else if($tombol == "tampiledit"){
        $sql = "select * from temppembeliandetil where id='$id'";
        $query = mysqli_query($con,$sql) or die ($sql);
    
        $re = mysqli_fetch_array($query);
        $jumlah = $re['jumlah'];
        $idmenu = $re['id_menu'];
        $harga = $re['harga'];
        $total = $re['subtotal'];
        $diskon = $re['diskon'];
        $jlhdiskon = $re['jlhdiskon'];
        $pajak = $re['pajak'];
        $jlhpajak = $re['jlhpajak'];
    
        echo "|".$id."|".$idmenu."|".$jumlah."|".$harga."|".$total."|".$diskon."|".$jlhdiskon."|".$pajak."|".$jlhpajak."|";
    }else if($tombol == "approvetransaksi"){
        $sql = "select * from tbpembelian where id_pembelian='$idpembelian'";
        $query = mysqli_query($con,$sql) or die ($sql);
    
        $re = mysqli_fetch_array($query);
        $supplier = $re['id_supplier'];
        $tanggal = $re['tanggal'];
        $referensi = $re['referensi'];
        $metodepembayaran = $re['metode_pembayaran'];
        $jatuhtempo = $re['jatuh_tempo'];
        $subtotal = $re['subtotal'];
        $diskon = $re['diskon'];
        $pajak = $re['pajak'];
        $grandtotal = $re['grandtotal'];
    
        $sql4 = "delete from temppembeliandetil where id_pembelian='$idpembelian'";
        $query4 = mysqli_query($con, $sql4) or die ($sql4);
        
        // Select data dari tbpembeliandetil
        $sql2 = "select * from tbpembeliandetil where id_pembelian='$idpembelian'";
        $query2 = mysqli_query($con, $sql2) or die ($sql2);
        while ($res2 = mysqli_fetch_array($query2)) {
            $idmenu = $res2['id_menu'];
            $jumlah = $res2['jumlah'];
            $harga = $res2['harga'];
            $diskon = $res2['diskon'];
            $jlhdiskon = $res2['jlhdiskon'];
            $pajak = $res2['pajak'];
            $jlhpajak = $res2['jlhpajak'];
            $subtotaldetil = $res2['subtotal'];
        
            $sql3 = "insert into temppembeliandetil (id_pembelian,id_menu,jumlah,harga,pajak,jlhpajak,diskon,jlhdiskon,subtotal) values ('$idpembelian','$idmenu','$jumlah','$harga','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotaldetil')";
            $query3 = mysqli_query($con, $sql3);
        }
        // end While tbpembeliandetil
    
        echo "|".$supplier."|".$tanggal."|".$referensi."|".$metodepembayaran."|".$jatuhtempo."|".$subtotal."|".$diskon."|".$pajak."|".$grandtotal."|";
    }else if($tombol == "hitungtotal"){
        // load temppembeliandetil
        $sql = "select sum(jumlah*harga), sum(jlhdiskon), sum(jlhpajak), sum(subtotal) from temppembeliandetil where id_pembelian='$idpembelian'";
        $query = mysqli_query($con,$sql);
        $res = mysqli_fetch_array($query);
    
        $totalharga = $res[0];
        $totaldiskon = $res[1];
        $totalpajak = $res[2];
        $totalsubtotal = $res[3];
        echo $totalharga."|".$totaldiskon."|".$totalpajak."|".$totalsubtotal;
    
    }else if($tombol == "proses"){
        $sqlcek = "select * from temppembeliandetil where id_pembelian='$idpembelian'";
        $querycek = mysqli_query($con,$sqlcek);
        $numcek = mysqli_num_rows($querycek);
    
        if($numcek > 0) {
            if ($act == "po") {
                $sql = "insert into tbpembelian (id_pembelian,id_user,id_supplier,tanggal,status,referensi,metode_pembayaran,jatuh_tempo,subtotal,diskon,pajak,grandtotal) values ('$idpembelian','$iduser','$idsupplier','$tanggal','PO Pembelian','$referensi','$metodepembayaran','$jatuhtempo','$subtotalakhir','$diskonakhir','$pajakakhir','$grandtotalakhir')";
                $query = mysqli_query($con, $sql);
            }else if ($act == "approve") {
                $sql = "update tbpembelian set id_user_approve='$iduser',id_supplier='$idsupplier',status='Pembelian',tanggal='$tanggal',referensi='$referensi',metode_pembayaran='$metodepembayaran',jatuh_tempo='$jatuhtempo',subtotal='$subtotalakhir', diskon ='$diskonakhir' ,pajak='$pajakakhir',grandtotal = '$grandtotalakhir' where  id_pembelian='$idpembelian'";
                $query = mysqli_query($con, $sql);
                
                if($metodepembayaran == "Kredit"){
                    $sqlhutang = "insert into tbhutang (id_pembelian,jumlah,sisa,jatuh_tempo) values ('$idpembelian','$grandtotalakhir','$grandtotalakhir','$jatuhtempo')";
                    $queryhutang = mysqli_query($con,$sqlhutang);
                }
                
                $sql4 = "delete from tbpembeliandetil where id_pembelian='$idpembelian'";
                $query4 = mysqli_query($con, $sql4) or die ($sql4);
            }
            // end if act
            
        
            // Select data dari temppembeliandetil
            $sql2 = "select * from temppembeliandetil where id_pembelian='$idpembelian'";
            $query2 = mysqli_query($con, $sql2) or die ($sql2);
            while ($res2 = mysqli_fetch_array($query2)) {
                $idmenu = $res2['id_menu'];
                $jumlah = $res2['jumlah'];
                $harga = $res2['harga'];
                $diskon = $res2['diskon'];
                $jlhdiskon = $res2['jlhdiskon'];
                $pajak = $res2['pajak'];
                $jlhpajak = $res2['jlhpajak'];
                $subtotaldetil = $res2['subtotal'];
            
                $sql3 = "insert into tbpembeliandetil (id_pembelian,id_menu,jumlah,harga,pajak,jlhpajak,diskon,jlhdiskon,subtotal) values ('$idpembelian','$idmenu','$jumlah','$harga','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotaldetil')";
                $query3 = mysqli_query($con, $sql3);
    
                if($act == "approve"){
                    $sqlmenu = "select * from tbmenu where id='$idmenu'";
                    $querymenu = mysqli_query($con,$sqlmenu);
                    $resmenu = mysqli_fetch_array($querymenu);
                    $stoklama = $resmenu['jumlah'];
                    
                    $stokbaru = $jumlah + $stoklama;
                    
                    $sqlupdate = "update tbmenu set jumlah='$stokbaru', harga_beli='$harga' where id='$idmenu'";
                    $queryupdate = mysqli_query($con,$sqlupdate);
                }
            }
            // end While temppembeliandetil
            
            $sql4 = "delete from temppembeliandetil where id_pembelian='$idpembelian'";
            $query4 = mysqli_query($con, $sql4) or die ($sql4);
            echo "sukses";
        }else{
            echo "kosong";
        }
        // end if numcek
    
    }else if($tombol == "tampil"){
        ?>
        <table id="datatable-fixed-header" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Kode</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Diskon</th>
                <!-- <th>Pajak</th> -->
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            <?php
        
            $no = 1;
            $sqlsel = "select temppembeliandetil.*,tbmenu.nama, tbmenu.kode_barang as kodebarang, tbmenu.satuan from temppembeliandetil left join tbmenu on temppembeliandetil.id_menu=tbmenu.id where id_pembelian='$idpembelian'";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
                $id = $res['id'];
                $idmenu_ = $res['idmenu'];
                $menu = $res['nama'];
                $jumlah = $res['jumlah'];
                $satuan = $res['satuan'];
                $harga = $res['harga'];
                $diskon = $res['diskon'];
                $jlhdiskon = $res['jlhdiskon'];
                $pajak = $res['pajak'];
                $jlhpajak = $res['jlhpajak'];
                $subtotal = $res['subtotal'];
                $kodebarang = $res['kodebarang'];
                ?>
                <tr>
                    <td> <?php echo $no;?>. </td>
                    <td> <?php echo $menu;?> </td>
                    <td> <?php echo $kodebarang;?> </td>
                    <td> <?php echo number_format($jumlah,0,',','.');?> </td>
                    <td> <?php echo $satuan;?> </td>
                    <td> <?php echo number_format($harga,0,',','.');?> </td>
                    <td> <?php echo $diskon."% (".number_format($jlhdiskon,0,',','.').")";?> </td>
                    <!-- <td> <?php echo $pajak."% (".number_format($jlhpajak,0,',','.').")";?> </td> -->
                    <td> <?php echo number_format($subtotal,0,',','.');?> </td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="f_edit('<?php echo $id;?>')"><span class="fa fa-pencil"></span></button>
                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="f_hapus('<?php echo $id;?>')"><span class="fa fa-trash"></span></button>
                    </td>
                </tr>
                <?php
                $no++;
            }
            ?>
            </tbody>
        </table>
        <script>

             $('#datatable-fixed-header').DataTable({
                 fixedHeader: true,
                 "searching": false,   // Search Box will Be Disabled
                 //"ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled
                 "info": true,         // Will show "1 to n of n entries" Text at bottom
                 "paging": false,
                 "lengthChange": false // Will Disabled Record number per page
             });

        </script>
        <?php
    }else if($tombol == "tampillistpembelian"){
        ?>
        <table id="datatable-fixed-header" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>ID Pembelian</th>
                <th>Tanggal</th>
                <th>User Input</th>
                <th>Supplier</th>
                <!-- <th>Referensi</th> -->
                <!-- <th>Pembayaran</th> -->
                <th>Grandtotal</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            <?php
        
            $no = 1;
            $sqlsel = "select tbpembelian.*,tbsupplier.nama as nama_supplier, tbuser.nama as nama_user from tbpembelian inner join tbsupplier on tbpembelian.id_supplier=tbsupplier.id inner join tbuser on tbpembelian.id_user=tbuser.iduser where tbpembelian.created_at >= now()-interval 3 month order by tbpembelian.created_at desc";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
                $id = $res['id'];
                $idpembelian = $res['id_pembelian'];
                $supplier = $res['nama_supplier'];
                $user = $res['nama_user'];
                $referensi = $res['referensi'];
                $metodepembayaran = $res['metode_pembayaran'];
                $jatuhtempo = $res['jatuh_tempo'];
                $grandtotal = $res['grandtotal'];
                $status = $res['status'];
                $tanggal = $res['tanggal'];
                ?>
                <tr>
                    <td> <?php echo $no;?>. </td>
                    <td> <?php echo $idpembelian;?> </td>
                    <td> <?php echo date("d-m-Y", strtotime($tanggal));?> </td>
                    <td> <?php echo $user;?> </td>
                    <td> <?php echo $supplier;?> </td>
                    <!-- <td> <?php echo $referensi;?> </td> -->
                    <!-- <td> <?php echo (($metodepembayaran == "Cash" ? 'Cash'  : 'Kredit ('.date("d-m-Y", strtotime($jatuhtempo)).')'));?> </td> -->
                    <td> <?php echo "Rp. ".number_format($grandtotal,0,',','.');?> </td>
                    <td> <span class="badge badge-pill <?php echo (($status == "PO Pembelian" ? 'badge-warning'  : 'badge-success')); ?>"><?php echo $status;?></span> </td>
                    <td>
                        <?php
                            if($status == "PO Pembelian"){
                            ?>
                                <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Approve PO" onclick="f_approvepo('<?php echo $id;?>')"><span class="fa fa-check"></span></button>
                            <?php
                            }
                        ?>
<!--                        <button class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Print Pembelian" onclick="f_printpembelian('<?php //echo $id;?>')"><span class="fa fa-print"></span></button>-->
                    </td>
                </tr>
                <?php
                $no++;
            }
            ?>
            </tbody>
        </table>
        <script>

             $('#datatable-fixed-header').DataTable({
                 fixedHeader: true,
                 "searching": true,   // Search Box will Be Disabled
                 //"ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled
                 "info": true,         // Will show "1 to n of n entries" Text at bottom
                 "paging": true,
                 "lengthChange": true // Will Disabled Record number per page
             });

        </script>
        <?php
    }
    
?>