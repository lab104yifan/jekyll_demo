<?php
    $problemno;
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
	<form action='problem.php', method="post" style="margin-left:160px; width:380px;">
	<label>ID:</label>
	<input class ="search" name = "searchid" value="" type="text" size = "30"/>
	<label style='margin-left:20px'>Name:</label>
	<input class ="search" name = "searchname" value="" type="text" size = "30"/>
	<input id = "searchbutton" type="submit" action="problem.php" value="Search" style="margin-left:20px;"/>
	</form>
	<div id = "pboard">
	    <?php
		$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
		mysql_select_db($DBNAME, $cn);
		$pagesize = 20;
		$rs = mysql_query("select count(*) from `problem`");
		$row = mysql_fetch_array($rs);
		$numrows = $row[0];
		$pages = intval($numrows / $pagesize);
		if ($numrows % $pagesize) $pages++;
		if (isset($_GET['page']))
		    $page = intval($_GET['page']);
	        else $page = 1;
		$offset = $pagesize * ($page - 1);
		$mesid = $_POST['searchid'];
		$mesname = $_POST['searchname'];
		$rs = mysql_query("select * from problem where id like '%$mesid%' and name like '%$mesname%' order by id asc");
		for ($i = 1; $i <= $offset; $i++) $row = mysql_fetch_array($rs);
		$i = 0;
		echo "<table id = 'ptable' border = '0'>";
		echo "<td align='center' width=150px height=35px style='font-size:20px;' class='title'> <strong>ID</strong> </td>";
		echo "<td align='center' width=550px height=35pxo style='font-size:20px;' class='title'> <strong>Problem</strong> </td>";
		if (isset($_SESSION['admin'])) 
		    echo "<td align='center' width=100px height=35pxo style='font-size:20px;' class='title'> <strong>Opption</strong> </td>";
		while ($row = mysql_fetch_array($rs)) {
		    echo "<tr align = 'center'>";
		    if ($i == $pagesize) break;
		    $id = $row['id'];
		    $name = $row['name'];
		    if ($i % 2) {
			echo "<td align='center' width=150px height = 29px class='odd'> <a href = 'oneproblem.php?problemno=$id' style='text-decoration:none'>$id </a> </td>";
			echo "<td align='center'width=550px height = 29px class = 'odd'> <a href = 'oneproblem.php?problemno=$id' style='text-decoration:none'>$name</a> </td>";
			if (isset($_SESSION['admin'])) {
			    echo "<td align='center' width=150px height = 29px class='odd'> <a href = 'modifyproblem.php?problemno=$id' style='text-decoration:none'>Modify</a> </td>";
			}
		    } else {
			echo "<td align='center' width=150px height = 29px class='even'> <a href = 'oneproblem.php?problemno=$id' style='text-decoration:none'>$id</a> </td>";
			echo "<td align='center'width=550px height = 29px class = 'even'> <a href = 'oneproblem.php?problemno=$id'style='text-decoration:none' >$name</a> </td>";
			if (isset($_SESSION['admin'])) {
			    echo "<td align='center' width=150px height = 29px class='even'><a href = 'modifyproblem.php?problemno=$id'style='text-decoration:none' > Modify </a></td>";
			}

		    }
		    $i++;
		    echo "</tr>";
		}
echo "</table>";
$pre = $page - 1;
if ($pre == 0) $pre = 1;
$next = $page + 1;
if ($next > $pages) $next = $pages;
echo "<div align ='center' id = 'pfooter'>";
echo "<a href = 'problem.php?page=1'><<</a>";
echo "<a href = 'problem.php?page=$pre'>pre</a>";
for ($i = 1; $i <= $pages; $i++)
echo "<a href = 'problem.php?page=$i'>[".$i."]</a>";
echo "<a href = 'problem.php?page=$next'>next</a>";
echo "<a href = 'problem.php?page=$pages'>>></a>";
echo "</div>";
mysql_close($cn);
?>
</div>
</div>
</div>
<?php
if(isset($_SESSION['admin'])) {
    echo "<div align='center' class = 'opbutton'>
	<p style='width:140px'><a href = 'addproblem.php'> Add Problem</a></p>
	</div>";
}
?>
<div id= "footer">
<?php include('footer.php'); ?>
</div>
</body>
</html>
