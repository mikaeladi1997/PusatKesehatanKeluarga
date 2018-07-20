<?php
// include header
include "header.php";
// set the tpl page
$page = "users.tpl";

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
	
	// if module is users and action is input
	if ($module == 'user' && $act == 'input')
	{
		$createdDate = date('Y-m-d H:i:s');
		$password = md5($_POST['userPassword']);
		$fullName = $_POST['fullName'];
		$address = $_POST['address'];
		$gender = $_POST['gender'];
		$position = $_POST['position'];
		$handphone = $_POST['handPhone'];
		$status = $_POST['status'];
		$blocked = $_POST['blocked'];
		$username = $_POST['username'];
		$userID = $_SESSION['userID'];
		
		// save into database
		$queryUser = "INSERT INTO as_users (fullName,address,gender,position,handPhone,status,blocked,username,password,created_date,created_userid,modified_date,modified_userid)
		VALUES('$fullName','$address','$gender','$position','$handphone','$status','$blocked','$username','$password','$createdDate','$userID','','')";
		mysqli_query($connect, $queryUser);
		
		 // redirect to the main user page
		header("Location: users.php?code=1");
	} // close bracket
	
	// if module is user and action is edit
	elseif ($module == 'user' && $act == 'edit')
	{
		// get user ID
		$userID = $_GET['userID'];
		
		// showing up the user data
		$queryUser = "SELECT * FROM as_users WHERE userID = '$userID'";
		$dataUser = mysqli_fetch_array(mysqli_query($connect, $queryUser));
		
		// assign to tpl
		$smarty->assign("userID", $dataUser['userID']);
		$smarty->assign("fullName", $dataUser['fullName']);
		$smarty->assign("address", $dataUser['address']);
		$smarty->assign("gender", $dataUser['gender']);
		$smarty->assign("position", $dataUser['position']);
		$smarty->assign("handPhone", $dataUser['handPhone']);
		$smarty->assign("status", $dataUser['status']);
		$smarty->assign("blocked", $dataUser['blocked']);
		$smarty->assign("level", $dataUser['level']);
	} // close bracket
	
	// if module is user and action is update
	elseif ($module == 'user' && $act == 'update')
	{
		$modifiedDate = date('Y-m-d H:i:s');
		$fullName = $_POST['fullName'];
		$address = $_POST['address'];
		$gender = $_POST['gender'];
		$position = $_POST['position'];
		$handphone = $_POST['handPhone'];
		$status = $_POST['status'];
		$blocked = $_POST['blocked'];
		$level = $_POST['level'];
		$userID = $_POST['userID'];
		
		// update into database
		$queryLogin = "UPDATE as_users SET fullName = '$fullName', address = '$address', gender = '$gender', position = '$position',
		handPhone = '$handphone', status = '$status', blocked = '$blocked' WHERE userID = '$userID'";
		mysqli_query($connect, $queryLogin);
		
		// redirect to the main user page
		header("Location: users.php?code=2");
	} // close bracket
	
	// if module is user and action is delete
	elseif ($module == 'user' && $act == 'delete')
	{
		// get user ID
		$userID = $_GET['userID'];
		
		// delete from user
		$queryUser = "DELETE FROM as_users WHERE userID = '$userID'";
		mysqli_query($connect, $queryUser);
		
		// redirect to the main user page
		header("Location: users.php?code=3");
	} // close bracket
	
	// if module is user and action is reset
	elseif ($module == 'user' && $act == 'reset')
	{
		// insert method into a variable
		$userID = $_GET['userID'];
		
		// showing up the user data
		$queryUser = "SELECT userID, username, password, fullName FROM as_users WHERE userID = '$userID'";
		$sqlUser = mysqli_query($connect, $queryUser);
		
		// fetch data
		$dataUser = mysqli_fetch_array($sqlUser);
		
		// assign to the tpl
		$smarty->assign("userID", $dataUser['userID']);
		$smarty->assign("username", $dataUser['username']);
		$smarty->assign("fullName", $dataUser['fullName']);
		
	} // close bracket
	
	// if module is user and action is inreset
	elseif ($module == 'user' && $act == 'inreset')
	{
		// insert method into a variable
		$userID = $_POST['userID'];
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		
		// query to reset password
		$queryUser = "UPDATE as_users SET username = '$username', password = '$password' WHERE userID = '$userID'";
		mysqli_query($connect, $queryUser);
		
		// redirect to the main user page 
		header("Location: users.php?code=4");
	} // close bracket
	
	// default
	else 
	{
		// create new object pagination
		$p = new Pagination;
		// limit 10 data for page
		$limit  = 10;
		$position = $p->searchPosition($limit);
		// showing up user data
		$queryUser = "SELECT * FROM as_users WHERE userID != '1' ORDER BY userID ASC LIMIT $position, $limit";
		$sqlUser = mysqli_query($connect, $queryUser);
		
		$i = 1 + $position;
		// fetch data
		while ($dtUser = mysqli_fetch_array($sqlUser))
		{
			// save data into array
			$dataUser[] = array('userID' => $dtUser['userID'],
								'fullName' => $dtUser['fullName'],
								'gender' => $dtUser['gender'],
								'position' => $dtUser['position'],
								'handPhone' => $dtUser['handPhone'],
								'status' => $dtUser['status'],
								'blocked' => $dtUser['blocked'],
								'no' => $i
								);
			$i++;
		}
		
		// count data
		$queryCountUser = "SELECT * FROM as_users WHERE userID != '1'";
		$sqlCountUser = mysqli_query($connect, $queryCountUser);
		$amountData = mysqli_num_rows($sqlCountUser);
		
		$amountPage = $p->amountPage($amountData, $limit);
		$pageLink = $p->navPage($_GET['page'], $amountPage);
		
		$smarty->assign("pageLink", $pageLink);
		// assign to the tpl
		$smarty->assign("dataUser", $dataUser);
		
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>