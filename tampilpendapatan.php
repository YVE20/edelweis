<?php
/**
 * Created By :    
 * User: Welly
 * Date: 11/02/2018
 * Time: 12:45
 */
    include "Koneksi.php";
    include "asset/function/function.php";

    // session_start();

    $tombol = $_POST['tombol'];
    // $id = $_POST['id'];
    $tanggalmulai = $_POST['tanggalmulai'];
    $tanggalselesai = $_POST['tanggalselesai'];

    if($tombol == "tampil"){
        $syarat = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " and (tanggal between '$tanggalmulai' and '$tanggalselesai')";
        }

        $sqljual = "select sum(grandtotal) as totaljual from tbjual where id!='' and metode_pembayaran='Cash' $syarat";
        $queryjual = mysqli_query($con,$sqljual);
        $resjual = mysqli_fetch_array($queryjual);
        $totalpenjualan = $resjual['totaljual'];

        $sqlbeli = "select sum(grandtotal) as totalbeli from tbpembelian where id!='' and metode_pembayaran='Cash' and status='Pembelian' $syarat";
        $querybeli = mysqli_query($con,$sqlbeli);
        $resbeli = mysqli_fetch_array($querybeli);
        $totalpembelian = $resbeli['totalbeli'];

        $sqlhutang = "select sum(jumlah) as totalhutang from tbhutangdetil where id!='' $syarat";
        $queryhutang = mysqli_query($con,$sqlhutang);
        $reshutang = mysqli_fetch_array($queryhutang);
        $totalhutang = $reshutang['totalhutang'];

        $sqlpiutang = "select sum(jumlah) as totalpiutang from tbpiutangdetil where id!='' $syarat";
        $querypiutang = mysqli_query($con,$sqlpiutang);
        $respiutang = mysqli_fetch_array($querypiutang);
        $totalpiutang = $respiutang['totalpiutang'];

        $sqlkas = "select sum(jumlah) totalkas from tbkas where id!='' $syarat";
        $querykas = mysqli_query($con,$sqlkas);
        $reskas = mysqli_fetch_array($querykas);
        $totalkas = $reskas['totalkas'];

        $totalakhir = ($totalpenjualan + $totalpiutang) - ($totalpembelian - $totalhutang) + $totalkas;
//        echo $sqljual;
//        echo $sqlkas;
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Total Penjualan</th>
              <th>Total Piutang Terbayar</th>
              <th>Total Pembelian</th>
              <th>Total Hutang Dibayar</th>
              <th>Total Kas</th>
              <th>Total Akhir</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td><?php echo "Rp ".uang($totalpenjualan);?></td>
              <td><?php echo "Rp ".uang($totalpiutang);?></td>
              <td><?php echo "Rp ".uang($totalpembelian);?></td>
              <td><?php echo "Rp ".uang($totalhutang);?></td>
              <td><?php echo "Rp ".uang($totalkas);?></td>
              <td><?php echo "Rp ".uang($totalakhir);?></td>
            </tr>
          </tbody>
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