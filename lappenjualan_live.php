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
                            <h4>Laporan Penjualan Live</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="get" action="">
                                    <h1 id="txtwaktu" style="text-align:center;"></h1>
                                    <div class="form-group form-element" style="text-align:center;">
                                        <input type="button" class="submit btn btn-info" name="btnpause" id="btnpause" value="Start" onclick="loadwaktu();" />
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

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txtwaktu').innerHTML = h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    var waktu;
    function loadwaktu() {
        var pause = $("#btnpause").val();
        if(pause == "Start"){
            f_search();
            waktu = setInterval(f_search, 10000);
            $("#btnpause").val("Pause");
        }else if(pause == "Pause"){
            clearInterval(waktu);
            $("#btnpause").val("Start");
        }
    }

    function f_search(){
        var jam = $("#txtwaktu").html();
//        alert(jam);
        $.post("tampilpenjualan_live.php",{tombol:"tampilcari",jam:jam})
            .done(function(data){
                $("#table").html(data);
        });
    }

  $(document).ready(function(){
      startTime();
      loadwaktu();
  });
</script>
