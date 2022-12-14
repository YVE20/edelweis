<?php

?>



<!-- start: Javascript -->
<script src="asset/js/jquery.ui.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>

<!-- plugins -->
<script src="asset/js/plugins/moment.min.js"></script>
<script src="asset/js/plugins/icheck.min.js"></script>
<script src="node_modules/select2/dist/js/select2.min.js"></script>
<script src="asset/plugins/jsloadimg/js/load-image.all.min.js"></script>

<!--Datatables-->
<script src="asset/js/plugins/jquery.datatables.min.js"></script>
<script src="asset/js/plugins/datatables.bootstrap.min.js"></script>
<script src="asset/js/plugins/dataTables.select.min.js"></script>
<script src="asset/js/plugins/dataTables.responsive.min.js"></script>
<script src="asset/js/plugins/dataTables.rowReorder.min.js"></script>
<script src="asset/js/plugins/jszip/dist/jszip.min.js"></script>
<script src="asset/js/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="asset/js/plugins/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="asset/js/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="asset/js/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="asset/js/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="node_modules/pdfmake/build/pdfmake.min.js"></script>
<script src="node_modules/pdfmake/build/vfs_fonts.js"></script>

<!--Datatables End-->
<script src="asset/js/plugins/fullcalendar.min.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>
<script src="asset/js/plugins/jquery.vmap.min.js"></script>
<script src="asset/js/plugins/maps/jquery.vmap.world.js"></script>
<script src="asset/js/plugins/jquery.vmap.sampledata.js"></script>
<script src="asset/js/plugins/chart.min.js"></script>
<script src="asset/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="asset/plugins/colorbox/jquery.colorbox-min.js"></script>
<script src="asset/plugins/accounting/accounting.min.js"></script>
<script src="asset/plugins/accounting/accounting.min.js"></script>
<script src="asset/plugins/fontawesome/js/solid.min.js"></script>
<script src="asset/jquerymask/dist/jquery.mask.min.js"></script>
<script src="asset/js/accounting.min.js"></script>
<script src="asset/js/angka-terbilang.min.js"></script>
<script src="node_modules/alertifyjs/build/alertify.min.js"></script>
<script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="node_modules/chart.js/dist/Chart.min.js"></script>
<script src="node_modules/print-js/dist/print.js"></script>

<!-- custom -->
<script src="asset/js/main.js"></script>
<script src="asset/function/functions.js"></script>

