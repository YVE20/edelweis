<?php
/**
 * Created By :    
 * User: Welly
 * Date: 11/02/2018
 * Time: 12:45
 */
    include "Koneksi.php";

    session_start();

    $tombol = $_POST['tombol'];
    $id = $_POST['id'];
    $kategori = $_POST['kategori'];
    $menu = $_POST['menu'];
    $jumlah = $_POST['jumlah'];
    $iduser = $_SESSION['iduser'];

    if($tombol == "simpan"){
        $sql = "INSERT INTO tblogsmenu (idmenu,jumlah,kategori,iduser) VALUES ('$menu','$jumlah','$kategori','$iduser')";
        $query =  mysqli_query($con,$sql) or die ($sql);

        $sqlbahan = "SELECT jumlah FROM tbmenu WHERE id='$menu'";
        $querybahan = mysqli_query($con,$sqlbahan);
        $resbahan = mysqli_fetch_array($querybahan);
        //   $jlhbahan = $resbahan['jumlah'];
        $jlhmenu = $resbahan['jumlah'] + $jumlah;

        $sqlupdate = "UPDATE tbmenu set jumlah='$jlhmenu' WHERE id='$menu'";
        $queryupdate = mysqli_query($con,$sqlupdate);
    }
    else if($tombol == "tampil"){
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Menu</th>
              <th>Jumlah</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $sqlsel = "SELECT * FROM tbmenu WHERE id='$menu'";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
              $id = $res['id'];
              $jumlah = $res['jumlah'];
              $namamenu = $res['nama'];
              $satuanmenu = $res['satuan'];
              ?>
                <tr>
                  <td><?php echo $namamenu;?></td>
                  <td><?php echo $jumlah." ".$satuanmenu;?></td>
                </tr>
              <?php
            }
          ?>
          </tbody>
        </table>
        <script>

            $('#datatable-fixed-header').DataTable({
                fixedHeader: true
            });

        </script>
        <?php
    }