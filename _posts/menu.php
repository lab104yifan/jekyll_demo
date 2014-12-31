<div id= "menu">
    <ul>
	<li id ="Home"><a href="home.php">Home</a></li>
	<li id ="Problem"><a href="problem.php">Problem</a></li>
	<li id ="Contest"><a href="contest.php">Contest</a></li>
	<li id ="Faq"><a href="status.php">Status</a></li>
	<?php if(!isset($_SESSION['isloggedin'])) print '<li id="login"><a href="login.php">Login</a></li>'; ?>
	<?php if(isset($_SESSION['isloggedin'])) print '<li id="logout"><a href="logout.php">Logout</a></li>'; ?>
    </ul>
</div>
