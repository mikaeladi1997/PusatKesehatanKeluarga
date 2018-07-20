<?php
// include header
include "header.php";
// set the tpl page
$page = "grade.tpl";

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
	
	// if module is grade and action is input
	if ($module == 'grade' && $act == 'input')
	{
		// change each value to variable name
		$createdDate = date('Y-m-d H:i:s');
		$gradeName = $_POST['gradeName'];
		$status = $_POST['status'];
		$userID = $_SESSION['userID'];
		
		// save into database
		$queryGrade = "INSERT INTO as_grade (grade_name,status,created_date,created_userid,modified_date,modified_userid)
		VALUES('$gradeName','$status','$createdDate','$userID','','')";
		mysqli_query($connect, $queryGrade);
		
		// redirect to the main grade page
		header("Location: grade.php?code=1");
	} // close bracket
	
	// if module is grade and action is edit
	elseif ($module == 'grade' && $act == 'edit')
	{
		// get the grade ID
		$gradeID = $_GET['gradeID'];
		
		// showing up from the table
		$queryGrade = "SELECT * FROM as_grade WHERE grade_id = '$gradeID'";
		$sqlGrade = mysqli_query($connect, $queryGrade);
		
		// fetch data
		$dataGrade = mysqli_fetch_array($sqlGrade);
		
		// assign data to the tpl
		$smarty->assign("gradeID", $dataGrade['grade_id']);
		$smarty->assign("gradeName", $dataGrade['grade_name']);
		$smarty->assign("status", $dataGrade['status']);
	} //close bracket
	
	// if module is grade and action is update
	elseif ($module == 'grade' && $act == 'update')
	{
		// change each value to variable name
		$modifiedDate = date('Y-m-d H:i:s');
		$gradeID = $_POST['gradeID'];
		$gradeName = $_POST['gradeName'];
		$status = $_POST['status'];
		$userID = $_SESSION['userID'];
		
		// save into the database
		$queryGrade = "UPDATE as_grade SET grade_name = '$gradeName', status = '$status', modified_date = '$modifiedDate', modified_userid = '$userID' WHERE grade_id = '$gradeID'";
		mysqli_query($connect, $queryGrade);
		
		// redirect to the main grade page
		header("Location: grade.php?code=2");
	} // close bracket
	
	// if module is grade and action is delete
	elseif ($module == 'grade' && $act == 'delete')
	{
		// get grade id
		$gradeID = $_GET['gradeID'];
		
		// delete from the table
		$queryGrade = "DELETE FROM as_grade WHERE grade_id = '$gradeID'";
		mysqli_query($connect, $queryGrade);
		
		// redirect to the main grade page
		header("Location: grade.php?code=3");
	} // close bracket
	
	// default
	else 
	{
		// create new object pagination
		$p = new PaginationGrade;
		// limit 10 data for page
		$limit  = 10;
		$position = $p->searchPosition($limit);
		// showing up grade data
		$queryGrade = "SELECT * FROM as_grade ORDER BY grade_id ASC LIMIT $position, $limit";
		$sqlGrade = mysqli_query($connect, $queryGrade);
		
		$i = 1 + $position;
		// fetch data
		while ($dtGrade = mysqli_fetch_array($sqlGrade))
		{
			// save data into array
			$dataGrade[] = array(	'gradeID' => $dtGrade['grade_id'],
									'gradeName' => $dtGrade['grade_name'],
									'status' => $dtGrade['status'],
									'no' => $i
									);
			$i++;
		}
		
		// count data
		$queryCountGrade = "SELECT * FROM as_grade";
		$sqlCountGrade = mysqli_query($connect, $queryCountGrade);
		$amountData = mysqli_num_rows($sqlCountGrade);
		
		$amountPage = $p->amountPage($amountData, $limit);
		$pageLink = $p->navPage($_GET['page'], $amountPage);
		
		$smarty->assign("pageLink", $pageLink);
		// assign to the tpl
		$smarty->assign("dataGrade", $dataGrade);
		
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>