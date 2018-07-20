<?php
// include header
include "header.php";
// set the tpl page
$page = "babtis.tpl";

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
	
	// if module is babtis and action is input
	if ($module == 'babtis' && $act == 'input')
	{
		// change each value to variable name
		$createdDate = date('Y-m-d H:i:s');
		$babtisName = $_POST['babtisName'];
		$status = $_POST['status'];
		$userID = $_SESSION['userID'];
		
		// save into database
		$queryBabtis = "INSERT INTO as_babtis (jenis_babtis,status,created_date,created_userid,modified_date,modified_userid)
		VALUES('$babtisName','$status','$createdDate','$userID','','')";
		mysqli_query($connect, $queryBabtis);
		
		// redirect to the main babtis page
		header("Location: babtis.php?code=1");
	} // close bracket
	
	// if module is babtis and action is edit
	elseif ($module == 'babtis' && $act == 'edit')
	{
		// get the babtis ID
		$babtisID = $_GET['babtisID'];
		
		// showing up from the table
		$queryBabtis = "SELECT * FROM as_babtis WHERE babtis_id = '$babtisID'";
		$sqlBabtis = mysqli_query($connect, $queryBabtis);
		
		// fetch data
		$dataBabtis = mysqli_fetch_array($sqlBabtis);
		
		// assign data to the tpl
		$smarty->assign("babtisID", $dataBabtis['babtis_id']);
		$smarty->assign("babtisName", $dataBabtis['jenis_babtis']);
		$smarty->assign("status", $dataBabtis['status']);
	} //close bracket
	
	// if module is babtis and action is update
	elseif ($module == 'babtis' && $act == 'update')
	{
		// change each value to variable name
		$modifiedDate = date('Y-m-d H:i:s');
		$babtisID = $_POST['babtisID'];
		$babtisName = $_POST['babtisName'];
		$status = $_POST['status'];
		$userID = $_SESSION['userID'];
		
		// save into the database
		$queryBabtis = "UPDATE as_babtis SET jenis_babtis = '$babtisName', status = '$status', modified_date = '$modifiedDate', modified_userid = '$userID' WHERE babtis_id = '$babtisID'";
		mysqli_query($connect, $queryBabtis);
		
		// redirect to the main babtis page
		header("Location: babtis.php?code=2");
	} // close bracket
	
	// if module is babtis and action is delete
	elseif ($module == 'babtis' && $act == 'delete')
	{
		// get babtis id
		$babtisID = $_GET['babtisID'];
		
		// delete from the table
		$queryBabtis = "DELETE FROM as_babtis WHERE babtis_id = '$babtisID'";
		mysqli_query($connect, $queryBabtis);
		
		// redirect to the main babtis page
		header("Location: babtis.php?code=3");
	} // close bracket
	
	// default
	else 
	{
		// create new object pagination
		$p = new PaginationBabtis;
		// limit 10 data for page
		$limit  = 10;
		$position = $p->searchPosition($limit);
		// showing up babtis data
		$queryBabtis = "SELECT * FROM as_babtis ORDER BY babtis_id ASC LIMIT $position, $limit";
		$sqlBabtis = mysqli_query($connect, $queryBabtis);
		
		$i = 1 + $position;
		// fetch data
		while ($dtBabtis = mysqli_fetch_array($sqlBabtis))
		{
			// save data into array
			$dataBabtis[] = array(	'babtisID' => $dtBabtis['babtis_id'],
									'babtisName' => $dtBabtis['jenis_babtis'],
									'status' => $dtBabtis['status'],
									'no' => $i
									);
			$i++;
		}
		
		// count data
		$queryCountBabtis = "SELECT * FROM as_babtis";
		$sqlCountBabtis = mysqli_query($connect, $queryCountBabtis);
		$amountData = mysqli_num_rows($sqlCountBabtis);
		
		$amountPage = $p->amountPage($amountData, $limit);
		$pageLink = $p->navPage($_GET['page'], $amountPage);
		
		$smarty->assign("pageLink", $pageLink);
		// assign to the tpl
		$smarty->assign("dataBabtis", $dataBabtis);
		
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>