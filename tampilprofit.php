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

    if($tombol == "tampilcari") {
        $syarat = "";
        $syaratdetil = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat .= " and (tj.tanggal between '$tanggalmulai' and '$tanggalselesai')";
        }
        if ($menu != "ALL"){
            $syarat .= " and tjd.idmenu='$menu'";
        }
        $sqlsel = "select sum(tjd.jumlah) as 'totaljumlah', sum(tjd.total) as 'totalakhir',tm.nama as nama_barang, tm.satuan, tm.kode_barang, tm.harga_beli as harga from tbjualdetil tjd inner join tbmenu tm on tjd.idmenu=tm.id inner join tbjual tj on tjd.idjual=tj.id where tjd.id!='' $syarat group by tjd.idmenu";
//        echo $sqlsel;

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap"
               cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Total Nilai Jual</th>
                <th>Total Nilai Beli</th>
                <th>Keuntungan</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $sumtotalakhir=0;
            $sumhargabeli=0;
            $sumkeuntungan=0;
            while ($res = mysqli_fetch_array($querysel)) {
                $totaljumlah = $res['totaljumlah'];
                $totalakhir = $res['totalakhir'];
                $namabarang = $res['nama_barang'];
                $kodebarang = $res['kode_barang'];
                $satuan = $res['satuan'];
                $harga = $res['harga'];
                
                $hargabeli = $harga * $totaljumlah;
                $keuntungan = $totalakhir - $hargabeli;
                ?>
                <tr>
                    <td><?php echo $kodebarang;?></td>
                    <td><?php echo $namabarang;?></td>
                    <td><?php echo uang($totaljumlah);?></td>
                    <td><?php echo $satuan;?></td>
                    <td><?php echo "Rp ".uang($totalakhir);?></td>
                    <td><?php echo "Rp ".uang($hargabeli);?></td>
                    <td><?php echo "Rp ".uang($keuntungan);?></td>
                </tr>
                <?php
                $sumtotalakhir += $totalakhir;
                $sumhargabeli += $hargabeli;
                $sumkeuntungan += $keuntungan;
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;font-weight: bold;">Total Akhir</td>
                    <td style="font-weight: bold;"><?php echo "Rp ".uang($sumtotalakhir);?></td>
                    <td style="font-weight: bold;"><?php echo "Rp ".uang($sumhargabeli);?></td>
                    <td style="font-weight: bold;"><?php echo "Rp ".uang($sumkeuntungan);?></td>
                </tr>
            </tfoot>
        </table>
        <script>
            $('#datatable-fixed-header').DataTable({
                "ordering": true,
                fixedHeader: true,
                dom: 'Bfrtip',
                buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print'
//                    'pageLength', 'excelFlash', 'print'
                    'pageLength',
                    { extend: 'excelFlash', footer:true},
                    { extend: 'print', footer:true},
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