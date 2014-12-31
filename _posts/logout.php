<?php 
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['isloggedin']);
    unset($_SESSION['userid']);
    unset($_SESSION['admin']);
    echo "<meta http-equiv='Refresh' content='0; URL=home.php'/>";
?>
