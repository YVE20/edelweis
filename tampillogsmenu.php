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
    $menu = $_POST['menu'];
    $tanggalmulai = $_POST['tanggalmulai'];
    $tanggalselesai = $_POST['tanggalselesai'];
    $user = $_POST['user'];

    if($tombol == "tampil"){
        $syarat = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " AND (DATE(tl.created_at) BETWEEN '$tanggalmulai' AND '$tanggalselesai')";
        }
        if ($menu != "ALL") {
            $syarat .= " AND tl.idmenu='$menu'";
        }
        if ($kategori != "ALL") {
            $syarat .= " and tl.kategori='$kategori'";
        }
        if ($user != "ALL") {
            $syarat .= " and tl.iduser='$user'";
        }

        $sqlsel = "SELECT tl.jumlah,tl.kategori,tu.nama AS 'namauser',tm.nama AS 'namamenu',tm.satuan,DATE(tl.created_at) AS 'tanggallogs' FROM tblogsmenu tl INNER JOIN tbmenu tm ON tl.idmenu=tm.id INNER JOIN tbuser tu ON tl.iduser=tu.iduser WHERE tl.id!='' $syarat";
//        echo $sqlsel;
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Produk</th>
              <th>Jumlah</th>
              <th>Kategori</th>
              <th>User</th>
              <th>Tanggal</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $querysel = mysqli_query($con,$sqlsel);
            $x = 1;
            $sumjumlah = 0;
            while($res = mysqli_fetch_array($querysel)){
              $jumlah = $res['jumlah'];
              $namamenu = $res['namamenu'];
              $satuanmenu = $res['satuan'];
              $namauser = $res['namauser'];
              $kategori = ucwords($res['kategori']);
              $tanggal = tgl_bahasa($res['tanggallogs']);
              ?>
                <tr>
                  <td><?php echo $x;?></td>
                  <td><?php echo $namamenu;?></td>
                  <td><?php echo $jumlah." ".$satuanmenu;?></td>
                  <td><?php echo $kategori;?></td>
                  <td><?php echo $namauser;?></td>
                  <td><?php echo $tanggal;?></td>
                </tr>
              <?php
                $x++;
                $sumjumlah += $jumlah;
            }
          ?>
          </tbody>
            <?php
            if($bahan != "ALL"){
                ?>
            <tfoot>
            <tr>
                <th></th>
                <th> Total Akhir </th>
                <th><?php echo $sumjumlah." Buah";?></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </tfoot>
                <?php
            }
            ?>
        </table>
        <script>
            var id = '<?php echo $_POST['id']?>'
            var kategori = '<?php echo $_POST['kategori']?>';
            var menu = '<?php echo $_POST['menu']?>';
            // var  = '<?php //echo $_POST['bulan'] ?>';
            var tanggalmulai = '<?php echo $_POST['tanggalmulai'] ?>';
            var tanggalselesai = '<?php echo $_POST['tanggalselesai'] ?>';
            var user = '<?php echo $_POST['user']; ?>';


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
                            window.location.href="cetak_laplogsmenu.php?id="+id+"&tm="+tanggalmulai+"&ts="+tanggalselesai+"&menu="+menu+"&user="+user+"&kategori="+kategori;                       
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