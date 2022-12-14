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
                            <h4>Laporan Pembelian</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;font-size:14px;">Tanggal Mulai</label>
                                                <input type="date" class="form-text" id="txttanggalmulai" name="txttanggalmulai">
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;font-size:14px;">Tanggal Selesai</label>
                                                <input type="date" class="form-text" id="txttanggalselesai" name="txttanggalselesai">
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-element">
                                                <label style="top:-10px;">Supplier</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbsupplier" id="cmbsupplier">
                                                    <option value="ALL" selected> Semua Supplier </option>
                                                    <?php
                                                    $sqlsupplier = "select * from tbsupplier order by nama asc";
                                                    $querysupplier = mysqli_query($con,$sqlsupplier);
                                                    while($res = mysqli_fetch_array($querysupplier)){
                                                        $id = $res['id'];
                                                        $nama = $res['nama'];
                                                        ?>
                                                        <option value="<?php echo $id;?>"> <?php echo $nama;?> </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-element">
                                                <label style="top:-10px;">User</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbuser" id="cmbuser">
                                                    <option value="ALL" selected> Semua User </option>
                                                    <?php
                                                    $sqluser = "select * from tbuser where status!='Admin' order by nama asc";
                                                    $queryuser = mysqli_query($con,$sqluser);
                                                    while($res = mysqli_fetch_array($queryuser)){
                                                        $id = $res['iduser'];
                                                        $nama = $res['nama'];
                                                        ?>
                                                        <option value="<?php echo $id;?>"> <?php echo $nama;?> </option>
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
      $("#cmbsupplier").val("ALL");
      $("#cmbuser").val("ALL");
      document.getElementById('txttanggalmulai').valueAsDate = new Date();
      document.getElementById('txttanggalselesai').valueAsDate = new Date();
      $('.selectpicker').selectpicker('refresh');
  }

  function f_search(){
      var supplier = $("#cmbsupplier").val();
      var user = $("#cmbuser").val();
      var tanggalmulai = $("#txttanggalmulai").val();
      var tanggalselesai = $("#txttanggalselesai").val();

      if(tanggalmulai == ""){
          tanggalmulai = tanggalselesai;
      }
      if(tanggalselesai == ""){
          tanggalselesai = tanggalmulai;
      }

      $.post("tampilpembelian.php",{tombol:"tampilcari",user:user,supplier:supplier,tanggalmulai:tanggalmulai,tanggalselesai:tanggalselesai})
          .done(function(data){
              $("#table").html(data);
          });
  }

  $(document).ready(function(){
      f_bersih();
  });
</script>
