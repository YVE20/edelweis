<?php
// ob_start();
include 'asset/plugins/fpdf/fpdf.php';
// session_start();
// ini_set("session.auto_start", 0);
include "Koneksi.php";
require 'asset/function/function.php';
    //include "../admin_login.php";


    // ob_start(); 

(isset($_GET['tm']) ? $tglmulai = $_GET['tm'] : $tglmulai='');
(isset($_GET['ts']) ? $tglselesai = $_GET['ts'] : $tglselesai='');
(isset($_GET['karyawan']) ? $karyawan = $_GET['karyawan'] : $karyawan='');
(isset($_GET['shift']) ? $shift = $_GET['shift'] : $shift='');
(isset($_GET['user']) ? $user = $_GET['user'] : $user='');

$tgl_cetak = date("d-m-Y");
    
    // cek pencarian
$syarat = "";
    if ($tglmulai != "" && $tglselesai != "") {
        $syarat = " AND tj.tanggal BETWEEN '$tglmulai' AND '$tglselesai'";
    }
    if ($karyawan != "ALL") {
        $syarat .= " AND tk.idkaryawan='$karyawan'";
    }
    if ($shift != "ALL") {
        if($shift != "Total"){
            $syarat .= " AND tj.shift='$shift'";
        }else{
            $syarat .= " AND (tj.shift='1' OR tj.shift='2' OR tj.shift='3') ";
        }
    }
    if ($user != "ALL") {
        $syarat .= " AND tu.iduser='$user'";
    }

    $sqlsel = "select tj.id,tj.tanggal,tj.shift,tj.meja,tj.subtotal,tj.diskon,tj.pajak,tj.grandtotal,tk.nama as 'namakaryawan',tu.nama as 'namauser', tj.created_at from tbjual tj left join tbkaryawan tk on tj.idkaryawan=tk.id left join tbuser tu on tj.iduser=tu.iduser where tj.id!='' $syarat order by tj.created_at asc";

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
    // Max width for Potrait 189
    $pdf = new PDF('P','mm','A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','B',15);

    $pdf->Cell(189,7,strtoupper('Laporan Penjualan'),0,1,'C');

    $pdf->Cell(189 ,5,'',0,1); //dummy
    $pdf->SetFont('Times','I',11);
    $pdf->Cell(30 ,7,'Tanggal Cetak : '.$tgl_cetak,0,1);

    $pdf->Cell(189 ,5,'',0,1); //dummy
    $pdf->Cell(189 ,5,'',0,1); //dummy
    
        // set color table header
        $pdf->SetFont('Times','B',11);
        // $pdf->SetTextColor(255, 255, 255);
        // $pdf->SetFillColor(33,150,243);
        // $pdf->SetDrawColor(150, 150, 150);

        $pdf->Cell(10 ,7,'No',1,0,'C');
        $pdf->Cell(20 ,7,'Tanggal',1,0,'C');
        $pdf->Cell(38 ,7,'No. Trans',1,0,'C');
        $pdf->Cell(25 ,7,'Username',1,0,'C');
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(26 ,7,'Subtotal (Rp)',1,0,'R');
        $pdf->Cell(22 ,7,'Diskon (Rp)',1,0,'R');
        $pdf->Cell(22 ,7,'Pajak (Rp)',1,0,'R');
        $pdf->Cell(26 ,7,'Grandtotal (Rp)',1,1,'R');//end of line

        $pdf->SetFont('Times','',10);
        // $pdf->SetTextColor(0, 0, 0);
        // $pdf->SetFillColor(255,255,255);
        
        // $id_order = $row['id_order'];
        $no_ = 1;
        $sumsubtotal = 0;
        $sumdiskon = 0;
        $sumpajak = 0;
        $sumgrandtotal = 0;
        //Numbers are right-aligned so we give 'R' after new line parameter
        // $sql1 = mysqli_query($con,"SELECT * FROM tbjual INNER JOIN tbuser USING(iduser) WHERE statbayar='bayar' $syarat ");
        $sql1 = mysqli_query($con, $sqlsel);
        while ($rows = mysqli_fetch_assoc($sql1)) {
            $subtotal = $rows['subtotal'];
            $diskon = $rows['diskon'];
            $pajak = $rows['pajak'];
            $grandtotal = $rows['grandtotal'];

            $total_ =  ((int)$rows['harga_produk'] * (int)$rows['jumlah_order']);
            $pdf->Cell(10 ,8,$no_,1,0,'C');
            $pdf->Cell(20 ,8,$rows['tanggal'],1,0);
            $pdf->Cell(38 ,8,$rows['id'],1,0);
            $pdf->Cell(25 ,8,$rows['namauser'],1,0);
            $pdf->SetFont('Times','',11);
            $pdf->Cell(26 ,8,uang($rows['subtotal']),1,0,'R');
            $pdf->Cell(22 ,8,uang($rows['diskon']),1,0,'R');
            $pdf->Cell(22 ,8,uang($rows['pajak']),1,0,'R');
            $pdf->Cell(26 ,8,uang($rows['grandtotal']),1,1,'R');
            
            $sumsubtotal += $subtotal;
            $sumdiskon += $diskon;
            $sumpajak += $pajak;
            $sumgrandtotal += $grandtotal;
            $no_++;
        }
        
        // $sqlTotal = mysqli_query($con,"SELECT SUM(subtotal) AS Subtotal, SUM(diskon) AS Diskon, SUM(pajak) AS Pajak, SUM(grandtotal) AS Grandtotal FROM tbjual WHERE statbayar='bayar' $syarat");
        $row = mysqli_fetch_assoc($sqlTotal);
        $pdf->SetFont('Times','B',12);
        
        $pdf->Cell(93 ,8,'Total',1,0,'C');
        // set color table footer
        // $pdf->SetTextColor(255, 255, 255);
        // $pdf->SetFillColor(33,150,243);
        $pdf->Cell(26 ,8,'Rp '.uang($sumsubtotal),1,0,'R');
        $pdf->Cell(22 ,8,'Rp '.uang($sumdiskon),1,0,'R');
        $pdf->Cell(22 ,8,'Rp '.uang($sumpajak),1,0,'R');
        // $pdf->Cell(9 ,8,'Rp.',1,0);
        $pdf->Cell(26 ,8,'Rp '.uang($sumgrandtotal),1,1,'R');//end of line
       
        $pdf->Cell(189 ,5,'',0,1); //dummy
        $pdf->Cell(189 ,5,'',0,1); //dummy

        // ob_get_clean();
    // $pdf->Close();
    $pdf->Output("D","Laporan-Penjualan.pdf");
    // ob_end_flush(); 
    exit;
?>