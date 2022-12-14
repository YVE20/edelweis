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
    $rute = $_POST['rute'];
    $transaksi = $_POST['transaksi'];

    if($tombol == "tampilcari") {
        $syarat = "";
        $syaratdetil = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " AND (tj.tanggal BETWEEN '$tanggalmulai' AND '$tanggalselesai')";
        }
        
        if ($konsumen != "ALL"){
            $syarat .= " AND tj.idkonsumen='$konsumen'";
        }

        if ($rute != "ALL"){
            $syarat .= " AND tk.rute='$rute'";
        }

        if ($transaksi == "tidak"){
            // $syarat .= "AND tj.idkonsumen NOT IN (SELECT id FROM tbkonsumen)";
            
            $sqlsel = "SELECT tk.*,tj.grandtotal FROM tbkonsumen tk LEFT JOIN tbjual tj ON tk.id = tj.idkonsumen WHERE tk.id NOT IN (SELECT idkonsumen FROM tbjual) AND tk.rute='$rute'";
        }else{

            $sqlsel = "SELECT SUM(tj.grandtotal) as grandtotal,tk.nama, tk.rute FROM tbjual tj LEFT JOIN tbkonsumen tk ON tj.idkonsumen=tk.id WHERE tj.id!='' $syarat GROUP BY tj.idkonsumen";
        }
        // echo $sqlsel;

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>Konsumen</th>
                <th>Grand Total </th>
            </tr>
            </thead>

            <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $sumtotalakhir=0;
            $no=1;
            while ($res = mysqli_fetch_array($querysel)) {
                $totalakhir = $res['grandtotal'];
                $konsumen = $res['nama'];
                $rute = $res['rute'];

                ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $konsumen;?></td>
                    <td><?php echo "Rp ".uang($totalakhir);?></td>
                </tr>
                <?php
                $sumtotalakhir += $totalakhir;
            }
            ?>
            </tbody>
            <tfoot>
               
                <tr style="font-weight:bold;">
                    <td></td>
                    <td>Total Akhir</td>
                    <td><?php echo "Rp ".uang($sumtotalakhir);?></td>
                </tr>
            </tfoot>
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
                    { 
                        text : 'PDF', 
                        action :function(){
                            window.location.href="cetak_lappenjualan_peritem.php?ts="+tanggalselesai+"&tm="+tanggalmulai+"&konsumen="+konsumen;
                        }
                    }
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