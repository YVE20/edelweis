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
    $kodebarang = $_POST['kode_barang'];
    $nama = $_POST['nama'];
    $hargadalam = $_POST['hargadalam'];
    $hargaluar = $_POST['hargaluar'];
    $hargadepo = $_POST['hargadepo'];
    $hargamodern = $_POST['hargamodern'];
    $hargatradisional = $_POST['hargatradisional'];
    $hargaagen = $_POST['hargaagen'];
    $hargauser = $_POST['hargauser'];
    $satuan = $_POST['satuan'];
    $kategori = $_POST['kategori'];
    $wilayah = $_POST['wilayah'];
    $jenis = $_POST['jenis'];
    $isikemasan = $_POST['isikemasan'];
    $img_url = $_FILES['imgurl'];
    $lokasi = $_POST['lokasi'];

    if($tombol == "simpan"){
          $sql = "INSERT INTO tbmenu (kode_barang,nama,wilayah,jenis_market,harga_dk,harga_lk,harga_depo,harga_modern,harga_tradisional,harga_agen,harga_user,img_url,satuan,kategori,isi_kemasan,jumlah,lokasi) VALUES ('$kodebarang','$nama','$wilayah','$jenis','$hargadalam','$hargaluar','$hargadepo','$hargamodern','$hargatradisional','$hargaagen','$hargauser','dummy.jpg','$satuan','$kategori','$isikemasan','0','$lokasi')";
          $query =  mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "edit"){
     //gambar kosong
        $sql = "UPDATE tbmenu SET kode_barang='$kodebarang', nama='$nama',wilayah='$wilayah',jenis_market='$jenis',harga_dk='$hargadalam',harga_lk='$hargaluar',harga_depo='$hargadepo',harga_modern='$hargamodern',harga_tradisional='$hargatradisional',harga_agen='$hargaagen',harga_user='$hargauser',satuan='$satuan',lokasi='$lokasi',kategori='$kategori',isi_kemasan='$isikemasan' WHERE id='$id'";
        $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
      $sql = "DELETE FROM tbmenu WHERE id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
      $sql = "SELECT * FROM tbmenu WHERE id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);

      $re = mysqli_fetch_array($query);
      $id = $re['id'];
      $kodebarang = $re['kode_barang'];
      $nama = $re['nama'];
      $wilayah = $re['wilayah'];
      $jenis = $re['jenis_market'];
      $hargadalam = $re['harga_dk'];
      $hargaluar = $re['harga_lk'];
      $hargadepo = $re['harga_depo'];
      $hargamodern = $re['harga_modern'];
      $hargatradisional = $re['harga_tradisional'];
      $hargaagen = $re['harga_agen'];
      $hargauser = $re['harga_user'];
      $satuan = $re['satuan'];
      $kategori = $re['kategori'];
      $isikemasan = $re['isi_kemasan'];
      $lokasi = $re['lokasi'];

      echo "|".$id."|".$kodebarang."|".$nama."|".$wilayah."|".$jenis."|".$hargaluar."|".$hargadalam."|".$hargadepo."|".$hargamodern."|".$hargatradisional."|".$hargaagen."|".$hargauser."|".$satuan."|".$kategori."|".$isikemasan."|".$lokasi."|";
    }
    else if($tombol == "tampil"){
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Nama</th>
              <th>Harga Jual</th>
              <th>Satuan</th>
              <th>Kategori</th>
              <th>Stok</th>
              <th>Lokasi</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $no = 1;
            $sqlsel = "SELECT * FROM tbmenu ORDER BY nama DESC";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
              $id = $res['id'];
              $kodebarang = $res['kode_barang'];
              $nama = $res['nama'];
              $hargadalam = $res['harga_dk'];
              $hargaluar = $res['harga_lk'];
              $hargadepo = $res['harga_depo'];
              $hargamodern = $res['harga_modern'];
              $hargatradisional = $res['harga_tradisional'];
              $hargaagen = $res['harga_agen'];
              $hargauser = $res['harga_user'];
              $satuan = $res['satuan'];
              $kategori = $res['kategori'];
              $isikemasan = $res['isi_kemasan'];
              $stok = $res['jumlah'];
              $lokasi = $res['lokasi'];

              ?>
                <tr>
                  <td><?php echo $kodebarang;?></td>
                  <td><?php echo $nama;?></td>
                  <td><?php echo "Rp ".uang($hargadalam);?></td>
                  <td><?php echo $satuan;?></td>
                  <td><?php echo $kategori;?></td>
                  <td><?php echo $stok;?></td>
                  <td><?php echo $lokasi;?></td>
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
                fixedHeader: true,
                "scrollX": true,
            });

        </script>
        <?php
    }