<?php
// include header
include "header.php";
// set the tpl page
$page = "jobs.tpl";

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
	if ($module == 'job' && $act == 'input')
	{
		// change each value to variable name
		$createdDate = date('Y-m-d H:i:s');
		$jobName = $_POST['jobName'];
		$status = $_POST['status'];
		$userID = $_SESSION['userID'];
		
		// save into database
		$queryJob = "INSERT INTO as_jobs (job_name,status,created_date,created_userid,modified_date,modified_userid)
		VALUES('$jobName','$status','$createdDate','$userID','','')";
		mysqli_query($connect, $queryJob);
		
		// redirect to the main job page
		header("Location: jobs.php?code=1");
	} // close bracket
	
	// if module is job and action is edit
	elseif ($module == 'job' && $act == 'edit')
	{
		// get the job ID
		$jobID = $_GET['jobID'];
		
		// showing up from the table
		$queryJob = "SELECT * FROM as_jobs WHERE job_id = '$jobID'";
		$sqlJob = mysqli_query($connect, $queryJob);
		
		// fetch data
		$dataJob = mysqli_fetch_array($sqlJob);
		
		// assign data to the tpl
		$smarty->assign("jobID", $dataJob['job_id']);
		$smarty->assign("jobName", $dataJob['job_name']);
		$smarty->assign("status", $dataJob['status']);
	} //close bracket
	
	// if module is job and action is update
	elseif ($module == 'job' && $act == 'update')
	{
		// change each value to variable name
		$modifiedDate = date('Y-m-d H:i:s');
		$jobID = $_POST['jobID'];
		$jobName = $_POST['jobName'];
		$status = $_POST['status'];
		$userID = $_SESSION['userID'];
		
		// save into the database
		$queryJob = "UPDATE as_jobs SET job_name = '$jobName', status = '$status', modified_date = '$modifiedDate', modified_userid = '$userID' WHERE job_id = '$jobID'";
		mysqli_query($connect, $queryJob);
		
		// redirect to the main job page
		header("Location: jobs.php?code=2");
	} // close bracket
	
	// if module is job and action is delete
	elseif ($module == 'job' && $act == 'delete')
	{
		// get job id
		$jobID = $_GET['jobID'];
		
		// delete from the table
		$queryJob = "DELETE FROM as_jobs WHERE job_id = '$jobID'";
		mysqli_query($connect, $queryJob);
		
		// redirect to the main job page
		header("Location: jobs.php?code=3");
	} // close bracket
	
	// default
	else 
	{
		// create new object pagination
		$p = new PaginationJob;
		// limit 10 data for page
		$limit  = 10;
		$position = $p->searchPosition($limit);
		// showing up job data
		$queryJob = "SELECT * FROM as_jobs ORDER BY job_id ASC LIMIT $position, $limit";
		$sqlJob = mysqli_query($connect, $queryJob);
		
		$i = 1 + $position;
		// fetch data
		while ($dtJob = mysqli_fetch_array($sqlJob))
		{
			// save data into array
			$dataJob[] = array(	'jobID' => $dtJob['job_id'],
								'jobName' => $dtJob['job_name'],
								'status' => $dtJob['status'],
								'no' => $i
								);
			$i++;
		}
		
		// count data
		$queryCountJob = "SELECT * FROM as_jobs";
		$sqlCountJob = mysqli_query($connect, $queryCountJob);
		$amountData = mysqli_num_rows($sqlCountJob);
		
		$amountPage = $p->amountPage($amountData, $limit);
		$pageLink = $p->navPage($_GET['page'], $amountPage);
		
		$smarty->assign("pageLink", $pageLink);
		// assign to the tpl
		$smarty->assign("dataJob", $dataJob);
		
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>