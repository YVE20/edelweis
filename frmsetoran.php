<?php
    $menu_head = "kas";
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
                            <h4>Form Setoran</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />

                                    <div class="form-group form-element">
                                        <label style="top:-10px;">Shift</label>
                                        <select class="form-control col-md-7 col-xs-12 combobox" name="cmbshift" id="cmbshift">
                                            <option value="1"> Shift 1 </option>
                                            <option value="2"> Shift 2 </option>
                                            <option value="3"> Shift 3 </option>
                                            <option value="Lembur"> Shift Lembur </option>
                                        </select>
                                    </div>

                                    <div class="form-group form-animate-text">
                                        <label style="top:-10px;font-size:14px;">Tanggal</label>
                                        <input type="date" class="form-text" id="txttanggal" name="txttanggal" required onblur="loaddata();">
                                        <span class="bar"></span>
                                    </div>

                                    <div class="form-group form-animate-text">
                                        <input type="text" onkeyup="jumlah()" class="form-text" id="txtjumlah" name="txtjumlah" value="0" required>
                                        <span class="bar"></span>
                                        <label>Jumlah</label>
                                    </div>

                                    <div class="form-group form-element">
                                        <button type="button" class="submit btn btn-success" name="simpan" id="simpan" value="simpan" onclick="f_simpan(); return false;"> Save </button>
                                        <button type="button" class="submit btn btn-primary" name="reset" id="reset" value="simpan" onclick="f_bersih();"> Reset </button>
                                    </div>
                                </form>

                            </div>
                            <?php
                                if ($_SESSION['status'] == "Owner" || $_SESSION['status'] == "Admin") {
                                    ?>
                                         <div  class="col-md-12" id="table" name="table"></div>
                                    <?php
                                }
                            ?>
                           
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
        var tanggal = $("#txttanggal").val();
        var shift = $("#cmbshift").val();
        var jumlah = $("#txtjumlah").val().replace(/\./g, "");

        if (jumlah == "" || jumlah == null) {
            jumlah = "0";
        }

        if (tanggal != "" && shift != "" && jumlah != 0) {
            $.post("savesetoran.php", {
                    tombol: tombol,
                    id: id,
                    jumlah: jumlah,
                    tanggal: tanggal,
                    shift: shift
                })
                .done(function (data) {                    
                    Swal.fire(
                        'Added!',
                        'Data Berhasil Ditambahkan',
                        'success'
                    )
                    $("#reset").click();
                    loaddata();
                });

        } else {
            Swal.fire({
                type: 'error',
                title: 'Oops... ',
                text: 'Jumlah masih kosong!'
            });
        }
    }

    function f_bersih() {
        $("#simpan").val("simpan");
        $("#txtjumlah").val("0");
        $("#cmbshift").val(1);
        document.getElementById('txttanggal').valueAsDate = new Date();
    }

    function loaddata() {
        var tanggal = $("#txttanggal").val();
        $.post("savesetoran.php", {
                tombol: "tampil",
                tanggal: tanggal
            })
            .done(function (data) {
                $("#table").html(data);
            });
    }

    function f_edit(id) {
        $("#reset").click();
        $.post("savesetoran.php", {
                tombol: "tampiledit",
                id: id
            })
            .done(function (data) {
                var pecah = data.split("|");
                // "|".$id."|".$tanggal."|".$jumlah."|".$shift."|";
                // var jumlah_;
                $("#txtid").val(pecah[1]);
                $("#txttanggal").val(pecah[2]);
                // $("#txtjumlah").val(pecah[3]);
                $("#txtjumlah").val(formatRupiah(pecah[3].toString()));
                $("#cmbshift").val(pecah[4]);

                $("#simpan").val("edit");
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
                $.post("savesetoran.php", {
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
        // if (confirm("Hapus data ini?") == true) {
        //     $.post("savesetoran.php", {
        //             tombol: "hapus",
        //             id: id
        //         })
        //         .done(function (data) {
        //             loaddata();
        //         });
        // }
    }

    function jumlah() {
        total = $("#txtjumlah").val().replace(/\./g, "");
        $("#txtjumlah").val(formatRupiah(total.toString()));
    }

    $(document).ready(function () {
        f_bersih();
        loaddata();
    });
</script>
