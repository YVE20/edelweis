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
    $menu = $_POST['menu'];
    $supplier = $_POST['supplier'];
    $user = $_POST['user'];

    if($tombol == "tampilcari") {
        $syarat = "";
        $syaratdetil = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " and (tb.tanggal between '$tanggalmulai' and '$tanggalselesai')";
        }
        if ($supplier != "ALL") {
            $syarat .= " and tb.id_supplier='$supplier'";
        }
        if ($user != "ALL") {
            $syarat .= " and tb.id_user='$user'";
        }
        if ($menu != "ALL"){
            $syarat .= " and tbd.idmenu='$menu'";
            $syaratdetil .= " and tbd.idmenu='$menu'";
        }
        $sqlsel = "select tb.id_pembelian,tb.tanggal,tk.nama as 'namasupplier',tu.nama as 'namauser' from tbpembelian tb left join tbsupplier tk on tb.id_supplier=tk.id left join tbuser tu on tb.id_user=tu.iduser inner join tbpembeliandetil tbd on tb.id_pembelian=tbd.id_pembelian where tb.id!='' $syarat group by tbd.id_pembelian order by tb.created_at desc";
//        echo $sqlsel;

        ?>
        <table id="datatable-fixed-header" class="table table-striped nowrap" cellspacing="0" style="width:100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>User</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Diskon</th>
                <th>Pajak</th>
                <th>Subtotal</th>
                <th>Total</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $x = 1;
            $sumharga = 0;
            $sumjumlah = 0;
            $sumtotal = 0;
            $sumpajak = 0;
            $sumdiskon = 0;
            $sumsubtotal = 0;
            while ($res = mysqli_fetch_array($querysel)) {
                $idtransaksi = $res['id_pembelian'];
                $tanggal = tgl_bahasa($res['tanggal']);
                $user = $res['namauser'];
                $supplier = $res['namasupplier'];
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $idtransaksi; ?></td>
                    <td><?php echo $tanggal; ?></td>
                    <td><?php echo $supplier; ?></td>
                    <td><?php echo $user; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $sqldet = "select tbd.jumlah, tbd.harga, tm.nama as 'namamenu', tm.kode_barang, tbd.diskon, tbd.jlhdiskon, tbd.pajak, tbd.jlhpajak, tbd.subtotal from tbpembeliandetil tbd inner join tbmenu tm on tbd.id_menu=tm.id where tbd.id_pembelian='$idtransaksi' $syaratdetil order by tbd.id";
                $querydet = mysqli_query($con,$sqldet);
//                echo $sqldet;
                while($resdet = mysqli_fetch_array($querydet)){
                    $jumlah = $resdet['jumlah'];
                    $harga = $resdet['harga'];
                    $total = $resdet['subtotal'];
                    $namamenu = $resdet['namamenu'];
                    $kodebarang = $resdet['kode_barang'];
                    $diskon = $resdet['diskon'];
                    $jlhdiskon = $resdet['jlhdiskon'];
                    $pajak = $resdet['pajak'];
                    $jlhpajak = $resdet['jlhpajak'];
                    $subtotal = $resdet['subtotal'];
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $kodebarang." - ".$namamenu;?></td>
                    <td><?php echo "Rp ".uang($harga);?></td>
                    <td><?php echo $jumlah;?></td>
                    <td><?php echo "$diskon % (".uang($jlhdiskon).")";?></td>
                    <td><?php echo "$pajak % (".uang($jlhpajak).")";?></td>
                    <td><?php echo "Rp ".uang($subtotal);?></td>
                    <td><?php echo "Rp ".uang($total);?></td>
                </tr>
                <?php
                    $sumharga += $harga;
                    $sumjumlah += $jumlah;
                    $sumtotal += $total;
                    $sumdiskon += $jlhdiskon;
                    $sumpajak += $jlhpajak;
                    $sumsubtotal += $subtotal;
                }
                $x++;

                if ($menu != "ALL"){
                    $col1 = "Rp ".uang($harga);
                    $col2 = $sumjumlah;
                    $col3 = "Rp ".uang($sumdiskon);
                    $col4 = "Rp ".uang($sumpajak);
                    $col5 = "Rp ".uang($sumsubtotal);
                }else{
                    $col1 = "";
                    $col2 = "";
                    $col3 = "";
                    $col4 = "";
                    $col5 = "";
                }
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align:right;"> Total Akhir </th>
                    <th><?php echo $col1;?></th>
                    <th><?php echo $col2;?></th>
                    <th><?php echo $col3;?></th>
                    <th><?php echo $col4;?></th>
                    <th><?php echo $col5;?></th>
                    <th><?php echo "Rp ".uang($sumtotal); ?></th>
                </tr>
            </tfoot>
        </table>
        <script>
            $('#datatable-fixed-header').DataTable({ 
                
                fixedHeader: true,
                dom: 'Bfrtip',
                "scrollX": true,
                "scrollY": "500px",
                "ordering": false,
                "searching": false,  
                "deferRender": true,            
                buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print'
//                    'pageLength', 'excelFlash', 'print'
                    'pageLength',
                    {   extend: 'excelFlash', footer:true},
                    {   extend: 'print', footer:true},
                  
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                iDisplayLength: -1,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                }
               
            });

        </script>
        <style>
            .dataTables_scrollHead, .dataTables_scrollBody, .dataTables_scrollFoot{
                width:100% !important;
                
            }
        </style>
        <?php
    }