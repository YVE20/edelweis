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
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];

    if ($tombol == "simpan") {
        $sql = "INSERT INTO tbsales (kode,nama,alamat,kontak) VALUES ('$kode','$nama','$alamat','$kontak')";
        $query = mysqli_query($con, $sql) or die($sql);
    }
    else if($tombol == "edit"){
        $sql = "UPDATE tbsales SET kode='$kode',nama='$nama',alamat='$alamat',kontak='$kontak' WHERE id='$id'";
        $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
      $sql = "DELETE FROM tbsales WHERE id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
      $sql = "SELECT * FROM tbsales WHERE id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);

      $re = mysqli_fetch_array($query);
      $id = $re['id'];
      $kode = $re['kode'];
      $nama = $re['nama'];
      $alamat = $re['alamat'];
      $kontak = $re['kontak'];


      echo "|".$id."|".$kode."|".$nama."|".$alamat."|".$kontak."|";
    }
    else if($tombol == "tampil"){
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $no = 1;
                $sqlsel = "SELECT * FROM tbsales ORDER BY nama DESC";
                $querysel = mysqli_query($con,$sqlsel);
                while($res = mysqli_fetch_array($querysel)){
                    $id = $res['id'];
                    $kode = $res['kode'];
                    $nama = $res['nama'];
                    $alamat = $res['alamat'];
                    $kontak = $res['kontak'];
            ?>
                <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $kode;?></td>
                    <td><?php echo $nama;?></td>
                    <td><?php echo $alamat;?></td>
                    <td><?php echo $kontak;?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="f_edit('<?php echo $id;?>')"><span
                                class="fa fa-pencil"></span></button>
                        <button class="btn btn-sm btn-danger" onclick="f_hapus('<?php echo $id;?>')"><span
                                class="fa fa-times"></span></button>
                    </td>
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