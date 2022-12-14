<?php
   include "KoneksiHome.php";

   $sql2 = "select * from license where id='1'";
   $query2 = mysqli_query($con,$sql2);
   $res = mysqli_fetch_array($query2);

   $namausaha = $res['nama'];
   $icon = $res['icon'];
   
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <title><?php echo $namausaha;?></title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/responsive.css">
      <link rel="shortcut icon" href="asset/img/<?php echo $_SESSION['icon']; ?>">
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   </head>
   <body class="main-layout">
      <!-- loader  -->  
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#" /></div>
      </div>
      <!-- end loader -->
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.php"><img src="../asset/img/logo_transparent.png" alt="#" /></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item active">
                                 <a class="nav-link" href="index.php">Home</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="about.php">About</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="contact.php">Contact Us</a>
                              </li>
                              <li class="nav-item d_none" onclick="viewKeranjang()">
                                 <a class="nav-link" href="#">
                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                    <div id="qtyKeranjang" style="margin-top: -30px;margin-left:20px;"> 0 </div>
                                 </a>
                              </li>
                              <?php
                              if($_SESSION['iduser'] == NULL){
                              ?>
                                 <li class="nav-item d_none" id="loginText">
                                    <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                                 </li>
                              <?php   
                              }else{
                              ?>
                                 <li class="nav-item d_none" id="loginText" style="display: none;">
                                    <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                                 </li>
                              <?php
                              }
                              ?>
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- end header inner -->
      <!-- end header -->
      <!-- banner -->
      <section class="banner_main">
         <div id="banner1" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
               <li data-target="#banner1" data-slide-to="0" class="active"></li>
               <li data-target="#banner1" data-slide-to="1"></li>
               <li data-target="#banner1" data-slide-to="2"></li>
               <li data-target="#banner1" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <div class="carousel-caption">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="text-bg">
                                 <span> Komputer dan Laptop </span>
                                 <h1> Aksesoris </h1>
                                 <p> Terdapat banyak variasi dari aksesoris komputer dan laptop. Segera miliki mulai dari keyboard, mouse hingga perangkat tambahan lainnya. </p>
                                 <a href="#"> Beli Sekarang </a> <a href="contact.php"> Hubungi </a>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="text_img">
                                 <figure><img src="images/pct.png" alt="#"/></figure>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="carousel-caption">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="text-bg">
                                 <span> Alat tulis dan Kantor </span>
                                 <h1> ATK </h1>
                                 <p> Peralatan tulis dan kantor yang siap menemai kebutuhan harian anda. Tersedia mulai dari memo, pulpen, pensil hingga penghapus. Segera miliki  </p>
                                 <a href="#"> Beli Sekarang </a> <a href="contact.php"> Hubungi </a>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="text_img">
                                 <figure><img src="images/atk.png" alt="#"/></figure>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="carousel-caption">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="text-bg">
                                 <span> Makanan </span>
                                 <h1> Pangan </h1>
                                 <p> Kebutuhan pangan harian yang tidak mungkin untuk dihindar. Tersedia mulai dari makanan instant hingga makanan segar lainnya.  </p>
                                 <a href="#"> Beli Sekarang </a> <a href="contact.php"> Hubungi </a>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="text_img">
                                 <figure><img src="images/makanan.png" alt="#"/></figure>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="carousel-caption">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="text-bg">
                                 <span> Sepatu </span>
                                 <h1> Fashion </h1>
                                 <p> Miliki sepatu casual terkini. Bangga menggunakan produk buatan lokal yang mendunia. Tersedia dari berbagai macam ukuran dan warna. </p>
                                 <a href="#"> Beli Sekarang </a> <a href="contact.php"> Hubungi </a>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="text_img">
                                 <figure><img src="images/sepatu.png" alt="#"/></figure>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <a class="carousel-control-prev" href="#banner1" role="button" data-slide="prev">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </a>
            <a class="carousel-control-next" href="#banner1" role="button" data-slide="next">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </a>
         </div>
      </section>
      <!-- end banner -->
      <!-- three_box -->
      <div class="three_box">
         <div class="container">
            <div class="row">
               <div class="col-md-3 mt-4">
                  <div class="box_text">
                     <i><img src="images/lasegar-satuan.jpeg" alt="#" style="margin-top:-30px"></i>
                     <h5> <b> Lasegar Orange 240ml </b> </h5>
                     <font style="font-size:10px"> Lorem ipsum ipsum dolor sit amet , Lorem ipsum ipsum dolor sit amet Lorem ipsum ipsum dolor sit </font><br><br>
                     <button class="btn" onclick="beliSekarang('111')"> Beli sekarang </button>
                     <button class="btn" onclick="keranjang('111')"> <img src="images/keranjang.png" alt="#"> </button>
                  </div>
               </div>
               <div class="col-md-3 mt-4">
                  <div class="box_text">
                     <i><img src="images/indomie-satuan.jpg" alt="#" style="margin-top:-30px"></i>
                     <h5> <b> Indomie Goreng 1 Dus </b> </h5>
                     <font style="font-size:10px"> Lorem ipsum ipsum dolor sit amet , Lorem ipsum ipsum dolor sit amet Lorem ipsum ipsum dolor sit </font><br><br>
                     <button class="btn" onclick="beliSekarang('112')"> Beli sekarang </button>
                     <button class="btn" onclick="keranjang('112')"> <img src="images/keranjang.png" alt="#"> </button>
                  </div>
               </div>
               <div class="col-md-3 mt-4">
                  <div class="box_text">
                     <i><img src="images/indomilik-satuan.jpg" alt="#" style="margin-top:-30px"></i>
                     <h5> <b> Indomilik Susu Steril 220ml </b> </h5>
                     <font style="font-size:10px"> Lorem ipsum ipsum dolor sit amet , Lorem ipsum ipsum dolor sit amet Lorem ipsum ipsum dolor sit </font><br><br>
                     <button class="btn" onclick="beliSekarang('113')"> Beli sekarang </button>
                     <button class="btn" onclick="keranjang('113')"> <img src="images/keranjang.png" alt="#"> </button>
                  </div>
               </div>
               <div class="col-md-3 mt-4">
                  <div class="box_text">
                     <i><img src="images/product2.png" alt="#" style="margin-top:-30px"></i>
                     <h5> <b> Mouse Logitech M321 </b> </h5>
                     <font style="font-size:10px"> Lorem ipsum ipsum dolor sit amet , Lorem ipsum ipsum dolor sit amet Lorem ipsum ipsum dolor sit </font><br><br>
                     <button class="btn" onclick="beliSekarang('114')"> Beli sekarang </button>
                     <button class="btn" onclick="keranjang('114')"> <img src="images/keranjang.png" alt="#"> </button>
                  </div>
               </div>
               <div class="col-md-3 mt-4">
                  <div class="box_text">
                     <i><img src="images/keyboard-satuan.jpg" alt="#" style="margin-top:-30px"></i>
                     <h5> <b> Keyboard MTech RGB 100G </b> </h5>
                     <font style="font-size:10px"> Lorem ipsum ipsum dolor sit amet , Lorem ipsum ipsum dolor sit amet Lorem ipsum ipsum dolor sit </font><br><br>
                     <button class="btn" onclick="beliSekarang('115')"> Beli sekarang </button>
                     <button class="btn" onclick="keranjang('115')"> <img src="images/keranjang.png" alt="#"> </button>
                  </div>
               </div>
                <div class="col-md-3 mt-4">
                  <div class="box_text">
                     <i><img src="images/roti-satuan.jpg" alt="#" style="margin-top:-30px"></i>
                     <h5> <b> Sari Roti Tawar 100Gr </b> </h5>
                     <font style="font-size:10px"> Lorem ipsum ipsum dolor sit amet , Lorem ipsum ipsum dolor sit amet Lorem ipsum ipsum dolor sit </font><br><br>
                     <button class="btn" onclick="beliSekarang('115')"> Beli sekarang </button>
                     <button class="btn" onclick="keranjang('115')"> <img src="images/keranjang.png" alt="#"> </button>
                  </div>
               </div>
                <div class="col-md-3 mt-4">
                  <div class="box_text">
                     <i><img src="images/pensil-satuan.jpg" alt="#" style="margin-top:-30px"></i>
                     <h5> <b> Faber Castle Pencil 2B </b> </h5>
                     <font style="font-size:10px"> Lorem ipsum ipsum dolor sit amet , Lorem ipsum ipsum dolor sit amet Lorem ipsum ipsum dolor sit </font><br><br>
                     <button class="btn" onclick="beliSekarang('115')"> Beli sekarang </button>
                     <button class="btn" onclick="keranjang('115')"> <img src="images/keranjang.png" alt="#"> </button>
                  </div>
               </div>
               <!-- Start looping data dari database -->
               <?php
                  $sql3 = "select * from tbmenu";
                  $query3 = mysqli_query($con,$sql3);

                  while ($re = mysqli_fetch_array($query3)) {
               ?>
                     <div class="col-md-3 mt-4">
                        <div class="box_text">
                           <div onclick="beliSekarang('<?= $re['kode_barang'] ?>')" style="cursor:pointer">>
                              <i><img src="<?= $re['img_url'] ?>" alt="#" style="margin-top:-30px"></i>
                              <h5> <b> <?= $re['nama'] ?> </b> </h5>
                              <font style="font-size:10px"> Lorem ipsum ipsum dolor sit amet , Lorem ipsum ipsum dolor sit amet Lorem ipsum ipsum dolor sit </font><br><br>
                           </div>
                           <div>
                              <button class="btn" onclick="beliSekarang('<?= $re['kode_barang'] ?>')"> Beli sekarang </button>
                              <button class="btn" onclick="keranjang('<?= $re['kode_barang'] ?>')"> <img src="images/keranjang.png" alt="#"> </button>
                           </div>
                           
                        </div>
                     </div>
               <?php
                  }
               ?>
               <!-- End of looping -->
            </div>
         </div>
      </div>
      <!-- customer -->
      <div class="customer">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Customer Review</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div id="myCarousel" class="carousel slide customer_Carousel " data-ride="carousel">
                     <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                     </ol>
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <div class="container">
                              <div class="carousel-caption ">
                                 <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                       <div class="test_box">
                                          <i><img src="images/cos.png" alt="#"/></i>
                                          <h4>Sandy Miller</h4>
                                          <p>ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <div class="container">
                              <div class="carousel-caption">
                                 <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                       <div class="test_box">
                                          <i><img src="images/cos.png" alt="#"/></i>
                                          <h4>Sandy Miller</h4>
                                          <p>ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <div class="container">
                              <div class="carousel-caption">
                                 <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                       <div class="test_box">
                                          <i><img src="images/cos.png" alt="#"/></i>
                                          <h4>Sandy Miller</h4>
                                          <p>ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                     </a>
                     <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end customer -->
      <!--  contact -->
      <div class="contact">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Contact Now</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-10 offset-md-1">
                  <form id="request" class="main_form">
                     <div class="row">
                        <div class="col-md-12 ">
                           <input class="contactus" placeholder="Name" type="type" name="Name"> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Email" type="type" name="Email"> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Phone Number" type="type" name="Phone Number">                          
                        </div>
                        <div class="col-md-12">
                           <textarea class="textarea" placeholder="Message" type="type" Message="Name">Message </textarea>
                        </div>
                        <div class="col-md-12">
                           <button class="send_btn">Send</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <!-- end contact -->
      <!--  footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                     <img class="logo1" src="../asset/img/logo_transparent.png" alt="#"/>
                     <ul class="social_icon">
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                     <h3>About Us</h3>
                     <ul class="about_us">
                        <li>dolor sit amet, consectetur<br> magna aliqua. Ut enim ad <br>minim veniam, <br> quisdotempor incididunt r</li>
                     </ul>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                     <h3>Contact Us</h3>
                     <ul class="conta">
                        <li>dolor sit amet,<br> consectetur <br>magna aliqua.<br> quisdotempor <br>incididunt ut e </li>
                     </ul>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                     <form class="bottom_form">
                        <h3>Newsletter</h3>
                        <input class="enter" placeholder="Enter your email" type="text" name="Enter your email">
                        <button class="sub_btn">subscribe</button>
                     </form>
                  </div>
               </div>
            </div>
            <div class="copyright">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12">
                        <p>© 2022 All Rights Reserved. </a></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- Login Modal -->
      <div class="modal fade" style="margin-top: 100px;" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-body">
                  <div class="row"> 
                     <div class="col-lg-12"> 
                        <center> <h2> <b> LOGIN </b> </h2>  </center> 
                     </div> 
                     <div class="col-lg-12 mt-3"> 
                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username"> 
                     </div> 
                     <div class="col-lg-12 mt-3"> 
                        <input type="password" id="pass" name="pass" class="form-control" placeholder="*********">
                     </div> 
                     <div class="col-lg-12 mt-3"> 
                        <center>
                           <button class="btn btn-primary w-50" onclick="ceklogin()"> <i class="fa fa-sign-in" aria-hidden="true"></i> Login </button>  
                        </center>   
                     </div> 
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Keranjang Modal Kosong -->
      <div class="modal fade" style="margin-top: 100px;" id="keranjangModalKosong" tabindex="-1" role="dialog" aria-labelledby="keranjangModalKosongLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
               <div class="modal-body">
                  <div class="row"> 
                     <div class="col-lg-12"> 
                        <center> <h2> <b> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Keranjang </b> </h2>  </center> 
                     </div> 
                     <div class="col-lg-12 mt-3"> 
                        <table class="table">
                           <colgroup>
                              <col style="width:5%">
                              <col style="width:55%">
                              <col style="width:20%">
                              <col style="width:20%">
                           </colgroup>
                           <thead>
                              <tr>
                                 <th> # </th>
                                 <th> Barang </th>
                                 <th> Qty </th>
                                 <th> Harga </th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <th colspan="4"> <center> Belum ada barang nih dikeranjangmu &#128521; <br> Ayo buruan belanja sekarang </center> </th>
                              </tr>
                           </tbody>
                        </table>
                     </div> 
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Checkout </button>
               </div>
            </div>
         </div>
      </div>
      <!-- Keranjang Modal Kosong -->
      <div class="modal fade" style="margin-top: 100px;" id="keranjangModal" tabindex="-1" role="dialog" aria-labelledby="keranjangModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
               <div class="modal-body">
                  <div class="row"> 
                     <div class="col-lg-12"> 
                        <center> <h2> <b> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Keranjang </b> </h2>  </center> 
                     </div> 
                     <div class="col-lg-12 mt-3"> 
                        <table class="table">
                           <colgroup>
                              <col style="width:5%">
                              <col style="width:55%">
                              <col style="width:20%">
                              <col style="width:20%">
                           </colgroup>
                           <thead>
                              <tr>
                                 <th> # </th>
                                 <th> Barang </th>
                                 <th> Qty </th>
                                 <th> Harga </th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php 
                                 $iduser = $_SESSION['iduser'];
                                 $sql4 = "select tbkeranjang.jumlah as 'jumlahBarang',  tbkeranjang.subtotal as 'subTotal', tbkeranjang.kode_barang as 'kodeBarang', tbmenu.nama as 'namaBarang' from tbkeranjang inner join tbmenu on tbkeranjang.kode_barang = tbmenu.kode_barang where tbkeranjang.id_user = '$iduser' ";
                                 $query4 = mysqli_query($con,$sql4);
                                 $row = 1;

                                 while($re4 = mysqli_fetch_array($query4)){
                              ?>
                                 <tr>
                                    <td> <?= $row++ ?> </td>
                                    <td> <?= $re4['namaBarang'] ?> </td>
                                    <td> 
                                       <button class="btn" onclick="minus(1)"> - </button> 
                                       <input type="text" id="qtyJumlahKeranjang" value="<?= $re4['jumlahBarang'] ?> " style="width:30px;text-align: center;border:none;" readonly>
                                       <button class="btn" onclick="plus(1)"> + </button> </td>
                                    <td> 
                                       Rp. <input type="text" id="subTotal" value="<?= $re4['subTotal'] ?> " style="width:80%;text-align: center;border:none;" readonly> 
                                    </td>
                                 </tr>
                              <?php      
                                 }
                              ?>
                           </tbody>
                        </table>
                     </div> 
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" onclick="beli()"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Checkout </button>
               </div>
            </div>
         </div>
      </div>
      <!-- End of modal -->
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      <script>
         $(document).ready(function(){
            countKeranjang();
         });
         function plus(satu){
            var qty = $('#qtyJumlahKeranjang').val();
            var subTotal = $('#subTotal').val();
            var hasil = parseInt(qty) + parseInt(satu);
            var hitungSubTotal = hasil * (subTotal/qty);
            $('#qtyJumlahKeranjang').val(hasil);
            $('#subTotal').val(hitungSubTotal);
         }
         function minus(satu){
            var qty = $('#qtyJumlahKeranjang').val();
            var subTotal = $('#subTotal').val();
            var hasil = parseInt(qty) - parseInt(satu);
            var hitungSubTotal = hasil * (subTotal/qty);
            if(hasil <= 0){
               Swal.fire({
                  icon: 'error',
                  title : 'Peringatan',
                  text : 'Jumlah barang tidak dapat kurang dari 1',
                  showConfirmButton: false,
                  timer: 1500
               })
               $('#qtyJumlahKeranjang').val(1);
            }else{
               $('#qtyJumlahKeranjang').val(hasil);
                $('#subTotal').val(hitungSubTotal);
            }
            
         }
         function countKeranjang(){
            var iduser = '<?= $_SESSION['iduser'] ?>';
            $.post("cekkeranjang.php", {
               iduser : iduser, typeKeranjang : "count"
            })
            .done(function(data) {
               if(data == "kosong"){
                  $('#qtyKeranjang').html(0);
               }else{
                  $('#qtyKeranjang').html(data);
               }
            });
         }
         function beliSekarang(kode_barang){
            location.href="about.php?kode_barang="+kode_barang;
         }
         function keranjang(kode_barang){
            var iduser = '<?= $_SESSION['iduser'] ?>';
            if(iduser != null){
               $.post("cekkeranjang.php", {
                  iduser : iduser, typeKeranjang : "add" , kode_barang : kode_barang, qty : 1
               })
               .done(function(data) {
                  console.log(data);
                  if(data == "success"){
                     Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Barang berhasil ditambahkan ke keranjang',
                        showConfirmButton: false,
                        timer: 1500
                     });
                     countKeranjang();
                  }
               });
            }
         }
         function viewKeranjang(){
            var iduser = '<?= $_SESSION['iduser'] ?>';
            $.post("cekkeranjang.php", {
               iduser : iduser, typeKeranjang : "view"
            })
            .done(function(data) {
               console.log(data);
               if(data == "kosong"){
                  $('#keranjangModalKosong').modal('show');
               }else{
                  $('#keranjangModal').modal('show');
               }
            });
         }
         function ceklogin(){
            $.post("ceklogin.php", {
               username : $('#username').val(), pass : $('#pass').val()
            })
            .done(function(data) {
               console.log(data);
               if(data == "kosong"){
                  //Akun ada tapi data keranjang 0
                  $('#qtyKeranjang').html("0");
                  $('#loginModal').modal('hide');
                  $('#loginText').css('display','none');
               }else if(data == "invalid"){
                  //Akun tidak ada
                  Swal.fire({
                     icon: 'error',
                     title: 'Gagal',
                     text: 'Anda belum memiliki akun',
                     showConfirmButton: false,
                     timer: 2500
                  });
               }else if(data == "isi") {
                  //Akun ada dan data keranjang tidak kosong
                  $('#qtyKeranjang').html(data);
               }
            });
         }
         function beli(){
            var iduser = '<?= $_SESSION['iduser'] ?>';
            Swal.fire({
                  title: 'Perhatian',
                  text: "Anda yakin ingin membeli barang tersebut ? Barang akan dibayar dengan sistem COD",
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Ya, beli !',
                  cancelButtonText : 'Batal'
            }).then((result) => {
                  if (result.isConfirmed) {
                     $.post("cekdatabarang.php", {
                        iduser : iduser , page : "Index"
                     })
                     .done(function(data) {
                        if(data == "sukses"){
                           Swal.fire({
                              icon: 'success',
                              title: 'Berhasil',
                              text: 'Barang berhasil dibeli',
                              showConfirmButton: false,
                              timer: 1500
                           });
                        }
                        countKeranjang();
                        $('#keranjangModal').modal('hide');
                     });
                  }else{
                     Swal.fire({
                        icon: 'error',
                        title: 'Batal',
                        text: 'Barang batal dibeli',
                        showConfirmButton: false,
                        timer: 1500
                     });
                  }
            })
         }
      </script>
   </body>
</html>

