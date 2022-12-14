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
$user = $_POST['user'];
$sales = $_POST['sales'];
$konsumen = $_POST['konsumen'];


if ($tombol == "tampilcari") {
    $syarat = "";
    $syaratdetil = "";
    if ($tanggalmulai != "" && $tanggalselesai != "") {
        $syarat = " AND (tj.tanggal BETWEEN '$tanggalmulai' AND '$tanggalselesai')";
    }
    if ($user != "ALL") {
        $syarat .= " AND tj.iduser='$user'";
    }
    if ($konsumen != "ALL") {
        $syarat .= " AND tj.idkonsumen='$konsumen'";
    }
    if ($sales != "ALL") {
        $syarat .= " AND tj.idsales='$sales'";
    }
    if ($menu != "ALL") {
        $syarat .= " AND tjd.idmenu='$menu'";
        $syaratdetil .= " AND tjd.idmenu='$menu'";
    }
    $sqlsel = "SELECT tj.id,tj.tanggal,tk.nama AS 'namakonsumen',ts.nama AS 'namasales',tu.nama AS 'namauser', tj.created_at FROM tbjual tj LEFT JOIN tbuser tu on tj.iduser=tu.iduser LEFT JOIN tbkonsumen tk ON tj.idkonsumen=tk.id LEFT JOIN tbsales ts ON tj.idsales=ts.id INNER JOIN tbjualdetil tjd ON tj.id=tjd.idjual WHERE tj.id!='' $syarat  GROUP BY tjd.idjual ORDER BY tj.created_at DESC";

?>
    <table id="datatable-fixed-header" class="table table-striped nowrap" cellspacing="0" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>User</th>
                <!-- <th>Sales</th> -->
                <th>Konsumen</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Diskon</th>
                <!-- <th>Pajak</th> -->
                <th>Subtotal</th>
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
            $sumpajak = 0;
            $sumdiskon = 0;
            $sumsubtotal = 0;
            while ($res = mysqli_fetch_array($querysel)) {
                $idtransaksi = $res['id'];
                $tanggal = tgl_bahasa($res['tanggal']);
                $created_at = $res['created_at'];
                $user = $res['namauser'];
                $karyawan = $res['namakaryawan'];
                $sales = $res['namasales'];
                $konsumen = $res['namakonsumen'];
                $shift = $res['shift'];
                $meja = $res['meja'];
            ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $idtransaksi; ?></td>
                    <td><?php echo $tanggal; ?></td>
                    <td><?php echo $created_at; ?></td>
                    <td><?php echo $user; ?></td>
                    <!-- <td><?php echo $sales; ?></td> -->
                    <td><?php echo $konsumen; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <!-- <td></td> -->
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $sqldet = "select tjd.jumlah, tjd.harga, tjd.total, tm.nama as 'namamenu', tjd.diskon, tjd.jlhdiskon, tjd.pajak, tjd.jlhpajak, tjd.subtotal from tbjualdetil tjd inner join tbmenu tm on tjd.idmenu=tm.id where tjd.idjual='$idtransaksi' $syaratdetil order by tjd.id";
                $querydet = mysqli_query($con, $sqldet);
                //                echo $sqldet;
                while ($resdet = mysqli_fetch_array($querydet)) {
                    $jumlah = $resdet['jumlah'];
                    $harga = $resdet['harga'];
                    $total = $resdet['total'];
                    $namamenu = $resdet['namamenu'];
                    $diskon = $resdet['diskon'];
                    $jlhdiskon = $resdet['jlhdiskon'];
                    $pajak = $resdet['pajak'];
                    $jlhpajak = $resdet['jlhpajak'];
                    $subtotal = $resdet['subtotal'];
                ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <!-- <td></td> -->
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $namamenu; ?></td>
                        <td><?php echo "Rp " . uang($harga); ?></td>
                        <td><?php echo $jumlah; ?></td>
                        <td><?php echo "$diskon % (" . uang($jlhdiskon) . ")"; ?></td>
                        <!-- <td><?php echo "$pajak % (" . uang($jlhpajak) . ")"; ?></td> -->
                        <td><?php echo "Rp " . uang($subtotal); ?></td>
                        <td><?php echo "Rp " . uang($total); ?></td>
                    </tr>
            <?php
                    $sumharga += $harga;
                    $sumjumlah += $jumlah;
                    $sumtotal += $total;
                    $sumdiskon += $jlhdiskon;
                    $sumpajak += $jlhpajak;
                    $sumsubtotal += $subtotal;
                }
                $x++;

                if ($menu != "ALL") {
                    $col1 = "Rp " . uang($harga);
                    $col2 = $sumjumlah;
                    $col3 = "Rp " . uang($sumdiskon);
                    $col4 = "Rp " . uang($sumpajak);
                    $col5 = "Rp " . uang($sumsubtotal);
                } else {
                    $col1 = "";
                    $col2 = "";
                    $col3 = "";
                    $col4 = "";
                    $col5 = "";
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <!-- <th></th> -->
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align:right;"> Total Akhir </th>
                <th><?php echo $col1; ?></th>
                <th><?php echo $col2; ?></th>
                <th><?php echo $col3; ?></th>
                <!-- <th><?php echo $col4; ?></th> -->
                <th><?php echo $col5; ?></th>
                <th><?php echo "Rp " . uang($sumtotal); ?></th>
            </tr>
        </tfoot>
    </table>
    <script>
        var user = '<?php echo $_POST['user'] ?>';
        var tanggalmulai = '<?php echo $tanggalmulai ?>';
        var tanggalselesai = '<?php echo $tanggalselesai ?>';
        var menu = '<?php echo $_POST['menu']; ?>';
        var sales = '<?php echo $_POST['sales']; ?>';
        var konsumen = '<?php echo $_POST['konsumen']; ?>';


        $('#datatable-fixed-header').DataTable({

            fixedHeader: true,
            dom: 'Bfrtip',
            "scrollX": true,
            "scrollY": "true",
            "ordering": false,
            "searching": false,
            "deferRender": true,
            buttons: [
                //                    'copy', 'csv', 'excel', 'pdf', 'print'
                //                    'pageLength', 'excelFlash', 'print'
                'pageLength',
                {
                    extend: 'excelFlash',
                    footer: true
                },
                {
                    extend: 'print',
                    footer: true
                },
                {
                    text: 'PDF',
                    action: function() {
                        window.location.href = "cetak_lappenjualan_detail.php?ts=" + tanggalselesai + "&tm=" + tanggalmulai + "&user=" + user + "&sales=" + sales + "&konsumen=" + konsumen + "&menu=" + menu;
                    }
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            iDisplayLength: -1,
            rowReorder: {
                selector: 'td:nth-child(2)'
            }
        });
    </script>
    <style>
        .dataTables_scrollHead,
        .dataTables_scrollBody,
        .dataTables_scrollFoot {
            width: 100% !important;

        }
    </style>
<?php
}
