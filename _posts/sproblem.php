<?php
    session_start();
    include('setting.php');
?>

<html>

<link rel= "stylesheet" href="images/Envision.css" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript" src="jquery-1.3.1.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#submitbutton').click(function() {
	var tmp = $('#smessage').val();
	if (tmp.length == 0) {
	    alert('Please input your code');
	    return false;
	}
	$('#go').click();
    });
});
</script>

<body class= "main">

<div id= "warp">
    <?php include('header.php'); ?>
    <?php include('menu.php'); ?>
</div>
<?php
$tmp = $_GET['problemno'];
echo"<form action='judge.php?problemno=$tmp' method='post' style='width:500px; margin-left:250px;'>";
?>
<div id= "sproblem">
<div id = "ssproblem">
<label style="font-size:16px"><strong>Please select your language:</strong></label></br>
<input type="radio" name = "lg" value ="C++"checked style='margin-top:10px'/><label>C++ 4.8.2</label></br>
<input type="radio" name = "lg" value ="ANSI C"/><label>ANSI C 4.8.2</label></br>
<input type="radio" name = "lg" value ="JAVA"/><label>JAVA 1.7.0</label></div>
<textarea id = "smessage" name = 'smessage'></textarea>
</div>

<div align = 'center' class = 'opbutton' style='margin-left:180px'>
<?php
$tmp = $_GET['problemno'];
echo"<p id = 'submitbutton'> <a href = 'javascript:void(0)'>Submit</a></p>
<p> <a href = 'oneproblem.php?problemno=$tmp'>Back</a></p>";
?>
<input type="submit" value="" id="go" style="width:1px; height:1px; visibility:hidden;"/>
</div>
</form>
<div id= "footer">
<?php include('footer.php'); ?>
</div>
</body>
</html>
