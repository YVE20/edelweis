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
                            <h4>Form Supplier</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <input type="hidden" name="txtid" id="txtid" />
                                  
                                    <div class="form-group form-animate-text">
                                        <input type="Text" class="form-text" id="txtnama" name="txtnama" required>
                                        <span class="bar"></span>
                                        <label>Nama</label>
                                    </div>
                                  
                                    <div class="form-group form-animate-text">
                                        <input type="Text" class="form-text" id="txtkontak" name="txtkontak" required>
                                        <span class="bar"></span>
                                        <label>Kontak</label>
                                    </div>
                                  
                                    <div class="form-group form-animate-text">
                                        <input type="Text" class="form-text" id="txtalamat" name="txtalamat" required>
                                        <span class="bar"></span>
                                        <label>Alamat</label>
                                    </div>
                                  
                                    <div class="form-group form-animate-text">
                                        <input type="Text" class="form-text" id="txtdeskripsi" name="txtdeskripsi" required>
                                        <span class="bar"></span>
                                        <label>Deskripsi</label>
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

  function f_simpan(){
      var tombol = $("#simpan").val();
      var nama = $("#txtnama").val();
      var kontak = $("#txtkontak").val();
      var alamat = $("#txtalamat").val();
      var deskripsi = $("#txtdeskripsi").val();
      var id = $("#txtid").val();

      if(tombol!="" && nama!="" && kontak!="" && alamat!="" && deskripsi!=""){
          $.post("savesupplier.php",{tombol:tombol,id:id,nama:nama,kontak:kontak,alamat:alamat,deskripsi:deskripsi})
              .done(function(data){
                  loaddata();
                  $("#reset").click();
              });
      }
  }

  function f_bersih(){
      $("#simpan").val("simpan");
      $("#txtnama").val("");
      $("#txtkontak").val("");
      $("#txtalamat").val("");
      $("#txtdeskripsi").val("");
  }

  function loaddata(){
      $.post("savesupplier.php",{tombol:"tampil"})
          .done(function(data){
              $("#table").html(data);
          });
  }
    function f_edit(id) {
        $("#reset").click();
        $.post("savesupplier.php", {
                tombol: "tampiledit",
                id: id
            })
            .done(function (data) {
                var pecah = data.split("|");
                $("#txtid").val(pecah[1]);
                $("#txtnama").val(pecah[2]);
                $("#txtkontak").val(pecah[3]);
                $("#txtalamat").val(pecah[4]);
                $("#txtdeskripsi").val(pecah[5]);
                
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
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {

                $.post("savesupplier.php", {
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
  
  $(document).ready(function(){
      loaddata();
  });
</script>
