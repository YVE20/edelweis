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
    $jam = $_POST['jam'];
    $tgl_lengkap = strftime("%Y-%m-%d %X");
    $tgl_jak = strftime("%Y-%m-%d");

    if($tombol == "tampilcari") {
        $sqlsel = "select tj.id,tj.tanggal,tj.status_antar,tu.nama as 'namauser' from tbjual tj left join tbuser tu on tj.iduser=tu.iduser inner join tbjualdetil tjd on tj.id=tjd.idjual where TIME(tj.created_at)<='$jam' and tj.tanggal='$tgl_jak' group by tjd.idjual order by tj.created_at desc limit 0,20";

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap"
            cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>User</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
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
                $stat = $res['status_antar'];

                if ($stat == "yes") {
                    $class= "label label-success";
                } else {
                    $class= "label label-warning";
                }
                
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $idtransaksi; ?></td>
                    <td><?php echo $tanggal; ?></td>
                    <td><?php echo $user; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $sqldet = "select tjd.jumlah, tjd.harga, tjd.total, tm.nama as 'namamenu' from tbjualdetil tjd inner join tbmenu tm on tjd.idmenu=tm.id where tjd.idjual='$idtransaksi' $syaratdetil order by tjd.id";
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
                    <td><?php echo $namamenu;?></td>
                    <td><?php echo "Rp ".uang($harga);?></td>
                    <td><?php echo $jumlah;?></td>
                    <td><?php echo "Rp ".uang($total);?></td>
                </tr>
                <?php
                    $sumharga += $harga;
                    $sumjumlah += $jumlah;
                    $sumtotal += $total;
                }
                $x++;
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" style="text-align:right;"> Total Akhir </th>
                    <th><?php echo "Rp ".uang($sumtotal); ?></th>
                </tr>
            </tfoot>
        </table>
        <script>

            $('#datatable-fixed-header').DataTable({
                "ordering": false,
                fixedHeader: true,
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print'
//                    'pageLength', 'excelFlash', 'print'
                    'pageLength'
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