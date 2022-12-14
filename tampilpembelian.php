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
    $supplier = $_POST['supplier'];
    $user = $_POST['user'];

    if($tombol == "tampilcari") {
        $syarat = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " and (tb.tanggal between '$tanggalmulai' and '$tanggalselesai')";
        }
        if ($supplier != "ALL") {
            $syarat .= " and tb.id_supplier='$supplier'";
        }
        if ($user != "ALL") {
            $syarat .= " and tb.id_user='$user'";
        }
        $sqlsel = "select tb.id_pembelian,tb.tanggal,tb.subtotal,tb.diskon,tb.pajak,tb.grandtotal,tk.nama as 'namasupplier',tu.nama as 'namauser' from tbpembelian tb left join tbsupplier tk on tb.id_supplier=tk.id left join tbuser tu on tb.id_user=tu.iduser where tb.id!='' $syarat order by tb.created_at desc";
//        echo $sqlsel;

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap"
               cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>User</th>
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Pajak</th>
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
                $idtransaksi = $res['id_pembelian'];
                $tanggal = tgl_bahasa($res['tanggal']);
                $user = $res['namauser'];
                $supplier = $res['namasupplier'];
                $subtotal = $res['subtotal'];
                $diskon = $res['diskon'];
                $pajak = $res['pajak'];
                $grandtotal = $res['grandtotal'];
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $idtransaksi; ?></td>
                    <td><?php echo $tanggal; ?></td>
                    <td><?php echo $supplier; ?></td>
                    <td><?php echo $user; ?></td>
                    <td><?php echo "Rp ".uang($subtotal); ?></td>
                    <td><?php echo "Rp ".uang($diskon); ?></td>
                    <td><?php echo "Rp ".uang($pajak); ?></td>
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
                <tr>
                    <th colspan="5" style="text-align:right;"> Total Akhir </th>
                    <th><?php echo "Rp ".uang($sumsubtotal); ?></th>
                    <th><?php echo "Rp ".uang($sumdiskon); ?></th>
                    <th><?php echo "Rp ".uang($sumpajak); ?></th>
                    <th><?php echo "Rp ".uang($sumgrandtotal); ?></th>
                </tr>
            </tfoot>
        </table>
        <script>
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