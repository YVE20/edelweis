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
    $tanggalmulai = $_POST['tanggalmulai'];
    $tanggalselesai = $_POST['tanggalselesai'];
    $status = $_POST['status'];
    $kustomer = $_POST['kustomer'];
    
    if($tombol == "tampilcari") {
        $syarat = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " and (tbpiutang.jatuh_tempo between '$tanggalmulai' and '$tanggalselesai')";
        }
        if ($status != "ALL") {
            if($status == "Lunas"){
                $syarat .= " and tbpiutang.sisa = 0";
            }else{
                $syarat .= " and tbpiutang.sisa > 0 ";
            }
        }
        if ($kustomer != "ALL") {
            $syarat .= " and tbjual.idkustomer = '$kustomer'";
        }
        $sqlsel = "select tbpiutang.*, tbkustomer.nama as nama_kustomer from tbpiutang inner join tbjual on tbpiutang.id_penjualan=tbjual.id inner join tbkustomer on tbjual.idkustomer = tbkustomer.id where tbpiutang.id != '' $syarat order by id desc";
//        echo $sqlsel;

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap"
               cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>ID Penjualan</th>
                <th>Customer</th>
                <th>Jatuh Tempo</th>
                <th>Jumlah Piutang</th>
                <th>Sisa Piutang</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $x = 1;
            $sumjumlah = 0;
            $sumsisa = 0;
            $tanggalsekarang = date("Y-m-d");

//            echo $status;
            while ($res = mysqli_fetch_array($querysel)) {
                $id = $res['id'];
                $idpenjualan = $res['id_penjualan'];
                $jumlah = $res['jumlah'];
                $sisa = $res['sisa'];
                $jatuhtempo = $res['jatuh_tempo'];
                $namakustomer = $res['nama_kustomer'];
                ?>
                <tr>
                    <td> <?php echo $x;?>. </td>
                    <td> <?php echo $idpenjualan;?> </td>
                    <td> <?php echo $namakustomer;?> </td>
                    <td> <?php echo date("d-m-Y", strtotime($jatuhtempo));?> </td>
                    <td> <?php echo "Rp. ".number_format($jumlah,0,',','.');?> </td>
                    <td> <?php echo "Rp. ".number_format($sisa,0,',','.');?> </td>
                    <td>
                        <?php
                        if($jatuhtempo < $tanggalsekarang && $sisa != 0){
                            ?>
                            <span class="badge badge-pill badge-danger">Jatuh Tempo</span>
                            <?php
                        }
                        if($jumlah != $sisa){
                            if($sisa == 0){
                                ?>
                                <span class="badge badge-pill badge-success">Lunas</span>
                                <?php
                            }else{
                            ?>
                            <span class="badge badge-pill badge-info">Terbayar Sebagian</span>
                            <?php
                            }
                        }
                        if($sisa == $jumlah){
                            ?>
                            <span class="badge badge-pill badge-warning">Belum Terbayar</span>
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if($jumlah != $sisa){
                            ?>
                            <button class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="left" title="History Pembayaran Piutang" onclick="f_history('<?php echo $id;?>')"><span class="fa fa-history"></span></button>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $x++;
                $sumjumlah += $jumlah;
                $sumsisa += $sisa;
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align:right;"> Total Akhir </th>
                    <th><?php echo "Rp ".uang($sumjumlah); ?></th>
                    <th><?php echo "Rp ".uang($sumsisa); ?></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <script>
            $('#datatable-fixed-header').DataTable({
                fixedHeader: true,
                dom: 'Bfrtip',
                "scrollX": true,
                buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print'
//                    'pageLength', 'excelFlash', 'print'
                    'pageLength',
                    {   extend: 'excelFlash', 
                        footer:true
                    },
                    {   extend: 'print', 
                        footer:true},
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