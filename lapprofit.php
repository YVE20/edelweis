<?php
    $menu_head = "laporan";
    include "Header.php";
?>
        <!-- page content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
        </div>
        <div class="form-element">
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="col-md-12 panel">
                        <div class="col-md-12 panel-heading">
                            <h4>Laporan Profit Penjualan</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;font-size:14px;">Tanggal Mulai</label>
                                                <input type="date" class="form-text" id="txttanggalmulai" name="txttanggalmulai">
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;font-size:14px;">Tanggal Selesai</label>
                                                <input type="date" class="form-text" id="txttanggalselesai" name="txttanggalselesai">
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-element" style="margin-top:10px">
                                                <label style="top:-10px;">Produk</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbmenu" id="cmbmenu">
                                                    <option value="ALL" selected> Semua Produk </option>
                                                    <?php
                                                    $sqlmenu = "select * from tbmenu order by nama asc";
                                                    $querymenu = mysqli_query($con,$sqlmenu);
                                                    while($res = mysqli_fetch_array($querymenu)){
                                                        $id = $res['id'];
                                                        $nama = $res['nama'];
                                                        $kode = $res['kode_barang'];
                                                        ?>
                                                        <option value="<?php echo $id;?>"> <?php echo $kode." - ".$nama;?> </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group form-element">
                                        <button type="button" class="submit btn btn-info" name="btnsearch" id="btnsearch" value="search" onclick="f_search();"> Search </button>
                                        <button type="button" class="submit btn btn-primary" name="reset" id="reset" value="simpan" onclick="f_bersih();"> Reset </button>
                                    </div>
                                </form>

                            </div>
                            <div class="col-md-12" id="table" name="table">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- page content -->
<?php include "Footer.php";?>

<script>

  function f_bersih(){
      $("#btnsearch").val("search");
      $("#cmbmenu").val("ALL");
      document.getElementById('txttanggalmulai').valueAsDate = new Date();
      document.getElementById('txttanggalselesai').valueAsDate = new Date();
      $('.selectpicker').selectpicker('refresh');
  }

  function f_search(){
      var menu = $("#cmbmenu").val();
      var tanggalmulai = $("#txttanggalmulai").val();
      var tanggalselesai = $("#txttanggalselesai").val();

      if(tanggalmulai == ""){
          tanggalmulai = tanggalselesai;
      }
      if(tanggalselesai == ""){
          tanggalselesai = tanggalmulai;
      }

      $.post("tampilprofit.php",{tombol:"tampilcari",menu:menu,tanggalmulai:tanggalmulai,tanggalselesai:tanggalselesai})
          .done(function(data){
              $("#table").html(data);
          });
  }

  $(document).ready(function(){
      f_bersih();
  });
</script>
