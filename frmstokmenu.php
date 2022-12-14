<?php
    $menu_head = "master";
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
                            <h4>Form Tambah & Kurang Barang</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />

                                    <div class="form-group form-element">
                                        <label style="top:-10px;">Kategori</label>
                                        <div class="row">
                                            <label class="col-md-2">
                                                <input id="radiotambah" type="radio" name="kategori" checked/> Tambah Stok
                                            </label>
                                            <?php if ($_SESSION['status'] == "Owner" || $_SESSION['status'] == "Admin") { ?>
                                            <label class="col-md-2">
                                                <input id="radiokurang" type="radio" name="kategori"/> Kurangi / Lost Stok
                                            </label>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="form-group form-element">
                                        <label style="top:-10px;">Produk</label>
                                        <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbmenu" id="cmbmenu" onchange="loaddata();">
                                            <option value="" disabled selected> --Pilih Menu-- </option>
                                            <?php
                                                $sqlbahan = "SELECT * FROM tbmenu ORDER BY nama ASC";
                                                $querybahan = mysqli_query($con,$sqlbahan);
                                                while($res = mysqli_fetch_array($querybahan)){
                                                    $id = $res['id'];
                                                    $nama = $res['nama'];
                                                    $kode_barang = $res['kode_barang'];
                                                    ?>
                                                        <option value="<?php echo $id;?>" data-subtext="<?php echo $kode_barang;?>"> <?php echo $nama;?> </option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group form-animate-text">
                                        <input type="number" class="form-text" id="txtjumlah" name="txtjumlah" value="0" required>
                                        <span class="bar"></span>
                                        <label>Jumlah</label>
                                    </div>

                                    <div class="form-group form-element">
                                        <button type="button" class="submit btn btn-success" name="simpan" id="simpan" value="simpan" onclick="f_simpan(); return false;"> Save </button>
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
    function f_simpan() {
        var tombol = $("#simpan").val();
        var id = $("#txtid").val();
        var menu = $("#cmbmenu").val();
        var jumlah = $("#txtjumlah").val();

        var kategori = "";
        if (document.getElementById("radiotambah").checked == true) {
            kategori = "masuk";
        } else if (document.getElementById("radiokurang").checked == true) {
            kategori = "keluar";
            jumlah = parseInt(jumlah) * -1;
        }
        
        if (jumlah == "" || jumlah == null) {
            jumlah = "0";
        }

        if (menu != "") {
            $.post("savestokmenu.php", {
                    tombol: tombol,
                    id: id,
                    kategori: kategori,
                    menu: menu,
                    jumlah: jumlah
                })
                .done(function (data) {
                    loaddata();
                    $("#reset").click();
                });
        }
    }

    function f_bersih() {
        $("#simpan").val("simpan");
        $("#txtjumlah").val("0");
        $("#radiotambah").prop("checked", true);
    }

    function loaddata() {
        var idmenu = $("#cmbmenu").val();
        $.post("savestokmenu.php", {
                tombol: "tampil",
                menu : idmenu
            })
            .done(function (data) {
                $("#table").html(data);
            });
    }

    $(document).ready(function () {
        f_bersih();
    });
</script>
