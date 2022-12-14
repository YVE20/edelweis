<?php
/**
 * Created By :    
 * User: Welly
 * Date: 11/02/2018
 * Time: 12:45
 */
    include "Koneksi.php";
    include "asset/function/function.php";

    session_start();

    $tombol = $_POST['tombol'];
    $id = $_POST['id'];
    $tanggalmulai = $_POST['tanggalmulai'];
    $tanggalselesai = $_POST['tanggalselesai'];

    if($tombol == "tampil"){
        $syarat = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " and (ts.tanggal between '$tanggalmulai' and '$tanggalselesai')";
        }

        $sqlsel = "select ts.tanggal,ts.jumlah,ts.shift,tu.nama as 'namauser' from tbsetoran ts inner join tbuser tu on ts.iduser=tu.iduser $syarat";
//        echo $sqlsel;
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Tanggal</th>
              <th>Jumlah</th>
              <th>Shift</th>
              <th>User</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $querysel = mysqli_query($con,$sqlsel);
            $x = 1;
            $sumjumlah = 0;
            while($res = mysqli_fetch_array($querysel)){
              $jumlah = $res['jumlah'];
              $namauser = $res['namauser'];
              $shift = $res['shift'];
              $tanggal = tgl_bahasa($res['tanggal']);
              ?>
                <tr>
                  <td><?php echo $x;?></td>
                  <td><?php echo $tanggal;?></td>
                  <td><?php echo "Rp ".uang($jumlah);?></td>
                  <td><?php echo $shift;?></td>
                  <td><?php echo $namauser;?></td>
                </tr>
              <?php
                $x++;
                $sumjumlah += $jumlah;
            }
          ?>
          </tbody>
            <tfoot>
            <tr>
                <th></th>
                <th> Total Akhir </th>
                <th><?php echo "Rp ".uang($sumjumlah);?></th>
                <th></th>
                <th></th>
            </tr>
            </tfoot>
        </table>
        <script>
            var tanggalmulai = '<?php echo $tanggalmulai ?>';
            var tanggalselesai = '<?php echo $tanggalselesai ?>';

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
                    { text : 'PDF', 
                        action :function(){
                            window.location.href="cetak_lapsetoran.php?ts="+tanggalselesai+"&tm="+tanggalmulai;
                            
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