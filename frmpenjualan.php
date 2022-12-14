<?php
    $menu_head = "penjualan";
    include "Header.php";

    $act = $_GET['act'];
    $idget = $_GET['id'];

if ($act=="new") {
    $ip = get_ip();
    $sqlsum = "select max(SUBSTRING_INDEX(id,'-',-1)) from tbjual where YEAR(tanggal)=YEAR(CURDATE())";
    $querysum = mysqli_query($con, $sqlsum) or die($sqlsum);
    $ressum = mysqli_fetch_array($querysum);
    $maxno = $ressum[0] + 1;
    $tanggal = date("Ymd");
    $judul = "Penjualan";

    if ($ip == "::1") {
        $ip = "1";
    } else {
        $pecah = explode('.', $ip);
        $ip = $pecah[3];
    }

    $idtransaksi = "J-" . $tanggal . "-" . $ip . "-" . $_SESSION['iduser'] . "-" . pad_left($maxno, 0, 5);


    $waktusekarang = date("H:i");
//        $waktusekarang = "08:21";
    $shift1 = $_SESSION['shift1'];
    $shift2 = $_SESSION['shift2'];
    $shift3 = $_SESSION['shift3'];
    $lembur = $_SESSION['lembur'];

    $pecah1 = explode("-", $shift1);
    $pecah2 = explode("-", $shift2);
    $pecah3 = explode("-", $shift3);
    $pecah_lembur = explode("-", $lembur);

    $shift1_mulai = $pecah1[0];
    $shift1_selesai = $pecah1[1];
    $shift2_mulai = $pecah2[0];
    $shift2_selesai = $pecah2[1];
    $shift3_mulai = $pecah3[0];
    $shift3_selesai = $pecah3[1];
    $lembur_mulai = $pecah_lembur[0];
    $lembur_selesai = $pecah_lembur[1];

    $shiftkaryawan = "";
    if ($waktusekarang >= $shift1_mulai && $waktusekarang <= $shift1_selesai) {
        $shiftkaryawan = '1';
    } elseif ($waktusekarang >= $shift2_mulai && $waktusekarang <= $shift2_selesai) {
        $shiftkaryawan = '2';
    } elseif ($waktusekarang >= $shift3_mulai && $waktusekarang <= $shift3_selesai) {
        $shiftkaryawan = '3';
    } elseif ($waktusekarang >= $lembur_mulai && $waktusekarang <= $lembur_selesai) {
        $shiftkaryawan = 'Lembur';
    } else {
        $shiftkaryawan = "2";
    }
} elseif ($act=="edit") {
    $idtransaksi = $idget;
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
                        <h4>Form Penjualan
                        </h4>
                        <span> ID Transaksi : <?php echo $idtransaksi;?></span>
                        <!-- <div id="shiftkaryawan"> Shift : <?php echo $shiftkaryawan;?>
                    </div> -->
                    <input type="hidden" name="txtidtransaksi" id="txtidtransaksi"
                        value="<?php echo $idtransaksi;?>" />
                    <input type="hidden" name="txtshiftkaryawan" id="txtshiftkaryawan"
                        value="<?php echo $shiftkaryawan;?>" />
                </div>
                <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                    <div class="col-md-3">
                        <div class="form-group form-element">
                            <label style="top:-10px;">Konsumen</label>
                            <select class="form-control col-md-7 col-xs-12 combobox selectpicker"
                                data-live-search="true" data-size="5" name="cmbkonsumen" id="cmbkonsumen" <?php if ($act == 'edit') {
                                            echo 'disabled';
                                        } ?> >
                                <option value="0" selected> Cash </option>

                                <?php
                                        $sqlmenu = "SELECT * FROM tbkonsumen where id!='0' ORDER BY nama ASC";
                                        $querymenu = mysqli_query($con, $sqlmenu);
                                        while ($res = mysqli_fetch_array($querymenu)) {
                                            $id = $res['id'];
                                            $nama = $res['nama'];
                                            $alamat = $res['alamat']; ?>
                                <option value="<?php echo $id; ?>"
                                    data-subtext="<?php echo $alamat; ?>">
                                    <?php echo $nama; ?>
                                </option>
                                <?php
                                        }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" style="margin-top:10px;padding-right:0px;">
                        <div class="form-group form-animate-text">
                            <input type="date" class="form-text" id="txttgltransaksi" name="txttgltransaksi" <?php if ($act == 'edit') {
                                            echo 'readonly';
                                        } ?>
                            >
                            <span class="bar"></span>
                            <label style="top:-10px">Tanggal Penjualan</label>
                        </div>
                    </div>
                    <div class="col-md-3" style="display:none">
                        <div class="form-group form-element">
                            <label style="top:-10px;">Metode Pembayaran</label>
                            <select class="form-control col-md-7 col-xs-12 combobox" name="cmbmetodepembayaran"
                                id="cmbmetodepembayaran" <?php if ($act == 'edit') {
                                            echo 'disabled';
                                        } ?>
                                onchange="metodebayar(this.value)">
                                <option value="Cash"> Cash </option>
                                <option value="Kredit"> Kredit </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3" id="jatuhtempo" style="display:none;">
                        <div class="form-group form-animate-text">
                            <input type="date" class="form-text" id="txtjatuhtempo" name="txtjatuhtempo" <?php if ($act == 'edit') {
                                            echo 'disabled';
                                        } ?>
                            >
                            <span class="bar"></span>
                            <label>Tanggal Jatuh Tempo</label>
                        </div>
                    </div>

                    <div class="col-md-12 panel" style="margin-top:20px;">
                        <form class="cmxform" id="frm" method="get" action="">
                            <input type="hidden" name="txtid" id="txtid" />

                            <div id="menunormal" name="menunormal" class="col-md-3">
                            </div>

                            <div class="col-md-7">
                                <div class="col-md-2">
                                    <div class="form-group form-animate-text">
                                        <label
                                            style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Jumlah</label>
                                        <input type="text" <?php if ($act == 'edit') {
                                            //echo 'disabled';
                                        } ?>
                                        class="form-text" id="txtjumlah" name="txtjumlah" value="1"
                                        onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id);hitungharga()">
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-animate-text">
                                        <label
                                            style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Harga</label>
                                        <input type="text" <?php if ($act == 'edit') {
                                            // echo 'disabled';
                                        } ?>
                                        class="form-text" id="txtharga" name="txtharga" onfocus="f_tonumber(this.id)"
                                        onblur="f_tocurrency(this.id);hitungharga()" value="0" >
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <div style="display:none" class="col-md-2">
                                    <div class="form-group form-animate-text">
                                        <label
                                            style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Pajak</label>
                                        <input type="text" <?php if ($act == 'edit') {
                                            // echo 'disabled';
                                        } ?>
                                        class="form-text" id="txtpajak" name="txtpajak" value="0"
                                        onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id);hitungharga()">
                                        <input type="hidden" id="txtjlhpajak" name="txtjlhpajak" value="0" />
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-animate-text">
                                        <label
                                            style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Diskon</label>
                                        <input type="text" <?php if ($act == 'edit') {
                                            // echo 'disabled';
                                        } ?>
                                        class="form-text" id="txtdiskon" name="txtdiskon" value="0"
                                        onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id);hitungharga()">
                                        <input type="hidden" id="txtjlhdiskon" name="txtjlhdiskon" value="0" />
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-animate-text">
                                        <label
                                            style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Total</label>
                                        <input type="text" class="form-text" id="txttotal" name="txttotal" value="0"
                                            readonly>
                                        <span class="bar"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2" style="margin-top:25px;">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?php
                                                        if ($act=='edit') {
                                                            ?>
                                            <button type="button" class="submit btn btn-info" name="simpan" id="simpan"
                                                value="edit" onclick="f_simpan(); return false;"> Save
                                            </button>
                                            <!-- <button type="button" class="submit btn btn-info" name="kurang" id="kurang"
                                                value="kurang" onclick="f_pilihretur('kurang'); return false;"> Retur
                                            </button> -->
                                            <?php
                                                        } else {
                                                            ?>
                                            <button type="button" class="submit btn btn-info" name="simpan" id="simpan"
                                                value="simpan" onclick="f_simpan(); return false;"> Save
                                            </button>
                                            <?php
                                                        }
                                                    ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?php
                                                    if ($act=='edit') {
                                                        ?>
                                            <button type="button" class="submit btn btn-warning" name="reset" id="reset"
                                                value="simpan" style="display:none;" disabled onclick="f_bersih();">
                                                Reset </button>
                                            <!-- <button type="button" class="submit btn btn-info" name="tambah"
                                                        id="tambah" value="tambah" onclick="f_pilihretur('tambah'); return false;"> Tambah
                                                    </button> -->
                                            <?php
                                                    } else {
                                                        ?>
                                            <button type="button" class="submit btn btn-warning" name="reset" id="reset"
                                                value="simpan" onclick="f_bersih();"> Reset </button>
                                            <?php
                                                    }
                                                ?>
                                        </div>
                                    </div>
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
                            <div class="col-md-9 form-group form-animate-text"
                                style="margin-top:0px !important;margin-bottom:0px !important;">
                                <input type="text" class="form-text text-right" id="txtsubtotal" name="txtsubtotal"
                                    value="0" readonly>
                                <span class="bar"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="padding-top:10px;padding-left:10px;">
                                <label style="color:#918C8C;font-weight:bold;font-size:17px;">Diskon</label>
                            </div>
                            <div class="col-md-9 form-group form-animate-text"
                                style="margin-top:0px !important;margin-bottom:0px !important;">
                                <input type="text" class="form-text text-right" id="txttotaldiskon"
                                    name="txttotaldiskon" readonly value="0" onblur="hitungtotal()">
                                <span class="bar"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="padding-top:10px;padding-left:10px;">
                                <label style="color:#918C8C;font-weight:bold;font-size:17px;">Pajak</label>
                            </div>
                            <div class="col-md-9 form-group form-animate-text"
                                style="margin-top:0px !important;margin-bottom:0px !important;">
                                <input type="text" class="form-text text-right" id="txttotalpajak" name="txttotalpajak"
                                    readonly value="0" onblur="hitungtotal()">
                                <span class="bar"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="padding-top:10px;padding-left:10px;">
                                <label style="color:#918C8C;font-weight:bold;font-size:17px;">Grandtotal</label>
                            </div>
                            <div class="col-md-9 form-group form-animate-text"
                                style="margin-top:0px !important;margin-bottom:0px !important;">
                                <input type="text" class="form-text text-right" id="txtgrandtotal" name="txtgrandtotal"
                                    value="0" readonly>
                                <span class="bar"></span>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <button type="button" class="submit pull-right btn btn-primary" name="proses" id="proses"
                                value="simpan" onclick="f_proses();"> Proses </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalRetur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Retur</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 form-group form-animate-text">
                                <input type="number" class="form-text" id="txtjlhretur" name="txtjlhretur" value="1">
                                <span class="bar"></span>
                                <label for="">Jumlah Retur (Per PCS <strong><span
                                            id="txtjlhpersatuan"></span></strong>)</label>
                            </div>
                            <div class="col-md-6 form-group form-animate-text">
                                <input type="number" class="form-text" id="txtisipersatuan" name="txtisipersatuan"
                                    readonly onfokus="" value="0">
                                <span class="bar"></span>
                                <label for="">Isi Per Kemasan <span id="txtsatuan"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="rdkelayakan" id="rdkelayakan1" value="layak" checked> Layak
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="rdkelayakan" id="rdkelayakan2" value="tidaklayak"> Tidak Layak
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="f_prosesretur()">Proses</button>
            </div>
        </div>
    </div>
