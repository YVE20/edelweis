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
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $wilayah = $_POST['wilayah'];
    $kategori = $_POST['kategori'];
    $rute = $_POST['rute'];
    $nofreezer = $_POST['nofreezer'];
    $maxhutang = $_POST['maxhutang'];
    $pajak = $_POST['pajak'];


    if ($tombol == "simpan") {
        $sql = "INSERT INTO tbkonsumen (nama,alamat,wilayah,kategori,rute,no_freezer,rate_pajak,max_hutang) VALUES ('$nama','$alamat','$wilayah','$kategori','$rute','$nofreezer','$pajak','$maxhutang')";
        $query = mysqli_query($con, $sql) or die($sql);
    }
    else if($tombol == "edit"){
        $sql = "UPDATE tbkonsumen SET nama='$nama',alamat='$alamat',wilayah='$wilayah',kategori='$kategori',rute='$rute',no_freezer='$nofreezer',rate_pajak='$pajak',max_hutang='$maxhutang' where id='$id'";
        $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
      $sql = "DELETE FROM tbkonsumen WHERE id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
      $sql = "SELECT * FROM tbkonsumen WHERE id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);

      $re = mysqli_fetch_array($query);
      $id = $re['id'];
      $nama = $re['nama'];
      $alamat = $re['alamat'];
      $wilayah = $re['wilayah'];
      $kategori = $re['kategori'];
      $rute = $re['rute'];
      $nofreezer = $re['no_freezer'];
      $pajak = $re['rate_pajak'];
      $maxhutang = $re['max_hutang'];


      echo "|".$id."|".$nama."|".$alamat."|".$wilayah."|".$kategori."|".$rute."|".$nofreezer."|".$pajak."|".$maxhutang."|";
    }
    else if($tombol == "tampil"){
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <!-- <th>Rate Pajak</th> -->
              <!-- <th>Max. Hutang</th> -->
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $no = 1;
            $sqlsel = "SELECT * FROM tbkonsumen ORDER BY nama DESC";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
              $id = $res['id'];
              $nama = $res['nama'];
              $alamat = $res['alamat'];
              $wilayah = $res['wilayah'];
              $kategori = $res['kategori'];
              $rute = $res['rute'];
              $noFreezer = $res['no_freezer'];
              $pajak = $res['rate_pajak'];
              $maxhutang = $res['max_hutang'];
              ?>
                <tr>
                  <td><?php echo $no++;?></td>
                  <td><?php echo $nama;?></td>
                  <td><?php echo $alamat;?></td>
                  <!-- <td><?php echo $pajak;?> %</td> -->
                  <!-- <td><?php echo $maxhutang;?> Kali</td> -->
                  <td>
                    <button class="btn btn-sm btn-warning" onclick="f_edit('<?php echo $id;?>')"><span class="fa fa-pencil"></span></button>
                    <button class="btn btn-sm btn-danger" onclick="f_hapus('<?php echo $id;?>')"><span class="fa fa-times"></span></button>
                  </td>
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