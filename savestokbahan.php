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
    $bahan = $_POST['bahan'];
    $jumlah = $_POST['jumlah'];
    $iduser = $_SESSION['iduser'];

    if($tombol == "simpan"){
      $sql = "insert into tblogsbahan (idbahan,jumlah,kategori,iduser) values ('$bahan','$jumlah','$kategori','$iduser')";
      $query =  mysqli_query($con,$sql) or die ($sql);

      $sqlbahan = "select jumlah from tbbahan where id='$bahan'";
      $querybahan = mysqli_query($con,$sqlbahan);
      $resbahan = mysqli_fetch_array($querybahan);
      $jlhbahan = $resbahan['jumlah'];
      $jlhbahan = $jlhbahan + $jumlah;

      $sqlupdate = "update tbbahan set jumlah='$jlhbahan' where id='$bahan'";
      $queryupdate = mysqli_query($con,$sqlupdate);
    }
    else if($tombol == "tampil"){
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Bahan</th>
              <th>Jumlah</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $sqlsel = "select * from tbbahan where id='$bahan'";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
              $id = $res['id'];
              $jumlah = $res['jumlah'];
              $namabahan = $res['nama'];
              $satuanbahan = $res['satuan'];
              ?>
                <tr>
                  <td><?php echo $namabahan;?></td>
                  <td><?php echo $jumlah." ".$satuanbahan;?></td>
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