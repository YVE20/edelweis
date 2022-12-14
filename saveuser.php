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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    if($tombol == "simpan"){
        $password = encryptIt($password);
        $sql = "INSERT INTO tbuser (nama,username,password,status) VALUES ('$nama','$username','$password','$status')";
        $query =  mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "edit"){
        $password = encryptIt($password);
        $sql = "UPDATE tbuser SET nama='$nama',username='$username',password='$password',status='$status' WHERE iduser='$id'";
      $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
      $sql = "DELETE FROM tbuser WHERE iduser='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
      $sql = "SELECT * FROM tbuser WHERE iduser='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);

      $re = mysqli_fetch_array($query);
      $id = $re['iduser'];
      $nama = $re['nama'];
      $username = $re['username'];
      $password = $re['password'];
      $status = $re['status'];

      $password = decryptIt($password);

      echo "|".$id."|".$nama."|".$username."|".$password."|".$status."|";
    }
    else if($tombol == "tampil"){
      if ($_SESSION['status'] == "Owner" || $_SESSION['status'] == "Admin" || $_SESSION['status'] == "admin_logistik") {

    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $no = 1;
            $sqlsel = "SELECT * FROM tbuser WHERE status!='Admin'";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
              $id = $res['iduser'];
              $nama = $res['nama'];
              $username = $res['username'];
              $status = $res['status'];
              ?>
                <tr>
                  <td><?php echo $no;?></td>
                  <td><?php echo $nama;?></td>
                  <td><?php echo $username;?></td>
                  <td><?php echo $status;?></td>
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
    }
  ?>