<script type="text/javascript">
    // var pajak_global=0;

    function f_tonumber(param) {
        let value = $("#" + param).val();
        $("#" + param).val(accounting.unformat(value, ','));
    }

    function f_tocurrency(param) {
        let value = $("#" + param).val();
        $("#" + param).val(accounting.formatNumber(value, 0, ".", ","));
    }

    function test(t) { //defining a function
        if (t === undefined) { //if t=undefined, call tt
        }
        return t;
    }


    function f_print(idjual, value, reload) {
        $.post("savepenjualan.php", {
                tombol: "print_faktur_recta",
                value: value,
                idjual: idjual
            })
            .done(function(data) {
                var pecah_id = idjual.split("-");

                var pecah = data.split("|");

                var kode_printer = pecah[1];
                var namaperusahaan = pecah[2];
                var tglwaktu = pecah[3];
                var meja = pecah[4];
                var namakaryawan = pecah[5];
                var detil = pecah[6];
                var grandtotal = pecah[7];
                var instagram = pecah[8];
                var alamat = pecah[9];
                var detil2 = pecah[10];
                var pecah_detil = detil.split('*');


                var hasilloopingdetil = "";

                for (var i = 0; i < (pecah_detil.length - 1); i++) {
                    var loopingdetil = pecah_detil[i].split("#");

                    hasilloopingdetil += "" +
                        "<tr>" +
                        "<td colspan=3 style=\"max-width:160px !important;width:160px !important;\"> " + loopingdetil[0] + " </td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td width=\"85px\"> " + loopingdetil[1] + "  x  Rp " + loopingdetil[2] + " </td>" +
                        "<td colspan=\"2\" style=\"text-align: right;\"> Rp " + loopingdetil[3] + " </td>" +
                        "</tr>";
                }

                $('<iframe>', {
                        name: 'faktur',
                        class: 'cetakfaktur',
                        style: 'display:none;max-width:160px !important;width:160px !important;'
                        // style: 'display:none;max-width:300px !important;width:300px !important;'
                    })
                    .appendTo('body')
                    .contents().find('body')
                    .append(`
                    <table style="width:160px !important;border:none;font-size:8pt;font-family: Sans-Serif !important;">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td colspan=3 style="max-width:160px !important;width:160px !important;text-align:center;font-size:16px !important;font-weight:bold;"> ` + namaperusahaan + ` </td>
                        </tr>
                        <tr>
                            <td colspan=3 style="max-width:160px !important;width:160px !important;text-align:center;"> ` + alamat + ` </td>
                        </tr>
                        <tr>
                            <td colspan=3 style="max-width:160px !important;width:160px !important;text-align:center;"> ------------------------------------------- </td>
                        </tr>
                        <tr>
                            <td colspan=3 style="max-width:160px !important;width:160px !important;"> Kode : ` + pecah_id[4] + ` </td>
                        </tr>
                        <tr>
                            <td colspan=3 style="max-width:160px !important;width:160px !important;"> ` + tglwaktu + ` </td>
                        </tr>
                        <tr>
                            <td colspan=3 style="max-width:160px !important;width:160px !important;text-align:center;"> ------------------------------------------- </td>
                        </tr>

                        ` + hasilloopingdetil + `

                        <tr>
                            <td colspan=3 style="max-width:160px !important;width:160px !important;text-align:center;"> ------------------------------------------- </td>
                        </tr>
                        <tr>
                            <td width="85px" style="text-align: right;font-weight: bold;"> Total </td>
                            <td colspan="2" style="text-align: right;font-weight: bold;"> Rp ` + grandtotal + ` </td>
                        </tr>
                        <tr>
                            <td colspan=3 style="max-width:160px !important;width:160px !important;text-align:center;padding-top:10px;font-weight:bold;"> "Terimakasih telah mengunjungi toko kami. Silahkan datang kembali."</td>
                        </tr>
                        
                    </table>
                `);


                setTimeout(() => {
                    window.frames['faktur'].focus();
                    window.frames['faktur'].print();
                }, 500);

                setTimeout(() => {
                    $(".cetakfaktur").remove();
                    window.location.href = "frmpenjualan.php?act=new&id=";
                }, 1000);

            });
    }

    


    $(document).ready(function() {
        var page = '<?php echo $menu_head ?>';
        // Optimalisation: Store the references outside the event handler:
        var $window = $(window);

        function checkWidth() {
            var windowsize = $window.width();
            if (windowsize <= 1050) {
                $('#content').animate({
                    'padding-left': '0px'
                }, 'slow');
                $('#left-menu .sub-left-menu').animate({
                    'width': '0px'
                }, 'slow', function() {
                    $('.overlay').show();
                    $('.opener-left-menu').removeClass('is-open');
                    $('.opener-left-menu').addClass('is-closed');
                    $('#left-menu .sub-left-menu').hide();
                });

                $('#right-menu').animate({
                    'width': '0px'
                }, 'slow', function() {
                    $('#right-menu').hide();
                });
            } else {
                $('#left-menu .sub-left-menu').show();
                $('#left-menu .sub-left-menu').animate({
                    'width': '230px'
                }, 'slow');
                $('#content').animate({
                    'padding-left': '230px',
                    'padding-right': '0px'
                }, 'slow');
                $('.overlay').hide();
                $('.opener-left-menu').removeClass('is-closed');
                $('.opener-left-menu').addClass('is-open');
                $('.opener-left-menu').show();
            }
        }
        // Execute on load
        checkWidth();
        // Bind event listener
        // $(window).resize(checkWidth);
    });

    // $(".get-nicer").niceScroll("div.left-menu", {
    //         cursorwidth: "5px"
    // }); 
</script>
<!-- end: Javascript -->
</body>

</html>