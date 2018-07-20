<?php
// include header
include "header.php";
// set the tpl page
$page = "staff.tpl";

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
	
	// if module is staff and action is input
	if ($module == 'staff' && $act == 'input')
	{
		// change each value to variable name
		$createdDate = date('Y-m-d H:i:s');
		$anggota_id = $_POST['anggota_id'];
		$jabatan = $_POST['jabatan'];
		$tanggal_mulai = $_POST['tanggal_mulai'];
		$tanggal_keluar = $_POST['tanggal_keluar'];
		$status = $_POST['status'];
		$userID = $_SESSION['userID'];
		
		$queryStaff = "INSERT INTO as_staffs (anggota_id,jabatan,tanggal_mulai,tanggal_keluar,status,created_date,created_userid,modified_date,modified_userid)
		VALUES('$anggota_id','$jabatan','$tanggal_mulai','$tanggal_keluar','$status','$createdDate','$userID','','')";
		mysqli_query($connect, $queryStaff);
		
		// redirect to the main staff page
		header("Location: staff.php?code=1");
	} // close bracket
	
	// if module is staff and action is add
	elseif ($module == 'staff' && $act == 'add')
	{
		$queryAnggota = "SELECT individu_id, full_name FROM as_individu ORDER BY full_name ASC";
		$sqlAnggota = mysqli_query($connect, $queryAnggota);
		
		// fetch data
		while ($dtAnggota = mysqli_fetch_array($sqlAnggota))
		{
			$dataAnggota[] = array(	'anggota_id' => $dtAnggota['individu_id'],
									'full_name' => $dtAnggota['full_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataAnggota", $dataAnggota);
	} // close bracket
	
	// if module is staff and action is edit
	elseif ($module == 'staff' && $act == 'edit')
	{
		$queryAnggota = "SELECT individu_id, full_name FROM as_individu ORDER BY full_name ASC";
		$sqlAnggota = mysqli_query($connect, $queryAnggota);
		
		// fetch data
		while ($dtAnggota = mysqli_fetch_array($sqlAnggota))
		{
			$dataAnggota[] = array(	'anggota_id' => $dtAnggota['individu_id'],
									'full_name' => $dtAnggota['full_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataAnggota", $dataAnggota);
		
		// get the staff ID
		$staff_id = $_GET['staff_id'];
		
		$queryStaff = "SELECT * FROM as_staffs WHERE staff_id = '$staff_id'";
		$sqlStaff = mysqli_query($connect, $queryStaff);
		
		// fetch data
		$dataStaff = mysqli_fetch_array($sqlStaff);
		
		// assign data to the tpl
		$smarty->assign("staff_id", $dataStaff['staff_id']);
		$smarty->assign("anggota_id", $dataStaff['anggota_id']);
		$smarty->assign("jabatan", $dataStaff['jabatan']);
		$smarty->assign("tanggal_mulai", $dataStaff['tanggal_mulai']);
		$smarty->assign("tanggal_keluar", $dataStaff['tanggal_keluar']);
		$smarty->assign("status", $dataStaff['status']);
	} //close bracket
	
	// if module is staff and action is update
	elseif ($module == 'staff' && $act == 'update')
	{
		// change each value to variable name
		$modifiedDate = date('Y-m-d H:i:s');
		$staff_id = $_POST['staff_id'];
		$anggota_id = $_POST['anggota_id'];
		$jabatan = $_POST['jabatan'];
		$tanggal_mulai = $_POST['tanggal_mulai'];
		$tanggal_keluar = $_POST['tanggal_keluar'];
		$status = $_POST['status']; 
		$userID = $_SESSION['userID'];
		
		$queryStaff = "UPDATE as_staffs SET anggota_id = '$anggota_id', jabatan = '$jabatan', tanggal_mulai = '$tanggal_mulai', tanggal_keluar = '$tanggal_keluar', status = '$status', modified_date = '$modifiedDate',
		modified_userid = '$userID' WHERE staff_id = '$staff_id'";
		mysqli_query($connect, $queryStaff);
		
		// redirect to the main staff page
		header("Location: staff.php?code=2");
	} // close bracket
	
	// if module is staff and action is delete
	elseif ($module == 'staff' && $act == 'delete')
	{
		// get staff id
		$staff_id = $_GET['staff_id'];
		
		// delete from the table
		$queryStaff = "DELETE FROM as_staffs WHERE staff_id = '$staff_id'";
		mysqli_query($connect, $queryStaff);
		
		// redirect to the main staff page
		header("Location: staff.php?code=3");
	} // close bracket
	
	// default
	else 
	{
		// create new object pagination
		$p = new PaginationStaff;
		// limit 10 data for page
		$limit  = 10;
		$position = $p->searchPosition($limit);
		// showing up staff data
		$queryStaff = "SELECT A.jabatan, A.staff_id, A.tanggal_mulai, A.tanggal_keluar, A.status, B.no_induk, B.full_name FROM as_staffs A INNER JOIN as_individu B ON A.anggota_id=B.individu_id ORDER BY A.staff_id ASC LIMIT $position, $limit";
		$sqlStaff = mysqli_query($connect, $queryStaff);
		
		$i = 1 + $position;
		// fetch data
		while ($dtStaff = mysqli_fetch_array($sqlStaff))
		{
			// save data into array
			$dataStaff[] = array(	'staff_id' => $dtStaff['staff_id'],
									'jabatan' => $dtStaff['jabatan'],
									'tanggal_mulai' => tgl_indo($dtStaff['tanggal_mulai']),
									'tanggal_keluar' => tgl_indo($dtStaff['tanggal_keluar']),
									'status' => $dtStaff['status'],
									'no_induk' => $dtStaff['no_induk'],
									'full_name' => $dtStaff['full_name'],
									'no' => $i
									);
			$i++;
		}
		
		// count data
		$queryCountStaff = "SELECT A.jabatan, A.staff_id, A.tanggal_mulai, A.tanggal_keluar, A.status, B.no_induk, B.full_name FROM as_staffs A INNER JOIN as_individu B ON A.anggota_id=B.individu_id";
		$sqlCountStaff = mysqli_query($connect, $queryCountStaff);
		$amountData = mysqli_num_rows($sqlCountStaff);
		
		$amountPage = $p->amountPage($amountData, $limit);
		$pageLink = $p->navPage($_GET['page'], $amountPage);
		
		$smarty->assign("pageLink", $pageLink);
		// assign to the tpl
		$smarty->assign("dataStaff", $dataStaff);
		
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>