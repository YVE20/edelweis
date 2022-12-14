<?php
    include "Koneksi.php";
    require 'asset/function/function.php';
    //include "../admin_login.php";
    require 'asset/plugins/fpdf/fpdf.php';
    (isset($_GET['tm']) ? $tglmulai = $_GET['tm'] : $tglmulai='');
    (isset($_GET['ts']) ? $tglselesai = $_GET['ts'] : $tglselesai='');
    (isset($_GET['shift']) ? $shift = $_GET['shift'] : $shift='');
    (isset($_GET['user']) ? $user = $_GET['user'] : $user='');
    (isset($_GET['sales']) ? $sales = $_GET['sales'] : $sales='');
    (isset($_GET['konsumen']) ? $konsumen = $_GET['konsumen'] : $konsumen=''); 
    (isset($_GET['menu']) ? $menu = $_GET['menu'] : $menu='');

    $tgl_cetak = date("d-m-Y");

    $syaratdetil = "";
    if ($tglmulai != "" && $tglselesai != "") {
        $syarat = " AND (tj.tanggal between '$tglmulai' AND '$tglselesai')";
    }
    if ($konsumen != "ALL") {
        $syarat .= " AND tj.idkonsumen='$konsumen'";
    }
    if ($sales != "ALL") {
        $syarat .= " AND tj.idsales='$sales'";
    }
    if ($user != "ALL") {
        $syarat .= " AND tj.iduser='$user'";
    }
    if ($menu != "ALL"){
        $syarat .= " AND tjd.idmenu='$menu'";
        $syaratdetil .= " AND tjd.idmenu='$menu'";
    }

    // $sqlsel = "select tj.id,tj.subtotal,tj.diskon,tj.pajak,tj.grandtotal,tj.tanggal,tj.shift,tj.meja,tk.nama as 'namakaryawan',tu.nama as 'namauser', tj.created_at from tbjual tj left join tbkaryawan tk on tj.idkaryawan=tk.id left join tbuser tu on tj.iduser=tu.iduser inner join tbjualdetil tjd on tj.id=tjd.idjual where tj.id!='' $syarat  group by tjd.idjual order by tj.created_at asc";

    $sqlsel = "SELECT tj.id,tj.subtotal,tj.diskon,tj.pajak,tj.grandtotal,tj.tanggal,tk.nama AS 'namakonsumen',ts.nama AS 'namasales',tu.nama AS 'namauser', tj.created_at FROM tbjual tj LEFT JOIN tbuser tu on tj.iduser=tu.iduser LEFT JOIN tbkonsumen tk ON tj.idkonsumen=tk.id LEFT JOIN tbsales ts ON tj.idsales=ts.id INNER JOIN tbjualdetil tjd ON tj.id=tjd.idjual WHERE tj.id!='' $syarat  GROUP BY tjd.idjual ORDER BY tj.created_at DESC";


    class PDF extends FPDF
    {
        // Page header
        function Header()
        {
            $this->SetFont('Arial','B',16);
            // Move to the right
            $this->Cell(20);
            // Logo
            // Image(string file , float x , float y , float w , float h )
            $this->Image('asset/img/'.$_SESSION['icon'],10,0,30,30);
            // Title
            $this->SetFont('Arial','B',30);
            $this->Cell(20);
            $this->Cell(149,10,$_SESSION['nama_perusahaan'],0,1,'L');
            $this->SetFont('Arial','',12);
            $this->Cell(40);
            $this->Cell(149,10,$_SESSION['alamat_perusahaan'],0,1,'L');
            // $this->Ln(7);
            $this->SetLineWidth(1.7);
            $this->Line(10, 32, 198, 32);
            $this->Ln(10);
        }
        // Page footer
        function Footer()
        {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Page number
            $this->Cell(0,10,'Halaman '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }
    $pdf = new PDF('P','mm','A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','B',15);
    $pdf->Cell(189,7,strtoupper('Laporan Penjualan Detail'),0,1,'C');
    $pdf->Cell(189 ,5,'',0,1); //dummy
    $pdf->SetFont('Times','I',11);
    $pdf->Cell(30 ,7,'Tanggal Cetak : '.$tgl_cetak,0,1);
    $pdf->Cell(189 ,5,'',0,1); //dummy
    $pdf->Cell(189 ,5,'',0,1); //dummy
        
    //Numbers are right-aligned so we give 'R' after new line parameter
    $querysel = mysqli_query($con, $sqlsel);

        $x = 1;
        $sumharga = 0;
        $sumjumlah = 0;
        $sumtotal = 0;
        $sumpajak = 0;
        $sumdiskon = 0;
        $sumsubtotal = 0;
        while ($res = mysqli_fetch_assoc($querysel)) {
            $idtransaksi = $res['id'];
            $tanggal = tgl_bahasa($res['tanggal']);
            $created_at = $res['created_at'];
            $user = $res['namauser'];
            $karyawan = $res['namakaryawan'];
            $sales = $res['namasales'];
            $konsumen = $res['namakonsumen'];
            $shift = $res['shift'];
            $meja = $res['meja'];
            $subtotal_jual = $res['subtotal'];
            $diskon_jual = 0;
            $pajak_jual = $res['pajak'];
            $grandtotal = $res['grandtotal'];


            $pdf->SetFont('Times','',11);
            $pdf->Cell(100 ,7,'No Transaksi : #'.$idtransaksi,0,0,'L');
            $pdf->Cell(89 ,7,'Waktu : '.$tanggal,0,1,'L');
            // $pdf->Cell(100 ,7, 'Meja : '.$meja,0,0,'L');
            $pdf->Cell(89 ,7,'User : '.$user,0,1,'L');

            // set color table header
            $pdf->SetFont('Times','B',11);
            $pdf->Cell(10 ,7,'No',1,0,'C');
            $pdf->Cell(48 ,7,'Menu',1,0,'C');
            $pdf->Cell(20 ,7,'Harga',1,0,'C');
            $pdf->Cell(15 ,7,'Qty',1,0,'C');
            $pdf->SetFont('Times','B',10);
            $pdf->Cell(26 ,7,'Subtotal (Rp)',1,0,'R');
            $pdf->Cell(22 ,7,'Diskon (Rp)',1,0,'R');
            // $pdf->Cell(22 ,7,'Pajak (Rp)',1,0,'R');
            $pdf->Cell(26 ,7,'Total (Rp)',1,1,'R');//end of line

            $pdf->SetFont('Times','',10);
            $sqldet = "select tjd.jumlah, tjd.harga, tjd.total, tm.nama as 'namamenu', tjd.diskon, tjd.jlhdiskon, tjd.pajak, tjd.jlhpajak, tjd.subtotal from tbjualdetil tjd inner join tbmenu tm on tjd.idmenu=tm.id where tjd.idjual='$idtransaksi' $syaratdetil order by tjd.id";
            $querydet = mysqli_query($con,$sqldet);
            //  echo $sqldet;
            $no_ = 1;
            while($resdet = mysqli_fetch_array($querydet)){
                $jumlah = $resdet['jumlah'];
                $harga = $resdet['harga'];
                $total = $resdet['total'];
                $namamenu = $resdet['namamenu'];
                $diskon = $resdet['diskon'];
                $jlhdiskon = $resdet['jlhdiskon'];
                $pajak = $resdet['pajak'];
                $jlhpajak = $resdet['jlhpajak'];
                $subtotal = $resdet['subtotal'];

                $diskon_jual += $jlhdiskon;

                $total_ =  ((int)$subtotal + (int)$jlhpajak) - (int)$jlhdiskon;
                $pdf->Cell(10 ,8,$no_,1,0,'C');
                $pdf->Cell(48 ,8,substr($namamenu,0,28),1,0,'L');
                $pdf->Cell(20 ,8,"Rp ".uang($harga),1,0,'L');
                $pdf->Cell(15 ,8,$jumlah,1,0,'C');
                $pdf->SetFont('Times','',11);
                $pdf->Cell(26 ,8,"Rp ".uang($subtotal),1,0,'R');
                $pdf->Cell(22 ,8,$diskon ."% (".uang($jlhdiskon).")",1,0,'R');
                // $pdf->Cell(22 ,8,$pajak." % (".uang($jlhpajak).")",1,0,'R');
                $pdf->Cell(26 ,8,"Rp ".uang($total),1,1,'R');
                $no_++;
            }
        
        // $pdf->Cell(141 ,5,'',0,0); //dummy  
        $pdf->SetFont('Times','B',11);  
        $pdf->Cell(93 ,8,"Total ",1,0,"C");
        
        $pdf->SetFont('Times','B',11);
        $pdf->Cell(26 ,8,"Rp ".uang($subtotal_jual),1,0,"R");
        $pdf->Cell(22 ,8,"Rp ".uang($diskon_jual),1,0,"R");
        // $pdf->Cell(22 ,8,"Rp ".uang($pajak_jual),1,0,"R");
        $pdf->Cell(26 ,8,"Rp ".uang($grandtotal),1,1,"R");


        $pdf->Cell(189 ,5,'',0,1); //dummy
        $pdf->Cell(189 ,5,'',0,1); //dummy
            
    }
    
    // $sqlTotal = mysqli_query($con,"SELECT SUM(subtotal) AS Subtotal, SUM(diskon) AS Diskon, SUM(pajak) AS Pajak, SUM(grandtotal) AS Grandtotal FROM tbjual WHERE statbayar='bayar' $syarat");
    // $row = mysqli_fetch_assoc($sqlTotal);
    // $pdf->SetFont('Times','B',12);
    
    // $pdf->Cell(93 ,8,'Total',1,0,'C');
    // // set color table footer
    // $pdf->SetTextColor(255, 255, 255);
    // $pdf->SetFillColor(33,150,243);
    // $pdf->Cell(26 ,8,'Rp '.uang($row['Subtotal']),1,0,'R',1);
    // $pdf->Cell(22 ,8,'Rp '.uang($row['Diskon']),1,0,'R',1);
    // $pdf->Cell(22 ,8,'Rp '.uang($row['Pajak']),1,0,'R',1);
    // // $pdf->Cell(9 ,8,'Rp.',1,0);
    // $pdf->Cell(26 ,8,'Rp '.uang($row['Grandtotal']),1,1,'R',1);//end of line
    
    // $pdf->Cell(189 ,5,'',0,1); //dummy
    $pdf->Cell(189 ,5,'',0,1); //dummy
 
    $pdf->Output('D','Laporan-Penjualan-Detail.pdf');
?>