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
                            <h4>Pembayaran Piutang</h4>
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
                    <h4 class="modal-title" id="myModalLabel">Pembayaran Piutang</h4>
                </div>
                <div class="modal-body">
    
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="hidden" name="txtid" id="txtid" />
                            <div class="form-group form-animate-text">
                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Sisa Piutang</label>
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
                            <div class="form-group form-animate-text">
                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Penagih</label>
                                <input type="text" class="form-text" id="txtpenagih" name="txtpenagih">
                                <span class="bar"></span>
                            </div>
                            <div class="form-group form-animate-text">
                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Note (Metode Pembayaran) </label>
                                <input type="text" class="form-text" id="txtnote" name="txtnote">
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

    <!-- page content -->
<?php include "Footer.php";?>

<script>

    function f_load(){
        $.post("savepiutang.php",{tombol:"tampillist"})
            .done(function(data){
                $("#table").html(data);
        });
    }
    
    function f_clear(){
        $("#txtid").val('');
        $("#txtsisa").val('0');
        $("#txtjumlah").val('0');
        $("#txttanggal").val('');
        $("#txtpenagih").val('');
        $("#txtnote").val('');
    }
    
    function f_bayar(id,sisa){
        f_clear();
        $("#modalBayar").modal();
        $("#txtid").val(id);
        $("#txtsisa").val(accounting.formatNumber(sisa, 0, ".", ","));
        $("#txtjumlah").val(accounting.formatNumber(sisa, 0, ".", ","));
    }
    
    function f_printpenagihan(id){
        $.post('savepiutang.php',{tombol: "data_print",id: id,})
          .done(function(data){

              let pecah = data.split("|");
              let idpenjualan = pecah[0];
              let jumlah = pecah[1];
              let sisa = pecah[2];
              let jatuhtempo = pecah[3];
              let namacustomer = pecah[4];
              let penagih = pecah[5];
              let jumlahterbayar = jumlah - sisa;
              let namauser = "<?php echo $_SESSION['nama']; ?>";


              $('<iframe>', {
                  name: 'faktur',
                  class: 'cetakfaktur',
                  style: 'display:none;max-width:700px !important;width:700px !important;max-height:1272px;'
                  // style: 'display:none;max-width:300px !important;width:300px !important;'
              })
                .appendTo('body')
                .contents().find('body')
                .append(`
      <style>
        .table-detail,.table-detail th,.table-detail td {
          border: 1px solid black;
          border-collapse: collapse;
        }
      </style>

      <table style="width:700px !important;font-size:10pt;font-family: Sans-Serif !important;border-bottom: black 3px solid">
          <tr>
              <th style="width:175px !important;"></th>
              <th style="width:175px !important;"></th>
              <th style="width:175px !important;"></th>
              <th style="width:175px !important;"></th>
          </tr>
          <tr>
              <td colspan=4 style="text-align:center;width:700px !important;font-family: Sans-Serif !important;padding-bottom:3px;"> <h1 style="margin-bottom:0px;margin-top:0px;"> CV Bulan Bintang </h1> </td>
          </tr>
          <tr>
              <td colspan=4 style="text-align:center;width:700px !important;font-family: Sans-Serif !important;font-size:14px;padding-bottom:3px;"> Jl. A. Yani 2 Komp, Pergudangan No A1-A2 </td>
          </tr>
          <tr>
              <td colspan=4 style="text-align:center;width:700px !important;font-family: Sans-Serif !important;font-size:14px;padding-bottom:3px;"> Kec. Sungai Raya, Kabupaten Kubu Raya, Kalimantan Barat </td>
          </tr>
          <tr>
              <td colspan=4 style="text-align:center;width:700px !important;font-family: Sans-Serif !important;font-size:14px;padding-bottom:3px;"> No. Telp. 0822-5115-2100 </td>
          </tr>
      </table>
      <table style="width:700px !important;font-family: Sans-Serif !important;margin-top:15px;">
          <tr>
              <th style="width:100px !important;"></th>
              <th style="width:100px !important;"></th>
              <th style="width:100px !important;"></th>
              <th style="width:100px !important;"></th>
              <th style="width:100px !important;"></th>
              <th style="width:100px !important;"></th>
              <th style="width:100px !important;"></th>
          </tr>
          <tr>
              <td style="font-family: Sans-Serif !important;font-size:11pt;padding-bottom:3px;"> Kepada Yth </td>
              <td colspan=6 style="font-family: Sans-Serif !important;font-size:11pt;padding-bottom:3px;"> : `+namacustomer+` </td>
          </tr>
          <tr>
              <td style="font-family: Sans-Serif !important;font-size:11pt;padding-bottom:3px;"> Perihal </td>
              <td colspan=6 style="font-family: Sans-Serif !important;font-size:11pt;padding-bottom:3px;"> : Penagihan Pembayaran Invoice </td>
          </tr>
          </tr>
      </table>
      <table class="table-detail" style="width:700px !important;font-size:9pt;font-family: Sans-Serif !important;margin-top:15px;">
          <tr>
              <th style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="30px"> No </th>
              <th style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="170px"> Nomor Invoice </th>
              <th style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="110px"> Tanggal Jatuh Tempo </th>
              <th style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="130px">  Nilai Invoice </th>
              <th style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="130px"> Jumlah Yang <br /> Sudah Dibayar </th>
              <th style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="130px"> Nilai Akhir <br /> Tertagih </th>
          </tr>
          <tr>
              <td style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="30px"> 1. </td>
              <td style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="170px"> `+idpenjualan+` </td>
              <td style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="110px"> `+jatuhtempo+` </td>
              <td style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="130px"> Rp. `+accounting.formatNumber(jumlah,0,'.',',')+` </td>
              <td style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="130px"> Rp. `+accounting.formatNumber(jumlahterbayar,0,'.',',')+` </td>
              <td style="text-align:center;font-size:10pt;padding-bottom:3px;padding-top:3px;" width="130px"> <b> Rp. `+accounting.formatNumber(sisa,0,'.',',')+` </b> </td>
          </tr>
      </table>
      <table style="width:700px !important;font-family: Sans-Serif !important;margin-top:40px;">
          <tr>
              <th style="width:175px !important;"></th>
              <th style="width:175px !important;"></th>
              <th style="width:175px !important;"></th>
              <th style="width:175px !important;"></th>
          </tr>
          <tr>
              <td colspan=2 style="font-family: Sans-Serif !important;text-align:left;vertical-align:top;font-size:11pt;padding-bottom:3px;text-transform: capitalize;"> </td>
              <td colspan=2 style="font-family: Sans-Serif !important;text-align:center;font-size:11pt;padding-bottom:3px;"> Hormat Kami <br /><br /><br /><br /><br /><br /> <b> `+namauser+` </b></td>
          </tr>
      </table>
      <table style="width:700px !important;font-family: Sans-Serif !important;margin-top:-130px;">
          <tr>
              <th style="width:130px !important;"></th>
              <th style="width:130px !important;"></th>
              <th style="width:100px !important;"></th>
              <th style="width:290px !important;"></th>
          </tr>
          <tr>
              <td colspan=3 style="font-family: Sans-Serif !important;text-align:left;vertical-align:top;font-size:11pt;border: 1px solid black;border-collapse: collapse;padding:7px;text-transform: capitalize;"> Terbilang : <b> `+angkaTerbilang(sisa)+` Rupiah </b> </td>
              <td style="font-family: Sans-Serif !important;text-align:center;font-size:11pt;padding-bottom:3px;"></td>
          </tr>
      </table>
    `);


              setTimeout(() => {
                  window.frames['faktur'].focus();
                  window.frames['faktur'].print();
              }, 500);

              setTimeout(() => { $(".cetakfaktur").remove(); }, 1000);

          });
    }
    
    function f_prosesbayar(){
        var id = $("#txtid").val();
        var sisa = accounting.unformat($("#txtsisa").val(),',');
        var jumlah = accounting.unformat($("#txtjumlah").val(),',');
        var tanggal = $("#txttanggal").val();
        var penagih = $("#txtpenagih").val();
        var note = $("#txtnote").val();

        if(jumlah == 0){
            Swal.fire('Peringatan!', 'Masukkan jumlah Piutang yang akan dibayar!', 'error');
        }else {
            if (tanggal != "") {
                if (jumlah > sisa) {
                    Swal.fire('Peringatan!', 'Jumlah yang diinput melebihi sisa Hutang!', 'error');
                } else {
                    $.post("savepiutang.php", {tombol: "bayar", id: id, sisa: sisa, jumlah: jumlah, tanggal: tanggal, penagih: penagih, note: note})
                      .done(function (data) {
                          if (data == "sukses") {
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
                          } else {
                              Swal.fire('Peringatan!', 'Data gagal tersimpan!', 'error');
                          }
                      });
                }
            } else {
                Swal.fire('Peringatan!', 'Pilih tanggal terlebih dulu!', 'error');
            }
        }
        
    }
    
    function f_history(id){
        $("#modalHistory").modal();
        $.post("savepiutang.php",{tombol:"historybayar",id:id})
          .done(function(data){
              $("#tablehistory").html(data);
          });
    }

    $(document).ready(function(){
        f_load();
    });
</script>
