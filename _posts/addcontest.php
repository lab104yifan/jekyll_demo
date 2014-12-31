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
	$('#add').click(function() {
	    var addname = $('#addname').val();
	    var addd1 = $('#st').val();
	    var addd2 = $('#et').val();
	    if (addname.length == 0) {
		alert("Contest name is empty!");
		return false;
	    }
	    if (addd1.length == 0) {
		alert("Please select Startime");
		return false;
	    }if (addd2.length == 0) {
		alert("Please select Endtime");
		return false;
	    }
	    $("#go").click();
	    });
	});

</script>

<body class= "main">

<div id= "warp">
<?php include('header.php'); ?>
<?php include('menu.php'); ?>
</div>


<?php
if ($_POST['addname']) {
    if (!isset($_SESSION['isloggedin'])) {
	exit(0);
    } else {
	if ($_SESSION['admin'] != true) {
	    exit(0);
	}
    }
    $cn = mysql_connect('localhost', $DBUSER, $DBPASS);
    mysql_select_db($DBNAME, $cn);
    $rs = mysql_query("select count(*) from contest");
    $row = mysql_fetch_array($rs);
    $id = $row[0] + 1001;
    $name = $_POST['addname'];
    $d1 = $_POST['st'];
    $d2 = $_POST['et'];
    mysql_query("insert into contest (id, name, starttime, endtime) values('$id', '$name', '$d1', '$d2')");
    mysql_close($cn);
    echo"<script>alert('Add contest success')</script>";
    echo"<meta http-equiv='Refresh' content='0; URL=contest.php'/>";
}
?>

<form action="addcontest.php" method="post", style="width:715px; margin-left:150px; margin-top:15px;" enctype="multipart/form-data">
<div id= "oneproblem" style="margin-left:0px">

<table border = '0' id = 'optable' style='margin-left:270px'>

<tr style="font-size:20px">
<td style="width:300px"><strong>Contest Name </strong></td>
</tr>
<tr>
<td style="width:300px"><input style="width:135px" id = "addname" name="addname"/></td>
</tr>

<tr class = 'title'><td><strong>Start Time </strong></td></tr>
<tr><td><input type='date' name='st' id = 'st'> </input></td></tr>
<tr class = 'title'><td><strong>End Time</strong></td></tr>
<tr><td><input type='date' name='et' id = 'et'> </input></td></tr>
</table>

</div>
<div align = 'center' class = 'opbutton' style = "margin-left:270px;">
<p id = 'add'> <a href = "javascript:void(0)">Add</a></p>
<p> <a href = 'contest.php'>Cencel</a></p>
<input type="submit", value="", id="go", style="visibility:hidden; height:1px; width:1px"/>
</div>
</form>

<div id= "footer">
<?php include('footer.php'); ?>
</div>
</body>
</html>
