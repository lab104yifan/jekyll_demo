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
	$('#registerbutton').click(function() {
		if ($('#registerfields').is(':hidden')) {
		    $('#registerfields').slideDown('fast');
		    $('#registerbutton').attr('value', 'Cencle');
		    $('#loginbutton').attr('value', 'Register');
		    $('#loginbutton').attr('name', 'register');
		    $('#error').hide();
		} else {
		    $('#registerfields').slideUp('fast');
		    $('#registerbutton').attr('value', 'Register');
		    $('#loginbutton').attr('value', 'Login');
		    $('#loginbutton').attr('name', 'login');
		    $('#error').hide();
		}
	});
	$('form').submit(function() {
	    var username = $("input[name='username']").attr('value');
	    var password = $("input[name='password']").attr('value');
	    var confirmpass = $("input[name='confirm']").attr('value');
	    var name = $("input[name='name']").attr('value');
	    var school = $("input[name='school']").attr('value');
	    var email = $("input[name='email']").attr('value');
	    $('#error').hide();
	    if (username.length == 0) {
		$('#error').text('Username cannot be empty');
		$('#error').attr('class', 'error');
		$('#error').fadeIn('slow');
		return false;
	    }
	    if (password.length == 0) {
		$('#error').text('Password cannot be empty');
		$('#error').attr('class', 'error');
		$('#error').fadeIn('slow');
		return false;
	    }
	    if ($('#loginbutton').attr('name') == 'register') {
	        if (confirmpass.length == 0) {
		   $('#error').text('Confirmpassword cannot be empty');
		    $('#error').attr('class', 'error');
		    $('#error').fadeIn('slow');
		    return false;
		}
		if (confirmpass != password) {
		    $('#error').text('Confirmpassword must be equal password');
		    $('#error').attr('class', 'error');
		    $('#error').fadeIn('slow');
		    return false;
		}
		if (name.length == 0) {
		    $('#error').text('Name cannot be empty');
		    $('#error').attr('class', 'error');
		    $('#error').fadeIn('slow');
		    return false;
		}
		if (school.length == 0) {
		    $('#error').text('School cannot be empty');
		    $('#error').attr('class', 'error');
		    $('#error').fadeIn('slow');
		    return false;
		}
		if (email.length == 0) {
		    $('#error').text('Email cannot be empty');
		    $('#error').attr('class', 'error');
		    $('#error').fadeIn('slow');
		    return false;
		}
	    }
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

<?php

if (isset($_SESSION['username'])) {
    $cn = mysql_connect('localhost', $DBUSER, $DBPASS);
    mysql_select_db($DBNAME, $cn);
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $query = "select * from `user` where `id` = '$username' and `password` = '$password'";
    $logged = mysql_query($query);
    $logged = mysql_fetch_array($logged);
    mysql_close($cn);
}

if ($logged['id']) {
    $_SESSION['isloggedin'] = "Yes";
    $_SESSION['userid'] = $logged['id'];
    if ($logged['type'] == 1) $_SESSION['admin'] = true;
    echo "<meta http-equiv='Refresh' content='0; URL=home.php'/>";
}
else {
    if ($_POST['username'] && $_POST['login']) {
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	echo "<meta http-equiv='Refresh' content='0; URL=login.php'/>";
    } else {
	$printedError = false;
	if (isset($_SESSION['username'])) {
	    $printedError = true;
	    print '<div id= "error" class= "successs" style="display: one; margin-left:360px;"> Password Error</div>';
	    unset($_SESSION['username']);
	    unset($_SESSION['password']);
	}
	if (isset($_POST['register'])) {
	    $cn = mysql_connect('localhost', $DBUSER, $DBPASS);
	    mysql_select_db($DBNAME, $cn);
	    $username = $_POST['username'];
	    $password = $_POST['password'];
	    $name = $_POST['name'];
	    $school = $_POST['school'];
	    $email = $_POST['email'];
	    $query = "insert into `user` (id, password, name, school, email) value('$username', '$password', '$name', '$school', '$email')";
	    if (!mysql_query($query)) {
		if (mysql_errno() == 1062) {
		    print '<div id= "error" class= "successs" style="display: one; margin-left:360px;"> ID is exist </div>';
		} else {
		    print '<div id= "error" class= "successs" style="display: one; margin-left:360px;"> Register Error</div>';
		}
	    } else {
		print '<div id= "error" class= "successs" style="display: one; margin-left:360px;"> Register Success </div>';
		$printedError = true;
	    }
	    mysql_close($cn);
	}
	if ($printedError == false) print '<div id= "error" class= "successs" style="display: none; margin-left:360px;"> Error </div>';
    }
}

?>

<div id = "lboard">
<form style="position: relative; width: 250px;" action="login.php" method="post">
<label>ID</label>
<input name= "username" value="" type="text" size="30" />
<label>Password</label>
<input name="password" value="" type="password" size="30" />
<span id="registerfields" style= "margin: 0; display: none">
<label>Confirm Password</label>
<input name="confirm" value="" type="password" size="30" />
<label>Name</label>
<input name="name" value="" type="text" size="30" />
<label>School</label>
<input name="school" value="" type="text" size="30" />
<label>Email</label>
<input name="email" value="" type="text" size="30" />
</span>
<div style="margin-top:10px">
<input id= "loginbutton" type= "submit" name= "login" value ="Login" style="margin-left:55px;"/>
<input id= "registerbutton" type= "button" value ="Register" style="margin-left:30px"/>
</div>
</form>
</div>
</div>

<div id= "footer">
<?php include('footer.php'); ?>
</div>

</body>
</html>