</div>

<!-- page content -->
<?php include "Footer.php";?>

<script>
    var act = "<?php echo $act;?>";
    var idget = "<?php echo $idget;?>";

    // VARIABEL UNTUK DETAIL PENJUALAN
    var $id = $("#txtid");
    var $menu = $("#cmbmenu");
    var $jumlah = $("#txtjumlah");
    var $harga = $("#txtharga");
    var $total = $("#txttotal");
    var $idjual = $("#txtidtransaksi");
    var $diskon = $("#txtdiskon");
    var $jlhdiskon = $("#txtjlhdiskon");
    var $pajak = $("#txtpajak");
    var $jlhpajak = $("#txtjlhpajak");
    var $tiperetur;
    var $rdkelayakan = $("input[name=rdkelayakan]:checked");
    // VARIABEL UNTUK PROSES PENJUALAN
    var $metodepembayaran = $("#cmbmetodepembayaran");
    var $jatuhtempo = $("#txtjatuhtempo");
    var $idkonsumen = $("#cmbkonsumen");
    var $kodecanvas = $("#cmbcanvas");
    var $subtotal = $("#txtsubtotal");
    var $totaldiskon = $("#txttotaldiskon");
    var $totalpajak = $("#txttotalpajak");
    var $grandtotal = $("#txtgrandtotal");
    var $shiftkaryawan = $("#txtshiftkaryawan");
    var $jlhretur = $("#txtjlhretur");
    var $satuan = $("#txtsatuan");
    var $jlhpersatuan = $("#txtjlhpersatuan");
    var $isisatuan = $("#txtisipersatuan");
    var $tgltransaksi = $("#txttgltransaksi");

    var pajak_global = 0;
    var $simpan = $("#simpan");

    alertify.minimalDialog || alertify.dialog('minimalDialog', function() {
        return {
            main: function(content) {
                this.setHeader('Please Wait');
                this.setContent('<h4 style="margin-top:20px;">Transaksi sedang diproses</h4>');
            }
        }
    });

    function metodebayar(param) {
        if (param == "Cash") {
            $("#jatuhtempo").css('display', 'none');
        } else {
            $("#jatuhtempo").css('display', 'block');
        }
    }

    function f_simpan() {
        // Swal.showLoading();
        var tombol = $("#simpan").val();

        if ($menu.val() != "" && $jumlah.val() != "") {
            $.post("savepenjualan.php", {
                    tombol: tombol,
                    idjual: $idjual.val(),
                    id: $id.val(),
                    kodecanvas: $kodecanvas.val(),
                    idkonsumen: $idkonsumen.val(),
                    menu: $menu.val(),
                    jumlah: $jumlah.val(),
                    harga: accounting.unformat($harga.val(), ','),
                    total: accounting.unformat($total.val(), ','),
                    diskon: $diskon.val(),
                    jlhdiskon: accounting.unformat($jlhdiskon.val(), ','),
                    pajak: $pajak.val(),
                    jlhpajak: accounting.unformat($jlhpajak.val(), ','),
                })
                .done(function(data) {
                    if (data == "sukses") {
                        // Swal.hideLoading()

                        loaddata();
                        $("#reset").click();

                        // $('#cmbmenu').selectpicker('toggle');

                    } else if (data == "kosong") {
                        Swal.fire({
                            type: 'error',
                            title: 'Stok untuk Produk ini tidak mencukupi'
                        })
                    } else if (data == "sudah ada") {
                        Swal.fire({
                            type: 'error',
                            title: 'Produk ini sudah diinput, silahkan diedit'
                        })
                    }
                });
        } else {
            Swal.fire({
                type: 'error',
                title: 'Produk Belum dipilih'
            })
        }
    }

    function f_proses() {
        if ($idkonsumen.val() != "" && $grandtotal.val() != 0) {
            $.post("savepenjualan.php", {
                    tombol: "proses",
                    act: act,
                    idjual: $idjual.val(),
                    kodecanvas: $kodecanvas.val(),
                    tgltransaksi: $tgltransaksi.val(),
                    metodepembayaran: $metodepembayaran.val(),
                    jatuhtempo: $jatuhtempo.val(),
                    subtotal: accounting.unformat($subtotal.val(), ','),
                    diskon: $diskon.val(),
                    pajak: $pajak.val(),
                    grandtotal: accounting.unformat($grandtotal.val(), ','),
                })
                .done(function(data) {
                    if (data == "kosong") {
                        Swal.fire({
                            type: 'error',
                            title: 'Tambahkan Produk terlebih dahulu'
                        })
                    }
                    if (data == "Sudah Ada") {
                        Swal.fire({
                            type: 'error',
                            title: 'No Penjualan Sudah Ada'
                        })
                    } else {
                        f_print($idjual.val());
                    }
                });
        } else {
            Swal.fire({
                type: 'error',
                title: 'Data Masih Kosong'
            })
        }
    }

    function f_pilihretur(tipe) {
        if ($menu.val() != '') {
            $tiperetur = tipe;
            $('#modalRetur').modal('show')
        }
    }

    function f_prosesretur() {
        $("input[name=rdkelayakan]").change(function() {
            $("input[name=rdkelayakan]:checked").val()
        });

        if ($("input[name=rdkelayakan]:checked").val() == 'tidaklayak') {
            $jlhretur.val(0);
        }

        $.post("savepenjualan.php", {
                tombol: "prosesretur",
                act: act,
                idjual: idget,
                menu: $menu.val(),
                tipe: 'kurang',
                jlhretur: $jlhretur.val(),
                kelayakan: $("input[name=rdkelayakan]:checked").val(),
            })
            .done(function(data) {
                $('#modalRetur').modal('hide')
                Swal.fire(
                    'Berhasil',
                    'Berhasil Retur',
                    'success'
                )

            }).fail(function() {
                Swal.fire(
                    'Gagal',
                    'Gagal Retur',
                    'warning'
                )
            })
        f_bersih()
        loaddata()
        hitungtotal()
    }

    function f_bersih() {
        $simpan.val("simpan");
        $menu.val("");
        $menu.prop("disabled", false);
        $jumlah.val("0");
        $harga.val("0");
        $total.val("0");
        $diskon.val("0");
        $jlhdiskon.val("0");
        $pajak.val("0");
        $jlhpajak.val("0");
        document.getElementById('txttgltransaksi').valueAsDate = new Date();
        $('.selectpicker').selectpicker('refresh');
        $("#txtjumlah").blur();
        $('#txttotal').focus();
    }

    function f_cancel() {
        $.post("savepenjualan.php", {
                tombol: "cancel",
                idjual: $idjual.val(),
            })
            .done(function(data) {
                location.href = "frmpenjualan.php?act=new&id=";
            });
    }

    function loaddata() {
        $.post("savepenjualan.php", {
                tombol: "tampil",
                idjual: $idjual.val(),
            })
            .done(function(data) {

                $("#table").html(data);
                hitungtotal();
                loadcanvas();
            });
    }

    function f_edit(id) {
        $("#reset").click();
        $.post("savepenjualan.php", {
                tombol: "tampiledit",
                id: id
            })
            .done(function(data) {
                // echo "|".$id."|".$menu."|".$idkonsumen."|".$idsales."|".$jumlah."|".$harga."|".$total."|".$diskon."|".$jlhdiskon."|".$pajak."|".$jlhpajak."|".$note."|".$isi_kemasan."|".$satuan."|";
                var pecah = data.split("|");
                $id.val(pecah[1]);
                $menu.val(pecah[2]);
                $idkonsumen.val(pecah[3]);
                $jumlah.val(pecah[5]);
                $harga.val(accounting.formatNumber(pecah[6], 0, '.', ','));
                $total.val(accounting.formatNumber(pecah[7], 0, '.', ','));
                $diskon.val(pecah[8]);
                $jlhdiskon.val(accounting.formatNumber(pecah[9], 0, '.', ','));
                $pajak.val(pecah[10]);
                $jlhpajak.val(accounting.formatNumber(pecah[11], 0, '.', ','));
                $isisatuan.val(pecah[13]);
                $satuan.text(pecah[14]);
                $jlhretur.val(1 / parseInt(pecah[13]));
                $jlhpersatuan.text(1 / parseInt(pecah[13]));

                $('.selectpicker').selectpicker('refresh');
                $menu.prop("disabled", true);
                $simpan.val("edit");
            });
    }

    function loadmenu() {
        $.post("savepenjualan.php", {
                tombol: "cekkonsumen",
                idkonsumen: $idkonsumen.val(),
            })
            .done(function(data) {
                // echo "|".$nama."|".$wilayah."|".$kategori."|".$rate_pajak."|".$max_hutang;
                var pecah = data.split("|");
                let wilayah = pecah[2];
                let kategori_konsumen = pecah[3];
                let pajak_ = pecah[4];
                pajak_global = pecah[4];
                $pajak.val(0);

                if ($kodecanvas.val()) {
                    $.post("savepenjualan.php", {
                            tombol: "tampildatamenucanvas",
                            kodecanvas: $kodecanvas.val(),
                            menu: $menu.val(),
                        })
                        .done(function(data) {
                            var pecah = data.split("|");
                            var canvas = pecah[1];
                            let JSONcanvas = JSON.parse(canvas);

                            $jumlah.val(JSONcanvas.jlhterjual ? JSONcanvas.jlhterjual : 1);

                        });
                } else {
                    $jumlah.val(1);
                }

                $.post("savepenjualan.php", {
                        tombol: "tampilmenu",
                        menu: $menu.val()
                    })
                    .done(function(data) {
                        //echo "|".$id."|".$menu."|".$wilayah."|".$jenis."|".$hargadk."|".$hargalk."|".$hargadepo."|".$hargamodern."|".$hargatradisional."|".$hargaagen."|".$hargauser."|".$diskon."|".$pajak."|".$satuan."|".$kategori."|".$jumlah."|".$isikemasan."|";

                        var pecahMenu = data.split("|");

                        let kategori_barang = pecahMenu[15];
                        if (kategori_barang == 'Bulk') {
                            if (kategori_konsumen == 'depo') {
                                $harga.val(accounting.formatNumber(pecahMenu[7], 0, '.', ','));
                            }
                            if (kategori_konsumen == 'modern') {
                                $harga.val(accounting.formatNumber(pecahMenu[8], 0, '.', ','));
                            }
                            if (kategori_konsumen == 'tradisional') {
                                $harga.val(accounting.formatNumber(pecahMenu[9], 0, '.', ','));
                            }
                            if (kategori_konsumen == 'agen') {
                                $harga.val(accounting.formatNumber(pecahMenu[10], 0, '.', ','));
                            }
                            if (kategori_konsumen == 'user') {
                                $harga.val(accounting.formatNumber(pecahMenu[11], 0, '.', ','));
                            }
                        } else {
                            if (wilayah == 'dalam') {
                                $harga.val(accounting.formatNumber(pecahMenu[5], 0, '.', ','));
                            }
                            if (wilayah == 'luar') {
                                $harga.val(accounting.formatNumber(pecahMenu[6], 0, '.', ','));
                            }
                        }

                        // $isisatuan.val(pecah[17]);
                        // $satuan.val(pecah[14]);
                        hitungharga();
                    });
            });
    }

    function loadcanvas() {
        $.post("savepenjualan.php", {
                tombol: "tampilmenucanvas",
                kodecanvas: $kodecanvas.val(),
            })
            .done(function(data) {
                $("#menunormal").html(data);
                $('.selectpicker').selectpicker('refresh');
                $menu = $("#cmbmenu");


            });

        if ($kodecanvas.val()) {
            $.post("savepenjualan.php", {
                    tombol: "tampildatacanvas",
                    kodecanvas: $kodecanvas.val(),
                })
                .done(function(data) {
                    var pecah = data.split("|");
                    var canvas = pecah[1];
                    let JSONcanvas = JSON.parse(canvas);
                    $('.selectpicker').selectpicker('refresh');
                });
        }
    }

    function hitungharga() {
        var jumlah = parseInt($jumlah.val());
        var total = parseInt(accounting.unformat($total.val(), ','));
        var harga = parseInt(accounting.unformat($harga.val(), ','));
        var pajak = parseInt($pajak.val());
        var diskon = parseInt($diskon.val());
        var jlhpajak = 0;
        var jlhdiskon = 0;


        if (diskon == "" || diskon == "0" || diskon <= 0) {
            diskon = 0;
            jlhdiskon = 0;
        } else {
            jlhdiskon = (jumlah * harga) * diskon / 100;
        }

        if (pajak == "" || pajak == "0" || pajak <= 0) {
            pajak = 0;
            jlhpajak = 0;
        } else {
            jlhpajak = ((jumlah * harga) - jlhdiskon) * pajak / 100;
        }

        var totalharga = (jumlah * harga) - jlhdiskon + jlhpajak;
        $total.val(accounting.formatNumber(totalharga, 0, '.', ','));
        $pajak.val(String(pajak));
        $jlhpajak.val(accounting.formatNumber(jlhpajak, 0, '.', ','));
        $diskon.val(String(diskon));
        $jlhdiskon.val(accounting.formatNumber(jlhdiskon, 0, '.', ','));

    }

    function hitungtotal() {
        ;
        $.post("savepenjualan.php", {
                tombol: "hitungtotal",
                idjual: $idjual.val(),
            })
            .done(function(data) {
                var pecah = data.split("|");
                for (var i = 0; i < pecah.length; i++) {
                    if (pecah[i] == "" || pecah[i] == null) {
                        pecah[i] = 0;
                    }
                }
                var subtotal = parseInt(pecah[3]);
                var diskon = parseInt(pecah[1]);
                var pajak = parseInt(pecah[2]);
                var grandtotal = parseInt(pecah[0]);
                let newpajak;
                let newsubtotal;

                if (pajak_global == 0) {
                    newpajak = pajak;
                    newsubtotal = subtotal;
                } else {
                    newpajak = grandtotal - ((grandtotal / 110) * 100);
                    newsubtotal = (grandtotal - newpajak);
                }

                $subtotal.val(accounting.formatNumber(newsubtotal, 0, '.', ','));
                $totaldiskon.val(accounting.formatNumber(diskon, 0, '.', ','));
                $totalpajak.val(accounting.formatNumber(newpajak, 0, '.', ','));
                $grandtotal.val(accounting.formatNumber(grandtotal, 0, '.', ','));
            });
    }

    function f_hapus(id) {

        Swal.fire({
            title: 'Yakin Akan Dihapus?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.value) {
                Swal.showLoading()

                $.post("savepenjualan.php", {
                        tombol: "hapus",
                        id: id
                    })
                    .done(function(data) {
                        loaddata();
                        Swal.hideLoading()

                    });
                Swal.fire(
                    'Terhapus',
                    'Sudah Dihapus.',
                    'success'
                )
            }
        })
        f_bersih();
    }

    $(document).ready(function() {
        f_bersih();
        if (act == "edit") {
            if (idget == "") {
                alertify.prompt('Perhatian', 'Masukkan ID Transaksi yang akan diedit:', '',
                    // OK
                    function(evt, value) {
                        var idjual = value;
                        $.post("savepenjualan.php", {
                                tombol: "periksapenjualan",
                                idjual: idjual
                            })
                            .done(function(data) {
                                var pecah = data.split("|");
                                if (pecah[0] == "no") {
                                    alertify.alert("Peringatan",
                                        "Maaf, ID Transaksi tersebut tidak terdaftar").setting({
                                        'onok': function() {
                                            location.href = "frmpenjualan.php?act=new&id=";
                                        }
                                    }).show();
                                } else if (pecah[0] == "yes") {
                                    location.href = "frmpenjualan.php?act=edit&id=" + pecah[1];
                                }
                            });
                    },
                    // Cancel
                    function() {
                        location.href = "frmpenjualan.php?act=new&id=";
                    });
            } else {
                // var idjual = $("#txtidtransaksi").val();
                $.post("savepenjualan.php", {
                        tombol: "edittransaksi",
                        idjual: $idjual.val(),
                    })
                    .done(function(data) {
                        var pecah = data.split("|");
                        $idkonsumen.val(pecah[1]);
                        $('.selectpicker').selectpicker('refresh');
                    });
            }
        } else if (act == "hapus") {
            // OK
            // var idjual = value;
            $.post("savepenjualan.php", {
                    tombol: "periksapenjualan",
                    idjual: idget
                })
                .done(function(data) {
                    var pecah = data.split("|");
                    if (pecah[0] == "no") {
                        alertify.alert("Peringatan", "Maaf, ID Transaksi tersebut tidak terdaftar")
                            .setting({
                                'onok': function() {
                                    location.href = "frmpenjualan.php?act=new&id=";
                                }
                            }).show();
                    } else if (pecah[0] == "yes") {
                        alertify.prompt('Perhatian', 'Masukkan Alasan kenapa transaksi dihapus:', '',
                            // OK
                            function(evt, value) {
                                var alasan = value;
                                $.post("savepenjualan.php", {
                                        tombol: "hapustransaksi",
                                        idjual: pecah[1],
                                        alasan: alasan
                                    })
                                    .done(function(data) {
                                        alertify.alert("Sukses",
                                                "Transaksi tersebut telah berhasil dihapus")
                                            .setting({
                                                'onok': function() {
                                                    location.href =
                                                        "frmpenjualan.php?act=new&id=";
                                                }
                                            }).show();
                                    });
                            },
                            // Cancel
                            function() {
                                location.href = "frmpenjualan.php?act=new&id=";
                            });
                    }
                });
        }

        loaddata();
        $('.selectpicker').selectpicker('refresh');

    });

    document.onkeyup = function(e) {
        if (e.ctrlKey && e.shiftKey && e.which == 65) {
            $('#txtjumlah').focus();
        } else if (e.ctrlKey && e.shiftKey && e.which == 90) {
            $('#simpan').click();
        }
    };


    let code = "";
    let reading = false;
    document.addEventListener('keypress', e => {
        //usually scanners throw an 'Enter' key at the end of read
        code += e.key; //while this is not an 'enter' it stores the every key            

        if (code.length > 5) {
            document.getElementById(code).selected = true;
            $('.selectpicker').selectpicker('refresh');
            loadmenu();
            setTimeout(() => {
                $('#txtjumlah').focus();
            }, 100);
            code = "";
        }
        //run a timeout of 200ms at the first read and clear everything
        if (!reading) {
            reading = true;
            setTimeout(() => {
                code = "";
                reading = false;
            }, 100);
        } //200 works fine for me but you can adjust it

    });

    $("#txtjumlah").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $("#txtjumlah").blur();
            $('#txttotal').focus();

            $('#simpan').click();
            // $('#txttotal').focus();
        }
    });
</script>