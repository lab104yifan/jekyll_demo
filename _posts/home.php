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

<div id= "hboard">
<h3 id= "hmessage">
<?php
$f = fopen("hboard", "r");
while (!feof($f)) {
    $line = fgets($f);
    echo "$line <br/>";
}
fclose($f);
?>
</h3>
</div>
<?php
if (isset($_SESSION['admin'])) {
    echo "<div align='center' class = 'opbutton'>
	<p style='width:140px'> <a href = 'modifyhboard.php'> Edit </a></p>
	</div>";
}
?>
<div id= "footer">
<?php include('footer.php'); ?>
</div>
</body>
</html>
