<?php
session_start();
include('setting.php');
?>

<?php
    $code = $_POST['smessage'];
    $suf = $_POST['lg'];
    $id = $_GET['problemno'];
    $userid = $_SESSION['username'];
    if ($suf == "JAVA") file_put_contents("/var/www/oj/judge/tmp.java", $code);
    else file_put_contents('/var/www/oj/judge/tmp.cpp', $code);
    if ($suf == "C++") $str = "g++ /var/www/oj/judge/tmp.cpp -o /var/www/oj/judge/a.out";
    else if ($suf == "ASCI C") $str = "gcc /var/www/oj/judge/tmp.cpp -o /var/www/oj/judge/a.out";
    else $str = "javec /var/www/oj/judge/tmp.java -o /var/www/oj/judge/a.out";
    exec($str, $s, $out);
    if ($out == 0) {
	exec("/var/www/oj/judge/./a.out < /var/www/oj/problems/$id/in > /var/www/oj/judge/out", $s, $out);
	if ($out == 0) {
	    $filename = "/var/www/oj/judge/out";
	    $fp = fopen($filename, "r");
	    $a = fread($fp, filesize($filename));
	    fclose($fp);
	    $filename = "/var/www/oj/problems/$id/out";
	    $fp = fopen($filename, "r");
	    $b = fread($fp, filesize($filename));
	    fclose($fp);
	    if ($a == $b)
		$status = 0;
	    else $status = 1;
	} else {
	    $status = 3;
	}
    } else {
	$status = 4;
    }
    $cn = mysql_connect('localhost', $DBUSER, $DBPASS);
    mysql_select_db($DBNAME, $cn);
    $rs = mysql_query("select count(*) from status");
    $row = mysql_fetch_array($rs);
    $tot = $row[0] + 1;
    if ($status == 4) $st = "CE";
    if ($status == 3) $st = "RE";
    if ($status == 1) $st = "WA";
    if ($status == 0) $st = "AC";
    $submittime = date('Y~m~d h.i.s', time());
    mysql_query("insert into status (id, submittime, userid, problemid, statu, language) values ($tot, '$submittime', '$userid', $id, '$st', '$suf')");
    echo"<meta http-equiv='Refresh' content='0; URL=status.php'/>";
    echo"<script>alert('Submit success')</script>";
    echo"";
?>
