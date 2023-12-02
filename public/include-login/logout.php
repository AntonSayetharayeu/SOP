<?php
session_start();

$_SESSION['u_id'] = "";
$_SESSION['email'] = "";
$_SESSION['password'] = "";
$_SESSION['name'] = "";
$_SESSION['Access_level'] = "";

session_destroy();
header("Location: ../../index.php");
?>