
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php
    session_start();
    if (!isset($_SESSION['isloggedin'])) {
	echo"0";
	exit(0);
    } else {
	if ($_SESSION['admin'] != true) {
	    echo"1";
	    exit(0);
	}
    }
    include('setting.php');
    $tmp = htmlentities($_REQUEST['message']);
    $f = fopen("hboard", 'w');
    fwrite($f, $tmp);
    fclose($f);
    echo"2";
?>
