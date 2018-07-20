<?php
// include header
include "header.php";
// set the tpl page
$page = "anggota_majelis.tpl";

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
	
	// if module is majelis and action is input
	if ($module == 'anggota' && $act == 'input')
	{
		// change each value to variable name
		$createdDate = date('Y-m-d H:i:s');
		$majelis_id = $_POST['majelis_id'];
		$anggota_id = $_POST['anggota_id'];
		$jabatan = $_POST['jabatan'];
		$userID = $_SESSION['userID'];
		
		// save into database
		$queryAnggota = "INSERT INTO as_majelis_anggota (majelis_id,anggota_id,jabatan,created_date,created_userid,modified_date,modified_userid)
		VALUES('$majelis_id','$anggota_id','$jabatan','$createdDate','$userID','','')";
		mysqli_query($connect, $queryAnggota);
		
		// redirect to the main majelis anggota page
		header("Location: anggota_majelis.php?module=anggota&act=detail&majelis_id=".$majelis_id."&code=1");
	} // close bracket
	
	// if module is majelis anggota and action is add
	elseif ($module == 'anggota' && $act == 'add')
	{
		$queryMajelis = "SELECT A.nama_periode, B.majelis_id, B.nama_majelis FROM as_majelis_periode A INNER JOIN as_majelis B ON B.majelis_periode_id=A.majelis_periode_id WHERE B.status = 'Y' ORDER BY A.nama_periode, B.nama_majelis ASC";
		$sqlMajelis = mysqli_query($connect, $queryMajelis);
		
		// fetch data
		while ($dtMajelis = mysqli_fetch_array($sqlMajelis))
		{
			$dataMajelis[] = array(	'majelis_id' => $dtMajelis['majelis_id'],
									'nama_periode' => $dtMajelis['nama_periode'],
									'nama_majelis' => $dtMajelis['nama_majelis']);
		}
		
		$majelis = mysqli_fetch_array(mysqli_query($connect, "SELECT A.nama_periode, B.majelis_id, B.nama_majelis FROM as_majelis_periode A INNER JOIN as_majelis B ON B.majelis_periode_id=A.majelis_periode_id WHERE B.status = 'Y' AND B.majelis_id = '$_GET[majelis_id]'"));
		// assign to the tpl
		$smarty->assign("dataMajelis", $dataMajelis);
		$smarty->assign("majelis_id", $majelis['majelis_id']);
		$smarty->assign("nama_periode", $majelis['nama_periode']);
		$smarty->assign("nama_majelis", $majelis['nama_majelis']);
		
		$queryAnggota = "SELECT full_name, individu_id FROM as_individu ORDER BY full_name ASC";
		$sqlAnggota = mysqli_query($connect, $queryAnggota);
		
		// fetch data
		while ($dtAnggota = mysqli_fetch_array($sqlAnggota))
		{
			$dataAnggota[] = array(	'anggota_id' => $dtAnggota['individu_id'],
									'full_name' => $dtAnggota['full_name']);
		} // close bracket
		
		// assign to the tpl
		$smarty->assign("dataAnggota", $dataAnggota);
	} // close bracket
	
	// if module is majelis anggota and action is edit
	elseif ($module == 'anggota' && $act == 'edit')
	{
		$queryMajelis = "SELECT A.nama_periode, B.majelis_id, B.nama_majelis FROM as_majelis_periode A INNER JOIN as_majelis B ON B.majelis_periode_id=A.majelis_periode_id WHERE B.status = 'Y' ORDER BY A.nama_periode, B.nama_majelis ASC";
		$sqlMajelis = mysqli_query($connect, $queryMajelis);
		
		// fetch data
		while ($dtMajelis = mysqli_fetch_array($sqlMajelis))
		{
			$dataMajelis[] = array(	'majelis_id' => $dtMajelis['majelis_id'],
									'nama_periode' => $dtMajelis['nama_periode'],
									'nama_majelis' => $dtMajelis['nama_majelis']);
		}
		
		// assign to the tpl
		$smarty->assign("dataMajelis", $dataMajelis);
		
		$queryAnggota = "SELECT full_name, individu_id FROM as_individu ORDER BY full_name ASC";
		$sqlAnggota = mysqli_query($connect, $queryAnggota);
		
		// fetch data
		while ($dtAnggota = mysqli_fetch_array($sqlAnggota))
		{
			$dataAnggota[] = array(	'anggota_id' => $dtAnggota['individu_id'],
									'full_name' => $dtAnggota['full_name']);
		} // close bracket
		
		// assign to the tpl
		$smarty->assign("dataAnggota", $dataAnggota);
		
		// get the majelis anggota ID
		$majelis_anggota_id = $_GET['majelis_anggota_id'];
		
		$queryMajelisAnggota = "SELECT * FROM as_majelis_anggota WHERE majelis_anggota_id = '$majelis_anggota_id'";
		$sqlMajelisAnggota = mysqli_query($connect, $queryMajelisAnggota);
		
		// fetch data
		$dataMajelisAnggota = mysqli_fetch_array($sqlMajelisAnggota);
		
		// assign data to the tpl
		$smarty->assign("majelis_anggota_id", $dataMajelisAnggota['majelis_anggota_id']);
		$smarty->assign("majelis_id", $dataMajelisAnggota['majelis_id']);
		$smarty->assign("anggota_id", $dataMajelisAnggota['anggota_id']);
		$smarty->assign("jabatan", $dataMajelisAnggota['jabatan']);
	} //close bracket
	
	// if module is majelis anggota and action is update
	elseif ($module == 'anggota' && $act == 'update')
	{
		// change each value to variable name
		$modifiedDate = date('Y-m-d H:i:s');
		$majelis_anggota_id = $_POST['majelis_anggota_id'];
		$majelis_id = $_POST['majelis_id'];
		$anggota_id = $_POST['anggota_id'];
		$jabatan = $_POST['jabatan'];
		$userID = $_SESSION['userID'];
		
		// save into the database
		$queryMajelisAnggota = "UPDATE as_majelis_anggota SET majelis_id = '$majelis_id', anggota_id = '$anggota_id', jabatan = '$jabatan', modified_date = '$modifiedDate', modified_userid = '$userID' WHERE majelis_anggota_id = '$majelis_anggota_id'";
		mysqli_query($connect, $queryMajelisAnggota);
		
		// redirect to the main majelis anggota page
		header("Location: anggota_majelis.php?code=2");
	} // close bracket
	
	// if module is majelis anggota and action is delete
	elseif ($module == 'anggota' && $act == 'delete')
	{
		// get majelis id
		$majelis_anggota_id = $_GET['majelis_anggota_id'];
		$majelis_id = $_GET['majelis_id'];
		
		// delete from the table
		$queryMajelisAnggota = "DELETE FROM as_majelis_anggota WHERE majelis_anggota_id = '$majelis_anggota_id'";
		mysqli_query($connect, $queryMajelisAnggota);
		
		// redirect to the main majelis anggota page
		header("Location: anggota_majelis.php?module=anggota&act=detail&majelis_id=".$majelis_id."&code=3");
	} // close bracket
	
	// if module is majelis anggota and action is detail
	elseif ($module == 'anggota' && $act == 'detail')
	{
		$majelis_id = $_GET['majelis_id'];
		
		$queryMajelis = "SELECT A.nama_periode, B.majelis_id, B.nama_majelis FROM as_majelis_periode A INNER JOIN as_majelis B ON B.majelis_periode_id=A.majelis_periode_id WHERE B.status = 'Y' AND B.majelis_id = '$majelis_id'";
		$sqlMajelis = mysqli_query($connect, $queryMajelis);
		
		// fetch data
		$dataMajelis = mysqli_fetch_array($sqlMajelis);
		
		$smarty->assign("nama_periode", $dataMajelis['nama_periode']);
		$smarty->assign("nama_majelis", $dataMajelis['nama_majelis']);
		
		$queryAnggota = "SELECT A.majelis_id, A.anggota_id, A.jabatan, B.full_name, A.majelis_anggota_id FROM as_majelis_anggota A INNER JOIN as_individu B ON A.anggota_id=B.individu_id WHERE A.majelis_id = '$dataMajelis[majelis_id]'";
		$sqlAnggota = mysqli_query($connect, $queryAnggota);
		$i = 1;
		// fetch data
		while ($dtAnggota = mysqli_fetch_array($sqlAnggota))
		{
			$dataAnggota[] = array(	'majelis_id' => $dtAnggota['majelis_id'],
									'majelis_anggota_id' => $dtAnggota['majelis_anggota_id'],
									'anggota_id' => $dtAnggota['anggota_id'],
									'jabatan' => $dtAnggota['jabatan'],
									'full_name' => $dtAnggota['full_name'],
									'no' => $i);
			$i++;					
		}
		
		// assign to the tpl
		$smarty->assign("dataAnggota", $dataAnggota);
		$smarty->assign("majelis_id", $majelis_id);
		
	} // close bracket
	
	// default
	else 
	{
		// create new object pagination
		$p = new PaginationMajelisAnggota;
		// limit 10 data for page
		$limit  = 10;
		$position = $p->searchPosition($limit);
		// showing up majelis data
		$queryMajelis = "SELECT A.nama_periode, B.majelis_id, B.nama_majelis FROM as_majelis_periode A INNER JOIN as_majelis B ON B.majelis_periode_id=A.majelis_periode_id WHERE B.status = 'Y' ORDER BY A.nama_periode, B.nama_majelis ASC LIMIT $position, $limit";
		$sqlMajelis = mysqli_query($connect, $queryMajelis);
		
		$i = 1 + $position;
		// fetch data
		while ($dtMajelis = mysqli_fetch_array($sqlMajelis))
		{
			$nums = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM as_majelis_anggota WHERE majelis_id = '$dtMajelis[majelis_id]'"));
			
			// save data into array
			$dataMajelis[] = array(	'majelis_id' => $dtMajelis['majelis_id'],
									'nama_periode' => $dtMajelis['nama_periode'],
									'nama_majelis' => $dtMajelis['nama_majelis'],
									'total' => $nums,
									'no' => $i
									);
			$i++;
		}
		
		// count data
		$queryCountMajelisAnggota = "SELECT A.nama_periode, B.majelis_id, B.nama_majelis FROM as_majelis_periode A INNER JOIN as_majelis B ON B.majelis_periode_id=A.majelis_periode_id WHERE B.status = 'Y'";
		$sqlCountMajelisAnggota = mysqli_query($connect, $queryCountMajelisAnggota);
		$amountData = mysqli_num_rows($sqlCountMajelisAnggota);
		
		$amountPage = $p->amountPage($amountData, $limit);
		$pageLink = $p->navPage($_GET['page'], $amountPage);
		
		$smarty->assign("pageLink", $pageLink);
		// assign to the tpl
		$smarty->assign("dataMajelis", $dataMajelis);
		
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>