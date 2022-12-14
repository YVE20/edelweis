<?php
    include "Koneksi.php";
    require 'asset/function/function.php';
    //include "../admin_login.php";
    require 'asset/plugins/fpdf/fpdf.php';
    (isset($_GET['tm']) ? $tglmulai = $_GET['tm'] : $tglmulai='');
    (isset($_GET['ts']) ? $tglselesai = $_GET['ts'] : $tglselesai='');
    (isset($_GET['karyawan']) ? $karyawan = $_GET['karyawan'] : $karyawan='');
    (isset($_GET['shift']) ? $shift = $_GET['shift'] : $shift='');
    (isset($_GET['user']) ? $user = $_GET['user'] : $user='');
    (isset($_GET['menu']) ? $menu = $_GET['menu'] : $menu='');

    // print_r($_GET);
    $tgl_cetak = date("d-m-Y");

    

        $syarat = "";
        $syaratdetil = "";
        if ($tglmulai != "" && $tglselesai != "") {
            $syarat = " and (tj.tanggal between '$tglmulai' and '$tglselesai')";
        }
        if ($karyawan != "ALL") {
            $syarat .= " and tj.idkaryawan='$karyawan'";
        }
        if ($shift != "ALL") {
            if($shift != "Total"){
                $syarat .= " and tj.shift='$shift'";
            }else{
                $syarat .= " and (tj.shift='1' or tj.shift='2' or tj.shift='3') ";
            }
        }
        if ($user != "ALL") {
            $syarat .= " and tj.iduser='$user'";
        }
        if ($menu != "ALL"){
            $syarat .= " and tjd.idmenu='$menu'";
            $syaratdetil .= " and tjd.idmenu='$menu'";
        }
        $sqlsel = "select tj.id,tj.tanggal,tj.shift,tj.meja,tk.nama as 'namakaryawan',tu.nama as 'namauser', tj.alasan from trashjual tj left join tbkaryawan tk on tj.idkaryawan=tk.id left join tbuser tu on tj.iduser=tu.iduser inner join trashjualdetil tjd on tj.id=tjd.idjual where tj.id!='' $syarat  group by tjd.idjual order by tj.created_at asc";
//        echo $sqlsel;


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

    $pdf->Cell(189,7,strtoupper('Laporan Penjualan Terhapus'),0,1,'C');

    $pdf->Cell(189 ,5,'',0,1); //dummy
    $pdf->SetFont('Times','I',11);
    $pdf->Cell(30 ,7,'Tanggal Cetak : '.$tgl_cetak,0,1);

    $pdf->Cell(189 ,5,'',0,1); //dummy
    $pdf->Cell(189 ,5,'',0,1); //dummy
    
        
        // $id_order = $row['id_order'];
        
        //Numbers are right-aligned so we give 'R' after new line parameter
        $querysel = mysqli_query($con, $sqlsel);
            $x = 1;
            $sumharga = 0;
            $sumjumlah = 0;
            $sumtotal = 0;
            $sumpajak = 0;
            $sumdiskon = 0;
            $sumsubtotal = 0;
            while ($res = mysqli_fetch_array($querysel)) {
                $idtransaksi = $res['id'];
                $tanggal = tgl_bahasa($res['tanggal']);
                $user = $res['namauser'];
                $karyawan = $res['namakaryawan'];
                $shift = $res['shift'];
                $meja = $res['meja'];
                $alasan = $res['alasan'];


                $pdf->SetFont('Times','',11);
                // $pdf->SetTextColor(0, 0, 0);
                // $pdf->SetFillColor(255,255,255);
                $pdf->Cell(100 ,7,'No Transaksi : #'.$idtransaksi,0,0,'L');
                $pdf->Cell(89 ,7,'Waktu : '.$tanggal,0,1,'L');

                $pdf->Cell(100 ,7, 'Meja : '.$meja,0,0,'L');
                $pdf->Cell(89 ,7,'User : '.$user,0,1,'L');

                // set color table header
                $pdf->SetFont('Times','B',11);
                // $pdf->SetTextColor(255, 255, 255);
                // $pdf->SetFillColor(33,150,243);
                // $pdf->SetDrawColor(150, 150, 150);

                $pdf->Cell(189 ,10,'   Alasan : '.$alasan,1,1,'L');//end of line

                // $pdf->SetTextColor(0, 0, 0);
                // $pdf->SetFillColor(255,255,255);
                // $pdf->Cell(96 ,10,$alasan,1,1,'L');

                // $pdf->SetTextColor(255, 255, 255);
                // $pdf->SetFillColor(33,150,243);
                // $pdf->SetDrawColor(150, 150, 150);

                $pdf->Cell(15 ,7,'No',1,0,'C');
                $pdf->Cell(78 ,7,'Menu',1,0,'C');
                $pdf->Cell(35 ,7,'Harga (Rp)',1,0,'R');
                $pdf->Cell(25 ,7,'Qty',1,0,'C');
                $pdf->SetFont('Times','B',10);
                $pdf->Cell(36 ,7,'Total (Rp)',1,1,'R');//end of line

                $pdf->SetFont('Times','',10);
                // $pdf->SetTextColor(0, 0, 0);
                // $pdf->SetFillColor(255,255,255);

                $sqldet = "select tjd.jumlah, tjd.harga, tjd.total, tm.nama as 'namamenu' from trashjualdetil tjd inner join tbmenu tm on tjd.idmenu=tm.id where tjd.idjual='$idtransaksi' $syaratdetil order by tjd.id";
                $querydet = mysqli_query($con,$sqldet);
              //  echo $sqldet;
                $no_ = 1;
                $grandtotal = 0; 
                while($resdet = mysqli_fetch_array($querydet)){
                   
                            
                    $jumlah = $resdet['jumlah'];
                    $harga = $resdet['harga'];
                    $total = $resdet['total'];
                    $namamenu = $resdet['namamenu'];

                    $total_ =  ((int)$subtotal + (int)$jlhpajak) - (int)$jlhdiskon;
                    $pdf->Cell(15 ,8,$no_,1,0,'C');
                    $pdf->Cell(78 ,8,$namamenu,1,0,'L');
                    $pdf->Cell(35 ,8,uang($harga),1,0,'R');
                    $pdf->Cell(25 ,8,$jumlah,1,0,'C');
                    $pdf->SetFont('Times','',11);
                    $pdf->Cell(36 ,8,uang($total),1,1,'R');
                    
                    $no_++;
                    $grandtotal+=$total;

                }
            
           
            
            // $pdf->Cell(141 ,5,'',0,0); //dummy  
            $pdf->SetFont('Times','B',11);  
            $pdf->Cell(153 ,8,"Total ",1,0,"C");
            
            $pdf->SetFont('Times','B',11);
            // $pdf->SetTextColor(255, 255, 255);
            // $pdf->SetFillColor(33,150,243);
            // $pdf->SetDrawColor(150, 150, 150);
            $pdf->Cell(36 ,8,"Rp ".uang($grandtotal),1,1,"R");
            


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
 
    $pdf->Output('D','Laporan-Penjualan-Terhapus.pdf');
?>