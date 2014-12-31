<?php
    session_start();
    include('setting.php');
?>

<html>
<head>

<link rel= "stylesheet" href="images/Envision.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript" src="jquery-1.3.1.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	$('form').submit(function() {
	    var name = $('#name').val();
	    var oldpassword = $('#oldpassword').val();
	    var newpassword = $('#newpassword').val();
	    var confirmpassword = $('#confirmpassword').val();
	    var school = $('#school').val();
	    var email = $('#email').val();
	    if (name.length == 0
		|| oldpassword.length == 0
		|| newpassword.length == 0
		|| confirmpassword.length == 0
		|| school.length == 0
		|| email.length == 0) {
		alert("Message not complete!");
		return false;
	    }
	    if (confirmpassword != newpassword) {
		alert("Password is diffrence");
		return false;
	    }
	});
	$('#cencelbutton').click(function() {
	    window.location.href="home.php";
	});
});

</script>
</head>

<body class= "main">

<div id= "warp">
<?php include('header.php'); ?>
<?php include('menu.php'); ?>
</div>

<div id= "LoginBoard">
<div id = "lboard">
<?php
$id = $_GET['userid'];
$cn = mysql_connect('localhost', $DBUSER, $DBPASS);
mysql_select_db($DBNAME, $cn);
$rs = mysql_query("select * from user where id = '$id'");
$row = mysql_fetch_array($rs);
$password = $row['password'];
$name = $row['name'];
$school = $row['school'];
$email = $row['email'];
if (isset($_POST['oldpassword'])) {
    if ($_POST['oldpassword'] != $password) {
	echo"<script>alert('Password is wrong')</script>";
    } else {
	$mname = $_POST['name'];
	$mpassword = $_POST['newpassword'];
	$mschool = $_POST['school'];
	$memail = $_POST['email'];
	mysql_query("update user set name = '$mname', password = '$mpassword', school = '$mschool', email = '$memail' where id = '$id'");
	echo"<script>alert('Modift success')</script>";
	echo "<meta http-equiv='Refresh' content='0; URL=home.php'/>";
    }
}
mysql_close($cn);
echo"
<form style='position: relative; width: 250px;' action='message.php?userid=$id' method='post'>
<label>ID</label>
<input name= 'userid' value='$id' type='text' size='30' readonly='true'/>
<label>Name</label>
<input id= 'name' name='name' value='$name' type='text' size='30' />
<label>Old Password</label>
<input id = 'oldpassword' name='oldpassword' value='' type='password' size='30' />
<label>New Password</label>
<input id = 'newpassword' name='newpassword' value='' type='password' size='30' />
<label>Confirm Password</label>
<input id = 'confirmpassword' name='confirm' value='' type='password' size='30' />
<label>School</label>
<input id = 'school' name='school' value='$school' type='text' size='30' />
<label>Email</label>
<input id = 'email' name='email' value='$email' type='text' size='30' />
<div style='margin-top:10px'>
<input id= 'loginbutton' type= 'submit' name= 'login' value ='Modify' style='margin-left:55px;'/>
<input id= 'cencelbutton' type= 'button' value ='Cencle' style='margin-left:30px'/>
</div>
</form>"
?>
</div>
</div>

<div id= "footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
