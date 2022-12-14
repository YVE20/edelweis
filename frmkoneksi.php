<!DOCTYPE html>
<html>
<head>
	<title> Form Koneksi </title>
	<link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css" />
	<script src="asset/js/jquery.min.js"> </script>
	<script src="asset/js/bootstrap.min.js"> </script>

	<script>

		$(function() {
	        rst();
	    });

	    function rst(){
	        $("#txtuser").val("root");
            $("#txtpass").val("");
            $("#txthost").val("localhost");
            $("#txtdatabase").val("");
	    }

	    function fsubmit(cmd){
	        var user = $("#txtuser").val();
	        var pass = $("#txtpass").val();
	        var host = $("#txthost").val();
	        var database = $("#txtdatabase").val();
	    	var json = {"host":host,"user":user,"pass":pass,"database":database,"cmd":cmd};
	    	var data = JSON.stringify(json);
	    	$.post("proseskoneksi.php",{
	    		data : data
	    	},function(data,ready){
	    		location.href = "Index.php";
	    	});
	    }

	</script>

</head>
<body>

<div class="container-fluid">

	<h2 class="page-header text-center"> Setting Koneksi </h2>

	<form name="frm" id="frm" class="col-md-10 col-md-offset-1">

		<input type="hidden" name="txtkode" id="txtkode">

		<div class="form-group">
			<label for="txthost"> Host : </label>
			<input type="text" name="txthost" id="txthost" class="form-control" placeholder="Host" tabindex="1" />
		</div>

		<div class="form-group">
			<label for="txtuser"> User : </label>
			<input type="password" name="txtuser" id="txtuser" class="form-control" placeholder="User" tabindex="1" />
		</div>

		<div class="form-group">
			<label for="txtpass"> Pass : </label>
			<input type="password" name="txtpass" id="txtpass" class="form-control" placeholder="Pass" tabindex="1" />
		</div>

		<div class="form-group">
			<label for="txtdatabase"> Database : </label>
			<input type="password" name="txtdatabase" id="txtdatabase" class="form-control" placeholder="Database" tabindex="1" />
		</div>

        <div class="form-group text-center row" style="margin-top:30px;">

        	<button type="button" name="btnsubmit" id="btnsubmit" value="Simpan" class="btn btn-info" onclick="fsubmit(this.value)"> <span class="glyphicon glyphicon-send" style="margin-right:10px"></span> Send </button>
        	<button type="button" name="btnreset" id="btnreset" value="Reset" class="btn btn-warning" onclick="location.href = 'Index.php'"> <span class="glyphicon glyphicon-refresh" style="margin-right:10px"></span> Reset </button>

        </div>

	</form>

</div>

</body>
</html>