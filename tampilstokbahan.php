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
    $bahan = $_POST['bahan'];

    if($tombol == "tampil"){
        $syarat = "";
        if($bahan != "ALL"){
            $syarat .= " and id='$bahan'";
        }
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Bahan</th>
              <th>Jumlah</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $sqlsel = "select * from tbbahan where id!='' $syarat";
//            echo $sqlsel;
            $no = 1;
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
              $id = $res['id'];
              $jumlah = $res['jumlah'];
              $namabahan = $res['nama'];
              $satuanbahan = $res['satuan'];
              ?>
                <tr>
                  <td><?php echo $no;?></td>
                  <td><?php echo $namabahan;?></td>
                  <td><?php echo $jumlah." ".$satuanbahan;?></td>
                </tr>
              <?php
              $no++;
            }
          ?>
          </tbody>
        </table>
        <script>
            var bahan = '<?php echo $_POST['bahan']?>';

            $('#datatable-fixed-header').DataTable({
                fixedHeader: true,
                dom: 'Bfrtip',
                "scrollX": true,
                buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print'
//                    'pageLength', 'excelFlash', 'print'
                    'pageLength',
                    { extend: 'excelFlash', footer:true},
                    { extend: 'print', footer:true},
                    { text : 'PDF', 
                        action :function(){

                            window.location.href="cetak_lapstokbahan.php?bahan="+bahan;
                            
                        }
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                iDisplayLength: -1
            });

        </script>
        <?php
    }