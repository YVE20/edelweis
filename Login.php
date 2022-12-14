<?php
    include "Koneksi.php";

    $sql2 = "select * from license where id='1'";
    $query2 = mysqli_query($con,$sql2);
    $res = mysqli_fetch_array($query2);

    $namausaha = $res['nama'];
    $icon = $res['icon'];
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="keyword" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $namausaha;?></title>

    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/icheck/skins/flat/aero.css" />
    <link href="node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="asset/css/style.css" rel="stylesheet">
    <!-- end: Css -->

    <link rel="shortcut icon" href="asset/img/icon.png">

    <style>
        body {
            margin: 0;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .form-signin-wrapper {
            background: white!important;
        }

        .form-signin .panel {
            background: #2196F3;
            background-image: linear-gradient(to bottom right, #2196F3, #48c6f0);
            /* box-shadow: [horizontal offset] [vertical offset] [blur radius] [optional spread radius] [color]; */
            box-shadow: 3px 2px 5px grey;
        }

        .footer{
            position: relative;
            margin-top: 100px;
            clear: both;
        }
    </style>
  </head>

    <body id="mimin" class="dashboard form-signin-wrapper">
        <div class="container">

            <form id="frmlogin" name="frmlogin" method="POST" enctype="multipart/form-data" autocomplete="off"
                class="form-signin">
                <div class="text-center">
                    <img src="asset/img/<?php echo $icon ?>" alt="logo" height="150">
                </div>

                <div class="panel periodic-login" style="margin-top:50px;">

                    <div class="panel-body text-center">
                        <h2><strong><?php echo $namausaha;?></strong></h2>

                        <!-- <i class="icons "></i> -->
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="text" class="form-text" id="txtusername" name="txtusername" required>
                            <span class="bar"></span>
                            <label>Username</label>
                        </div>
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="password" class="form-text" id="txtpassword" name="txtpassword" required>
                            <span class="bar"></span>
                            <label>Password</label>
                        </div>
                        <button type="submit" id="btnlogin" name="btnlogin" class="btn col-md-12 btn-round btn-default"
                            value="Sign In"><span class="glyphicon glyphicon-log-in" style="margin-right:5px;"></span> Sign
                            In</button>
                    </div>
                </div>
            </form>
            

        </div>

    <!-- end: Content -->
    <!-- start: Javascript -->
    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/jquery.ui.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>

    <script src="asset/js/plugins/moment.min.js"></script>
    <script src="asset/js/plugins/icheck.min.js"></script>

    <!-- <script src="asset/js/jquery.min.js"></script> -->
    <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>

    <!-- custom -->
    <script src="asset/js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_flat-aero',
                radioClass: 'iradio_flat-aero'
            });
        });


        $("#frmlogin").on('submit', (function (e) {
            e.preventDefault();
            // var tombol = $("#simpan").val();
            var user = $("#txtusername").val();
            var pass = $("#txtpassword").val();

            var formData = new FormData();
            formData.append('txtusername', user);
            formData.append('txtpassword', pass);

            $.ajax({
                url: "Uji Login.php",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data.trim() === "0") {
                        Swal.fire({
                            type: 'error',
                            title: 'Username atau Password Salah!',
                            allowOutsideClick: false


                        }).then((result) => {
                            if (result.value) {
                                window.location.href = "Login.php";
                            }
                        })
                    } else if (data.trim() === "Kasir" || data.trim() === "Supervisor") {
                        window.location.href = "frmtable.php";
                    } else {
                        window.location.href = "home.php";
                    }
                }
            });

        }));

        document.onkeyup = function (e) {
            //A = 65
            //Z = 90
            //a = 97
            //z = 122
            if (e.ctrlKey && e.altKey && e.shiftKey && e.which == 75) {
                //75 = K
                location.href = 'frmkoneksi.php';
            }
        };
    </script>
    <!-- end: Javascript -->
  </body>

</html>