<?php
// include header
include "header.php";
// set the tpl page
$page = "laporan_jemaat.tpl";

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
	
	$batita = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(date_of_birth)), '%y')+0 BETWEEN '0' AND '2'"));
	$balita = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(date_of_birth)), '%y')+0 BETWEEN '3' AND '4'"));
	$kanak = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(date_of_birth)), '%y')+0 BETWEEN '5' AND '7'"));
	$pratama = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(date_of_birth)), '%y')+0 BETWEEN '8' AND '11'"));
	$madya = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(date_of_birth)), '%y')+0 BETWEEN '12' AND '14'"));
	$remaja = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(date_of_birth)), '%y')+0 BETWEEN '15' AND '16'"));
	$pemuda = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(date_of_birth)), '%y')+0 BETWEEN '17' AND '24'"));
	$dewasa = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(date_of_birth)), '%y')+0 BETWEEN '25' AND '54'"));
	$lansia = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) AS TOTAL FROM as_individu WHERE status = 'Y' AND DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(date_of_birth)), '%y')+0 > 55"));
	
	
	$smarty->assign("batita", $batita['TOTAL']);
	$smarty->assign("balita", $balita['TOTAL']);
	$smarty->assign("kanak", $kanak['TOTAL']);
	$smarty->assign("pratama", $pratama['TOTAL']);
	$smarty->assign("madya", $madya['TOTAL']);
	$smarty->assign("remaja", $remaja['TOTAL']);
	$smarty->assign("pemuda", $pemuda['TOTAL']);
	$smarty->assign("dewasa", $dewasa['TOTAL']);
	$smarty->assign("lansia", $lansia['TOTAL']);
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>