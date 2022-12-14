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
    $konsumen = $_POST['konsumen'];
    $sales = $_POST['sales'];
    $user = $_POST['user'];

    if($tombol == "tampilcari") {
        $syarat = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " AND (tj.tanggal BETWEEN '$tanggalmulai' AND '$tanggalselesai')";
        }
        if ($konsumen != "ALL") {
            $syarat .= " AND tj.idkonsumen='$konsumen'";
        }
        if ($sales != "ALL") {
                $syarat .= " AND tj.idsales='$sales'";
        }
        if ($user != "ALL") {
            $syarat .= " AND tj.iduser='$user'";
        }

        $sqlsel = "SELECT tj.id,tj.tanggal,tj.idkonsumen,tj.idsales,tj.subtotal,tj.diskon,tj.pajak,tj.grandtotal,tk.nama AS 'namakonsumen',ts.nama AS 'namasales',tu.nama AS 'namauser', tj.created_at FROM tbjual tj LEFT JOIN tbkonsumen tk ON tj.idkonsumen=tk.id LEFT JOIN tbsales ts ON tj.idsales=ts.id LEFT JOIN tbuser tu ON tj.iduser=tu.iduser WHERE tj.id!='' $syarat ORDER BY tj.created_at DESC";

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>User</th>
                <th>Konsumen</th>
                <!-- <th>Sales</th> -->
                <!-- <th>Subtotal</th>
                <th>Diskon</th> -->
                <!-- <th>Pajak</th> -->
                <th>Grandtotal</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $x = 1;
            $sumsubtotal = 0;
            $sumdiskon = 0;
            $sumpajak = 0;
            $sumgrandtotal = 0;

            while ($res = mysqli_fetch_array($querysel)) {
                $idtransaksi = $res['id'];
                $kodecanvas = $res['kodecanvas'];
                $tanggal = tgl_bahasa($res['tanggal']);
                $created_at = $res['created_at'];
                $user = $res['namauser'];
                $konsumen = $res['namakonsumen'];
                $sales = $res['namasales'];
                $subtotal = $res['subtotal'];
                $diskon = $res['diskon'];
                $pajak = $res['pajak'];
                $grandtotal = $res['grandtotal'];
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $idtransaksi; ?></td>
                    <td><?php echo $tanggal; ?></td>
                    <td><?php echo $created_at; ?></td>
                    <td><?php echo $user; ?></td>
                    <td><?php echo $konsumen; ?></td>
                    <!-- <td><?php echo $sales; ?></td> -->
                    <!-- <td><?php echo "Rp ".uang($subtotal); ?></td>
                    <td><?php echo "Rp ".uang($diskon); ?></td> -->
                    <!-- <td><?php echo "Rp ".uang($pajak); ?></td> -->
                    <td><?php echo "Rp ".uang($grandtotal); ?></td>
                </tr>
                <?php
                $x++;
                $sumsubtotal += $subtotal;
                $sumdiskon += $diskon;
                $sumpajak += $pajak;
                $sumgrandtotal += $grandtotal;
            }
            ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <!-- <td></td> -->
                    <td style="text-align:right;"> Total Akhir </td>
                    <!-- <td><?php echo "Rp ".uang($sumsubtotal); ?></td>
                    <td><?php echo "Rp ".uang($sumdiskon); ?></td> -->
                    <!-- <td><?php echo "Rp ".uang($sumpajak); ?></td> -->
                    <td><?php echo "Rp ".uang($sumgrandtotal); ?></td>
                </tr>
            </tfoot>
        </table>
        <script>
            var sales = '<?php echo $_POST['sales'] ?>';
            var konsumen = '<?php echo $_POST['konsumen'] ?>';
            var user = '<?php echo $_POST['user'] ?>';
            var tanggalmulai = '<?php echo $tanggalmulai ?>';
            var tanggalselesai = '<?php echo $tanggalselesai ?>';
            $('#datatable-fixed-header').DataTable({
                fixedHeader: true,
                dom: 'Bfrtip',
                "scrollX": true,
                "deferRender": true,            
                buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print'
//                    'pageLength', 'excelFlash', 'print'
                    'pageLength',
                    {   extend: 'excelFlash', 
                        footer:true
                    },
                    {   extend: 'print', 
                        footer:true},
                    // {   text : 'PDF', 
                    //     action :function(){
                            
                    //         window.location.href="cetak_lappenjualan.php?ts="+tanggalselesai+"&tm="+tanggalmulai+"&konsumen="+konsumen+"&sales="+sales+"&user="+user;
                            
                    //     }
                    // }
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                iDisplayLength: -1,
                
            });

        </script>
        <?php
    }