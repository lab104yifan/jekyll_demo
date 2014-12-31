<?php
    session_start();
?>

<div id = "header">
<h1 id = "logo-text"><a href = "home.php">FJNU Online Judge</a></h1>

<?php
if (isset($_SESSION['isloggedin'])) {
    $id = $_SESSION['username'];
    echo"
	<div id = 'inf-board'>
	<p style='font-size:18px; font-weight:bold'><a> Hello, ";
	if (isset($_SESSION['admin']))
	    echo"Admin </a>";
	else echo "Coder </a>";
	echo"<a>$id</a></p>
	<p><a href = 'message.php?userid=$id'>Modify Information</a></p>";
	if (isset($_SESSION['admin']))
	    echo"<p><a href = 'user.php'>View user</a></p>";
    echo"</div>";
}
?>

</div>
