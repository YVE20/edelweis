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
    $shift = $_POST['shift'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];

    $iduser = $_SESSION['iduser'];
    $statususer = $_SESSION['status'];

    if($tombol == "simpan"){
      $sql = "insert into tbsetoran (tanggal,shift,jumlah,iduser) values ('$tanggal','$shift','$jumlah','$iduser')";
      $query =  mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "edit"){
        $sql = "update tbsetoran set tanggal='$tanggal', shift='$shift', jumlah='$jumlah' where id='$id'";
        $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
        $sql = "delete from tbsetoran where id='$id'";
        $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
        $sql = "select * from tbsetoran where id='$id'";
        $query = mysqli_query($con,$sql) or die ($sql);

        $re = mysqli_fetch_array($query);
        $id = $re['id'];
        $tanggal = $re['tanggal'];
        $jumlah = $re['jumlah'];
        $shift = $re['shift'];

        echo "|".$id."|".$tanggal."|".$jumlah."|".$shift."|";
    }
    else if($tombol == "tampil"){
    ?>
    <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
        width="100%">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Shift</th>
                <th>Jumlah</th>
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
                $sqlsel = "select * from tbsetoran where tanggal='$tanggal'";
                $querysel = mysqli_query($con,$sqlsel);
                while($res = mysqli_fetch_array($querysel)){
                $id = $res['id'];
                $tanggal = $res['tanggal'];
                $tanggal = tgl_bahasa($tanggal);
                $jumlah = $res['jumlah'];
                $shift = $res['shift'];
                
                ?>
            <tr>
                <td><?php echo $tanggal;?></td>
                <td><?php echo "Shift-".$shift;?></td>
                <td><?php echo "Rp ".uang($jumlah);?></td>
                <?php
                    if($statususer != "Kasir"){
                ?>
                    <td class="text-center">
                        <!-- <button class="btn btn-sm btn-warning" onclick="f_edit('<?php echo $id;?>')"><span class="fa fa-pencil"></span></button> -->
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