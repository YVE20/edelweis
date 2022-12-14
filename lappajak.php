<?php
    $menu_head = "laporan";
    include "Header.php";
    // include ("asset/function/function.php");
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
                            <h4>Laporan Penjualan</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />

                                    <div class="form-group form-element">
                                        <label style="top:-10px;">Pilih Bulan</label>
                                        <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbbulan" id="cmbbulan">
                                            <option value="ALL" selected> Semua Bulan </option>
                                            <?php
                                            $sqluser = "select MONTH(tanggal) as Bulan from tbjual GROUP BY MONTH(tanggal)";
                                            $queryuser = mysqli_query($con,$sqluser);
                                            while($res = mysqli_fetch_array($queryuser)){
                                                $bulan = bulan($res['Bulan']);
                                                // $nama = $res['nama'];
                                                ?>
                                                <option value="<?php echo $bulan;?>"> <?php echo $bulan;?> </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
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
      $("#cmbbulan").val("ALL");
      
      $('.selectpicker').selectpicker('refresh');
  }

  function f_search(){
      var bulan = $("#cmbbulan").val();


      $.post("tampilpajak.php",{tombol:"tampilcari",bulan:bulan})
          .done(function(data){
              $("#table").html(data);
          });
  }

  $(document).ready(function(){
      f_bersih();
  });
</script>
