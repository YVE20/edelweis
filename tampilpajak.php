
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
    $bulan = $_POST['bulan'];

    if($tombol == "tampilcari") {
        $syarat = "";
       
        if ($bulan != "ALL") {
            $syarat .= " AND MONTH(tanggal)='$bulan'";
        }
        // if ($shift != "ALL") {
        //     if($shift != "Total"){
        //         $syarat .= " and tj.shift='$shift'";
        //     }else{
        //         $syarat .= " and (tj.shift='1' or tj.shift='2' or tj.shift='3') ";
        //     }
        // }
        // if ($user != "ALL") {
        //     $syarat .= " and tj.iduser='$user'";
        // }
        $sqlsel = "SELECT tj.id,tj.tanggal,tjd.jlhpajak,tm.nama as 'namamenu', tj.created_at FROM tbjual tj left join tbjualdetil tjd on tj.id=tjd.idjual left join tbmenu tm on tjd.idmenu=tm.id where tj.id!='' $syarat order by tj.created_at asc";
//        echo $sqlsel;

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap"
               cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Menu</th>
                <th>Jumlah Pajak</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $x = 1;
            // $sumsubtotal = 0;
            // $sumdiskon = 0;
            $sumpajak = 0;
            // $sumgrandtotal = 0;

            // echo $shift;
            while ($res = mysqli_fetch_array($querysel)) {
                $idtransaksi = $res['id'];
                $tanggal = tgl_bahasa($res['tanggal']);
                // $created_at = $res['created_at'];
                $menu = $res['namamenu'];
                // $karyawan = $res['namakaryawan'];
                // $shift = $res['shift'];
                // $meja = $res['meja'];
                // $subtotal = $res['subtotal'];
                // $diskon = $res['diskon'];
                $pajak = $res['jlhpajak'];
                // $grandtotal = $res['grandtotal'];
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $idtransaksi; ?></td>
                    <td><?php echo $tanggal; ?></td>
                    <td><?php echo $menu; ?></td>
                    <td><?php echo $pajak; ?></td>
                   
                </tr>
                <?php
                $x++;
                // $sumpajak+= $;
                // $sumdiskon += $diskon;
                $sumpajak += $pajak;
                // $sumgrandtotal += $grandtotal;
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><?php echo "Rp ".uang($sumpajak); ?></th>
                </tr>
            </tfoot>
        </table>
        <script>
           
            var bulan = '<?php echo $_POST['bulan'] ?>';
            // var tanggalmulai = '<?php //echo $tanggalmulai ?>';
            // var tanggalselesai = '<?php //echo $tanggalselesai ?>';
            $('#datatable-fixed-header').DataTable({
                fixedHeader: true,
                dom: 'Bfrtip',
                "scrollX": true,
                buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print'
//                    'pageLength', 'excelFlash', 'print'
                    'pageLength',
                    {   extend: 'excelFlash', 
                        footer:true
                    },
                    {   extend: 'print', 
                        footer:true},
                    {   text : 'PDF', 
                        action :function(){
                            window.location.href="cetak_lappajak.php?bulan"+bulan;                       
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