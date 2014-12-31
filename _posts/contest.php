<?php
    $contestno;
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
	<form action='contest.php', method="post" style="margin-left:160px; width:560px;">
	<label>ID:</label>
	<input class ="search" name = "searchid" value="" type="text" size = "30"/>
	<label style='margin-left:20px'>Name:</label>
	<input class ="search" name = "searchname" value="" type="text" size = "30"/>
	<label style='margin-left:20px'>Status:</label>
	<select class = "search" name = "searchst" style="margin-left:8px">
	<option value="">Select</option>
	<option value="Scheduled">Scheduled</option>
	<option value="Runing">Runing</option>
	<option value="Ended">Ended</option>
	</select>
	<input id = "searchbutton" type="submit" action="problem.php" value="Search" style="margin-left:20px;"/>
	</form>
	<div id = "pboard">
	    <?php
		$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
		mysql_select_db($DBNAME, $cn);
		$pagesize = 20;
		$rs = mysql_query("select count(*) from contest");
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
		$messt = $_POST['searchst'];
		$nt = date("Y-m-d H:i:s", time());
		$rs = mysql_query("select * from contest where id like '%$mesid%' and name like '%$mesname%' order by id asc");
		for ($i = 1; $i <= $offset; $i++) $row = mysql_fetch_array($rs);
		$i = 0;
		echo "<table id = 'ptable' border = '0'>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>ID</strong> </td>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>Contest</strong> </td>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>StartTime</strong> </td>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>EndTime</strong> </td>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>Status</strong> </td>";
		if (isset($_SESSION['admin'])) 
		    echo "<td align='center' width=100px height=35pxo style='font-size:20px;' class='title'> <strong>Opption</strong> </td>";
		while ($row = mysql_fetch_array($rs)) {
		    echo "<tr align = 'center'>";
		    if ($i == $pagesize) break;
		    $id = $row['id'];
		    $name = $row['name'];
		    $st = $row['starttime'];
		    $et = $row['endtime'];
		    if ($nt < $st) {
			$status = 'Scheduled';
			$color = 'blue';
		    }
		    else if ($nt > $et) {
			$status = 'Ended';
			$color = 'red';
		    }
		    else {
			$status = 'Runing';
			$color = 'green';
		    }
		    if ($messt != '' && $messt != $status) continue;
		    if ($i % 2) {
			echo "<td align='center' height = 29px class='odd'> <a href = 'onecontest.php?contestno=$id' style='text-decoration:none'>$id </a> </td>";
			echo "<td align='center' height = 29px class = 'odd'> <a href = 'onecontest.php?contestno=$id' style='text-decoration:none'>$name</a> </td>";
			echo "<td align='center' height = 29px class = 'odd'> <a style='text-decoration:none'>$st</a> </td>";
			echo "<td align='center' height = 29px class = 'odd'> <a style='text-decoration:none'>$et</a> </td>";
			echo "<td align='center' height = 29px class = 'odd'> <a style='text-decoration:none; color:$color'>$status</a> </td>";
			if (isset($_SESSION['admin'])) {
			    echo "<td align='center' height = 29px class='odd'> <a href = 'modifycontest.php?contestno=$id' style='text-decoration:none'>Modify</a> </td>";
			}
		    } else {
			echo "<td align='center' height = 29px class='even'> <a href = 'onecontest.php?contestno=$id' style='text-decoration:none'>$id</a> </td>";
			echo "<td align='center height = 29px class = 'even'> <a href = 'onecontest.php?contestno=$id'style='text-decoration:none' >$name</a> </td>";
			echo "<td align='center' height = 29px class = 'even'> <a style='text-decoration:none'>$st</a> </td>";
			echo "<td align='center' height = 29px class = 'even'> <a style='text-decoration:none'>$et</a> </td>";
			echo "<td align='center' height = 29px class = 'even'> <a style='text-decoration:none; color:$color'>$status</a> </td>";
			if (isset($_SESSION['admin'])) {
			    echo "<td align='center' height = 29px class='even'><a href = 'modifycontest.php?contestno=$id'style='text-decoration:none' > Modify </a></td>";
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
echo "<a href = 'contest.php?page=1'><<</a>";
echo "<a href = 'contest.php?page=$pre'>pre</a>";
for ($i = 1; $i <= $pages; $i++)
echo "<a href = 'contest.php?page=$i'>[".$i."]</a>";
echo "<a href = 'contest.php?page=$next'>next</a>";
echo "<a href = 'contest.php?page=$pages'>>></a>";
echo "</div>";
mysql_close($cn);
?>
</div>
</div>
</div>
<?php
if(isset($_SESSION['admin'])) {
    echo "<div align='center' class = 'opbutton'>
	<p style='width:140px'><a href = 'addcontest.php'> Add Contest</a></p>
	</div>";
}
?>
<div id= "footer">
<?php include('footer.php'); ?>
</div>
</body>
</html>
