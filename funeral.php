<?php
// include header
include "header.php";
// set the tpl page
$page = "funeral.tpl";

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
	
	// if module is funeral and action is input
	if ($module == 'funeral' && $act == 'input')
	{
		// change each value to variable name
		$createdDate = date('Y-m-d H:i:s');
		$funeralName = $_POST['funeralName'];
		$funeralAddress = $_POST['funeralAddress'];
		$status = $_POST['status'];
		$userID = $_SESSION['userID'];
		
		// save into database
		$queryFuneral = "INSERT INTO as_funeral (funeral_name,funeral_address,status,created_date,created_userid,modified_date,modified_userid)
		VALUES('$funeralName','$funeralAddress','$status','$createdDate','$userID','','')";
		mysqli_query($connect, $queryFuneral);
		
		// redirect to the main funeral page
		header("Location: funeral.php?code=1");
	} // close bracket
	
	// if module is funeral and action is edit
	elseif ($module == 'funeral' && $act == 'edit')
	{
		// get the funeral ID
		$funeralID = $_GET['funeralID'];
		
		// showing up from the table
		$queryFuneral = "SELECT * FROM as_funeral WHERE funeral_id = '$funeralID'";
		$sqlFuneral = mysqli_query($connect, $queryFuneral);
		
		// fetch data
		$dataFuneral = mysqli_fetch_array($sqlFuneral);
		
		// assign data to the tpl
		$smarty->assign("funeralID", $dataFuneral['funeral_id']);
		$smarty->assign("funeralName", $dataFuneral['funeral_name']);
		$smarty->assign("funeralAddress", $dataFuneral['funeral_address']);
		$smarty->assign("status", $dataFuneral['status']);
	} //close bracket
	
	// if module is funeral and action is update
	elseif ($module == 'funeral' && $act == 'update')
	{
		// change each value to variable name
		$modifiedDate = date('Y-m-d H:i:s');
		$funeralID = $_POST['funeralID'];
		$funeralName = $_POST['funeralName'];
		$funeralAddress = $_POST['funeralAddress'];
		$status = $_POST['status'];
		$userID = $_SESSION['userID'];
		
		// save into the database
		$queryFuneral = "UPDATE as_funeral SET funeral_name = '$funeralName', funeral_address = '$funeralAddress', status = '$status', modified_date = '$modifiedDate', modified_userid = '$userID' WHERE funeral_id = '$funeralID'";
		mysqli_query($connect, $queryFuneral);
		
		// redirect to the main funeral page
		header("Location: funeral.php?code=2");
	} // close bracket
	
	// if module is funeral and action is delete
	elseif ($module == 'funeral' && $act == 'delete')
	{
		// get funeral id
		$funeralID = $_GET['funeralID'];
		
		// delete from the table
		$queryFuneral = "DELETE FROM as_funeral WHERE funeral_id = '$funeralID'";
		mysqli_query($connect, $queryFuneral);
		
		// redirect to the main funeral page
		header("Location: funeral.php?code=3");
	} // close bracket
	
	// default
	else 
	{
		// create new object pagination
		$p = new PaginationFuneral;
		// limit 10 data for page
		$limit  = 10;
		$position = $p->searchPosition($limit);
		// showing up funeral data
		$queryFuneral = "SELECT * FROM as_funeral ORDER BY funeral_id ASC LIMIT $position, $limit";
		$sqlFuneral = mysqli_query($connect, $queryFuneral);
		
		$i = 1 + $position;
		// fetch data
		while ($dtFuneral = mysqli_fetch_array($sqlFuneral))
		{
			// save data into array
			$dataFuneral[] = array(	'funeralID' => $dtFuneral['funeral_id'],
									'funeralName' => $dtFuneral['funeral_name'],
									'funeralAddress' => $dtFuneral['funeral_address'],
									'status' => $dtFuneral['status'],
									'no' => $i
									);
			$i++;
		}
		
		// count data
		$queryCountFuneral = "SELECT * FROM as_funeral";
		$sqlCountFuneral = mysqli_query($connect, $queryCountFuneral);
		$amountData = mysqli_num_rows($sqlCountFuneral);
		
		$amountPage = $p->amountPage($amountData, $limit);
		$pageLink = $p->navPage($_GET['page'], $amountPage);
		
		$smarty->assign("pageLink", $pageLink);
		// assign to the tpl
		$smarty->assign("dataFuneral", $dataFuneral);
		
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>