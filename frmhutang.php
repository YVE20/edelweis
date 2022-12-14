<?php
    $menu_head = "keuangan";
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
                            <h4>Pembayaran Hutang</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;padding-top:30px;">
                            <div class="col-md-12" id="table" name="table">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- modal bayar -->
    <div class="modal fade=" id="modalBayar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Pembayaran Hutang</h4>
                </div>
                <div class="modal-body">
    
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="hidden" name="txtid" id="txtid" />
                            <div class="form-group form-animate-text">
                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Sisa Hutang</label>
                                <input type="text" class="form-text" id="txtsisa" name="txtsisa" value="0" onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id)" readonly>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group form-animate-text">
                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Nominal Pelunasan</label>
                                <input type="text" class="form-text" id="txtjumlah" name="txtjumlah" value="0" onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id)">
                                <span class="bar"></span>
                            </div>
                            <div class="form-group form-animate-text">
                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Tanggal Pelunasan</label>
                                <input type="date" class="form-text" id="txttanggal" name="txttanggal">
                                <span class="bar"></span>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
    
                </div>
                <!-- end modal body -->
                <div class="modal-footer">
                    <button type="button" id="proses_finale" onclick="f_prosesbayar()" style="margin:auto;" class="btn btn-primary">Proses</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal bayar -->

    <!-- modal history bayar -->
    <div class="modal fade=" id="modalHistory" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Pembayaran Hutang</h4>
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

    <!-- page content -->
<?php include "Footer.php";?>

<script>

    function f_load(){
        $.post("savehutang.php",{tombol:"tampillist"})
            .done(function(data){
                $("#table").html(data);
        });
    }
    
    function f_clear(){
        $("#txtid").val('');
        $("#txtsisa").val('0');
        $("#txtjumlah").val('0');
        $("#txttanggal").val('');
    }
    
    function f_bayar(id,sisa){
        f_clear();
        $("#modalBayar").modal();
        $("#txtid").val(id);
        $("#txtsisa").val(accounting.formatNumber(sisa, 0, ".", ","));
        $("#txtjumlah").val(accounting.formatNumber(sisa, 0, ".", ","));
    }
    
    function f_prosesbayar(){
        var id = $("#txtid").val();
        var sisa = accounting.unformat($("#txtsisa").val(),',');
        var jumlah = accounting.unformat($("#txtjumlah").val(),',');
        var tanggal = $("#txttanggal").val();
        
        if(jumlah == 0){
            Swal.fire('Peringatan!', 'Masukkan jumlah Hutang yang akan dibayar!', 'error');
        }else{
            if(tanggal != ""){
                if(jumlah > sisa){
                    Swal.fire('Peringatan!', 'Jumlah yang diinput melebihi sisa Hutang!', 'error');
                }else{
                    $.post("savehutang.php",{tombol:"bayar",id:id,sisa:sisa,jumlah:jumlah,tanggal:tanggal})
                      .done(function(data){
                          if(data == "sukses"){
                              Swal.fire({
                                  title: 'Informasi',
                                  text: "Pelunasan Hutang berhasil tersimpan",
                                  type: 'info',
                                  confirmButtonText: 'Ya',
                                  confirmButtonClass: 'btn btn-primary',
                                  buttonsStyling: false,
                              }).then(function (result) {
                                  $('#modalBayar').modal('toggle');
                                  f_load();
                              })
                          }else{
                              Swal.fire('Peringatan!', 'Data gagal tersimpan!', 'error');
                          }
                      });
                }
            }else{
                Swal.fire('Peringatan!', 'Pilih tanggal terlebih dulu!', 'error');
            }
        }
        
    }
    
    function f_history(id){
        $("#modalHistory").modal();
        $.post("savehutang.php",{tombol:"historybayar",id:id})
          .done(function(data){
              $("#tablehistory").html(data);
          });
    }

    $(document).ready(function(){
        f_load();
    });
</script>
