<?php
    $menu_head = "sistem";
    include "Header.php";
    include "asset/vendor/samayo/bulletproof/src/bulletproof.php";

    $hilang = "";
    if($_SESSION['status'] != "Admin"){
      $hilang = "style='display:none;'";
    }
    
    
?>
        <!-- page content -->
<div id="content">
    <div class="panel box-shadow-none content-header">
    </div>
    <div class="form-element">
        <div class="col-md-12 padding-0">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 id="namatoko"></h4>

                    </div>

                    <form class="cmxform" name="frm" id="frm" method="post" action="">
                        <!-- end panel-heading -->
                        <div class="panel-body">
                            <div class="text-center">
                                <div class="img-profile ">
                                      <!-- <img id="img_profile" src="" alt="logo" class="img-rounded" width="200px"
                                    height="200px"> -->
                                </div>
                              
                            </div>

                            <div class="well" style="margin-top:10px;">
                                <div class="form-group">
                                    <label for="imgupload">Upload Icon</label>
                                    <input type="file" id="imgupload" name="imgupload">
                                    <!-- <p class="help-block">Example block-level help text here.</p> -->
                                    <!-- <input type="submit" name="upload" value="upload" /> -->
                                </div>
                                <div class="img-preview">
                                    <!-- <div id="imagePreview" style="background-image: url('asset/img/1.jpg');"> -->
                                    <!-- </div> -->
                                </div>
                                <div class="clearfix"></div>

                            </div>
                        </div>

                        <!-- <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                        <input type="file" name="pictures" accept="image/*"/>
                        <input type="submit" value="upload"/>
                    </form> -->
                        <!-- end panel-body -->
                </div>
                <!-- end panel -->

                <!-- <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Pengaturan Shift</h4>
                    </div>
                    <div class="panel-body">
                    <div class="form-group form-animate-text" <?php echo $hilang;?>>
                                    <input type="text" class="form-text" id="txtshift1" name="txtshift1">
                                    <span class="bar"></span>
                                    <label>Shift 1</label>
                                </div>

                                <div class="form-group form-animate-text" <?php echo $hilang;?>>
                                    <input type="text" class="form-text" id="txtshift2" name="txtshift2">
                                    <span class="bar"></span>
                                    <label>Shift 2</label>
                                </div>

                                <div class="form-group form-animate-text" <?php echo $hilang;?>>
                                    <input type="text" class="form-text" id="txtshift3" name="txtshift3">
                                    <span class="bar"></span>
                                    <label>Shift 3</label>
                                </div>

                                <div class="form-group form-animate-text" <?php echo $hilang;?>>
                                    <input type="text" class="form-text" id="txtlembur" name="txtlembur">
                                    <span class="bar"></span>
                                    <label>Lembur</label>
                                </div>
                    </div>
                </div> -->


            </div>
            <!-- end col-5 -->

            <div class="col-md-8">
                <div class="col-md-12 panel panel-default">
                    <div class="col-md-12 panel-heading">
                        <h4>Konfigurasi</h4>
                    </div>
                    <div class="col-md-12 panel-body">
                        <div class="col-md-12">
                            
                                <input type="hidden" name="txtid" id="txtid" />
                                <div class="form-group form-animate-text">
                                    <input type="text" class="form-text" id="txtnama" name="txtnama" required>
                                    <span class="bar"></span>
                                    <label>Nama</label>
                                </div>

                                <div class="form-group form-animate-text">
                                    <textarea class="form-text" id="txtalamat" name="txtalamat" rows="3"></textarea>
                                    <span class="bar"></span>
                                    <label>Alamat</label>
                                </div>

                                <!-- <div class="form-group form-animate-text">
                                    <input type="text" class="form-text" id="txtinstagram" name="txtinstagram">
                                    <span class="bar"></span>
                                    <label>Instagram</label>
                                </div>

                                <div class="form-group form-animate-text">
                                    <input type="text" class="form-text" id="txtpassword" name="txtpassword">
                                    <span class="bar"></span>
                                    <label>Password Wifi</label>
                                </div> -->

                                <div class="form-group form-animate-text">
                                    <input type="text" class="form-text" id="txttelp" name="txttelp">
                                    <span class="bar"></span>
                                    <label>Tel No.</label>
                                </div>

                                <!-- <div class="form-group form-animate-text" <?php echo $hilang;?>>
                                    <input type="text" class="form-text" id="txticon" name="txticon">
                                    <span class="bar"></span>
                                    <label>Icon</label>
                                </div> -->


                                <div class="form-group form-animate-text" hidden <?php echo $hilang;?>>
                                    <input type="text" class="form-text" id="txtidtoko" name="txtidtoko">
                                    <span class="bar"></span>
                                    <label>ID Toko</label>
                                </div>

                                <!-- <div class="form-group form-animate-text" <?php echo $hilang;?>>
                                    <input type="text" class="form-text" id="txtprinter" name="txtprinter">
                                    <span class="bar"></span>
                                    <label>Printer</label>
                                </div> -->

                                <!-- <div class="form-group form-animate-text" <?php echo $hilang;?>>
                                    <input type="text" class="form-text" id="txtppn" name="txtppn">
                                    <span class="bar"></span>
                                    <label>Pajak Pertambahan Nilai (PPN %)</label>
                                </div>

                                <div class="form-group form-animate-text" <?php echo $hilang;?>>
                                    <input type="text" class="form-text" id="txtmeja" name="txtmeja">
                                    <span class="bar"></span>
                                    <label>Jumlah Meja</label>
                                </div> -->

                                <div class="form-group form-element" hidden>
                                    <label style="top:-10px;">Stok Bahan Minus</label>
                                    <div class="row">
                                        <label class="col-md-1">
                                            <input id="Y" type="radio" name="minus" onclick="rad('Y')" value="Y" checked/> Ya
                                        </label>
                                        <label class="col-md-1">
                                            <input id="N" type="radio" name="minus" onclick="rad('N')" value="N"/> Tidak
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group form-element" style="margin-bottom: 10px;">
                                    <button type="submit" class="submit btn btn-success" name="simpan" id="simpan" value="simpan"> Save </button>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-7 -->
            </form>
           
        </div>
    </div>
