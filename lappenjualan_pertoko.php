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
                            <h4>Laporan Penjualan Konsumen</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;font-size:14px;">Tanggal Mulai</label>
                                                <input type="date" class="form-text" id="txttanggalmulai" name="txttanggalmulai">
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-animate-text">
                                                <label style="top:-10px;font-size:14px;">Tanggal Selesai</label>
                                                <input type="date" class="form-text" id="txttanggalselesai" name="txttanggalselesai">
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-element" style="margin-top:10px">
                                                <label style="top:-10px;">Konsumen</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbkonsumen" id="cmbkonsumen">
                                                    <option value="ALL" selected> Semua Konsumen </option>
                                                    <?php
                                                    $sqlmenu = "SELECT * FROM tbkonsumen ORDER BY nama ASC";
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
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4" style="display:none;">
                                            <div class="form-group form-element">
                                                <label style="top:-10px;">Rute</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbrute" id="cmbrute">
                                                    <option value="ALL" selected> Semua Rute </option>
                                                    <?php
                                                    $sqlmenu = "SELECT rute FROM `tbkonsumen` GROUP BY rute ORDER BY rute ASC";
                                                    $querymenu = mysqli_query($con,$sqlmenu);
                                                    while($res = mysqli_fetch_array($querymenu)){
                                                        $rute = $res['rute'];
                                                        ?>
                                                        <option value="<?php echo $rute;?>"> <?php echo $rute;?> </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="display:none;">
                                            <div class="form-group form-element">
                                                <label style="top:-10px;">Transaksi</label>
                                                <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-size="5" name="cmbtransaksi" id="cmbtransaksi">
                                                    <option value="ada" selected> Ada Transaksi</option>
                                                    <option value="tidak" selected> Tidak Ada Transaksi </option>
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
    let $konsumen = $("#cmbkonsumen");
    let $rute = $("#cmbrute");
    let $transaksi = $("#cmbtransaksi");

    function f_bersih() {
        $("#btnsearch").val("search");
        $konsumen.val("ALL");
        $rute.val("ALL");
        $transaksi.val("ada");
        document.getElementById('txttanggalmulai').valueAsDate = new Date();
        document.getElementById('txttanggalselesai').valueAsDate = new Date();
        $('.selectpicker').selectpicker('refresh');
    }

    function f_search() {
        var tanggalmulai = $("#txttanggalmulai").val();
        var tanggalselesai = $("#txttanggalselesai").val();

        if (tanggalmulai == "") {
            tanggalmulai = tanggalselesai;
        }
        if (tanggalselesai == "") {
            tanggalselesai = tanggalmulai;
        }

        $.post("tampilpenjualan_pertoko.php", {
                tombol: "tampilcari",
                konsumen: $konsumen.val(),
                rute: $rute.val(),
                transaksi: $transaksi.val(),
                tanggalmulai: tanggalmulai,
                tanggalselesai: tanggalselesai
            })
            .done(function (data) {
                $("#table").html(data);
            });
    }

    $(document).ready(function () {
        f_bersih();
    });
</script>
