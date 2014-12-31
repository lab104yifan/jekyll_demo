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
	    var addd1 = $('#addd1').val();
	    var addd2 = $('#addd2').val();
	    var addd3 = $('#addd3').val();
	    var addd4 = $('#addd4').val();
	    var addd5 = $('#addd5').val();
	    if (addname.length == 0) {
		alert("Problem name is empty!");
		return false;
	    }
	    if (addd1.length == 0) {
		alert("Describe is empty!");
		return false;
	    }if (addd2.length == 0) {
		alert("Input is empty!");
		return false;
	    }if (addd3.length == 0) {
		alert("Output is empty!");
		return false;
	    }if (addd4.length == 0) {
		alert("Sample Input is empty!");
		return false;
	    }if (addd5.length == 0) {
		alert("Sample Output is empty!");
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
    $id = $_GET['problemno'];
    $name = $_POST['addname'];
    $inf = $_FILES['infile']['name'];
    $outf = $_FILES['outfile']['name'];
    $d1 = $_POST['addd1'];
    $d2 = $_POST['addd2'];
    $d3 = $_POST['addd3'];
    $d4 = $_POST['addd4'];
    $d5 = $_POST['addd5'];
    mysql_query("update `problem` set name = '$name', d1 = '$d1', d2 = '$d2', d3 = '$d3', d4 = '$d4', d5 = '$d5' where id='$id'");
    closedir($handle);

    if (is_uploaded_file($_FILES['infile']['tmp_name']) && is_uploaded_file($_FILES['outfile']['tmp_name'])) {
	move_uploaded_file($_FILES["infile"]["tmp_name"], "./problems/$id/in");
	move_uploaded_file($_FILES["outfile"]["tmp_name"], "./problems/$id/out");
    }
    echo"<script>alert('Modify problem success')</script>";
    echo"<meta http-equiv='Refresh' content='0; URL=problem.php'/>";
    mysql_close($cn);
}
?>

<?php
$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
mysql_select_db($DBNAME, $cn);
$id = $_GET['problemno'];
$rs = mysql_query("select * from problem where id = '$id'");
$pb = mysql_fetch_array($rs);
$name = $pb['name'];
$d1 = $pb['d1'];
$d2 = $pb['d2'];
$d3 = $pb['d3'];
$d4 = $pb['d4'];
$d5 = $pb['d5'];

echo "<form action='modifyproblem.php?problemno=$id' method='post', style='width:715px; margin-left:150px; margin-top:15px;' enctype='multipart/form-data'>";
mysql_close($cn);
?>
<div id= "oneproblem" style="margin-left:0px">

<table border = '0', style="width:700px">

<tr style="font-size:20px">
<td style="width:300px"><strong>Problem Name </strong></td>
<td style="width:200px"><strong>InPutFile</strong></td>
<td style="width:200px"><strong>OutPutFile</strong></td>
</tr>

<tr>
<?php echo"
<td style='width:300px'><input style='width:135px' id = 'addname' name='addname' value='$name'/></td>";
?>
<td style="width:200px"><input type="file" style="width:235px" id = "infile" name="infile"/></td>
<td style="width:200px"><input type="file" style="width:235px" id = "outfile" name="outfile"/></td>
</tr>
</table>

<table border = '0' id = 'optable'>
<tr class = 'title'><td><strong>Describe </strong></td></tr>
<tr class = 'desc'><td><textarea id = "addd1" name="addd1">
<?php echo"$d1" ?>
</textarea></td></tr>
<tr class = 'title'><td><strong>Input </strong></td></tr>
<tr class = 'desc'><td><textarea id = "addd2" name="addd2">
<?php echo"$d2" ?>
</textarea></td></tr>
<tr class = 'title'><td><strong>Output </strong></td></tr>
<tr class = 'desc'><td><textarea id = "addd3" name="addd3">
<?php echo"$d3" ?>
</textarea></td></tr>
<tr class = 'title'><td><strong>Sample Input </strong></td></tr>
<tr class = 'desc'><td><textarea id = "addd4" name="addd4">
<?php echo"$d4" ?>
</textarea></td></tr>
<tr class = 'title'><td><strong>Sample Output</strong></td></tr>
<tr class = 'desc'><td><textarea id = "addd5" name="addd5">
<?php echo"$d5" ?>
</textarea></td></tr>
</table>

</div>
<div align = 'center' class = 'opbutton' style = "margin-left:280px;">
<p id = 'add'> <a href = "javascript:void(0)">Modify</a></p>
<p> <a href = 'problem.php'>Cencel</a></p>
<input type="submit", value="", id="go", style="visibility:hidden; height:1px; width:1px"/>
</div>
</form>

<div id= "footer">
<?php include('footer.php'); ?>
</div>
</body>
</html>
