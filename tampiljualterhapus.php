<?php
/**
 * Created By :    
 * User: Welly
 * Date: 11/02/2018
 * Time: 12:45
 */
    include "Koneksi.php";
    include "asset/function/function.php";

    $tombol = $_POST['tombol'];
    $tanggalmulai = $_POST['tanggalmulai'];
    $tanggalselesai = $_POST['tanggalselesai'];
    $menu = $_POST['menu'];
    $karyawan = $_POST['karyawan'];
    $shift = $_POST['shift'];
    $user = $_POST['user'];

    if($tombol == "tampilcari") {
        $syarat = "";
        $syaratdetil = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " and (tj.tanggal between '$tanggalmulai' and '$tanggalselesai')";
        }
        if ($karyawan != "ALL") {
            $syarat .= " and tj.idkaryawan='$karyawan'";
        }
        if ($shift != "ALL") {
            if($shift != "Total"){
                $syarat .= " and tj.shift='$shift'";
            }else{
                $syarat .= " and (tj.shift='1' or tj.shift='2' or tj.shift='3') ";
            }
        }
        if ($user != "ALL") {
            $syarat .= " and tj.iduser='$user'";
        }
        if ($menu != "ALL"){
            $syarat .= " and tjd.idmenu='$menu'";
            $syaratdetil .= " and tjd.idmenu='$menu'";
        }
        $sqlsel = "select tj.id,tj.tanggal,tj.shift,tj.meja,tk.nama as 'namakaryawan',tu.nama as 'namauser', tj.alasan from trashjual tj left join tbkaryawan tk on tj.idkaryawan=tk.id left join tbuser tu on tj.iduser=tu.iduser inner join trashjualdetil tjd on tj.id=tjd.idjual where tj.id!='' $syarat  group by tjd.idjual order by tj.created_at asc";
//        echo $sqlsel;

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap"
               cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>User</th>
                <th>Shift</th>
                <th>Meja</th>
                <th>Karyawan</th>
                <th>Menu</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Alasan</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $x = 1;
            $sumharga = 0;
            $sumjumlah = 0;
            $sumtotal = 0;
            while ($res = mysqli_fetch_array($querysel)) {
                $idtransaksi = $res['id'];
                $tanggal = tgl_bahasa($res['tanggal']);
                $user = $res['namauser'];
                $karyawan = $res['namakaryawan'];
                $shift = $res['shift'];
                $meja = $res['meja'];
                $alasan = $res['alasan'];
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $idtransaksi; ?></td>
                    <td><?php echo $tanggal; ?></td>
                    <td><?php echo $user; ?></td>
                    <td><?php echo "Shift ".$shift; ?></td>
                    <td><?php echo $meja; ?></td>
                    <td><?php echo $karyawan; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $alasan; ?></td>
                </tr>
                <?php
                $sqldet = "select tjd.jumlah, tjd.harga, tjd.total, tm.nama as 'namamenu' from trashjualdetil tjd inner join tbmenu tm on tjd.idmenu=tm.id where tjd.idjual='$idtransaksi' $syaratdetil order by tjd.id";
                $querydet = mysqli_query($con,$sqldet);
//                echo $sqldet;
                while($resdet = mysqli_fetch_array($querydet)){
                    $jumlah = $resdet['jumlah'];
                    $harga = $resdet['harga'];
                    $total = $resdet['total'];
                    $namamenu = $resdet['namamenu'];
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $namamenu;?></td>
                    <td><?php echo "Rp ".uang($harga);?></td>
                    <td><?php echo $jumlah;?></td>
                    <td><?php echo "Rp ".uang($total);?></td>
                    <td></td>
                </tr>
                <?php
                    $sumharga += $harga;
                    $sumjumlah += $jumlah;
                    $sumtotal += $total;
                }
                $x++;

                if ($menu != "ALL"){
                    $col1 = "Rp ".uang($harga);
                    $col2 = $sumjumlah;
                }else{
                    $col1 = "";
                    $col2 = "";
                }
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align:right;"> Total Akhir </th>
                    <th><?php echo $col1;?></th>
                    <th><?php echo $col2;?></th>
                    <th><?php echo "Rp ".uang($sumtotal); ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <script>
            var shift = '<?php echo $_POST['shift'] ?>';
            var karyawan = '<?php echo $_POST['karyawan'] ?>';
            var user = '<?php echo $_POST['user'] ?>';
            var tanggalmulai = '<?php echo $tanggalmulai ?>';
            var tanggalselesai = '<?php echo $tanggalselesai ?>';
            var menu = '<?php echo $_POST['menu']; ?>';

            $('#datatable-fixed-header').DataTable({
                "ordering": false,
                fixedHeader: true,
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print'
//                    'pageLength', 'excelFlash', 'print'
                    'pageLength',
                    { extend: 'excelFlash', footer:true},
                    { extend: 'print', footer:true},
                    {  text: 'PDF', 
                        action :function(){
                            window.location.href="cetak_lappenjualanterhapus.php?ts="+tanggalselesai+"&tm="+tanggalmulai+"&karyawan="+karyawan+"&shift="+shift+"&user="+user+"&menu="+menu;
                        }
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                iDisplayLength: -1
            });

        </script>
        <?php
    }