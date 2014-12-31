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

<div id= "problem">
    <div id = "pmenu">
	<form action='problem.php', method="post" style="margin-left:160px; width:219px;">
	<input class ="search" name = "search" value="" type="text" size = "30"/>
	<input id = "searchbutton" type="submit" action="problem.php" value="Search" style="float left; margin-left:10px;"/>
	</form>
	<div id = "pboard">
	    <?php
		$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
		mysql_select_db($DBNAME, $cn);
		$pagesize = 10;
		$rs = mysql_query("select count(*) from user where type is null");
		$row = mysql_fetch_array($rs);
		$numrows = $row[0];
		$pages = intval($numrows / $pagesize);
		if ($numrows % $pagesize) $pages++;
		if (isset($_GET['page']))
		    $page = intval($_GET['page']);
	        else $page = 1;
		$offset = $pagesize * ($page - 1);
		$rs = mysql_query("select * from user where type is null order by id asc");
		for ($i = 1; $i <= $offset; $i++) $row = mysql_fetch_array($rs);
		$i = 0;
		echo "<table border='0' id = 'ptable'>";
		echo "<td align='center' width=100px height=35px style='font-size:20px;'> <strong>ID</strong> </td>";
		echo "<td align='center' width=100px height=35px style='font-size:20px;'> <strong>Password</strong> </td>";
		echo "<td align='center' width=100px height=35px style='font-size:20px;'> <strong>Name</strong> </td>";
		echo "<td align='center' width=100px height=35px style='font-size:20px;'> <strong>School</strong> </td>";
		echo "<td align='center' width=100px height=35px style='font-size:20px;'> <strong>Email</strong> </td>";
		echo "<td align='center' width=100px height=35px style='font-size:20px;'> <strong>Opption</strong> </td>";
		while ($row = mysql_fetch_array($rs)) {
		    echo "<tr align = 'center'>";
		    if ($i == $pagesize) break;
		    $id = $row['id'];
		    $password = $row['password'];
		    $name = $row['name'];
		    $school = $row['school'];
		    $email = $row['email'];
		    echo "<td align='center' width=100px height = 29px> $id </td>";
		    echo "<td align='center'width=100px height = 29px> $password </td>";
		    echo "<td align='center'width=100px height = 29px> $name </td>";
		    echo "<td align='center'width=100px height = 29px> $school </td>";
		    echo "<td align='center'width=100px height = 29px> $email </td>";
		    echo "<td align='center'width=100px height = 29px>";
		    $i++;
		    echo "</tr>";
		}
		for (;$i <= $pagesize; $i++) echo"<tr></tr>";
		echo "</table>";
		$pre = $page - 1;
		if ($pre == 0) $pre = 1;
		$next = $page + 1;
		if ($next > $pages) $next = $pages;
		echo "<div align ='center' id = 'pfooter'>";
		echo "<a href = 'user.php?page=1'><<</a>";
		echo "<a href = 'user.php?page=".$pre." - 1'>pre</a>";
		for ($i = 1; $i <= $pages; $i++)
		    echo "<a href = 'user.php?page=".$i."'>[".$i."]</a>";
		echo "<a href = 'user.php?page=".$next."'>next</a>";
		echo "<a href = 'user.php?page=".$pages."'>>></a>";
		echo "</div>";
		mysql_close($cn);
	    ?>
	</div>
    </div>
</div>

<div id= "footer">
    <?php include('footer.php'); ?>
</div>
</body>
</html>
