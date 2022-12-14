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
                            <h4>Form Konsumen</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="post" action="">
                                    <input type="hidden" name="txtid" id="txtid" />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" id="txtnama" name="txtnama" required>
                                                <span class="bar"></span>
                                                <label>Nama</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text" style="">
                                                <input type="text" class="form-text" id="txtalamat" name="txtalamat"
                                                    >
                                                <span class="bar"></span>
                                                <label>Alamat</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="display:none">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group form-element">
                                                    <h4 style="top:-10px;">Wilayah</h4>
                                                    <select class="form-control col-md-7 col-xs-12 combobox"
                                                        name="cmbwilayah" id="cmbwilayah">
                                                        <option value="dalam" selected>Dalam Kota</option>
                                                        <option value="luar">Luar Kota</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group form-element">
                                                    <h4 style="top:-10px;">Kategori</h4>
                                                    <select class="form-control col-md-7 col-xs-12 combobox"
                                                        name="cmbkategori" id="cmbkategori">
                                                        <option value="depo">Depo</option>
                                                        <option value="modern">Modern Market</option>
                                                        <option value="tradisional">Tradisional Market</option>
                                                        <option value="agen">Agen</option>
                                                        <option value="user">User</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="padding-top:15px;">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" id="txtrute"
                                                    name="txtrute" >
                                                <span class="bar"></span>
                                                <label>Rute</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-3" style="display:none">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" id="txtnofreezer"
                                                    name="txtnofreezer" >
                                                <span class="bar"></span>
                                                <label>Nomor Freezer</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 hidden">
                                            <div class="form-group form-animate-text">
                                                <input type="number" class="form-text" id="txtmaxhutang"
                                                    name="txtmaxhutang" value="1" required>
                                                <span class="bar"></span>
                                                <label>Max. Hutang</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden">
                                            <div class="form-group">
                                                <h4 class="col-sm-12 control-label">Pajak</h4>
                                                <div class="col-sm-12">
                                                    <div class="col-sm-6 padding-0">
                                                        <input type="radio" value="11" name="rdpajak"> PKP
                                                    </div>
                                                    <div class="col-sm-6 padding-0">
                                                        <input type="radio" value="0" name="rdpajak" checked> Non-PKP
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <br>

                                    <div class="form-group form-element">
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

    $("#frm").on('submit', (function (e) {
        e.preventDefault();
        var tombol = $("#simpan").val();
        var id = $("#txtid").val();
        var nama = $("#txtnama").val();
        var alamat = $("#txtalamat").val();
        var wilayah = $("#cmbwilayah").val();
        var kategori = $("#cmbkategori").val();
        var nofreezer = $("#txtnofreezer").val();
        var rute = $("#txtrute").val();
        var maxhutang = $("#txtmaxhutang").val();
        var pajak = $("input[name=rdpajak]:checked").val();

        if (nama != "" && alamat != "" && maxhutang != "") {

            var formData = new FormData();
            formData.append('tombol', tombol);
            formData.append('id', id);
            formData.append('nama', nama);
            formData.append('alamat', alamat);
            formData.append('wilayah', wilayah);
            formData.append('kategori', kategori);
            formData.append('rute', rute);
            formData.append('nofreezer', nofreezer);
            formData.append('maxhutang', maxhutang);
            formData.append('pajak', pajak);

            $.ajax({
                url: "savekonsumen.php",
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
        $("#rdkategori").val("dalam");
    }

    function loaddata() {
        $.post("savekonsumen.php", {
                tombol: "tampil"
            })
            .done(function (data) {
                $("#table").html(data);
            });
    }

    function f_edit(id) {
        $("#reset").click();
        $.post("savekonsumen.php", {
                tombol: "tampiledit",
                id: id
            })
            .done(function (data) {
                // echo "|".$id."|".$nama."|".$alamat."|".$wilayah."|".$kategori."|".$rute."|".$nofreezer."|".$pajak."|".$maxhutang."|";

                var pecah = data.split("|");
                $("#txtid").val(pecah[1]);
                $("#txtnama").val(pecah[2]);
                $("#txtalamat").val(pecah[3]);
                $("#cmbwilayah").val(pecah[4]);
                $("#cmbkategori").val(pecah[5]);
                $("#txtrute").val(pecah[6]);
                $("#txtnofreezer").val(pecah[7]);
                $("#input[name=rdpajak]:checked").val(pecah[8]);
                $("#txtmaxhutang").val(pecah[9]);
                $("#simpan").val("edit");

                window.scrollTo(0, 0);
            });
    }

    function f_hapus(id) {
        // if(confirm("Hapus data ini?") == true) {
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
                $.post("savekonsumen.php", {
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
