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
    $kategori = $_POST['kategori'];
    $tanggalmulai = $_POST['tanggalmulai'];
    $tanggalselesai = $_POST['tanggalselesai'];

    if($tombol == "tampil"){
        $syarat = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " and (tk.tanggal between '$tanggalmulai' and '$tanggalselesai')";
        }
        if ($kategori != "ALL") {
            $syarat .= " and tk.kategori='$kategori'";
        }

        $sqlsel = "select tk.tanggal,tk.jumlah,tk.keterangan,tk.kategori,tu.nama as 'namauser' from tbkas tk inner join tbuser tu on tk.iduser=tu.iduser $syarat";
//        echo $sqlsel;
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Tanggal</th>
              <th>Jumlah</th>
              <th>Kategori</th>
              <th>User</th>
              <th>Keterangan</th>
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
              $keterangan = $res['keterangan'];
              $kategori = ucwords($res['kategori']);
              $tanggal = tgl_bahasa($res['tanggal']);
              ?>
                <tr>
                  <td><?php echo $x;?></td>
                  <td><?php echo $tanggal;?></td>
                  <td><?php echo $jumlah;?></td>
                  <td><?php echo $kategori;?></td>
                  <td><?php echo $namauser;?></td>
                  <td><?php echo $keterangan;?></td>
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
                <th><?php echo $sumjumlah;?></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </tfoot>
        </table>
        <script>
            var tanggalmulai = '<?php echo $tanggalmulai ?>';
            var tanggalselesai = '<?php echo $tanggalselesai ?>';
            var kategori = '<?php echo $_POST['kategori'] ?>';

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
                            window.location.href="cetak_lapkas.php?ts="+tanggalselesai+"&tm="+tanggalmulai+"&kategori="+kategori;
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