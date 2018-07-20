<?php
// include header
include "header.php";
// set the tpl page
$page = "medicine.tpl";

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
	
	// if module is job and action is input
	if ($module == 'medicine' && $act == 'input')
	{
		// change each value to variable name
		$createdDate = date('Y-m-d H:i:s');
		$medicineID = $_POST['medicineID'];
		$medicineName = $_POST['medicineName'];
		$userID = $_SESSION['userID'];
		
		// save into database
		$queryMedicine = "INSERT INTO as_medicine (medicine_id, medicine_name,created_date,created_userid,modified_date,modified_userid)
		VALUES('$medicineID','$medicineName','$createdDate','$userID','','')";
		mysqli_query($connect, $queryMedicine);
		
		// redirect to the main job page
		header("Location: medicine.php?code=1");
	} // close bracket
	
	// if module is job and action is edit
	elseif ($module == 'medicine' && $act == 'edit')
	{
		// get the job ID
		$medicineID = $_GET['medicineID'];
		
		// showing up from the table
		$queryMedicine = "SELECT * FROM as_medicine WHERE medicine_id = '$medicineID'";
		$sqlMedicine = mysqli_query($connect, $queryMedicine);
		
		// fetch data
		$dataMedicine = mysqli_fetch_array($sqlMedicine);
		
		// assign data to the tpl
		$smarty->assign("medicineID", $dataMedicine['medicine_id']);
		$smarty->assign("medicineName", $dataMedicine['medicine_name']);
	} //close bracket
	
	// if module is job and action is update
	elseif ($module == 'medicine' && $act == 'update')
	{
		// change each value to variable name
		$modifiedDate = date('Y-m-d H:i:s');
		$medicineID = $_POST['medicineID'];
		$medicineName = $_POST['medicineName'];
		$userID = $_SESSION['userID'];
		
		// save into the database
		$queryMedicine = "UPDATE as_medicine SET medicine_name = '$medicineName', modified_date = '$modifiedDate', modified_userid = '$userID' WHERE medicine_id = '$medicineID'";
		mysqli_query($connect, $queryMedicine);
		
		// redirect to the main job page
		header("Location: medicine.php?code=2");
	} // close bracket
	
	// if module is job and action is delete
	elseif ($module == 'medicine' && $act == 'delete')
	{
		// get job id
		$medicineID = $_GET['medicineID'];
		
		// delete from the table
		$queryMedicine = "DELETE FROM as_medicine WHERE medicine_id = '$medicineID'";
		mysqli_query($connect, $queryMedicine);
		
		// redirect to the main job page
		header("Location: medicine.php?code=3");
	} // close bracket
	
	// default
	else 
	{
		// create new object pagination
		$p = new PaginationMedicine;
		// limit 10 data for page
		$limit  = 10;
		$position = $p->searchPosition($limit);
		// showing up job data
		$queryMedicine = "SELECT * FROM as_medicine ORDER BY medicine_id ASC LIMIT $position, $limit";
		$sqlMedicine = mysqli_query($connect, $queryMedicine);
		
		$i = 1 + $position;
		// fetch data
		while ($dtMedicine = mysqli_fetch_array($sqlMedicine))
		{
			// save data into array
			$dataMedicine[] = array(	'medicineID' => $dtMedicine['medicine_id'],
								'medicineName' => $dtMedicine['medicine_name'],
								'no' => $i
								);
			$i++;
		}
		
		// count data
		$queryCountMedicine = "SELECT * FROM as_medicine";
		$sqlCountMedicine = mysqli_query($connect, $queryCountMedicine);
		$amountData = mysqli_num_rows($sqlCountMedicine);
		
		$amountPage = $p->amountPage($amountData, $limit);
		$pageLink = $p->navPage($_GET['page'], $amountPage);
		
		$smarty->assign("pageLink", $pageLink);
		// assign to the tpl
		$smarty->assign("dataMedicine", $dataMedicine);
		
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>