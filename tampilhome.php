<?php
/**
 * Created By :    
 * User: Welly
 * Date: 11/02/2018
 * Time: 12:45
 */
    include "Koneksi.php";
    include "asset/function/function.php";
    $bulan = date("m");
    $tahun = date("Y");

    session_start();

    $tombol = $_POST['tombol'];

    if($tombol == "tampilbahan"){
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Bahan</th>
              <th>Satuan</th>
              <th>Jumlah Tersisa</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $sqlsel = "SELECT * FROM tbbahan WHERE jumlah <= 10 ORDER BY jumlah ASC";
            $querysel = mysqli_query($con,$sqlsel);
            $x = 1;
            while($res = mysqli_fetch_array($querysel)){
                $nama = $res['nama'];
                $satuan = $res['satuan'];
                $jumlah = $res['jumlah'];
                // if(($satuan=="Gram" && $jumlah<="1000") || ($satuan=="Ml" && $jumlah<="1000") || ($satuan=="Pcs" && $jumlah<="10")) {
                    ?>
                    <tr>
                        <td><?php echo $x; ?></td>
                        <td><?php echo $nama; ?></td>
                        <td><?php echo $satuan; ?></td>
                        <td><?php echo $jumlah; ?></td>
                    </tr>
                    <?php
                    $x++;
                // }
                // print_r($res);
            }
          ?>
          </tbody>
        </table>
        <script>

            $('#datatable-fixed-header').DataTable({
                fixedHeader: true,
            });

        </script>
        <?php
    }else if($tombol == "pie") {
    
      $sqlsel = "SELECT tbjual.*, tbjualdetil.*, SUM(tbjualdetil.jumlah) qty, tbmenu.nama FROM tbjual JOIN tbjualdetil ON tbjual.id = tbjualdetil.idjual JOIN tbmenu ON tbjualdetil.idmenu = tbmenu.id WHERE MONTH(tanggal) = '$bulan'  AND YEAR(tanggal) = '$tahun' GROUP BY nama ORDER BY qty DESC LIMIT 5";
      $querysel = mysqli_query($con,$sqlsel);
      $x = 1;
      $json_array = array();
      while($res = mysqli_fetch_array($querysel)){

        $json_array[] = $res;
      }
      echo (json_encode($json_array));
    }else if($tombol == "line") {
    
      $sqlsel = "SELECT MONTH(tanggal) AS Bulan, SUM(grandtotal) AS Grandtotal FROM tbjual WHERE YEAR(tanggal) = '$tahun' GROUP BY MONTH(tanggal)";
      $querysel = mysqli_query($con,$sqlsel);
      $x = 1;
      $json_array = array();
      while($res = mysqli_fetch_array($querysel)){

        $json_array[] = $res;
      }
      echo (json_encode($json_array));
    }

