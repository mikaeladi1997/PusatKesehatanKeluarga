<?php
// include header
include "header.php";
// set the tpl page
$page = "anggota_komisi.tpl";

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
	
	// if module is komisi and action is input
	if ($module == 'anggota' && $act == 'input')
	{
		// change each value to variable name
		$createdDate = date('Y-m-d H:i:s');
		$komisi_id = $_POST['komisi_id'];
		$anggota_id = $_POST['anggota_id'];
		$jabatan = $_POST['jabatan'];
		$userID = $_SESSION['userID'];
		
		// save into database
		$queryAnggota = "INSERT INTO as_komisi_anggota (komisi_id,anggota_id,jabatan,created_date,created_userid,modified_date,modified_userid)
		VALUES('$komisi_id','$anggota_id','$jabatan','$createdDate','$userID','','')";
		mysqli_query($connect, $queryAnggota);
		
		// redirect to the main komisi anggota page
		header("Location: anggota_komisi.php?module=anggota&act=detail&komisi_id=".$komisi_id."&code=1");
	} // close bracket
	
	// if module is komisi anggota and action is add
	elseif ($module == 'anggota' && $act == 'add')
	{
		$queryKomisi = "SELECT A.nama_periode, B.komisi_id, B.nama_komisi FROM as_komisi_periode A INNER JOIN as_komisi B ON B.komisi_periode_id=A.komisi_periode_id WHERE B.status = 'Y' ORDER BY A.nama_periode, B.nama_komisi ASC";
		$sqlKomisi = mysqli_query($connect, $queryKomisi);
		
		// fetch data
		while ($dtKomisi = mysqli_fetch_array($sqlKomisi))
		{
			$dataKomisi[] = array(	'komisi_id' => $dtKomisi['komisi_id'],
									'nama_periode' => $dtKomisi['nama_periode'],
									'nama_komisi' => $dtKomisi['nama_komisi']);
		}
		
		$komisi = mysqli_fetch_array(mysqli_query($connect, "SELECT A.nama_periode, B.komisi_id, B.nama_komisi FROM as_komisi_periode A INNER JOIN as_komisi B ON B.komisi_periode_id=A.komisi_periode_id WHERE B.status = 'Y' AND B.komisi_id = '$_GET[komisi_id]'"));
		// assign to the tpl
		$smarty->assign("dataKomisi", $dataKomisi);
		$smarty->assign("komisi_id", $komisi['komisi_id']);
		$smarty->assign("nama_periode", $komisi['nama_periode']);
		$smarty->assign("nama_komisi", $komisi['nama_komisi']);
		
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
	
	// if module is komisi anggota and action is edit
	elseif ($module == 'anggota' && $act == 'edit')
	{
		$queryKomisi = "SELECT A.nama_periode, B.komisi_id, B.nama_komisi FROM as_komisi_periode A INNER JOIN as_komisi B ON B.komisi_periode_id=A.komisi_periode_id WHERE B.status = 'Y' ORDER BY A.nama_periode, B.nama_komisi ASC";
		$sqlKomisi = mysqli_query($connect, $queryKomisi);
		
		// fetch data
		while ($dtKomisi = mysqli_fetch_array($sqlKomisi))
		{
			$dataKomisi[] = array(	'komisi_id' => $dtKomisi['komisi_id'],
									'nama_periode' => $dtKomisi['nama_periode'],
									'nama_komisi' => $dtKomisi['nama_komisi']);
		}
		
		// assign to the tpl
		$smarty->assign("dataKomisi", $dataKomisi);
		
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
		
		// get the komisi anggota ID
		$komisi_anggota_id = $_GET['komisi_anggota_id'];
		
		$queryKomisiAnggota = "SELECT * FROM as_komisi_anggota WHERE komisi_anggota_id = '$komisi_anggota_id'";
		$sqlKomisiAnggota = mysqli_query($connect, $queryKomisiAnggota);
		
		// fetch data
		$dataKomisiAnggota = mysqli_fetch_array($sqlKomisiAnggota);
		
		// assign data to the tpl
		$smarty->assign("komisi_anggota_id", $dataKomisiAnggota['komisi_anggota_id']);
		$smarty->assign("komisi_id", $dataKomisiAnggota['komisi_id']);
		$smarty->assign("anggota_id", $dataKomisiAnggota['anggota_id']);
		$smarty->assign("jabatan", $dataKomisiAnggota['jabatan']);
	} //close bracket
	
	// if module is komisi anggota and action is update
	elseif ($module == 'anggota' && $act == 'update')
	{
		// change each value to variable name
		$modifiedDate = date('Y-m-d H:i:s');
		$komisi_anggota_id = $_POST['komisi_anggota_id'];
		$komisi_id = $_POST['komisi_id'];
		$anggota_id = $_POST['anggota_id'];
		$jabatan = $_POST['jabatan'];
		$userID = $_SESSION['userID'];
		
		// save into the database
		$queryKomisiAnggota = "UPDATE as_komisi_anggota SET komisi_id = '$komisi_id', anggota_id = '$anggota_id', jabatan = '$jabatan', modified_date = '$modifiedDate', modified_userid = '$userID' WHERE komisi_anggota_id = '$komisi_anggota_id'";
		mysqli_query($connect, $queryKomisiAnggota);
		
		// redirect to the main komisi anggota page
		header("Location: anggota_komisi.php?code=2");
	} // close bracket
	
	// if module is komisi anggota and action is delete
	elseif ($module == 'anggota' && $act == 'delete')
	{
		// get komisi id
		$komisi_anggota_id = $_GET['komisi_anggota_id'];
		$komisi_id = $_GET['komisi_id'];
		
		// delete from the table
		$queryKomisiAnggota = "DELETE FROM as_komisi_anggota WHERE komisi_anggota_id = '$komisi_anggota_id'";
		mysqli_query($connect, $queryKomisiAnggota);
		
		// redirect to the main komisi anggota page
		header("Location: anggota_komisi.php?module=anggota&act=detail&komisi_id=".$komisi_id."&code=3");
	} // close bracket
	
	// if module is komisi anggota and action is detail
	elseif ($module == 'anggota' && $act == 'detail')
	{
		$komisi_id = $_GET['komisi_id'];
		
		$queryKomisi = "SELECT A.nama_periode, B.komisi_id, B.nama_komisi FROM as_komisi_periode A INNER JOIN as_komisi B ON B.komisi_periode_id=A.komisi_periode_id WHERE B.status = 'Y' AND B.komisi_id = '$komisi_id'";
		$sqlKomisi = mysqli_query($connect, $queryKomisi);
		
		// fetch data
		$dataKomisi = mysqli_fetch_array($sqlKomisi);
		
		$smarty->assign("nama_periode", $dataKomisi['nama_periode']);
		$smarty->assign("nama_komisi", $dataKomisi['nama_komisi']);
		
		$queryAnggota = "SELECT A.komisi_id, A.anggota_id, A.jabatan, B.full_name, A.komisi_anggota_id FROM as_komisi_anggota A INNER JOIN as_individu B ON A.anggota_id=B.individu_id WHERE A.komisi_id = '$dataKomisi[komisi_id]'";
		$sqlAnggota = mysqli_query($connect, $queryAnggota);
		$i = 1;
		// fetch data
		while ($dtAnggota = mysqli_fetch_array($sqlAnggota))
		{
			$dataAnggota[] = array(	'komisi_id' => $dtAnggota['komisi_id'],
									'komisi_anggota_id' => $dtAnggota['komisi_anggota_id'],
									'anggota_id' => $dtAnggota['anggota_id'],
									'jabatan' => $dtAnggota['jabatan'],
									'full_name' => $dtAnggota['full_name'],
									'no' => $i);
			$i++;					
		}
		
		// assign to the tpl
		$smarty->assign("dataAnggota", $dataAnggota);
		$smarty->assign("komisi_id", $komisi_id);
		
	} // close bracket
	
	// default
	else 
	{
		// create new object pagination
		$p = new PaginationKomisiAnggota;
		// limit 10 data for page
		$limit  = 10;
		$position = $p->searchPosition($limit);
		// showing up komisi data
		$queryKomisi = "SELECT A.nama_periode, B.komisi_id, B.nama_komisi FROM as_komisi_periode A INNER JOIN as_komisi B ON B.komisi_periode_id=A.komisi_periode_id WHERE B.status = 'Y' ORDER BY A.nama_periode, B.nama_komisi ASC LIMIT $position, $limit";
		$sqlKomisi = mysqli_query($connect, $queryKomisi);
		
		$i = 1 + $position;
		// fetch data
		while ($dtKomisi = mysqli_fetch_array($sqlKomisi))
		{
			$nums = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM as_komisi_anggota WHERE komisi_id = '$dtKomisi[komisi_id]'"));
			
			// save data into array
			$dataKomisi[] = array(	'komisi_id' => $dtKomisi['komisi_id'],
									'nama_periode' => $dtKomisi['nama_periode'],
									'nama_komisi' => $dtKomisi['nama_komisi'],
									'total' => $nums,
									'no' => $i
									);
			$i++;
		}
		
		// count data
		$queryCountKomisiAnggota = "SELECT A.nama_periode, B.komisi_id, B.nama_komisi FROM as_komisi_periode A INNER JOIN as_komisi B ON B.komisi_periode_id=A.komisi_periode_id WHERE B.status = 'Y'";
		$sqlCountKomisiAnggota = mysqli_query($connect, $queryCountKomisiAnggota);
		$amountData = mysqli_num_rows($sqlCountKomisiAnggota);
		
		$amountPage = $p->amountPage($amountData, $limit);
		$pageLink = $p->navPage($_GET['page'], $amountPage);
		
		$smarty->assign("pageLink", $pageLink);
		// assign to the tpl
		$smarty->assign("dataKomisi", $dataKomisi);
		
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>