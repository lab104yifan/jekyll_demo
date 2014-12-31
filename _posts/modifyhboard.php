<?php
    session_start();
    include('setting.php');
?>

<html>
<head>

<link rel= "stylesheet" href="images/Envision.css" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript" src="jquery-1.3.1.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#submit').click(function() {
	var tmp = $('#mhboard').val();
	$.post("modifynext.php", {message: tmp}, function(data) {
	    if (data == "0") {
		alert("You shound login");
		window.location.href ='login.php';
	    }
	    else if (data == "1") {
		alert("You isn't admin");
		window.location.href ='home.php';
	    }
	    else {
		alert("Modify success");
		window.location.href ='home.php';
	    }
	});
    });
});
</script>
</head>

<body class= "main">

<div id= "warp">
<?php include('header.php'); ?>
<?php include('menu.php'); ?>
</div>

<textarea class = "submitboard" id = "mhboard"> <?php 
readfile("hboard");
?></textarea>

<div align='center' class = 'opbutton'>
<p id = 'submit'> <a href="javascript:void(0)"> Save </a></p>
<p> <a href = 'home.php'> Cencel </a></p>
</div>
<div id= "footer">
<?php include('footer.php'); ?>
</div>
</body>
</html>
