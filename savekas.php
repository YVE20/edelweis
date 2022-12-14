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
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];

    $iduser = $_SESSION['iduser'];
    $statususer = $_SESSION['status'];

    if($tombol == "simpan"){
      $sql = "insert into tbkas (iduser,tanggal,jumlah,kategori,keterangan) values ('$iduser','$tanggal','$jumlah','$kategori','$keterangan')";
      $query =  mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "edit"){
        $sql = "update tbkas set jumlah='$jumlah',keterangan='$keterangan',kategori='$kategori',tanggal='$tanggal' where id='$id'";
        $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
        $sql = "delete from tbkas where id='$id'";
        $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
        $sql = "select * from tbkas where id='$id'";
        $query = mysqli_query($con,$sql) or die ($sql);

        $re = mysqli_fetch_array($query);
        $id = $re['id'];
        $tanggal = $re['tanggal'];
        $jumlah = $re['jumlah'];
        $keterangan = $re['keterangan'];
        $kategori = $re['kategori'];

        echo "|".$id."|".$tanggal."|".$jumlah."|".$keterangan."|".$kategori."|";
    }
    else if($tombol == "tampil"){
    ?>
    <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
        width="100%">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <?php
                    if($statususer != "Kasir"){
                ?>
                    <th>Action</th>
                <?php
                    }
                ?>
            </tr>
        </thead>

        <tbody>
            <?php
                $sqlsel = "select * from tbkas where tanggal='$tanggal'";
                $querysel = mysqli_query($con,$sqlsel);
                while($res = mysqli_fetch_array($querysel)){
                $id = $res['id'];
                $tanggal = $res['tanggal'];
                $tanggal = tgl_bahasa($tanggal);
                $jumlah = $res['jumlah'];
                $kategori = $res['kategori'];
                $keterangan = $res['keterangan'];
                ?>
            <tr>
                <td><?php echo $tanggal;?></td>
                <td><?php echo "Rp ".uang($jumlah);?></td>
                <td><?php echo "Kas ".ucwords($kategori);?></td>
                <td><?php echo $keterangan;?></td>
                <?php
                    if($statususer != "Kasir"){
                ?>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="f_edit('<?php echo $id;?>')"><span class="fa fa-pencil"></span></button>
                        <button class="btn btn-sm btn-danger" onclick="f_hapus('<?php echo $id;?>')"><span class="fa fa-times"></span></button>
                    </td>    
                <?php
                    }
                ?>
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