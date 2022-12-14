<?php
/**
 * Created By :    
 * User: Welly
 * Date: 25/02/2018
 * Time: 12:02
 */

// Function to get the client IP address
function get_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    if($ipaddress == "::1")
        $ipaddress = gethostbyname(trim(`hostname`));

    return $ipaddress;
}

function encryptIt( $val ) {
    //$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    //$valEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $val, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    $valEncoded = base64_encode($val);
    return( $valEncoded );
}

function decryptIt( $val ) {
    //$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    //$valDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $val ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    $valDecoded = base64_decode($val);
    return( $valDecoded );
}

function pad_left($input,$pad,$pad_length){
    return str_pad($input, $pad_length, "$pad", STR_PAD_LEFT);
}

function tgl_mysql($val){
    $pecah = explode("-",$val);
    $tanggal = $pecah[2]."-".$pecah[1]."-".$pecah[0];
    return $tanggal;
}

function tgl_mysql2($val){
    $pecah = explode("/",$val);
    $tanggal = $pecah[2]."-".$pecah[1]."-".$pecah[0];
    return $tanggal;
}

function tgl_html($val){
    $pecah = explode("-",$val);
    $tanggal = $pecah[2]."/".$pecah[1]."/".$pecah[0];
    return $tanggal;
}

function tgl_indo($val){
    $pecah = explode("-",$val);
    $tanggal = $pecah[2]."-".$pecah[1]."-".$pecah[0];
    return $tanggal;
}

function tgl_bahasa($val){
    $pecah = explode("-",$val);
    $tanggal = $pecah[2]."-".bulan($pecah[1])."-".$pecah[0];
    return $tanggal;
}

function uang($val){
    $hasil = number_format($val, 0, ',', '.');
    return $hasil;
}

function uangRp($val){
    $hasil = "Rp ".number_format($val, 0, ',', '.');
    return $hasil;
}

function bulan($val){
    $bln = "";
    if($val == "01" || $val =='1' ){
        $bln = "Jan";
    }else if($val == "02" || $val =='2'){
        $bln = "Feb";
    }else if($val == "03" || $val =='3'){
        $bln = "Mar";
    }else if($val == "04" || $val =='4'){
        $bln = "Apr";
    }else if($val == "05" || $val =='5'){
        $bln = "Mei";
    }else if($val == "06" || $val =='6'){
        $bln = "Jun";
    }else if($val == "07" || $val =='7'){
        $bln = "Jul";
    }else if($val == "08" || $val =='8'){
        $bln = "Ags";
    }else if($val == "09" || $val =='9'){
        $bln = "Sep";
    }else if($val == "10"){
        $bln = "Okt";
    }else if($val == "11"){
        $bln = "Nov";
    }else if($val == "12"){
        $bln = "Des";
    }
    return $bln;
}

function tglfile($val){
    $pecah = explode("-",$val);
    $tanggal = $pecah[2].".".$pecah[1].".".$pecah[0];
    return $tanggal;
}

function tgl_excel($val){
    $pecah = explode("-",$val);
//    $tanggal = "=date(".$pecah[0].",".$pecah[1].",".$pecah[2].")";
//    $tanggal = "=date($pecah[0],$pecah[1],$pecah[2])";
    $tanggal = $pecah[2]."/".$pecah[1]."/".$pecah[0];
    return $tanggal;
}

function ambil_bulan($val){
    if($val == "Januari" || $val == "January" || $val=="Jan" || $val=="jan" || $val=="01"){
        $bln = "01";
    }else if($val == "Februari" || $val == "February" || $val == "Pebruari" || $val=="Feb" || $val=="feb" || $val=="02"){
        $bln = "02";
    }else if($val == "Maret" || $val=="Mar" || $val=="mar" || $val=="03"){
        $bln = "03";
    }else if($val == "April" || $val=="Apr" || $val=="apr" || $val=="04"){
        $bln = "04";
    }else if($val == "Mei" || $val=="May" || $val=="may" || $val=="05"){
        $bln = "05";
    }else if($val == "Juni" || $val=="June" || $val=="june" || $val=="jun" || $val=="Jun" || $val=="Juny" || $val=="06"){
        $bln = "06";
    }else if($val == "Juli" || $val=="Jul" || $val=="July" || $val=="july" || $val=="jul" || $val=="07"){
        $bln = "07";
    }else if($val == "Agustus" || $val == "agustus" || $val == "August" || $val=="Agu" || $val=="Ags" || $val=="Aug" || $val=="agu" || $val=="ags" || $val=="aug" || $val=="08"){
        $bln = "08";
    }else if($val == "September" || $val=="Sept" || $val=="sept" || $val=="sep" || $val=="spt" || $val=="Sep" || $val=="09" || $val=="Spt"){
        $bln = "09";
    }else if($val == "Oktober" || $val=="Okt" || $val=="Oct" || $val=="okt" || $val=="oct" || $val=="10"){
        $bln = "10";
    }else if($val == "November" || $val == "Nopember" || $val=="Nov" || $val=="nov" || $val=="nop" || $val=="Nop" || $val=="11"){
        $bln = "11";
    }else if($val == "Desember" || $val == "December" || $val=="Des" || $val=="des" || $val=="dec" || $val=="Dec" || $val=="12"){
        $bln = "12";
    }
    return $bln;
}

function randomUser($panjang){
    $pool = array_merge(range(0,9), range('a','z'), range('A','Z'));

    $key = "";
    for($i=0; $i<$panjang;$i++){
        $key .= $pool[mt_rand(0, count($pool)-1)];
    }
    return $key;
}

function timeago($original) {
    // $original = strtotime($date);	
    
    date_default_timezone_set('Asia/Jakarta');
    $chunks = array(
        array(60 * 60 * 24 * 365, 'tahun'),
        array(60 * 60 * 24 * 30, 'bulan'),
        array(60 * 60 * 24 * 7, 'minggu'),
        array(60 * 60 * 24, 'hari'),
        array(60 * 60, 'jam'),
        array(60, 'menit'),
    );
    $today = time();
    $since = $today - $original;
   
    if ($since > 604800)
    {
      $print = date("M jS", $original);
      if ($since > 31536000)
      {
        $print .= ", " . date("Y", $original);
      }
      return $print;
    }
   
    for ($i = 0, $j = count($chunks); $i < $j; $i++)
    {
      $seconds = $chunks[$i][0];
      $name = $chunks[$i][1];
   
      if (($count = floor($since / $seconds)) != 0)
        break;
    }
   
    $print = ($count == 1) ? '1 ' . $name : "$count {$name}";
    return $print . ' yang lalu';
 }

 function col($karakter,$kolom)
 {
     // $subtotal_jual = "";
     $panjangChar = strlen($karakter);
    //  echo $panjangChar;
     $nilai = 0;
     if ($panjangChar < $kolom) {
         $nilai = $kolom - (int)$panjangChar;
     }
    //  echo $nilai;
    
     $space = str_repeat(" ",$nilai);
     // $space1 = $space."".$subtotal_jual;
     return $space;
 }