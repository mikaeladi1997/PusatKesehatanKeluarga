<?php
// include header
include "header.php";
// set the tpl page
$page = "laporan_jemaat_gender.tpl";

// if session is null, showing up the text and exit
if ($_SESSION['username'] == '' && $_SESSION['password'] == '')
{
	// show up the text and exit
	echo "You have not authorization for access the modules.";
	exit();
}

else 
{
	// get variable
	$module = $_GET['module'];
	$act = $_GET['act'];
	
	$now = date('Y-m-d');
	
	$laki = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND gender = 'L'"));
	$perempuan = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND gender = 'P'"));
	
	
	$smarty->assign("laki", $laki['TOTAL']);
	$smarty->assign("perempuan", $perempuan['TOTAL']);
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>