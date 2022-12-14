<?php
    include "Koneksi.php";
    require 'asset/function/function.php';
    //include "../admin_login.php";
    require 'asset/plugins/fpdf/fpdf.php';
    // (isset($_GET['tm']) ? $tglmulai = $_GET['tm'] : $tglmulai='');
    // (isset($_GET['ts']) ? $tglselesai = $_GET['ts'] : $tglselesai='');
    (isset($_GET['bahan']) ? $bahan = $_GET['bahan'] : $bahan='');
    
    $tgl_cetak = date("d-m-Y");
    
    $syarat = "";
    if($bahan != "ALL"){
        $syarat = " AND id='$bahan'";
    }

    $sqlsel = "SELECT * FROM tbbahan WHERE id!='' $syarat ORDER BY jumlah ASC";

    // echo "SELECT * FROM tbjual INNER JOIN tbuser USING(iduser) WHERE statbayar='bayar' $syarat ";
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

    $pdf->Cell(189,7,strtoupper('Laporan Stok Bahan'),0,1,'C');

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
        $pdf->Cell(95 ,7,'Bahan',1,0,'C');
        $pdf->Cell(39 ,7,'Jumlah',1,0,'C');  
        $pdf->Cell(40 ,7,'Satuan',1,1,'C'); 
        
        

        $pdf->SetFont('Times','',12);
        // $pdf->SetTextColor(0, 0, 0);
        // $pdf->SetFillColor(255,255,255);
        
        // $id_order = $row['id_order'];
        $no_ = 1;
        //Numbers are right-aligned so we give 'R' after new line parameter
        $sql1 = mysqli_query($con,$sqlsel);
        // $sumtotalakhir=0;
        while ($rows = mysqli_fetch_assoc($sql1)) {
            // $total_ =  ((int)$rows['harga_produk'] * (int)$rows['jumlah_order']);
            $pdf->Cell(15 ,8,$no_,1,0,'C');
            $pdf->Cell(95 ,8,$rows['nama'],1,0);
            
            $pdf->Cell(39 ,8,$rows['jumlah'],1,0,'C');
            $pdf->Cell(40 ,8,$rows['satuan'],1,1,'C');
           
                        
            $no_++;
            // $sumtotalakhir += $rows['totalakhir'];
        }
        
        // print_r[$rows];
        // $sqlTotal = mysqli_query($con,"SELECT SUM(subtotal) AS Subtotal, SUM(diskon) AS Diskon, SUM(pajak) AS Pajak, SUM(grandtotal) AS Grandtotal FROM tbjual WHERE statbayar='bayar' $syarat");
        // $row = mysqli_fetch_assoc($sqlTotal);
        // $pdf->SetFont('Times','B',12);
        
        // $pdf->Cell(163 ,8,'Total',1,0,'C');
        // // set color table footer
        // $pdf->SetTextColor(255, 255, 255);
        // $pdf->SetFillColor(33,150,243);
        // // $pdf->Cell(9 ,8,'Rp.',1,0);
        // $pdf->Cell(26 ,8,'Rp '.uang($sumtotalakhir),1,1,'R',1);//end of line
       
        $pdf->Cell(189 ,5,'',0,1); //dummy
        $pdf->Cell(189 ,5,'',0,1); //dummy
 
    $pdf->Output('D','Laporan-Stok-Bahan.pdf');
?>