<?php
session_start();
echo "please wait we are logging you out";
session_destroy();
header("location:/forum/index.php");


?>