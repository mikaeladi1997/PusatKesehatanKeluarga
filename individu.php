<?php
// include header
include "header.php";
// set the tpl page
$page = "individu.tpl";

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
	
	// if module is individu and action is input
	if ($module == 'individu' && $act == 'input')
	{
		// change each value to variable name
		$createdDate = date('Y-m-d H:i:s');
		$full_name = $_POST['full_name'];
		$nick_name = $_POST['nick_name'];
		$address = $_POST['address'];
		$telepon = $_POST['telepon'];
		$hp = $_POST['hp'];
		$gender = $_POST['gender'];
		$blood_type = $_POST['blood_type'];
		$place_of_birth = $_POST['place_of_birth'];
		$date_of_birth = $_POST['date_of_birth'];
		$death_status = $_POST['death_status'];
		$death_date = $_POST['death_date'];
		$funeral_id = $_POST['funeral_id'];
		$religion = $_POST['religion'];
		$disability = $_POST['disability'];
		$father_id = $_POST['father_id'];
		$mother_id = $_POST['mother_id'];
		$photo = $_POST['filename'];
		$email = $_POST['email'];
		$status = $_POST['status'];
		$negara = $_POST['negara'];
		$pendidikan_terakhir = $_POST['pendidikan_terakhir'];
		$nama_lembaga = $_POST['nama_lembaga'];
		$job_id = $_POST['job_id'];
		$side_job = $_POST['side_job'];
		$grade_id = $_POST['grade_id'];
		$hobi = $_POST['hobi'];
		$bakat = $_POST['bakat'];
		$pasangan_id = $_POST['pasangan_id'];
		$tanggal_nikah = $_POST['tanggal_nikah'];
		$status_nikah = $_POST['status_nikah'];
		$no_induk = $_POST['no_induk'];
		
		// save into database
		$queryIndividu = "INSERT INTO as_individu(	no_induk,
													full_name,
													nick_name,
													address,
													telepon,
													hp,
													gender,
													blood_type,
													place_of_birth,
													date_of_birth,
													death_status,
													death_date,
													funeral_id,
													religion,
													disability,
													father_id,
													mother_id,
													photo,
													email,
													status,
													negara,
													pendidikan_terakhir,
													nama_lembaga,
													job_id,
													side_job,
													grade_id,
													hobi,
													bakat,
													pasangan_id,
													tanggal_nikah,
													status_nikah
													)
											VALUES(	'$no_induk',
													'$full_name',
													'$nick_name',
													'$address',
													'$telepon',
													'$hp',
													'$gender',
													'$blood_type',
													'$place_of_birth',
													'$date_of_birth',
													'$death_status',
													'$death_date',
													'$funeral_id',
													'$religion',
													'$disability',
													'$father_id',
													'$mother_id',
													'$photo',
													'$email',
													'$status',
													'$negara',
													'$pendidikan_terakhir',
													'$nama_lembaga',
													'$job_id',
													'$side_job',
													'$grade_id',
													'$hobi',
													'$bakat',
													'$pasangan_id',
													'$tanggal_nikah',
													'$status_nikah')";
		
		mysqli_query($connect, $queryIndividu);
			
		// redirect to the main individu page
		header("Location: individu.php?code=1");
	} // close bracket
	
	// if module is individu and action is search
	elseif ($module == 'individu' && $act == 'search')
	{
		// get keyword
		$name = $_GET['name'];
		
		// showing up search of name
		$querySearch = "SELECT * FROM as_individu WHERE full_name LIKE '%$name%' ORDER BY full_name ASC";
		$sqlSearch = mysqli_query($connect, $querySearch);
		$numSearch = mysqli_num_rows($sqlSearch);
		$i = 1;
		// fetch data
		while ($dtSearch = mysqli_fetch_array($sqlSearch))
		{
			$dataSearch[] = array(	'individu_id' => $dtSearch['individu_id'],
									'no_induk' => $dtSearch['no_induk'],
									'full_name' => $dtSearch['full_name'],
									'nick_name' => $dtSearch['nick_name'],
									'place_of_birth' => $dtSearch['place_of_birth'],
									'date_of_birth' => tgl_indo($dtSearch['date_of_birth']),
									'gender' => $dtSearch['gender'],
									'status' => $dtSearch['status'],
									'no' => $i
									);
			$i++;
		}
		
		$smarty->assign("dataSearch", $dataSearch);
		$smarty->assign("keyword", $name);
		$smarty->assign("numSearch", $numSearch);
	} // close bracket
	
	// if module is individu and action is add
	elseif ($module == 'individu' && $act == 'add')
	{
		// get last sort number
		$queryNo = "SELECT no_induk FROM as_individu ORDER BY no_induk DESC LIMIT 1";
		$sqlNo = mysqli_query($connect, $queryNo);
		$numsNo = mysqli_num_rows($sqlNo);
		$dataNo = mysqli_fetch_array($sqlNo);		
		
		$start = substr($dataNo['no_induk'],0-4);	
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
		
		// assign sort number to the tpl
		$smarty->assign("sortno", $psortno);
		
		// showing up data funeral
		$queryFuneral = "SELECT * FROM as_funeral WHERE status = 'Y' ORDER BY funeral_name ASC";
		$sqlFuneral = mysqli_query($connect, $queryFuneral);
		
		// fetch data
		while ($dtFuneral = mysqli_fetch_array($sqlFuneral))
		{
			$dataFuneral[] = array(	'funeral_id' => $dtFuneral['funeral_id'],
									'funeral_name' => $dtFuneral['funeral_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataFuneral", $dataFuneral);
		
		// showing up data father
		$queryFather = "SELECT individu_id, full_name FROM as_individu WHERE gender = 'L' ORDER BY full_name ASC";
		$sqlFather = mysqli_query($connect, $queryFather);
		
		// fetch data
		while ($dtFather = mysqli_fetch_array($sqlFather))
		{
			$dataFather[] = array(	'father_id' => $dtFather['individu_id'],
									'full_name' => $dtFather['full_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataFather", $dataFather);
		
		// showing up data mother
		$queryMother = "SELECT individu_id, full_name FROM as_individu WHERE gender = 'P' ORDER BY full_name ASC";
		$sqlMother = mysqli_query($connect, $queryMother);
		
		// fetch data
		while ($dtMother = mysqli_fetch_array($sqlMother))
		{
			$dataMother[] = array(	'mother_id' => $dtMother['individu_id'],
									'full_name' => $dtMother['full_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataMother", $dataMother);
		
		// showing up data job
		$queryJob = "SELECT * FROM as_jobs WHERE status = 'Y' ORDER BY job_name ASC";
		$sqlJob = mysqli_query($connect, $queryJob);
		
		// fetch data
		while ($dtJob = mysqli_fetch_array($sqlJob))
		{
			$dataJob[] = array(	'job_id' => $dtJob['job_id'],
								'job_name' => $dtJob['job_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataJob", $dataJob);
		
		// showing up data grade
		$queryGrade = "SELECT * FROM as_grade WHERE status = 'Y' ORDER BY grade_id ASC";
		$sqlGrade = mysqli_query($connect, $queryGrade);
		
		// fetch data
		while ($dtGrade = mysqli_fetch_array($sqlGrade))
		{
			$dataGrade[] = array(	'grade_id' => $dtGrade['grade_id'],
									'grade_name' => $dtGrade['grade_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataGrade", $dataGrade);
		
		// showing up data pasangan
		$queryPasangan = "SELECT individu_id, full_name FROM as_individu ORDER BY full_name ASC";
		$sqlPasangan = mysqli_query($connect, $queryPasangan);
		
		// fetch data
		while ($dtPasangan = mysqli_fetch_array($sqlPasangan))
		{
			$dataPasangan[] = array(	'pasangan_id' => $dtPasangan['individu_id'],
										'full_name' => $dtPasangan['full_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataPasangan", $dataPasangan);
	} // close bracket
	
	// if module is individu and action is view
	elseif ($module == 'individu' && $act == 'view')
	{
		// get the individu ID
		$individuID = $_GET['individuID'];
		
		$queryIndividu = "SELECT * FROM as_individu WHERE individu_id = '$individuID'";
		$sqlIndividu = mysqli_query($connect, $queryIndividu);
		
		$dataIndividu = mysqli_fetch_array($sqlIndividu);
		
		// showing up data funeral
		$queryFuneral = "SELECT * FROM as_funeral WHERE funeral_id = '$dataIndividu[funeral_id]'";
		$dataFuneral = mysqli_fetch_array(mysqli_query($connect, $queryFuneral));
				
		// showing up data job
		$queryJob = "SELECT * FROM as_jobs WHERE job_id = '$dataIndividu[job_id]'";
		$dataJob = mysqli_fetch_array(mysqli_query($connect, $queryJob));
		
		// showing up data grade
		$queryGrade = "SELECT * FROM as_grade WHERE grade_id = '$dataIndividu[grade_id]'";
		$dataGrade = mysqli_fetch_array(mysqli_query($connect, $queryGrade));
		
		if ($dataIndividu['status'] == 'Y')
		{
			$status = "WNI";
		}
		else
		{
			$status = "WNA";
		}
		
		$smarty->assign("no_induk", $dataIndividu['no_induk']);
		$smarty->assign("individu_id", $dataIndividu['individu_id']);
		$smarty->assign("full_name", $dataIndividu['full_name']);
		$smarty->assign("nick_name", $dataIndividu['nick_name']);
		$smarty->assign("address", $dataIndividu['address']);
		$smarty->assign("telepon", $dataIndividu['telepon']);
		$smarty->assign("hp", $dataIndividu['hp']);
		$smarty->assign("gender", $dataIndividu['gender']);
		$smarty->assign("blood_type", $dataIndividu['blood_type']);
		$smarty->assign("place_of_birth", $dataIndividu['place_of_birth']);
		$smarty->assign("date_of_birth", tgl_indo($dataIndividu['date_of_birth']));
		$smarty->assign("death_status", $dataIndividu['death_status']);
		$smarty->assign("death_date", tgl_indo($dataIndividu['death_date']));
		$smarty->assign("funeral_name", $dataFuneral['funeral_name']);
		$smarty->assign("religion", $dataIndividu['religion']);
		$smarty->assign("disability", $dataIndividu['disability']);
		$smarty->assign("father_name", $dataIndividu['father_id']);
		$smarty->assign("mother_name", $dataIndividu['mother_id']);
		$smarty->assign("photo", $dataIndividu['photo']);
		$smarty->assign("email", $dataIndividu['email']);
		$smarty->assign("status", $status);
		$smarty->assign("negara", $dataIndividu['negara']);
		$smarty->assign("pendidikan_terakhir", $dataIndividu['pendidikan_terakhir']);
		$smarty->assign("nama_lembaga", $dataIndividu['nama_lembaga']);
		$smarty->assign("job_name", $dataJob['job_name']);
		$smarty->assign("side_job", $dataIndividu['side_job']);
		$smarty->assign("grade_name", $dataGrade['grade_name']);
		$smarty->assign("hobi", $dataIndividu['hobi']);
		$smarty->assign("bakat", $dataIndividu['bakat']);
		$smarty->assign("pasangan_name", $dataIndividu['pasangan_id']);
		$smarty->assign("tanggal_nikah", tgl_indo($dataIndividu['tanggal_nikah']));
		$smarty->assign("status_nikah", $dataIndividu['status_nikah']);
		$smarty->assign("keyword", $_GET['keyword']);
	} //close bracket
	
	// if module is individu and action is edit
	elseif ($module == 'individu' && $act == 'edit')
	{
		// showing up data funeral
		$queryFuneral = "SELECT * FROM as_funeral WHERE status = 'Y' ORDER BY funeral_name ASC";
		$sqlFuneral = mysqli_query($connect, $queryFuneral);
		
		// fetch data
		while ($dtFuneral = mysqli_fetch_array($sqlFuneral))
		{
			$dataFuneral[] = array(	'funeral_id' => $dtFuneral['funeral_id'],
									'funeral_name' => $dtFuneral['funeral_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataFuneral", $dataFuneral);
		
		// showing up data father
		$queryFather = "SELECT individu_id, full_name FROM as_individu WHERE gender = 'L' ORDER BY full_name ASC";
		$sqlFather = mysqli_query($connect, $queryFather);
		
		// fetch data
		while ($dtFather = mysqli_fetch_array($sqlFather))
		{
			$dataFather[] = array(	'father_id' => $dtFather['individu_id'],
									'full_name' => $dtFather['full_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataFather", $dataFather);
		
		// showing up data mother
		$queryMother = "SELECT individu_id, full_name FROM as_individu WHERE gender = 'P' ORDER BY full_name ASC";
		$sqlMother = mysqli_query($connect, $queryMother);
		
		// fetch data
		while ($dtMother = mysqli_fetch_array($sqlMother))
		{
			$dataMother[] = array(	'mother_id' => $dtMother['individu_id'],
									'full_name' => $dtMother['full_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataMother", $dataMother);
		
		// showing up data job
		$queryJob = "SELECT * FROM as_jobs WHERE status = 'Y' ORDER BY job_name ASC";
		$sqlJob = mysqli_query($connect, $queryJob);
		
		// fetch data
		while ($dtJob = mysqli_fetch_array($sqlJob))
		{
			$dataJob[] = array(	'job_id' => $dtJob['job_id'],
								'job_name' => $dtJob['job_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataJob", $dataJob);
		
		// showing up data grade
		$queryGrade = "SELECT * FROM as_grade WHERE status = 'Y' ORDER BY grade_id ASC";
		$sqlGrade = mysqli_query($connect, $queryGrade);
		
		// fetch data
		while ($dtGrade = mysqli_fetch_array($sqlGrade))
		{
			$dataGrade[] = array(	'grade_id' => $dtGrade['grade_id'],
									'grade_name' => $dtGrade['grade_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataGrade", $dataGrade);
		
		// showing up data pasangan
		$queryPasangan = "SELECT individu_id, full_name FROM as_individu ORDER BY full_name ASC";
		$sqlPasangan = mysqli_query($connect, $queryPasangan);
		
		// fetch data
		while ($dtPasangan = mysqli_fetch_array($sqlPasangan))
		{
			$dataPasangan[] = array(	'pasangan_id' => $dtPasangan['individu_id'],
										'full_name' => $dtPasangan['full_name']);
		}
		
		// assign to the tpl
		$smarty->assign("dataPasangan", $dataPasangan);
		
		// get the individu ID
		$individuID = $_GET['individuID'];
		
		$queryIndividu = "SELECT * FROM as_individu WHERE individu_id = '$individuID'";
		$sqlIndividu = mysqli_query($connect, $queryIndividu);
		
		$dataIndividu = mysqli_fetch_array($sqlIndividu);
		
		$smarty->assign("no_induk", $dataIndividu['no_induk']);
		$smarty->assign("individu_id", $dataIndividu['individu_id']);
		$smarty->assign("full_name", $dataIndividu['full_name']);
		$smarty->assign("nick_name", $dataIndividu['nick_name']);
		$smarty->assign("address", $dataIndividu['address']);
		$smarty->assign("telepon", $dataIndividu['telepon']);
		$smarty->assign("hp", $dataIndividu['hp']);
		$smarty->assign("gender", $dataIndividu['gender']);
		$smarty->assign("blood_type", $dataIndividu['blood_type']);
		$smarty->assign("place_of_birth", $dataIndividu['place_of_birth']);
		$smarty->assign("date_of_birth", $dataIndividu['date_of_birth']);
		$smarty->assign("death_status", $dataIndividu['death_status']);
		$smarty->assign("death_date", $dataIndividu['death_date']);
		$smarty->assign("funeral_id", $dataIndividu['funeral_id']);
		$smarty->assign("religion", $dataIndividu['religion']);
		$smarty->assign("disability", $dataIndividu['disability']);
		$smarty->assign("father_id", $dataIndividu['father_id']);
		$smarty->assign("mother_id", $dataIndividu['mother_id']);
		$smarty->assign("photo", $dataIndividu['photo']);
		$smarty->assign("email", $dataIndividu['email']);
		$smarty->assign("status", $dataIndividu['status']);
		$smarty->assign("negara", $dataIndividu['negara']);
		$smarty->assign("pendidikan_terakhir", $dataIndividu['pendidikan_terakhir']);
		$smarty->assign("nama_lembaga", $dataIndividu['nama_lembaga']);
		$smarty->assign("job_id", $dataIndividu['job_id']);
		$smarty->assign("side_job", $dataIndividu['side_job']);
		$smarty->assign("grade_id", $dataIndividu['grade_id']);
		$smarty->assign("hobi", $dataIndividu['hobi']);
		$smarty->assign("bakat", $dataIndividu['bakat']);
		$smarty->assign("pasangan_id", $dataIndividu['pasangan_id']);
		$smarty->assign("tanggal_nikah", $dataIndividu['tanggal_nikah']);
		$smarty->assign("status_nikah", $dataIndividu['status_nikah']);
		$smarty->assign("keyword", $_GET['keyword']);
	} //close bracket
	
	// if module is individu and action is update
	elseif ($module == 'individu' && $act == 'update')
	{
		// change each value to variable name
		$modifiedDate = date('Y-m-d H:i:s');
		$full_name = $_POST['full_name'];
		$nick_name = $_POST['nick_name'];
		$address = $_POST['address'];
		$telepon = $_POST['telepon'];
		$hp = $_POST['hp'];
		$gender = $_POST['gender'];
		$blood_type = $_POST['blood_type'];
		$place_of_birth = $_POST['place_of_birth'];
		$date_of_birth = $_POST['date_of_birth'];
		$death_status = $_POST['death_status'];
		$death_date = $_POST['death_date'];
		$funeral_id = $_POST['funeral_id'];
		$religion = $_POST['religion'];
		$disability = $_POST['disability'];
		$father_id = $_POST['father_id'];
		$mother_id = $_POST['mother_id'];
		$photo = $_POST['filename'];
		$email = $_POST['email'];
		$status = $_POST['status'];
		$negara = $_POST['negara'];
		$pendidikan_terakhir = $_POST['pendidikan_terakhir'];
		$nama_lembaga = $_POST['nama_lembaga'];
		$job_id = $_POST['job_id'];
		$side_job = $_POST['side_job'];
		$grade_id = $_POST['grade_id'];
		$hobi = $_POST['hobi'];
		$bakat = $_POST['bakat'];
		$pasangan_id = $_POST['pasangan_id'];
		$tanggal_nikah = $_POST['tanggal_nikah'];
		$status_nikah = $_POST['status_nikah'];
		$individu_id = $_POST['individu_id'];
		$keyword = $_POST['keyword'];
		
		if ($photo != '')
		{
			// update into database
			$queryIndividu = "UPDATE as_individu SET 	full_name = '$full_name',
														nick_name = '$nick_name',
														address = '$address',
														telepon = '$telepon',
														hp = '$hp',
														gender = '$gender',
														blood_type = '$blood_type',
														place_of_birth = '$place_of_birth',
														date_of_birth = '$date_of_birth',
														death_status = '$death_status',
														death_date = '$death_date',
														funeral_id = '$funeral_id',
														religion = '$religion',
														disability = '$disability',
														father_id = '$father_id',
														mother_id = '$mother_id',
														photo = '$photo',
														email = '$email',
														status = '$status',
														negara = '$negara',
														pendidikan_terakhir = '$pendidikan_terakhir',
														nama_lembaga = '$nama_lembaga',
														job_id = '$job_id',
														side_job = '$side_job',
														grade_id = '$grade_id',
														hobi = '$hobi',
														bakat = '$bakat',
														pasangan_id = '$pasangan_id',
														tanggal_nikah = '$tanggal_nikah',
														status_nikah = '$status_nikah'
														WHERE individu_id = '$individu_id'";
		}
		else 
		{
			// update into database
			$queryIndividu = "UPDATE as_individu SET 	full_name = '$full_name',
														nick_name = '$nick_name',
														address = '$address',
														telepon = '$telepon',
														hp = '$hp',
														gender = '$gender',
														blood_type = '$blood_type',
														place_of_birth = '$place_of_birth',
														date_of_birth = '$date_of_birth',
														death_status = '$death_status',
														death_date = '$death_date',
														funeral_id = '$funeral_id',
														religion = '$religion',
														disability = '$disability',
														father_id = '$father_id',
														mother_id = '$mother_id',
														email = '$email',
														status = '$status',
														negara = '$negara',
														pendidikan_terakhir = '$pendidikan_terakhir',
														nama_lembaga = '$nama_lembaga',
														job_id = '$job_id',
														side_job = '$side_job',
														grade_id = '$grade_id',
														hobi = '$hobi',
														bakat = '$bakat',
														pasangan_id = '$pasangan_id',
														tanggal_nikah = '$tanggal_nikah',
														status_nikah = '$status_nikah'
														WHERE individu_id = '$individu_id'";
		}
													
		mysqli_query($connect, $queryIndividu);
		
		// redirect to the main individu page
		header("Location: individu.php?module=individu&act=search&name=".$keyword."&code=2");
	} // close bracket
	
	// if module is individu and action is delete
	elseif ($module == 'individu' && $act == 'delete')
	{
		// get individu id
		$individuID = $_GET['individuID'];
		$keyword = $_GET['keyword'];
		
		// delete photo
		$queryPhoto = "SELECT photo FROM as_individu WHERE individu_id = '$individuID'";
		$dataPhoto = mysqli_fetch_array(mysqli_query($connect, $queryPhoto));
		
		if ($dataPhoto['photo'] != '')
		{
			unlink("images/photo_individu/".$dataPhoto['photo']);
		}
		
		// delete from the table
		$queryIndividu = "DELETE FROM as_individu WHERE individu_id = '$individuID'";
		mysqli_query($connect, $queryIndividu);
		
		// redirect to the main individu page
		header("Location: individu.php?module=individu&act=search&name=".$keyword."&code=3");
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