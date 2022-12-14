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
                            <h4>Laporan Piutang</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;font-size:14px;">Tanggal Jatuh Tempo Mulai</label>
                                                <input type="date" class="form-text" id="txttanggalmulai" name="txttanggalmulai">
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;font-size:14px;">Tanggal Jatuh Tempo Selesai</label>
                                                <input type="date" class="form-text" id="txttanggalselesai" name="txttanggalselesai">
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-element">
                                                <label style="top:-10px;">Customer</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbkustomer" id="cmbkustomer">
                                                    <option value="ALL" selected> Semua Customer </option>
                                                    <?php
                                                    $sqlkustomer = "select * from tbkustomer order by nama asc";
                                                    $querykustomer = mysqli_query($con,$sqlkustomer);
                                                    while($res = mysqli_fetch_array($querykustomer)){
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
                                                <label style="top:-10px;">Status Piutang</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox" name="cmbstatus" id="cmbstatus">
                                                    <option value="ALL" selected> Semua Piutang </option>
                                                    <option value="Lunas"> Lunas </option>
                                                    <option value="Belum Lunas"> Belum Lunas </option>
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

    <!-- modal history bayar -->
    <div class="modal fade=" id="modalHistory" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Pembayaran Piutang</h4>
                </div>
                <div class="modal-body">
    
                    <div class="row clearfix">
                        <div class="col-md-12" id="tablehistory" name="tablehistory">
                        </div>
                    </div>
                    <!-- end row -->
    
                </div>
            </div>
        </div>
    </div>
    <!-- end modal history bayar -->


<?php include "Footer.php";?>

<script>

  function f_bersih(){
      $("#btnsearch").val("search");
      $("#cmbstatus").val("ALL");
      $("#cmbkustomer").val("ALL");
      document.getElementById('txttanggalmulai').valueAsDate = new Date();
      document.getElementById('txttanggalselesai').valueAsDate = new Date();
      $('.selectpicker').selectpicker('refresh');
  }

  function f_search(){
      var status = $("#cmbstatus").val();
      var kustomer = $("#cmbkustomer").val();
      var tanggalmulai = $("#txttanggalmulai").val();
      var tanggalselesai = $("#txttanggalselesai").val();

      if(tanggalmulai == ""){
          tanggalmulai = tanggalselesai;
      }
      if(tanggalselesai == ""){
          tanggalselesai = tanggalmulai;
      }

      $.post("tampilpiutang.php",{tombol:"tampilcari",status:status,kustomer:kustomer,tanggalmulai:tanggalmulai,tanggalselesai:tanggalselesai})
          .done(function(data){
              $("#table").html(data);
          });
  }

  function f_history(id){
      $("#modalHistory").modal();
      $.post("savepiutang.php",{tombol:"historybayar",id:id})
        .done(function(data){
            $("#tablehistory").html(data);
        });
  }

  $(document).ready(function(){
      f_bersih();
  });
</script>
