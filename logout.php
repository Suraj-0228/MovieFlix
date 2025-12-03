<?php
session_start();
session_unset();
session_destroy();
setcookie('user_login', '', time() - 3600, "/"); // Delete cookie
header("Location: login.php");
exit();
