<?php 
    $menu_head = "data";
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
                            <h4>Form Produk</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="post" action="">
                                    <input type="hidden" name="txtid" id="txtid" />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" id="txtkodebarang" name="txtkodebarang" required>
                                                <span class="bar"></span>
                                                <label>Kode Produk</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" id="txtnama" name="txtnama" required>
                                                <span class="bar"></span>
                                                <label>Nama</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-element">
                                                <label style="">Kategori</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox" name="cmbkategori"
                                                    id="cmbkategori" onchange="pilihkategori(this.value)" >
                                                    <option value="Sepatu">Alat Tulis</option>
                                                    <option value="Lain-Lain">Lain-Lain</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-element">
                                                <label style="">Satuan</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox" name="cmbsatuan"
                                                    id="cmbsatuan" >
                                                    <?php
                                                    $sqlmenu = "select * from tbsatuan";
                                                    $querymenu = mysqli_query($con,$sqlmenu);
                                                    while($res = mysqli_fetch_array($querymenu)){
                                                        $satuan = $res['satuan'];
                                                ?>
                                                    <option value="<?php echo $satuan;?>"> <?php echo $satuan;?> </option>
                                                    <?php
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="display:none;padding:10px 0px">
                                            <div class="form-group">
                                                <!-- <h4 class="col-sm-12 control-label">Wilayah</h4> -->
                                                <label style="">Wilayah</label>
                                                <div class="col-sm-12">
                                                    <div class="col-sm-6 padding-0">
                                                        <input type="radio" value="dalam" name="rdwilayah" checked> Dalam Kota
                                                    </div>
                                                    <div class="col-sm-6 padding-0">
                                                        <input type="radio" value="luar" name="rdwilayah"> Luar Kota
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="display:none;">
                                            <div class="form-group form-element">
                                                <label style="">Jenis Konsumen</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox" name="cmbjenis"
                                                    id="cmbjenis">
                                                    <option value="depo">Depo</option>
                                                    <option value="modern">Modern Market</option>
                                                    <option value="tradisional">Tradisional Market</option>
                                                    <option value="agen">Agen</option>
                                                    <option value="user">User</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div id="luar" class="col-md-3" style="display:none">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" value="0" id="txthargaluar" name="txthargaluar"
                                                    required>
                                                <span class="bar"></span>
                                                <label>Harga Luar Kota</label>
                                            </div>
                                        </div>
                                        <div id="dalam" class="col-md-3">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" value="0" id="txthargadalam" name="txthargadalam"
                                                    required>
                                                <span class="bar"></span>
                                                <label>Harga Jual</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="display:none">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" id="txtlokasi" name="txtlokasi">
                                                <span class="bar"></span>
                                                <label>Lokasi</label>
                                            </div>
                                        </div>
                                        <div id="depo" class="col-md-3" style="display:none">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" value="0" id="txthargadepo" name="txthargadepo"
                                                    required>
                                                <span class="bar"></span>
                                                <label>Harga Depo</label>
                                            </div>
                                        </div>
                                        <div id="mm" class="col-md-3" style="display:none">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" value="0" id="txthargamodern" name="txthargamodern"
                                                    required>
                                                <span class="bar"></span>
                                                <label>Harga Modern Market</label>
                                            </div>
                                        </div>
                                        <div id="tm" class="col-md-3" style="display:none">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" value="0" id="txthargatradisional" name="txthargatradisional"
                                                    required>
                                                <span class="bar"></span>
                                                <label>Harga Tradisional Market</label>
                                            </div>
                                        </div>
                                        <div id="agen" class="col-md-3" style="display:none">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" value="0" id="txthargaagen" name="txthargaagen"
                                                    required>
                                                <span class="bar"></span>
                                                <label>Harga Agen</label>
                                            </div>
                                        </div>
                                        <div id="user" class="col-md-3" style="display:none">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" value="0" id="txthargauser" name="txthargauser"
                                                    required>
                                                <span class="bar"></span>
                                                <label>Harga User</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="display:none">
                                            <div class="form-group form-animate-text">
                                                <input type="number" class="form-text" id="txtisikemasan" value="1" name="txtisikemasan"
                                                    required>
                                                <span class="bar"></span>
                                                <label>Isi per Dus</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                       
                                    </div>

                                    <br>
                                    <br>

                                    <div class="form-group form-element" style="margin-bottom:5px">
                                        <button type="submit" class="submit btn btn-success" name="simpan" id="simpan"
                                            value="simpan"> Save </button>
                                        <button type="reset" class="submit btn btn-primary" name="reset" id="reset"
                                            value="simpan" onclick="f_bersih();"> Reset </button>
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

    $("#txthargaluar").keyup(function () {
        var hargaluar = $("#txthargaluar");
        $("#txthargaluar").val(formatRupiah(hargaluar.val()));
    });
    $("#txthargadalam").keyup(function () {
        var hargadalam = $("#txthargadalam");
        $("#txthargadalam").val(formatRupiah(hargadalam.val()));
    });
    $("#txthargadepo").keyup(function () {
        var hargadepo = $("#txthargadepo");
        $("#txthargadepo").val(formatRupiah(hargadepo.val()));
    });
    $("#txthargamodern").keyup(function () {
        var hargamodern = $("#txthargamodern");
        $("#txthargamodern").val(formatRupiah(hargamodern.val()));
    });
    $("#txthargatradisional").keyup(function () {
        var hargatradisional = $("#txthargatradisional");
        $("#txthargatradisional").val(formatRupiah(hargatradisional.val()));
    });
    $("#txthargaagen").keyup(function () {
        var hargaagen = $("#txthargaagen");
        $("#txthargaagen").val(formatRupiah(hargaagen.val()));
    });
    $("#txthargauser").keyup(function () {
        var hargauser = $("#txthargauser");
        $("#txthargauser").val(formatRupiah(hargauser.val()));
    });

    function pilihkategori(param){
        if(param == "Bulk"){
            $("#luar").css('display','none');
            $("#dalam").css('display','none');
            $("#depo").css('display','block');
            $("#mm").css('display','block');
            $("#tm").css('display','block');
            $("#agen").css('display','block');
            $("#user").css('display','block');
            $("#txthargadalam").val(0);
            $("#txthargaluar").val(0);

        }else{
            $("#luar").css('display','none');
            $("#dalam").css('display','block');
            $("#depo").css('display','none');
            $("#mm").css('display','none');
            $("#tm").css('display','none');
            $("#agen").css('display','none');
            $("#user").css('display','none');
            $("#txthargaluar").val(0);
            $("#txthargadepo").val(0);
            $("#txthargamodern").val(0);
            $("#txthargatradisional").val(0);
            $("#txthargaagen").val(0);
            $("#txthargauser").val(0);

        }
    }

    $("#frm").on('submit', (function (e) {
        e.preventDefault();
        var tombol = $("#simpan").val();
        var id = $("#txtid").val();
        var kode = $("#txtkodebarang").val();
        var nama = $("#txtnama").val();
        var hargaluar = $("#txthargaluar").val().replace(/\./g, "");
        var hargadalam = $("#txthargadalam").val().replace(/\./g, "");
        var hargadepo = $("#txthargadepo").val().replace(/\./g, "");
        var hargamodern = $("#txthargamodern").val().replace(/\./g, "");
        var hargatradisional = $("#txthargatradisional").val().replace(/\./g, "");
        var hargaagen = $("#txthargaagen").val().replace(/\./g, "");
        var hargauser = $("#txthargauser").val().replace(/\./g, "");
        var satuan = $("#cmbsatuan").val();
        var kategori = $("#cmbkategori").val();
        var lokasi = $("#txtlokasi").val();
        var wilayah = $("input[name=rdwilayah]:checked").val();
        var jenis = $("#cmbjenis").val();
        var isikemasan = $("#txtisikemasan").val();

        if (kode != "" && nama != "" && isikemasan != "" && isikemasan != 0) {

            var formData = new FormData();
            formData.append('tombol', tombol);
            formData.append('id', id);
            formData.append('kode_barang', kode);
            formData.append('nama', nama);
            formData.append('hargaluar', hargaluar);
            formData.append('hargadalam', hargadalam);
            formData.append('hargadepo', hargadepo);
            formData.append('hargamodern', hargamodern);
            formData.append('hargatradisional', hargatradisional);
            formData.append('hargaagen', hargaagen);
            formData.append('hargauser', hargauser);
            formData.append('satuan', satuan);
            formData.append('kategori', kategori);
            formData.append('wilayah', wilayah);
            formData.append('jenis', jenis);
            formData.append('lokasi', lokasi);
            formData.append('isikemasan', isikemasan);
            // formData.append('imgurl', $('input[type=file]')[0].files[0]);

            $.ajax({
                url: "savemenu.php",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    loaddata();
                    $("#reset").click();
                }
            });
        } else {
            Swal.fire({
                type: 'error',
                title: 'Masih Ada Data yang Kosong'
            })
        }
    }));

    function f_bersih() {
        $("#simpan").val("simpan");
        $("#txtkodebarang").val("");
        $("#txtnama").val("");
        $("#txthargaluar").val(0);
        $("#txthargadalam").val(0);
        $("#txthargadepo").val(0);
        $("#txthargamodern").val(0);
        $("#txthargatradisional").val(0);
        $("#txthargaagen").val(0);
        $("#txthargauser").val(0);
        $("#cmbsatuan").val('Stick');
        $("#txtlokasi").val('');
        $("#cmbkategori").val('');
        $("#rdwilayah").val("dalam");
        $("#txtisikemasan").val("");
    }

    function loaddata() {
        $.post("savemenu.php", {
                tombol: "tampil"
            })
            .done(function (data) {
                $("#table").html(data);
                pilihkategori('Stick');
            });
    }

    function f_edit(id) {
        $("#reset").click();
        $.post("savemenu.php", {
                tombol: "tampiledit",
                id: id
            })
            .done(function (data) {
                // echo "|".$id."|".$kodebarang."|".$nama."|".$wilayah."|".$jenis."|".$hargaluar."|".$hargadalam."|".$hargadepo."|".$hargamodern."|".$hargatradisional."|".$hargaagen."|".$hargauser."|".$satuan."|".$isikemasan."|";
                var pecah = data.split("|");
                $("#txtid").val(pecah[1]);
                $("#txtkodebarang").val(pecah[2]);
                $("#txtnama").val(pecah[3]);
                $("input[name=rdwilayah]:checked").val(pecah[4]);
                $("#cmbjenis").val(pecah[5]);
                $("#txthargaluar").val(formatRupiah(pecah[6]));
                $("#txthargadalam").val(formatRupiah(pecah[7]));
                $("#txthargadepo").val(formatRupiah(pecah[8]));
                $("#txthargamodern").val(formatRupiah(pecah[9]));
                $("#txthargatradisional").val(formatRupiah(pecah[10]));
                $("#txthargaagen").val(formatRupiah(pecah[11]));
                $("#txthargauser").val(formatRupiah(pecah[12]));
                $("#cmbsatuan").val(pecah[13]);
                $("#cmbkategori").val(pecah[14]);
                $("#txtisikemasan").val(pecah[15]);
                $("#txtlokasi").val(pecah[16]);
                $("#simpan").val("edit");

                window.scrollTo(0, 0);
            });
    }

    function f_hapus(id) {
        Swal.fire({
            title: 'Hapus Data Ini?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.post("savemenu.php", {
                        tombol: "hapus",
                        id: id
                    })
                    .done(function (data) {
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

    $(document).ready(function () {
        loaddata();
    });
</script>
