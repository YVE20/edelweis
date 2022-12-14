<?php
$menu_head = "penjualan";
include "Header.php";
?>
<div id="content">
    <div class="panel box-shadow-none content-header">
    </div>
    <div class="form-element">
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="col-md-12 panel">
                    <div class="col-md-12 panel-heading">
                        <h4>Daftar Penjualan</h4>
                    </div>
                    <div class="col-md-12 panel-body" style="padding-bottom:30px;padding-top:30px;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group form-animate-text">
                                    <label style="top:-10px;font-size:14px;">Tanggal Transaksi</label>
                                    <input type="date" class="form-text" id="txttanggal" name="txttanggal">
                                    <span class="bar"></span>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top:35px">
                                <button type="button" class="submit btn btn-info" name="btnsearch" id="btnsearch" value="search" onclick="f_load();"> Search </button>
                            </div>
                            <div class="col-md-4 text-right" style="margin-top:35px">
                                <button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Buat Transaksi" onclick="f_create_transaction()"><span class="fa fa-plus"></span> Buat Transaksi</button>
                            </div>
                        </div>
                        <div class="col-md-12" id="table" name="table">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Footer.php"; ?>

<script>
    function f_load() {
        let tanggal = $('#txttanggal').val();
        if (tanggal == "") {
            return Swal.fire({
                type: 'error',
                title: 'Oops... Tanggal Belum Dipilih!',
                text: 'Pilih Tanggal Lebih Dulu.'
            });
        }

        $.post("savepenjualan.php", {
                tombol: "tampillistpenjualan",
                tanggal: tanggal
            })
            .done(function(data) {
                $("#table").html(data);
                return;
            });
    }

    function f_create_transaction() {
        location.href = "frmpenjualan.php?act=new&id=";
    }

    $(document).ready(function() {
        document.getElementById('txttanggal').valueAsDate = new Date();
        f_load();
    });
</script>