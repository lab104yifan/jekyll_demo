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
	<form action='status.php', method="post" style="margin-left:160px; width:610px;">
	<label>SubmitID:</label>
	<input class ="search" name = "searchsid" value="" type="text" size = "30" style="margin-left:8px"/>
	<label>SubmitTime:</label>
	<input class ="search" name = "searchtime" value="" type="text" size = "30"/>
	<label>UserID:</label>
	<input class ="search" name = "searchuid" value="" type="text" size = "30"/></br>
	<label>ProblemID:</label>
	<input class ="search" name = "searchpid" value="" type="text" size = "30"/>
	<label>Language:</label>
	<select class ="search" name = "searchlg" style="margin-left:17px">
	<option value="">Select</option>
	<option value="C++">C++</option>
	<option value="ANSI C">ANSI C</option>
	<option value="JAVA">JAVA</option>
	</select>
	<label>Status:</label>
	<select class ="search" name = "searchst" style="margin-left:8px">
	<option value="">Select</option>
	<option value="AC">AC</option>
	<option value="WA">WA</option>
	<option value="TLE">TLE</option>
	<option value="RE">RE</option>
	<option value="CE">CE</option>
	</select>
	<input id = "searchbutton" type="submit" value="Search" style="float left; margin-left:16px;"/>
	</form>
	<div id = "pboard">
	    <?php
		$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
		mysql_select_db($DBNAME, $cn);
		$pagesize = 20;
		$rs = mysql_query("select count(*) from status");
		$row = mysql_fetch_array($rs);
		$numrows = $row[0];
		$pages = intval($numrows / $pagesize);
		if ($numrows % $pagesize) $pages++;
		if (isset($_GET['page']))
		    $page = intval($_GET['page']);
	        else $page = 1;
		$offset = $pagesize * ($page - 1);
		$messid = $_POST['searchsid'];
		$mestime = $_POST['searchtime'];
		$mesuid = $_POST['searchuid'];
		$mespid = $_POST['searchpid'];
		$meslg = $_POST['searchlg'];
		$messt = $_POST['searchst'];
		$rs = mysql_query("select * from status where id like '%$messid%' and submittime like '%$mestime%' and userid like '%$mesuid%' and problemid like '%$mespid%' and statu like '%$messt' and language like '%$meslg%' order by id desc");
		for ($i = 1; $i <= $offset; $i++) $row = mysql_fetch_array($rs);
		$i = 0;
		echo "<table id = 'ptable' border = '0'>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>SubmitID</strong> </td>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>SubmitTime</strong> </td>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>UserID</strong> </td>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>ProblemID</strong> </td>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>Language</strong> </td>";
		echo "<td align='center' height=35px style='font-size:20px;' class='title'> <strong>Status</strong> </td>";
		while ($row = mysql_fetch_array($rs)) {
		    echo "<tr align = 'center'>";
		    if ($i == $pagesize) break;
		    $id = $row['id'];
		    $time = $row['submittime'];
		    $userid = $row['userid'];
		    $problemid = $row['problemid'];
		    $status = $row['statu'];
		    $language = $row['language'];
		    if ($status == "AC") $cl = "green";
		    else $cl = "red";
		    if ($i % 2) {
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none'>$id </a> </td>";
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none'>$time </a> </td>";
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none'>$userid </a> </td>";
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none' href = 'oneproblem.php?problemno=$problemid'>$problemid </a> </td>";
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none'>$language </a> </td>";
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none; color:$cl'>$status </a> </td>";
		    } else {
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none'>$id </a> </td>";
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none'>$time </a> </td>";
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none'>$userid </a> </td>";
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none' href = 'oneproblem.php?problemno=$problemid'>$problemid </a> </td>";
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none'>$language </a> </td>";
			echo "<td align='center' height = 29px class='odd'> <a style='text-decoration:none; color:$cl'>$status </a> </td>";
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
echo "<a href = 'status.php?page=1'><<</a>";
echo "<a href = 'status.php?page=$pre'>pre</a>";
for ($i = 1; $i <= $pages; $i++)
echo "<a href = 'status.php?page=$i'>[".$i."]</a>";
echo "<a href = 'status.php?page=$next'>next</a>";
echo "<a href = 'status.php?page=$pages'>>></a>";
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
