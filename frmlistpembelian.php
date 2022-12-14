<?php
    $menu_head = "pembelian";
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
                            <h4>Daftar Pembelian</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;padding-top:30px;">
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

    function f_load(){
        $.post("savepembelian.php",{tombol:"tampillistpembelian"})
            .done(function(data){
                $("#table").html(data);
        });
    }

    function f_approvepo(id){
        location.href = "frmpembelian.php?act=approve&id="+id;
    }
    
    $(document).ready(function(){
        f_load();
    });
</script>
