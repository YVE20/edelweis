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
    $id = $_POST['id'];
    $sisa = $_POST['sisa'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    
    $iduser = $_SESSION['iduser'];
    
    if($tombol == "bayar") {
        $sisabaru = $sisa - $jumlah;
        
        $sqlup = "update tbhutang set sisa='$sisabaru' where id='$id'";
        $queryup = mysqli_query($con,$sqlup);
        
        $sqlins = "insert into tbhutangdetil (id_hutang,id_user,jumlah,tanggal) values ('$id','$iduser','$jumlah','$tanggal')";
        $queryins = mysqli_query($con,$sqlins);
        
        echo "sukses";
    }else if($tombol == "tampillist"){
        ?>
        <table id="datatable-fixed-header" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>ID Pembelian</th>
                <th>Supplier</th>
                <th>Jatuh Tempo</th>
                <th>Jumlah Hutang</th>
                <th>Sisa Hutang</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            <?php
            
            $tanggalsekarang = date("Y-m-d");
            
            $no = 1;
            $sqlsel = "select tbhutang.*, tbsupplier.nama as nama_supplier from tbhutang inner join tbpembelian on tbhutang.id_pembelian=tbpembelian.id_pembelian inner join tbsupplier on tbpembelian.id_supplier = tbsupplier.id where sisa > 0 order by id desc";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
                $id = $res['id'];
                $idpembelian = $res['id_pembelian'];
                $jumlah = $res['jumlah'];
                $sisa = $res['sisa'];
                $jatuhtempo = $res['jatuh_tempo'];
                $namasupplier = $res['nama_supplier'];
                ?>
                <tr>
                    <td> <?php echo $no;?>. </td>
                    <td> <?php echo $idpembelian;?> </td>
                    <td> <?php echo $namasupplier;?> </td>
                    <td> <?php echo date("d-m-Y", strtotime($jatuhtempo));?> </td>
                    <td> <?php echo "Rp. ".number_format($jumlah,0,',','.');?> </td>
                    <td> <?php echo "Rp. ".number_format($sisa,0,',','.');?> </td>
                    <td>
                        <?php
                        if($jatuhtempo < $tanggalsekarang){
                            ?>
                            <span class="badge badge-pill badge-danger">Jatuh Tempo</span>
                            <?php
                        }
                        if($jumlah != $sisa){
                            ?>
                            <span class="badge badge-pill badge-info">Terbayar Sebagian</span>
                            <?php
                        }
                        if($sisa == $jumlah){
                            ?>
                            <span class="badge badge-pill badge-warning">Belum Terbayar</span>
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Pembayaran Hutang" onclick="f_bayar('<?php echo $id;?>','<?php echo $sisa;?>')"><span class="fa fa-file-text-o"></span></button>
                        <?php
                        if($jumlah != $sisa){
                            ?>
                            <button class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="History Pembayaran Hutang" onclick="f_history('<?php echo $id;?>')"><span class="fa fa-history"></span></button>
                            <?php
                        }
                        ?>
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
    }else if($tombol == "historybayar"){
        ?>
        <table id="datatable-fixed-header-history" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Pembayaran Ke-</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Waktu Input</th>
            </tr>
            </thead>

            <tbody>
            <?php
            
            $tanggalsekarang = date("Y-m-d");
            
            $no = 1;
            $sqlsel = "select tbhutangdetil.*, tbuser.nama as nama_user from tbhutangdetil inner join tbuser on tbhutangdetil.id_user = tbuser.iduser where tbhutangdetil.id_hutang='$id' order by id asc";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
                $id = $res['id'];
                $tanggal = $res['tanggal'];
                $jumlah = $res['jumlah'];
                $user = $res['nama_user'];
                $createdat = $res['created_at'];
                ?>
                <tr>
                    <td> <?php echo $no;?>. </td>
                    <td> <?php echo $user;?> </td>
                    <td> <?php echo "Pembayaran Ke-".$no;?> </td>
                    <td> <?php echo "Rp. ".number_format($jumlah,0,',','.');?> </td>
                    <td> <?php echo date("d-m-Y", strtotime($tanggal));?> </td>
                    <td> <?php echo date("d-m-Y H:i:s", strtotime($createdat));?> </td>
                </tr>
                <?php
                $no++;
            }
            ?>
            </tbody>
        </table>
        <script>

             $('#datatable-fixed-header-history').DataTable({
                 fixedHeader: true,
                 "searching": false,   // Search Box will Be Disabled
                 //"ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled
                 "info": true,         // Will show "1 to n of n entries" Text at bottom
                 "paging": false,
                 "lengthChange": false // Will Disabled Record number per page
             });

        </script>
        <?php
    }
    
?>