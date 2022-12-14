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
                            <h4>Laporan Bahan</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />

                                    <div class="form-group form-element">
                                        <label style="top:-10px;">Bahan</label>
                                        <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbbahan" id="cmbbahan">
                                            <option value="ALL" selected> Semua Bahan </option>
                                            <?php
                                                
                                                $sqlbahan = "select * from tbbahan order by nama asc";
                                                $querybahan = mysqli_query($con,$sqlbahan);
                                                while($res = mysqli_fetch_array($querybahan)){
                                                    $id = $res['id'];
                                                    $nama = $res['nama'];
                                                    $satuan = $res['satuan'];
                                                    ?>
                                                        <option value="<?php echo $id;?>" data-subtext="<?php echo $satuan;?>"> <?php echo $nama;?> </option>
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
  function f_search() {
      var idbahan = $("#cmbbahan").val();
//      alert(idbahan);
      $.post("tampilstokbahan.php", {tombol: "tampil",bahan:idbahan})
          .done(function (data) {
              $("#table").html(data);
          });
  }

  function f_bersih() {
      $("#cmbbahan").val("ALL");
      $('.selectpicker').selectpicker('refresh');
  }

  $(document).ready(function(){
      f_bersih();
  });
</script>
