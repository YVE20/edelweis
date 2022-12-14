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
    $kategori = $_POST['kategori'];

    if($tombol == "tampilcari") {
        $syarat = "";
        $syaratdetil = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " and (tj.tanggal between '$tanggalmulai' and '$tanggalselesai')";
        }
        if ($kategori != "ALL"){
            $syarat .= " and tm.satuan='$kategori'";
        }
        $sqlsel = "select sum(tjd.jumlah) as 'totaljumlah', sum(tjd.total) as 'totalakhir',tm.satuan, tm.satuan, tjd.harga from tbjualdetil tjd inner join tbmenu tm on tjd.idmenu=tm.id inner join tbjual tj on tjd.idjual=tj.id where tjd.id!='' $syarat group by tm.satuan";
//        echo $sqlsel;

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap"
               cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Kategori</th>
                <!-- <th>Harga</th> -->
                <th>Jumlah</th>
                <!-- <th>Satuan</th> -->
                <th>Total</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $sumtotalakhir=0;
            while ($res = mysqli_fetch_array($querysel)) {
                $totaljumlah = $res['totaljumlah'];
                $totalakhir = $res['totalakhir'];
                // $kategori = $res['kategori'];
                $satuan = $res['satuan'];
                $harga = $res['harga'];
                ?>
                <tr>
                    <td><?php echo $satuan;?></td>
                    <!-- <td><?php echo "Rp ".uang($harga);?></td> -->
                    <td><?php echo $totaljumlah;?></td>
                    <!-- <td><?php echo $satuan;?></td> -->
                    <td><?php echo "Rp ".uang($totalakhir);?></td>
                </tr>
                <?php
                $sumtotalakhir += $totalakhir;
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <!-- <th></th> -->
                    <!-- <th></th> -->
                    <th>Total Akhir</th>
                    <th><?php echo "Rp ".uang($sumtotalakhir);?></th>
                </tr>
            </tfoot>
        </table>
        <script>
            var kategori = '<?php echo $_POST['kategori']?>';
            var tanggalmulai = '<?php echo $_POST['tanggalmulai']?>';
            var tanggalselesai = '<?php echo $_POST['tanggalselesai']?>';

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
                    { 
                        text : 'PDF', 
                        action :function(){
                            window.location.href="cetak_lappenjualan_perkategori.php?ts="+tanggalselesai+"&tm="+tanggalmulai+"&kategori="+kategori;
                        }
                    }
                ],
                lengthkategori: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                iDisplayLength: -1
            });

        </script>
        <?php
    }