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
                            <h4>Form User</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />
                                    <div class="form-group form-animate-text">
                                        <input type="text" class="form-text" id="txtnama" name="txtnama" required>
                                        <span class="bar"></span>
                                        <label>Nama</label>
                                    </div>

                                    <div class="form-group form-animate-text">
                                        <input type="text" class="form-text" id="txtusername" name="txtusername" required>
                                        <span class="bar"></span>
                                        <label>Username</label>
                                    </div>

                                    <div class="form-group form-animate-text">
                                        <input type="password" class="form-text" id="txtpassword" name="txtpassword" required>
                                        <span class="bar"></span>
                                        <label>Password</label>
                                    </div>
                                    
                                    <div class="form-group form-element">
                                        <button type="button" class="submit btn btn-success" name="simpan" id="simpan" value="simpan" onclick="f_simpan(); return false;"> Save </button>
                                        <button type="reset" class="submit btn btn-primary" name="reset" id="reset" value="simpan" onclick="f_bersih();"> Reset </button>
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
        var nama = $("#txtnama").val();
        var username = $("#txtusername").val();
        var password = $("#txtpassword").val();
        var status = $("#cmbstatus").val();

        if (nama != "" && username != "" && password != "") {
            $.post("saveuser.php", {
                    tombol: tombol,
                    id: id,
                    nama: nama,
                    username: username,
                    password: password,
                    status: status
                })
                .done(function (data) {
                    loaddata();
                    $("#reset").click();
                });
        }
    }

    function f_bersih() {
        $("#simpan").val("simpan");
        $("#cmbstatus").val("user");
    }

    function loaddata() {
        $.post("saveuser.php", {
                tombol: "tampil"
            })
            .done(function (data) {
                $("#table").html(data);
            });
    }

    function f_edit(id) {
        $("#reset").click();
        $.post("saveuser.php", {
                tombol: "tampiledit",
                id: id
            })
            .done(function (data) {
                var pecah = data.split("|");
                $("#txtid").val(pecah[1]);
                $("#txtnama").val(pecah[2]);
                $("#txtusername").val(pecah[3]);
                $("#txtpassword").val(pecah[4]);
                $("#cmbstatus").val(pecah[5]);
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
                $.post("saveuser.php", {
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
