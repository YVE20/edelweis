<?php
/**
 * Created By :    
 * User: Welly
 * Date: 11/02/2018
 * Time: 12:45
 */
    include "Koneksi.php";

    $tombol = $_POST['tombol'];
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];

    if($tombol == "simpan"){
      $sql = "insert into tbsupplier (nama,kontak,alamat,deskripsi) values ('$nama','$kontak','$alamat','$deskripsi')";
      $query =  mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "edit"){
      $sql = "update tbsupplier set nama='$nama',kontak='$kontak',alamat='$alamat',deskripsi='$deskripsi' where id='$id'";
      $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
      $sql = "delete from tbsupplier where id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
      $sql = "select * from tbsupplier where id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);

      $re = mysqli_fetch_array($query);
      $id = $re['id'];
      $nama = $re['nama'];
      $kontak = $re['kontak'];
      $alamat = $re['alamat'];
      $deskripsi = $re['deskripsi'];

      echo "|".$id."|".$nama."|".$kontak."|".$alamat."|".$deskripsi."|";
    }
    else if($tombol == "tampil"){
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kontak</th>
                <th>Alamat</th>
                <th>Deskripsi</th>
                <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $sqlsel = "select * from tbsupplier order by id asc";
            $querysel = mysqli_query($con,$sqlsel);
            $no=1;
            while($res = mysqli_fetch_array($querysel)){
              $id = $res['id'];
              $nama = $res['nama'];
              $kontak = $res['kontak'];
              $alamat = $res['alamat'];
              $deskripsi = $res['deskripsi'];
              ?>
                <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $nama;?></td>
                    <td><?php echo $kontak;?></td>
                    <td><?php echo $alamat;?></td>
                    <td><?php echo $deskripsi;?></td>
                    
                    <td>
                    <button class="btn btn-sm btn-warning" onclick="f_edit('<?php echo $id;?>')"><span class="fa fa-pencil"></span></button>
                    <button class="btn btn-sm btn-danger" onclick="f_hapus('<?php echo $id;?>')"><span class="fa fa-times"></span></button>
                  </td>
                </tr>
              <?php
              $no++;
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