</div>
        <!-- /page content -->
<?php include "Footer.php";?>

<script>


    document.getElementById("imgupload").onchange = function(e) {
        loadImage(
            e.target.files[0],
            function(img) {
                $('#img_profile').remove();
                $(".img-profile").append(img);
            },{maxWidth: 200}
        );
    };

    $("#frm").on('submit', (function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Apakah anda ingin menyimpan konfigurasi ini?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Update'
        }).then((result) => {
            if (result.value) {


                var tombol = $("#simpan").val();
                var nama = $("#txtnama").val();
                var alamat = $("#txtalamat").val();
                var instagram = $("#txtinstagram").val();
                var password = $("#txtpassword").val();
                var telp = $("#txttelp").val();
                var icon = $("#txticon").val();
                var shift1 = $("#txtshift1").val();
                var shift2 = $("#txtshift2").val();
                var shift3 = $("#txtshift3").val();
                var lembur = $("#txtlembur").val();
                var idtoko = $("#txtidtoko").val();
                var printer = $("#txtprinter").val();
                var ppn = $("#txtppn").val();
                var meja = $("#txtmeja").val();
                var minus = "";
                if (document.getElementById("Y").checked) {
                    minus = "Y";

                } else {
                    minus = "N";
                }

                var formData = new FormData();
                formData.append('tombol', 'edit');
                formData.append('nama', nama);
                formData.append('alamat', alamat);
                formData.append('instagram', instagram);
                formData.append('password', password);
                formData.append('telp', telp);
                formData.append('minus', minus);
                formData.append('shift1', shift1);
                formData.append('shift2', shift2);
                formData.append('shift3', shift3);
                formData.append('lembur', lembur);
                formData.append('printer', printer);
                formData.append('idtoko', idtoko);
                formData.append('ppn', ppn);
                formData.append('meja', meja);
                formData.append('icon', $('input[type=file]')[0].files[0]);

                $.ajax({
                    url: "savelicense.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                    },
                    error: function () {}
                });

                Swal.fire(
                    'Sukses!',
                    'Konfigurasi Telah Diupdate.',
                    'success'
                )
            }
        })


    }));


    function rad(value) {
        minus = value;
    }

  function loaddata(){
      $.post("savelicense.php",{tombol:"tampil"})
          .done(function(data){
            // echo "|"1.$nama."|"2.$alamat."|"3.$telp."|"4.$icon."|"5.$minus."|"6.$shift1."|"7.$shift2."|"8.$shift3."|"9.$idtoko."|"10.$printer."|"11.$ppn."|"12.$instagram."|"13.$lembur."|"14.$password."|"15.$meja."|";
              var pecah = data.split("|");
              $("#txtnama").val(pecah[1]);
              $("#txtalamat").val(pecah[2]);
              $("#txttelp").val(pecah[3]);
            //   $("#txticon").val(pecah[4]);
              $("#txtshift1").val(pecah[6]);
              $("#txtshift2").val(pecah[7]);
              $("#txtshift3").val(pecah[8]);
              $("#txtidtoko").val(pecah[9]);
              $("#txtprinter").val(pecah[10]);
              $("#txtppn").val(pecah[11]);
              $("#txtinstagram").val(pecah[12]);
              $("#txtlembur").val(pecah[13]);
              $("#txtpassword").val(pecah[14]);
              $("#txtmeja").val(pecah[15]);
              $("#namatoko").text(pecah[1]);
            //   $('#img_profile').attr('src', "asset/img/"+pecah[4]);
              $('.img-profile').prepend('<img id="img_profile" height="200px" src="asset/img/'+pecah[4]+'" />')
              if(pecah[5] == "Y"){
                  document.getElementById("Y").checked = true;
              }else if(pecah[5] == "N"){
                  document.getElementById("N").checked = true;
              }
          });
  }

  $(document).ready(function(){
      loaddata();
  });
</script>
