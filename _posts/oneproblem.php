<?php
    session_start();
    include('setting.php');
?>

<html>

<link rel= "stylesheet" href="images/Envision.css" type="text/css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<body class= "main">

<div id= "warp">
    <?php include('header.php'); ?>
    <?php include('menu.php'); ?>
</div>

<div id= "oneproblem">
<table border = '0' id = 'optable'>
<?php
$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
mysql_select_db($DBNAME, $cn);
$tmp = $_GET['problemno'];
$rs = mysql_query("select * from problem where id = '$tmp'");
$pb = mysql_fetch_array($rs);
$name = $pb['name'];
$d1 = $pb['d1'];
$d2 = $pb['d2'];
$d3 = $pb['d3'];
$d4 = $pb['d4'];
$d5 = $pb['d5'];
$d1 = str_replace("\r\n","<br/>",$d1);
$d2 = str_replace("\r\n","<br/>",$d2);
$d3 = str_replace("\r\n","<br/>",$d3);
$d4 = str_replace("\r\n","<br/>",$d4);
$d5 = str_replace("\r\n","<br/>",$d5);
echo"
<tr class = 'desc' align='center' style='font-size:30px'><td><strong>$name"; echo"</strong></td></tr>
<tr class = 'title'><td><strong>Describe </strong></td></tr>
<tr class = 'desc'><td>$d1"; echo"</td></tr>
<tr class = 'title'><td><strong>Input </strong></td></tr>
<tr class = 'desc'><td>$d2"; echo"</td></tr>
<tr class = 'title'><td><strong>Output </strong></td></tr>
<tr class = 'desc'><td>$d3"; echo"</td></tr>
<tr class = 'title'><td><strong>Sample Input </strong></td></tr>
<tr class = 'desc'><td>$d4"; echo"</td></tr>
<tr class = 'title'><td><strong>Sample Output</strong></td></tr>
<tr class = 'desc'><td>$d5"; echo"</td></tr>";
?>
</table>
</div>
<div align = 'center' class = 'opbutton'>
<?php
$tmp = $_GET['problemno'];
echo "<p> <a href = 'sproblem.php?problemno=$tmp'>Submit</a></p>
<p> <a href = 'disscuss.php?problemno=$tmp'>Disscuss</a></p>";
?>
</div>

<div id= "footer">
<?php include('footer.php'); ?>
</div>
</body>
</html>
