<?php
// include header
include "header.php";
// set the tpl page
$page = "disease.tpl";

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
	if ($module == 'disease' && $act == 'input')
	{
		// change each value to variable name
		$createdDate = date('Y-m-d H:i:s');
		$diseaseName = $_POST['diseaseName'];
		$userID = $_SESSION['userID'];
		
		// save into database
		$queryDisease = "INSERT INTO as_disease (disease_name,created_date,created_userid,modified_date,modified_userid)
		VALUES('$diseaseName','$createdDate','$userID','','')";
		mysqli_query($connect, $queryDisease);
		
		// redirect to the main job page
		header("Location: disease.php?code=1");
	} // close bracket
	
	// if module is job and action is edit
	elseif ($module == 'disease' && $act == 'edit')
	{
		// get the job ID
		$diseaseID = $_GET['diseaseID'];
		
		// showing up from the table
		$queryDisease = "SELECT * FROM as_disease WHERE disease_id = '$diseaseID'";
		$sqlDisease = mysqli_query($connect, $queryDisease);
		
		// fetch data
		$dataDisease = mysqli_fetch_array($sqlDisease);
		
		// assign data to the tpl
		$smarty->assign("diseaseID", $dataDisease['disease_id']);
		$smarty->assign("diseaseName", $dataDisease['disease_name']);
	} //close bracket
	
	// if module is job and action is update
	elseif ($module == 'disease' && $act == 'update')
	{
		// change each value to variable name
		$modifiedDate = date('Y-m-d H:i:s');
		$diseaseID = $_POST['diseaseID'];
		$diseaseName = $_POST['diseaseName'];
		$userID = $_SESSION['userID'];
		
		// save into the database
		$queryDisease = "UPDATE as_disease SET disease_name = '$diseaseName', modified_date = '$modifiedDate', modified_userid = '$userID' WHERE disease_id = '$diseaseID'";
		mysqli_query($connect, $queryDisease);
		
		// redirect to the main job page
		header("Location: disease.php?code=2");
	} // close bracket
	
	// if module is job and action is delete
	elseif ($module == 'disease' && $act == 'delete')
	{
		// get job id
		$diseaseID = $_GET['diseaseID'];
		
		// delete from the table
		$queryDisease = "DELETE FROM as_disease WHERE disease_id = '$diseaseID'";
		mysqli_query($connect, $queryDisease);
		
		// redirect to the main job page
		header("Location: disease.php?code=3");
	} // close bracket
	
	// default
	else 
	{
		// create new object pagination
		$p = new PaginationDisease;
		// limit 10 data for page
		$limit  = 10;
		$position = $p->searchPosition($limit);
		// showing up job data
		$queryDisease = "SELECT * FROM as_disease ORDER BY disease_id ASC LIMIT $position, $limit";
		$sqlDisease = mysqli_query($connect, $queryDisease);
		
		$i = 1 + $position;
		// fetch data
		while ($dtDisease = mysqli_fetch_array($sqlDisease))
		{
			// save data into array
			$dataDisease[] = array(	'diseaseID' => $dtDisease['disease_id'],
								'diseaseName' => $dtDisease['disease_name'],
								'no' => $i
								);
			$i++;
		}
		
		// count data
		$queryCountDisease = "SELECT * FROM as_disease";
		$sqlCountDisease = mysqli_query($connect, $queryCountDisease);
		$amountData = mysqli_num_rows($sqlCountDisease);
		
		$amountPage = $p->amountPage($amountData, $limit);
		$pageLink = $p->navPage($_GET['page'], $amountPage);
		
		$smarty->assign("pageLink", $pageLink);
		// assign to the tpl
		$smarty->assign("dataDisease", $dataDisease);
		
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>