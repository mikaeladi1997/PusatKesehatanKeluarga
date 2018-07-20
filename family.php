<?php
// include header
include "header.php";
// set the tpl page
$page = "family.tpl";

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
	
	// if module is family and action is input
	if ($module == 'family' && $act == 'input')
	{
		// change each value to variable name
		$kepala_keluarga = $_POST['kepala_keluarga'];
		
		$queryKeluarga = "SELECT * FROM as_family WHERE kepala_keluarga = '$kepala_keluarga'";
		$sqlKeluarga = mysqli_query($connect, $queryKeluarga);
		$numKeluarga = mysqli_num_rows($sqlKeluarga);
		
		if ($numKeluarga > 0)
		{
			// redirect to the main keluarga page
			header("Location: family.php?module=family&act=add&code=4");
		}
		else {
			// save into database
			$nik = $_POST['nik'];
			$sortno = $_POST['sortno'];
			$kepala_keluarga = $_POST['kepala_keluarga'];
			$tanggal_nikah = $_POST['tanggal_nikah'];
			$alamat = $_POST['alamat'];
			$createdDate = date('Y-m-d H:i:s');
			$userID = $_SESSION['userID'];
			$photo = $_POST['filename'];
			
			$querySave = "INSERT INTO as_family (nik,sortno,kepala_keluarga,tanggal_nikah,alamat,photo,created_date,created_userid,modified_date,modified_userid)
			VALUES ('$nik','$sortno','$kepala_keluarga','$tanggal_nikah','$alamat','$photo','$createdDate','$userID','','')";
			mysqli_query($connect, $querySave);
			
			$fid = mysqli_insert_id($connect);
			
			// redirect to the main keluarga page
			header("Location: family.php?module=family&act=step&fid=".$fid."&code=5");
		}
	} // close bracket
	
	// if module is family and action is add
	elseif ($module == 'family' && $act == 'add')
	{
		// showing up data kepala
		$queryKepala = "SELECT * FROM as_individu ORDER BY full_name ASC";
		$sqlKepala = mysqli_query($connect, $queryKepala);
		
		// fetch data
		while ($dtKepala = mysqli_fetch_array($sqlKepala))
		{
			$dataKepala[] = array(	'kepala_id' => $dtKepala['individu_id'],
									'kepala_name' => $dtKepala['full_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataKepala", $dataKepala);
		
		// get last sort number
		$queryNo = "SELECT sortno FROM as_family ORDER BY sortno DESC LIMIT 1";
		$sqlNo = mysqli_query($connect, $queryNo);
		$numsNo = mysqli_num_rows($sqlNo);
		$dataNo = mysqli_fetch_array($sqlNo);		
		
		$start = substr($dataNo['sortno'],0-4);	
		$next = $start + 1;
		$tempNo = strlen($next);
		
		if ($tempNo == 1)
		{
			$sortno = "000";
		}
		elseif ($tempNo == 2)
		{
			$sortno = "00";
		}
		elseif ($tempNo == 3)
		{
			$sortno = "0";
		}
		elseif ($tempNo == 4)
		{
			$sortno = "";
		}
		
		$psortno = $sortno.$next;
		$nik = $psortno."-GBIAWN-".date('m')."-".date('Y');
		
		// assign sort number to the tpl
		$smarty->assign("sortno", $psortno);
		$smarty->assign("nik", $nik);
	}

	// if module is family and action is step
	elseif ($module == 'family' && $act == 'step')
	{
		// get the family id
		$fid = $_GET['fid'];
		
		// get data based on family id
		$queryFamily = "SELECT A.full_name, B.photo, B.nik, B.alamat, B.tanggal_nikah, B.family_id FROM as_individu A INNER JOIN as_family B ON A.individu_id=B.kepala_keluarga WHERE B.family_id = '$fid'";
		$sqlFamily = mysqli_query($connect, $queryFamily);
		$dataFamily = mysqli_fetch_array($sqlFamily);
		
		// assign to the tpl
		$smarty->assign("full_name", $dataFamily['full_name']);
		$smarty->assign("nik", $dataFamily['nik']);
		$smarty->assign("alamat", $dataFamily['alamat']);
		$smarty->assign("tanggal_nikah", tgl_indo($dataFamily['tanggal_nikah']));
		$smarty->assign("family_id", $dataFamily['family_id']);
		$smarty->assign("fid", $_GET['fid']);
		$smarty->assign("photo", $dataFamily['photo']);
		
		$queryChild = "SELECT B.full_name, B.gender, A.status, A.family_id, A.family_child_id, B.no_induk, B.place_of_birth, B.date_of_birth, C.job_name, B.blood_type, A.status FROM as_family_child A INNER JOIN as_individu B ON B.individu_id=A.child_id LEFT JOIN as_jobs C ON C.job_id=B.job_id
		WHERE A.family_id = '$_GET[fid]' ORDER BY A.family_child_id ASC";
		$sqlChild = mysqli_query($connect, $queryChild);
		$i = 1;
		// fetch data
		while ($dtChild = mysqli_fetch_array($sqlChild))
		{
			if ($dtChild['status'] == '1'){
				$status = "Suami";
			}
			elseif ($dtChild['status'] == '2'){
				$status = "Istri";
			}
			elseif ($dtChild['status'] == '3'){
				$status = "Anak";
			}
		
			$dataChild[] = array(	'full_name' => $dtChild['full_name'],
									'gender' => $dtChild['gender'],
									'cid' => $dtChild['family_child_id'],
									'fid' => $dtChild['family_id'],
									'no_induk' => $dtChild['no_induk'],
									'place_of_birth' => $dtChild['place_of_birth'],
									'date_of_birth' => tgl_indo($dtChild['date_of_birth']),
									'job_name' => $dtChild['job_name'],
									'blood_type' => $dtChild['blood_type'],
									'status' => $status,
									'no' => $i
									);
			$i++;
		}
		
		// assign to the tpl
		$smarty->assign("dataChild", $dataChild);
	} // close bracket
	
	// if module is family and action is update
	elseif ($module == 'family' && $act == 'update')
	{
		$fid = $_POST['fid'];
		$tanggal_nikah = $_POST['tanggal_nikah'];
		$alamat = $_POST['alamat'];
		$photo = $_POST['filename'];
		
		if ($photo != '')
		{
			$queryFid = "UPDATE as_family SET tanggal_nikah = '$tanggal_nikah', alamat = '$alamat', photo = '$photo' WHERE family_id = '$fid'";
			$sqlFid = mysqli_query($connect, $queryFid);
			
			// redirect to the family page
			header("Location: family.php?module=family&act=step&fid=".$fid."&keyword=&code=2");
		}
		else
		{
			$queryFid = "UPDATE as_family SET tanggal_nikah = '$tanggal_nikah', alamat = '$alamat' WHERE family_id = '$fid'";
			$sqlFid = mysqli_query($connect, $queryFid);
			
			// redirect to the family page
			header("Location: family.php?module=family&act=step&fid=".$fid."&keyword=&code=2");
		}
	} // close bracket
	
	// if module is family and action is edit
	elseif ($module == 'family' && $act == 'edit')
	{
		$fid = $_GET['fid'];
		
		$queryFid = "SELECT B.full_name, A.nik, A.family_id, A.sortno, A.tanggal_nikah, A.alamat, A.photo FROM as_family A INNER JOIN as_individu B ON A.kepala_keluarga=B.individu_id WHERE A.family_id = '$fid'";
		$sqlFid = mysqli_query($connect, $queryFid);
		
		$dataFid = mysqli_fetch_array($sqlFid);
		
		$smarty->assign("full_name", $dataFid['full_name']);
		$smarty->assign("nik", $dataFid['nik']);
		$smarty->assign("fid", $dataFid['family_id']);
		$smarty->assign("sortno", $dataFid['sortno']);
		$smarty->assign("tanggal_nikah", $dataFid['tanggal_nikah']);
		$smarty->assign("alamat", $dataFid['alamat']);
		$smarty->assign("photo", $dataFid['photo']);
	} // close bracket
	
	// if module is family and action is addchildinput
	elseif ($module == 'family' && $act == 'addchildinput')
	{
		$createdDate = date('Y-m-d H:i:s');
		$child_id = $_POST['child_id'];
		$fid = $_POST['fid'];
		$status = $_POST['status'];
		$keterangan = $_POST['keterangan'];
		$userID = $_SESSION['userID'];
		
		$queryChild = "INSERT INTO as_family_child (family_id,child_id,status,keterangan,created_date,created_userid,modified_date,modified_userid)
		VALUES('$fid','$child_id','$status','$keterangan','$createdDate','$userID','','')";
		$sqlChild = mysqli_query($connect, $queryChild);
		
		header("Location: family.php?module=family&act=step&fid=".$fid."&code=4");
	} // close bracket
	
	// if module is family and action is addchild
	elseif ($module == 'family' && $act == 'addchild')
	{
		// showing up data kepala
		$queryKepala = "SELECT * FROM as_individu ORDER BY full_name ASC";
		$sqlKepala = mysqli_query($connect, $queryKepala);
		
		// fetch data
		while ($dtKepala = mysqli_fetch_array($sqlKepala))
		{
			$dataKepala[] = array(	'kepala_id' => $dtKepala['individu_id'],
									'kepala_name' => $dtKepala['full_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataKepala", $dataKepala);
		
		// get the family id
		$fid = $_GET['fid'];
		
		// get data based on family id
		$queryFamily = "SELECT A.full_name, B.nik, B.alamat, B.family_id, B.tanggal_nikah FROM as_individu A INNER JOIN as_family B ON A.individu_id=B.kepala_keluarga WHERE B.family_id = '$fid'";
		$sqlFamily = mysqli_query($connect, $queryFamily);
		$dataFamily = mysqli_fetch_array($sqlFamily);
		
		// assign to the tpl
		$smarty->assign("full_name", $dataFamily['full_name']);
		$smarty->assign("nik", $dataFamily['nik']);
		$smarty->assign("alamat", $dataFamily['alamat']);
		$smarty->assign("family_id", $dataFamily['family_id']);
		$smarty->assign("tanggal_nikah", tgl_indo($dataFamily['tanggal_nikah']));
		$smarty->assign("fid", $fid);
	} // close bracket
	
	// if module is family and action is search
	elseif ($module == 'family' && $act == 'search')
	{
		$name = $_GET['name'];
		$querySearch = "SELECT A.nik, A.family_id, A.alamat, B.full_name, A.tanggal_nikah FROM as_family A INNER JOIN as_individu B ON B.individu_id=A.kepala_keluarga WHERE B.full_name LIKE '%$name%' ORDER BY B.full_name ASC";
		$sqlSearch = mysqli_query($connect, $querySearch);
		$numSearch = mysqli_num_rows($sqlSearch);
		$i = 1;
		while ($dtSearch = mysqli_fetch_array($sqlSearch))
		{
			$dataSearch[] = array(	'fid' => $dtSearch['family_id'],
									'nik' => $dtSearch['nik'],
									'alamat' => $dtSearch['alamat'],
									'full_name' => $dtSearch['full_name'],
									'tanggal_nikah' => tgl_indo($dtSearch['tanggal_nikah']),
									'no' => $i);
			$i++;
		}
		
		// assign to the tpl
		$smarty->assign("dataSearch", $dataSearch);
		$smarty->assign("numSearch", $numSearch);
		$smarty->assign("keyword", $name);
	} // close bracket
	
	// if module is family and action is delete
	elseif ($module == 'family' && $act == 'delete')
	{
		// get cid
		$cid = $_GET['cid'];
		$fid = $_GET['fid'];
		
		// delete from the table
		$queryFamily = "DELETE FROM as_family_child WHERE family_child_id = '$cid'";
		mysqli_query($connect, $queryFamily);
		
		// redirect to the main family page
		header("Location: family.php?module=family&act=step&fid=".$fid."&code=6");
	} // close bracket
	
	// if module is family and action is delete
	elseif ($module == 'family' && $act == 'deletefam')
	{
		// get fid
		$fid = $_GET['fid'];
		$name = $_GET['name'];
		
		// delete from the table
		$queryChild = "DELETE FROM as_family_child WHERE family_id = '$fid'";
		mysqli_query($connect, $queryChild);
		
		// delete from the table
		$queryFamily = "DELETE FROM as_family WHERE family_id = '$fid'";
		mysqli_query($connect, $queryFamily);
		
		// redirect to the main family page
		header("Location: family.php?module=family&act=search&name=".$name."&code=7");
	} // close bracket
	
	// default
	else 
	{
			
	} // close bracket
	
	// assign code to the tpl
	$smarty->assign("code", $_GET['code']);
	$smarty->assign("module", $_GET['module']);
	$smarty->assign("act", $_GET['act']);
	
} // close bracket

// include footer
include "footer.php";
?>