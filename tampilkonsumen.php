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
    $konsumen = $_POST['konsumen'];
    $rute = $_POST['rute'];

    if($tombol == "tampilcari") {
        $syarat = "";
        $syaratdetil = "";
        // if ($tanggalmulai != "" && $tanggalselesai != "") {
        //     $syarat = " AND (tanggal BETWEEN '$tanggalmulai' AND '$tanggalselesai')";
        // }
        
        if ($konsumen != "ALL"){
            $syarat .= " AND id='$konsumen'";
        }

        if ($rute != "ALL"){
            $syarat .= " AND rute='$rute'";
        }

        $sqlsel = "SELECT * FROM tbkonsumen WHERE id!='' $syarat";

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>Konsumen</th>
                <th>Alamat</th>
                <th>Kategori</th>
                <th>Rute</th>
                <!-- <th>Grand Total </th> -->
            </tr>
            </thead>

            <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $no=1;
            while ($res = mysqli_fetch_array($querysel)) {
                $konsumen = $res['nama'];
                $rute = $res['rute'];
                $kategori = $res['kategori'];
                $alamat = $res['alamat'];

                ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $konsumen;?></td>
                    <td><?php echo $alamat;?></td>
                    <td><?php echo $kategori;?></td>
                    <td><?php echo $rute;?></td>
                    <!-- <td><?php echo "Rp ".uang($totalakhir);?></td> -->
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <script>
            var konsumen = '<?php echo $_POST['konsumen']?>';
            var tanggalmulai = '<?php echo $_POST['tanggalmulai']?>';
            var tanggalselesai = '<?php echo $_POST['tanggalselesai']?>';

            $('#datatable-fixed-header').DataTable({
                "ordering": false,
                fixedHeader: true,
                "scrollX": false,
                "paging": true,
                // dom: 'Bfrtip',
                buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print'
//                    'pageLength', 'excelFlash', 'print'
                    'pageLength',
                    { extend: 'excelFlash', footer:true},
                    { extend: 'print', footer:true},
                    // { 
                    //     text : 'PDF', 
                    //     action :function(){
                    //         window.location.href="cetak_lappenjualan_peritem.php?ts="+tanggalselesai+"&tm="+tanggalmulai+"&konsumen="+konsumen;
                    //     }
                    // }
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                iDisplayLength: 10
            });

        </script>
        <?php
    }