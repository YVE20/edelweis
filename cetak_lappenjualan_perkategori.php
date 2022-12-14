<?php
    include "Koneksi.php";
    require 'asset/function/function.php';
    //include "../admin_login.php";
    require 'asset/plugins/fpdf/fpdf.php';
    (isset($_GET['tm']) ? $tanggalmulai = $_GET['tm'] : $tanggalmulai='');
    (isset($_GET['ts']) ? $tanggalselesai = $_GET['ts'] : $tanggalselesai='');
    (isset($_GET['kategori']) ? $kategori = $_GET['kategori'] : $kategori='');
    // (isset($_GET['shift']) ? $shift = $_GET['shift'] : $shift='');
    // (isset($_GET['user']) ? $user = $_GET['user'] : $user='');


    $tgl_cetak = date("d-m-Y");
    
    $syarat = "";
    // $syaratdetil = "";
    if ($tanggalmulai != "" && $tanggalselesai != "") {
        $syarat = " and (tj.tanggal between '$tanggalmulai' and '$tanggalselesai')";
    }
    if ($kategori != "ALL"){
        $syarat .= " and tm.kategori='$kategori'";
    }
    $sqlsel = "select sum(tjd.jumlah) as 'totaljumlah', sum(tjd.total) as 'totalakhir',tm.kategori, tm.satuan, tm.harga from tbjualdetil tjd inner join tbmenu tm on tjd.idmenu=tm.id inner join tbjual tj on tjd.idjual=tj.id where tjd.id!='' $syarat group by tm.kategori";

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

    $pdf->Cell(189,7,strtoupper('Laporan Penjualan Perkategori'),0,1,'C');

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
        $pdf->Cell(53 ,7,'Kategori',1,0,'C');
        // $pdf->Cell(26 ,7,'Harga (Rp)',1,0,'C');
        $pdf->Cell(52 ,7,'Jumlah',1,0,'C');
        // $pdf->Cell(15 ,7,'Satuan',1,0,'C');
        // $pdf->Cell(22 ,7,'Diskon (Rp)',1,0,'R');
        // $pdf->Cell(22 ,7,'Pajak (Rp)',1,0,'R');
        $pdf->SetFont('Times','B',10);
        $pdf->Cell(74 ,7,'Total (Rp)',1,1,'R');
        

        $pdf->SetFont('Times','',10);
        // $pdf->SetTextColor(0, 0, 0);
        // $pdf->SetFillColor(255,255,255);
        
        // $id_order = $row['id_order'];
        $no_ = 1;
        //Numbers are right-aligned so we give 'R' after new line parameter
        $sql1 = mysqli_query($con,$sqlsel);
        $sumtotalakhir=0;
        while ($rows = mysqli_fetch_assoc($sql1)) {
            // $total_ =  ((int)$rows['harga_produk'] * (int)$rows['jumlah_order']);
            $pdf->Cell(10 ,8,$no_,1,0,'C');
            $pdf->Cell(53 ,8,substr($rows['kategori'],0,30),1,0);
            // $pdf->Cell(26 ,8,uang($rows['harga']),1,0,'R');
            $pdf->Cell(52 ,8,$rows['totaljumlah'],1,0,'C');
            $pdf->SetFont('Times','',11);
            // $pdf->Cell(15 ,8,$rows['satuan'],1,0,'C');
            // $pdf->Cell(22 ,8,uang($rows['totaldiskon']),1,0,'R');
            // $pdf->Cell(22 ,8,uang($rows['totalpajak']),1,0,'R');
            $pdf->Cell(74 ,8,uang($rows['totalakhir']),1,1,'R');
                        
            $no_++;
            $sumtotalakhir += $rows['totalakhir'];
        }
        
        // print_r[$rows];
        // $sqlTotal = mysqli_query($con,"SELECT SUM(subtotal) AS Subtotal, SUM(diskon) AS Diskon, SUM(pajak) AS Pajak, SUM(grandtotal) AS Grandtotal FROM tbjual WHERE statbayar='bayar' $syarat");
        // $row = mysqli_fetch_assoc($sqlTotal);
        $pdf->SetFont('Times','B',12);
        
        $pdf->Cell(115 ,8,'Total',1,0,'C');
        // set color table footer
        // $pdf->SetTextColor(255, 255, 255);
        // $pdf->SetFillColor(33,150,243);
        // $pdf->Cell(9 ,8,'Rp.',1,0);
        $pdf->Cell(74 ,8,'Rp '.uang($sumtotalakhir),1,1,'R');//end of line
       
        $pdf->Cell(189 ,5,'',0,1); //dummy
        $pdf->Cell(189 ,5,'',0,1); //dummy
 
    $pdf->Output('D','Laporan-Penjualan-Perkategori.pdf');
?>