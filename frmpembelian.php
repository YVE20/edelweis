<?php
    $menu_head = "pembelian";
    include "Header.php";

    $act = $_GET['act'];
    $idget = $_GET['id'];
    $today = date("Y-m-d");

    if($act=="po") {
        $ip = get_ip();
        $sqlsum = "select max(SUBSTRING_INDEX(id_pembelian,'-',-1)) from tbpembelian where YEAR(tanggal)=YEAR(CURDATE())";
        $querysum = mysqli_query($con, $sqlsum) or die ($sqlsum);
        $ressum = mysqli_fetch_array($querysum);
        $maxno = $ressum[0] + 1;
        $tanggal = date("Ymd");
        $judul = "PO Pembelian";

        if ($ip == "::1") {
            $ip = "1";
        } else {
            $pecah = explode('.', $ip);
            $ip = $pecah[3];
        }

        $idtransaksi = "B-" . $tanggal . "-" . $ip . "-" . $_SESSION['iduser'] . "-" . pad_left($maxno, 0, 5);
        
    }else if($act=="approve"){
        $sqlsum = "select id_pembelian from tbpembelian where id='$idget'";
        $querysum = mysqli_query($con, $sqlsum) or die ($sqlsum);
        $ressum = mysqli_fetch_array($querysum);
        $idtransaksi = $ressum['id_pembelian'];
    
        $judul = "Approve PO Pembelian";
    }
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
                            <h4>Form <?php echo $judul; ?></h4>
                            <span> ID Transaksi : <?php echo $idtransaksi;?></span>
                            <br />
                            <span> Status : <?php echo $judul; ?></span>
                            <input type="hidden" name="txtidtransaksi" id="txtidtransaksi" value="<?php echo $idtransaksi;?>" />
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="col-md-6" style="padding-right:0px;padding-left:0px;">
                                        <div class="form-group form-element">
                                            <label style="top:-10px;">Nama Supplier</label>
                                            <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbsupplier" id="cmbsupplier">
                                                <?php
                                                $sqlmenu = "select * from tbsupplier order by nama asc";
                                                $querymenu = mysqli_query($con,$sqlmenu);
                                                while($res = mysqli_fetch_array($querymenu)){
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
                                    <div class="col-md-6" style="margin-top:10px;padding-right:0px;">
                                        <div class="form-group form-animate-text">
                                            <input type="date" class="form-text" id="txttanggal" name="txttanggal" value="<?php echo $today; ?>">
                                            <span class="bar"></span>
                                            <label>Tanggal</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-2" style="margin-top:10px;padding-right:0px;padding-left:0px;">
                                    <div class="form-group form-animate-text">
                                        <input type="text" class="form-text" id="txtreferensi" name="txtreferensi">
                                        <span class="bar"></span>
                                        <label>Referensi</label>
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-5">
                                    <div class="col-md-6" style="padding-right:0px;padding-left:0px;">
                                        <div class="form-group form-element">
                                            <label style="top:-10px;">Metode Pembayaran</label>
                                            <select class="form-control col-md-7 col-xs-12 combobox" name="cmbmetodepembayaran" id="cmbmetodepembayaran" onchange="metodebayar(this.value)">
                                                <option value="Cash"> Cash </option>
                                                <option value="Kredit"> Kredit </option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-md-6" style="margin-top:10px;display:none;padding-right:0px;" id="jatuhtempo">
                                        <div class="form-group form-animate-text">
                                            <input type="date" class="form-text" id="txtjatuhtempo" name="txtjatuhtempo">
                                            <span class="bar"></span>
                                            <label>Tanggal Jatuh Tempo</label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            
                            <div class="col-md-12 panel" style="margin-top:50px;">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />

                                    <div class="col-md-3" style="padding-right:0px;">
                                        <div class="form-group" style="margin-top:10px;">
                                            <label style="top:-10px;">Barang</label>
                                            <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbmenu" id="cmbmenu" onchange="loadmenu();">
                                                <option value="" disabled selected> --Pilih Barang-- </option>
                                                <?php
                                                    $sqlmenu = "select * from tbmenu order by nama asc";
                                                    $querymenu = mysqli_query($con,$sqlmenu);
                                                    while($res = mysqli_fetch_array($querymenu)){
                                                        $id = $res['id'];
                                                        $nama = $res['nama'];
                                                        $harga = $res['harga_beli'];
                                                        $kodebarang = $res['kode_barang'];
                                                        ?>
                                                            <option id="<?php echo $id.'|'.$harga;?>" value="<?php echo $id;?>"> <?php echo $kodebarang." - ".$nama;?> </option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-7" style="padding-left:0px;">
                                        <div class="col-md-2" style="padding-right:0px;">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Jumlah</label>
                                                <input type="text" class="form-text" id="txtjumlah" name="txtjumlah" value="0" onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id);hitungharga()">
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="padding-right:0px;">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Harga</label>
                                                <input type="text" class="form-text" id="txtharga" name="txtharga" value="0" onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id);hitungharga()">
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="padding-right:0px;">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Diskon (%)</label>
                                                <input type="text" class="form-text" id="txtdiskon" name="txtdiskon" value="0" onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id);hitungharga()">
                                                <input type="hidden" id="txtjlhdiskon" name="txtjlhdiskon" value="0" />
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-2" style="padding-right:0px;">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Pajak (%)</label>
                                                <input type="text" class="form-text" id="txtpajak" name="txtpajak" value="0" onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id);hitungharga()">
                                                <input type="hidden" id="txtjlhpajak" name="txtjlhpajak" value="0" />
                                                <span class="bar"></span>
                                            </div>
                                        </div> -->
                                        <div class="col-md-3" style="padding-right:0px;">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Subtotal</label>
                                                <input type="text" class="form-text" id="txttotal" name="txttotal" value="0" readonly>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2" style="padding-left:0px;padding-right:0px;margin-top:25px;">
                                        <div class="form-group">
                                            <button type="button" class="submit btn btn-info" name="simpan" id="simpan" value="simpan" onclick="f_simpan(); return false;"> Save </button>
                                            <button type="button" class="submit btn btn-warning" name="reset" id="reset" value="simpan" onclick="f_bersih();"> Reset </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="col-md-12" id="table" name="table">
                                </div>
                            </div>
                            <div class="col-md-4 col-md-offset-8">
                                <div class="row">
                                    <div class="col-md-3" style="padding-top:10px;padding-left:10px;">
                                        <label style="color:#918C8C;font-weight:bold;font-size:17px;">Subtotal</label>
                                    </div>
                                    <div class="col-md-9 form-group form-animate-text" style="margin-top:0px !important;margin-bottom:0px !important;">
                                        <input type="text" class="form-text" id="txtsubtotal" name="txtsubtotal" value="0" readonly>
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="padding-top:10px;padding-left:10px;">
                                        <label style="color:#918C8C;font-weight:bold;font-size:17px;">Diskon</label>
                                    </div>
                                    <div class="col-md-9 form-group form-animate-text" style="margin-top:0px !important;margin-bottom:0px !important;">
                                        <input type="text" class="form-text" id="txttotaldiskon" name="txttotaldiskon" readonly value="0" onblur="hitungtotal()">
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-3" style="padding-top:10px;padding-left:10px;">
                                        <label style="color:#918C8C;font-weight:bold;font-size:17px;">Pajak</label>
                                    </div>
                                    <div class="col-md-9 form-group form-animate-text" style="margin-top:0px !important;margin-bottom:0px !important;">
                                        <input type="text" class="form-text" id="txttotalpajak" name="txttotalpajak" readonly value="0" onblur="hitungtotal()">
                                        <span class="bar"></span>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-md-3" style="padding-top:10px;padding-left:10px;">
                                        <label style="color:#918C8C;font-weight:bold;font-size:17px;">Grandtotal</label>
                                    </div>
                                    <div class="col-md-9 form-group form-animate-text" style="margin-top:0px !important;margin-bottom:0px !important;">
                                        <input type="text" class="form-text" id="txtgrandtotal" name="txtgrandtotal" value="0" readonly>
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:20px;margin-left:90px;">
                                    <button type="button" class="submit btn btn-primary" name="proses" id="proses" value="simpan" onclick="f_proses();"> Proses </button>
                                </div>
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

    var act = "<?php echo $act;?>";
    var idget = "<?php echo $idget;?>";

    alertify.minimalDialog || alertify.dialog('minimalDialog',function(){
        return {
            main:function(content){
                this.setHeader('Please Wait');
                this.setContent('<h4 style="margin-top:20px;">Transaksi sedang diproses</h4>');
            }
        }
    });

    function metodebayar(param){
        if(param == "Cash"){
            $("#jatuhtempo").css('display','none');
        }else{
            $("#jatuhtempo").css('display','block');
        }
    }

  function f_simpan(){
      var tombol = $("#simpan").val();
      var id = $("#txtid").val();
      var menu = $("#cmbmenu").val();
      var jumlah = accounting.unformat($("#txtjumlah").val(),',');
      var harga = accounting.unformat($("#txtharga").val(),',');
      var total = accounting.unformat($("#txttotal").val(),',');
      var idpembelian = $("#txtidtransaksi").val();
      var diskon = accounting.unformat($("#txtdiskon").val(),',');
      var jlhdiskon = $("#txtjlhdiskon").val();
      var pajak = accounting.unformat($("#txtpajak").val(),',');
      var jlhpajak = $("#txtjlhpajak").val();

      
      
      if( menu != "" && menu != null && menu != "null"){
          $.post("savepembelian.php",{tombol:tombol,idpembelian:idpembelian,id:id,menu:menu,jumlah:jumlah,harga:harga,total:total,diskon:diskon,jlhdiskon:jlhdiskon,pajak:pajak,jlhpajak:jlhpajak})
              .done(function(data){
                  if(data == "sukses"){
                      loaddata();
                      $("#reset").click();
                  }
              });
      }else{
          alertify.alert("Peringatan","Pilih Barang Terlebih Dahulu!");
      }
  }

  function f_proses(){
      var idpembelian = $("#txtidtransaksi").val();
      var idsupplier = $("#cmbsupplier").val();
      var tanggal = $("#txttanggal").val();
      var referensi = $("#txtreferensi").val();
      var metodepembayaran = $("#cmbmetodepembayaran").val();
      var jatuhtempo = $("#txtjatuhtempo").val();
      var subtotal = accounting.unformat($("#txtsubtotal").val(),',');
      var diskon = accounting.unformat($("#txttotaldiskon").val(),',');
      var pajak = accounting.unformat($("#txttotalpajak").val(),',');
      var grandtotal = accounting.unformat($("#txtgrandtotal").val(),',');
      
      if(metodepembayaran == "Kredit" && jatuhtempo == "") {
          alertify.alert("Peringatan","Pilih Tanggal Jatuh Tempo!");
      }else{
          alertify.minimalDialog('');
          $.post("savepembelian.php", {
              tombol: "proses",
              act: act,
              idpembelian: idpembelian,
              idsupplier: idsupplier,
              tanggal: tanggal,
              referensi: referensi,
              metodepembayaran: metodepembayaran,
              jatuhtempo: jatuhtempo,
              subtotalakhir: subtotal,
              diskonakhir: diskon,
              pajakakhir: pajak,
              grandtotalakhir: grandtotal,
          })
            .done(function (data) {
                alertify.minimalDialog().destroy();
                if(data == "kosong"){
                    alertify.alert("Peringatan","Tambahkan menu terlebih dahulu");
                }else {
                    Swal.fire({
                        title: 'Informasi',
                        text: "Data berhasil tersimpan",
                        type: 'info',
                        confirmButtonText: 'Ya',
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                    }).then(function (result) {
                        if(act == "approve"){
                            location.href = "frmlistpembelian.php";
                        }else{
                            location.reload();
                        }
                    })
                }
            });
      }
  }

  function f_bersih(){
      $("#simpan").val("simpan");
      $("#cmbmenu").val("");
      $("#cmbmenu").prop("disabled",false);
      $("#txtjumlah").val("0");
      $("#txtharga").val("0");
      $("#txttotal").val("0");
      $("#txtdiskon").val("0");
      $("#txtjlhdiskon").val("0");
      $("#txtpajak").val("0");
      $("#txtjlhpajak").val("0");
      $('.selectpicker').selectpicker('refresh');
  }

  function loaddata(){
      var idpembelian = $("#txtidtransaksi").val();
      $.post("savepembelian.php",{tombol:"tampil",idpembelian:idpembelian})
          .done(function(data){
              $("#table").html(data);
              hitungtotal();
          });
  }

  function f_edit(id){
      $("#reset").click();
      $.post("savepembelian.php",{tombol:"tampiledit",id:id})
          .done(function(data){
              var pecah = data.split("|");
              $("#txtid").val(pecah[1]);
              $("#cmbmenu").val(pecah[2]);
              $("#txtjumlah").val(accounting.formatNumber(pecah[3],0,'.',','));
              $("#txtharga").val(accounting.formatNumber(pecah[4],0,'.',','));
              $("#txttotal").val(accounting.formatNumber(pecah[5],0,'.',','));
              $("#txtdiskon").val(accounting.formatNumber(pecah[6],0,'.',','));
              $("#txtjlhdiskon").val(pecah[7]);
              $("#txtpajak").val(accounting.formatNumber(pecah[8],0,'.',','));
              $("#txtjlhpajak").val(pecah[9]);
              $('.selectpicker').selectpicker('refresh');
              $("#cmbmenu").prop("disabled",true);
              $("#simpan").val("edit");
          });
  }

  function loadmenu(){
      var menu = $("#cmbmenu").find('option:selected').attr('id');
      var pecah = menu.split("|");
      $("#txtjumlah").val("1");
      $("#txtharga").val(accounting.formatNumber(pecah[1],0,'.',','));
      $("#txttotal").val(accounting.formatNumber(pecah[1],0,'.',','));
  }

  function hitungharga(){
      var jumlah = accounting.unformat($("#txtjumlah").val(),',');
      var total = accounting.unformat($("#txttotal").val(),',');
      var harga = accounting.unformat($("#txtharga").val(),',');
      var pajak = accounting.unformat($("#txtpajak").val(),',');
      var diskon = accounting.unformat($("#txtdiskon").val(),',');
      var jlhpajak = 0;
      var jlhdiskon = 0;


      if(diskon == "" || diskon == "0" || diskon <= 0){
          diskon = 0;
          jlhdiskon = 0;
      }else{
          jlhdiskon = (jumlah * harga) * diskon / 100;
      }

      if(pajak == "" || pajak == "0" || pajak <= 0){
          pajak = 0;
          jlhpajak = 0;
      }else{
          jlhpajak = ((jumlah * harga) - jlhdiskon) * pajak / 100;
      }

      var totalharga = (jumlah * harga) - jlhdiskon + jlhpajak;
      $("#txttotal").val(accounting.formatNumber(totalharga,0,'.',','));
      $("#txtpajak").val(accounting.formatNumber(pajak,0,'.',','));
      $("#txtjlhpajak").val(String(jlhpajak));
      $("#txtdiskon").val(accounting.formatNumber(diskon,0,'.',','));
      $("#txtjlhdiskon").val(String(jlhdiskon));
  }

  function hitungtotal(){
      var idpembelian = $("#txtidtransaksi").val();
      $.post("savepembelian.php",{tombol:"hitungtotal",idpembelian:idpembelian})
          .done(function(data){
              var pecah = data.split("|");

              var subtotal = pecah[0];
              var diskon = pecah[1];
              var pajak = pecah[2];
              var grandtotal = pecah[3];

              $("#txtsubtotal").val(accounting.formatMoney(subtotal, "Rp ", 0, ".", ","));
              $("#txttotaldiskon").val(accounting.formatMoney(diskon, "Rp ", 0, ".", ","));
              $("#txttotalpajak").val(accounting.formatMoney(pajak, "Rp ", 0, ".", ","));
              $("#txtgrandtotal").val(accounting.formatMoney(grandtotal, "Rp ", 0, ".", ","));
          });
  }

  function f_hapus(id){
      Swal.fire({
          title: 'Hapus Data Ini?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.value) {

              $.post("savepembelian.php",{tombol:"hapus",id:id})
                .done(function(data){
                    loaddata();
                });

              Swal.fire(
                'Deleted!',
                'Data Berhasil Dihapus',
                'success'
              )
          }
      })
  }

  $(document).ready(function(){
      f_bersih();
      loaddata();
      $('.selectpicker').selectpicker('refresh');
      if(act == "approve"){
          if(idget == ""){
              location.href = "frmlistpembelian.php";
          }else{
              var idpembelian = $("#txtidtransaksi").val();
              $.post("savepembelian.php",{tombol:"approvetransaksi",idpembelian:idpembelian})
                  .done(function(data){
                      var pecah = data.split("|");

                      $("#cmbsupplier").val(pecah[1]).selectpicker('refresh');;
                      $("#txttanggal").val(pecah[2]);
                      $("#txtreferensi").val(pecah[3]);
                      $("#cmbmetodepembayaran").val(pecah[4]);
                      $("#txtjatuhtempo").val(pecah[5]);
                      $("#txtsubtotal").val(accounting.formatMoney(pecah[6], "Rp ", 0, ".", ","));
                      $("#txttotaldiskon").val(accounting.formatMoney(pecah[7], "Rp ", 0, ".", ","));
                      $("#txttotalpajak").val(accounting.formatMoney(pecah[8], "Rp ", 0, ".", ","));
                      $("#txtgrandtotal").val(accounting.formatMoney(pecah[9], "Rp ", 0, ".", ","));
                      loaddata();
                      metodebayar(pecah[4]);
                  });
          }
      }
  });
</script>
