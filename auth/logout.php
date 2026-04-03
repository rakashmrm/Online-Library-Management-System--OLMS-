<?php
session_start();
session_unset();
session_destroy();

echo "Logging out... Redirecting to home page";
header("refresh:2;url=../index.php");
exit();
?>