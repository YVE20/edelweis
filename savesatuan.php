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
    $satuan = $_POST['satuan'];
    // $harga = $_POST['harga'];
    // $kategori = $_POST['kategori'];
    // $satuan = $_POST['satuan'];

    if($tombol == "simpan"){
      $sql = "insert into tbsatuan (satuan) values ('$satuan')";
      $query =  mysqli_query($con,$sql) or die ($sql);

      $sqlselect = "select * from tbsatuan order by created_at asc limit 0,1";
      $queryselect = mysqli_query($con,$sqlselect);
      $resselect = mysqli_fetch_array($queryselect);
      echo $resselect['id_satuan'];
    }
    else if($tombol == "edit"){
      $sql = "update tbsatuan set satuan='$satuan' where id_satuan='$id'";
      $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
      $sql = "delete from tbsatuan where id_satuan='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
      $sql = "select * from tbsatuan where id_satuan='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);

      $re = mysqli_fetch_array($query);
      $id = $re['id_satuan'];
      $satuan = $re['satuan'];

      echo "|".$id."|".$satuan."|";
    }
    else if($tombol == "tampil"){
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th>No</th>
                <th>satuan</th>
                <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $sqlsel = "select * from tbsatuan order by id_satuan asc";
            $querysel = mysqli_query($con,$sqlsel);
            $no=1;
            while($res = mysqli_fetch_array($querysel)){
              $id = $res['id_satuan'];
              $satuan = $res['satuan'];
            //   $harga = $res['harga'];
            //   $kategori = $res['kategori'];
            //   $satuan = $res['satuan'];
              ?>
                <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $satuan;?></td>
                    
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