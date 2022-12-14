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
    $pekerjaan = $_POST['pekerjaan'];

    if($tombol == "simpan"){
      $sql = "insert into tbkaryawan (nama,pekerjaan) values ('$nama','$pekerjaan')";
      $query =  mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "edit"){
      $sql = "update tbkaryawan set nama='$nama',pekerjaan='$pekerjaan' where id='$id'";
      $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
      $sql = "delete from tbkaryawan where id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
      $sql = "select * from tbkaryawan where id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);

      $re = mysqli_fetch_array($query);
      $id = $re['id'];
      $nama = $re['nama'];
      $pekerjaan = $re['pekerjaan'];

      echo "|".$id."|".$nama."|".$pekerjaan."|";
    }
    else if($tombol == "tampil"){
    ?>
    <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
        width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Pekerjaan</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $no=1;
                $sqlsel = "select * from tbkaryawan order by nama asc";
                $querysel = mysqli_query($con,$sqlsel);
                while($res = mysqli_fetch_array($querysel)){
                $id = $res['id'];
                $nama = $res['nama'];
                $pekerjaan = $res['pekerjaan'];
            ?>
            <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $nama;?></td>
                <td><?php echo $pekerjaan;?></td>
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