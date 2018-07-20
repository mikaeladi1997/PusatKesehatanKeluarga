<?php
date_default_timezone_set("ASIA/JAKARTA");
error_reporting(0);
session_start();
// include all files are required
include "includes/connection.php";
include "includes/page_function.php";
include "includes/fungsi_indotgl.php";
include "includes/debug.php";

require('libs/Smarty.class.php');

// create new object
$smarty = new Smarty;

$year = date('Y');

// check userLevel, if userLevel is 1, then Administrator
if ($_SESSION['userLevel'] == '1'){
	$userLevel = "Administrator";
}

// assign userLevel to the tpl
$smarty->assign("userLevel", $userLevel);
$smarty->assign("userLv", $_SESSION['userLevel']);
$smarty->assign("userID", $_SESSION['userID']);
$smarty->assign("userFullName", $_SESSION['userFullName']);
?>