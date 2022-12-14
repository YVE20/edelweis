<?php
    include "Koneksi.php";
    require 'asset/function/function.php';
    //include "../admin_login.php";
    require 'asset/plugins/fpdf/fpdf.php';
    (isset($_GET['tm']) ? $tglmulai = $_GET['tm'] : $tglmulai='');
    (isset($_GET['ts']) ? $tglselesai = $_GET['ts'] : $tglselesai='');
    // (isset($_GET['bulan']) ? $bulan = $_GET['bulan'] : $bulan='');
    
    $tgl_cetak = date("d-m-Y");
    $syarat = "";
        if ($tglmulai != "" && $tglselesai != "") {
            $syarat = " AND (tanggal BETWEEN '$tglmulai' AND '$tglselesai')";
        }
        $sqljual = "SELECT SUM(grandtotal) AS totaljual FROM tbjual WHERE id!='' $syarat";
        $queryjual = mysqli_query($con,$sqljual);
        $resjual = mysqli_fetch_array($queryjual);
        $totalpenjualan = $resjual['totaljual'];

        $sqlkas = "SELECT SUM(jumlah) totalkas FROM tbkas WHERE id!='' $syarat";
        $querykas = mysqli_query($con,$sqlkas);
        $reskas = mysqli_fetch_array($querykas);
        $totalkas = $reskas['totalkas'];

        $sqlsetoran = "select sum(jumlah) totalsetoran from tbsetoran where id!='' $syarat";
        $querysetoran = mysqli_query($con,$sqlsetoran);
        $ressetoran = mysqli_fetch_array($querysetoran);
        $totalsetoran = $ressetoran['totalsetoran'];

        $totalakhir = $totalpenjualan + $totalkas;

  
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
    $pdf->SetFont('Times','B',14);

    $pdf->Cell(189,7,strtoupper('Laporan Pendapatan'),0,1,'C');

    $pdf->Cell(189 ,5,'',0,1); //dummy
    $pdf->SetFont('Times','I',11);
    $pdf->Cell(30 ,7,'Tanggal Cetak : '.$tgl_cetak,0,1);

    $pdf->Cell(189 ,5,'',0,1); //dummy
    $pdf->Cell(189 ,5,'',0,1); //dummy
    
        // set color table header
        $pdf->SetFont('Times','B',12);
        // $pdf->SetTextColor(255, 255, 255);
        // $pdf->SetFillColor(33,150,243);
        // $pdf->SetDrawColor(150, 150, 150);

        $pdf->Cell(15 ,7,'No',1,0,'C');
        $pdf->Cell(40 ,7,'Total Penjualan',1,0,'C');
        $pdf->Cell(38 ,7,'Total Kas',1,0,'C');  
        $pdf->Cell(58 ,7,'Total Akhir',1,0,'C'); 
        $pdf->Cell(38 ,7,'Total Setoran',1,1,'C');  
         
        
        $pdf->SetFont('Times','',12);
        // $pdf->SetTextColor(0, 0, 0);
        // $pdf->SetFillColor(255,255,255);
        
        
        // $no_ = 1;
        
        $pdf->Cell(15 ,8,"1",1,0,'C');
        $pdf->Cell(40 ,8,uang($totalpenjualan),1,0,'C');
        $pdf->Cell(38 ,8,uang($totalkas),1,0,'C');
        $pdf->Cell(58 ,8,uang($totalakhir),1,0,'C');
        $pdf->Cell(38 ,8,uang($totalsetoran),1,1,'C');
         
       
        $pdf->Cell(189 ,5,'',0,1); //dummy
        $pdf->Cell(189 ,5,'',0,1); //dummy
 
    $pdf->Output('D','Laporan-Pendapatan.pdf',"T");
?>