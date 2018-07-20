<?php
date_default_timezone_set("ASIA/JAKARTA");
error_reporting(0);
session_start();
// include semua file yang dibutuhkan
include "includes/connection.php";
include "includes/debug.php";
include "includes/fungsi_indotgl.php";

// jika session login kosong
if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	// arahkan ke halaman login
	header("Location: index.php?code=3");
}

else{
	ob_start();
	require ("includes/html2pdf/html2pdf.class.php");
	$filename="print_individu.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	
	$module = $_GET['module'];
	$act = $_GET['act'];
	$individuID = $_GET['individuID'];
	$queryIndividu = "SELECT * FROM as_individu WHERE individu_id = '$individuID'";
	$dataIndividu = mysqli_fetch_array(mysqli_query($connect, $queryIndividu));
	
	// showing up data funeral
	$queryFuneral = "SELECT * FROM as_funeral WHERE funeral_id = '$dataIndividu[funeral_id]'";
	$dataFuneral = mysqli_fetch_array(mysqli_query($connect, $queryFuneral));
	
	// showing up data job
	$queryJob = "SELECT * FROM as_jobs WHERE job_id = '$dataIndividu[job_id]'";
	$dataJob = mysqli_fetch_array(mysqli_query($connect, $queryJob));
	
	// showing up data grade
	$queryGrade = "SELECT * FROM as_grade WHERE grade_id = '$dataIndividu[grade_id]'";
	$dataGrade = mysqli_fetch_array(mysqli_query($connect, $queryGrade));
	
	$date_of_birth = tgl_indo($dataIndividu['date_of_birth']);
	if ($dataIndividu['death_date'] != '0000-00-00')
	{
		$death_date = tgl_indo($dataIndividu['death_date']);
	}
	else
	{
		$death_date = "-";
	}
	
	if ($dataIndividu['religion'] == '1'){
		$agama = "Islam";
	}
	elseif ($dataIndividu['religion'] == '2'){
		$agama = "Kristen";
	}
	elseif ($dataIndividu['religion'] == '3'){
		$agama = "Katolik";
	}
	elseif ($dataIndividu['religion'] == '4'){
		$agama = "Hindu";
	}
	elseif ($dataIndividu['religion'] == '5'){
		$agama = "Budha";
	}
	elseif ($dataIndividu['religion'] == '6'){
		$agama = "Kong Hu Chu";
	}
	elseif ($dataIndividu['religion'] == '7'){
		$agama = "Lain-lain";
	}
	
	if ($dataIndividu['pendidikan_terakhir'] == '1'){
		$pendidikan_terakhir = "S3";
	}
	elseif ($dataIndividu['pendidikan_terakhir'] == '2'){
		$pendidikan_terakhir = "S2";
	}
	elseif ($dataIndividu['pendidikan_terakhir'] == '3'){
		$pendidikan_terakhir = "S1";
	}
	elseif ($dataIndividu['pendidikan_terakhir'] == '4'){
		$pendidikan_terakhir = "D4";
	}
	elseif ($dataIndividu['pendidikan_terakhir'] == '5'){
		$pendidikan_terakhir = "D3";
	}
	elseif ($dataIndividu['pendidikan_terakhir'] == '6'){
		$pendidikan_terakhir = "D2";
	}
	elseif ($dataIndividu['pendidikan_terakhir'] == '7'){
		$pendidikan_terakhir = "D1";
	}
	elseif ($dataIndividu['pendidikan_terakhir'] == '8'){
		$pendidikan_terakhir = "SMA/SMK";
	}
	elseif ($dataIndividu['pendidikan_terakhir'] == '9'){
		$pendidikan_terakhir = "SMP";
	}
	elseif ($dataIndividu['pendidikan_terakhir'] == '10'){
		$pendidikan_terakhir = "SD";
	}
	elseif ($dataIndividu['pendidikan_terakhir'] == '11'){
		$pendidikan_terakhir = "TK";
	}
	
	if ($dataIndividu['tanggal_nikah'] != '0000-00-00'){
		$tanggal_nikah = tgl_indo($dataIndividu['tanggal_nikah']);
	}
	else{
		$tanggal_nikah = "-";
	}
	
	if ($dataIndividu['status_nikah'] == '1'){
		$status_nikah = "Belum Menikah";
	}
	elseif ($dataIndividu['status_nikah'] == '2'){
		$status_nikah = "Cerai";
	}
	elseif ($dataIndividu['status_nikah'] == '3'){
		$status_nikah = "Menikah";
	}
	elseif ($dataIndividu['status_nikah'] == '4'){
		$status_nikah = "Wafat";
	}
	
	if ($dataIndividu['status'] == 'Y'){
		$status = "WNI";
	}
	else{
		$status = "WNA";
	}
	
	$content = " <table width='100%' align='center' style='border-bottom: #000; padding-bottom: 10px;'>
					<tr valign='top'>
						<td width='80' align='right' valign='middle'><img src='images/logo.jpg' width='70'></td>
						<td width='610' style='padding-left: 10px;' valign='middle'>
							<div style='font-size: 20px; font-weight: bold; padding-bottom: 5px;'>
								CV. ASFA Solution
							</div>
							Sultan Residence H-9, Jl. Nyimas Gandasari - Kel. Jungjang - Kec. Arjawinangun - Kab. Cirebon <br>
							Telp. (0231) 8830633; 08562121141, 
							Website: http://www.asfamedia.com, Email: info@asfasolution.com
						</td>
					</tr>
				</table><br>
				<h4><u>DATA WARGA</u></h4>
				<h4>Data Pribadi</h4>
				<table>
					<tr>
						<td>No Induk</td>
						<td>:</td>
						<td>$dataIndividu[no_induk]</td>
					</tr>
					<tr>
						<td width='125'>Nama</td>
						<td width='6'>:</td>
						<td>$dataIndividu[full_name]</td>
					</tr>
					<tr>
						<td>Nama Panggil</td>
						<td>:</td>
						<td>$dataIndividu[nick_name]</td>
					</tr>
					<tr>
						<td>Jenis Kelamin</td>
						<td>:</td>
						<td>$dataIndividu[gender]</td>
					</tr>
					<tr>
						<td>Golongan Darah</td>
						<td>:</td>
						<td>$dataIndividu[blood_type]</td>
					</tr>
					<tr>
						<td>Tempat, Tgl Lahir</td>
						<td>:</td>
						<td>$dataIndividu[place_of_birth], $date_of_birth</td>
					</tr>
					<tr>
						<td>Wafat?</td>
						<td>:</td>
						<td>$dataIndividu[death_status]</td>
					</tr>
					<tr>
						<td>Tanggal Wafat</td>
						<td>:</td>
						<td>$death_date</td>
					</tr>
					<tr>
						<td>Tempat Pemakaman</td>
						<td>:</td>
						<td>$dataFuneral[funeral_name]</td>
					</tr>
					<tr>
						<td>Agama</td>
						<td>:</td>
						<td>$agama</td>
					</tr>
					<tr>
						<td>Cacat</td>
						<td>:</td>
						<td>$dataIndividu[disability]</td>
					</tr>
					<tr>
						<td>Nama Ayah</td>
						<td>:</td>
						<td>$dataIndividu[father_id]</td>
					</tr>
					<tr>
						<td>Nama Ibu</td>
						<td>:</td>
						<td>$dataIndividu[mother_id]</td>
					</tr>
				</table><br>
				<h4>Alamat & Telepon Selular</h4>
				<table>
					<tr>
						<td width='125'>Alamat</td>
						<td width='6'>:</td>
						<td>$dataIndividu[address]</td>
					</tr>
					<tr>
						<td>Telepon</td>
						<td>:</td>
						<td>$dataIndividu[telepon]</td>
					</tr>
					<tr>
						<td>Nomor HP</td>
						<td>:</td>
						<td>$dataIndividu[hp]</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<td>$dataIndividu[email]</td>
					</tr>
				</table><br>
				<h4>Kewargaan</h4>
				<table>
					<tr>
						<td width='125'>Kewarganegaraan</td>
						<td width='6'>:</td>
						<td>$status</td>
					</tr>
					<tr>
						<td>Negara</td>
						<td>:</td>
						<td>$dataIndividu[negara]</td>
					</tr>
				</table><br>
				<h4>Pendidikan & Pekerjaan</h4>
				<table>
					<tr>
						<td width='125'>Pendidikan Terakhir</td>
						<td width='6'>:</td>
						<td>$pendidikan_terakhir</td>
					</tr>
					<tr>
						<td>Nama Lembaga / Pendidikan</td>
						<td>:</td>
						<td>$dataIndividu[nama_lembaga]</td>
					</tr>
					<tr>
						<td>Pekerjaan Utama</td>
						<td>:</td>
						<td>$dataJob[job_name]</td>
					</tr>
					<tr>
						<td>Pekerjaan Sampingan</td>
						<td>:</td>
						<td>$dataIndividu[side_job]</td>
					</tr>
					<tr>
						<td>Penghasilan Bulanan</td>
						<td>:</td>
						<td>$dataGrade[grade_name]</td>
					</tr>
					<tr>
						<td>Minat / Hobi</td>
						<td>:</td>
						<td>$dataIndividu[hobi]</td>
					</tr>
					<tr>
						<td>Bakat</td>
						<td>:</td>
						<td>$dataIndividu[bakat]</td>
					</tr>
				</table><br>
				<h4>Pernikahan</h4>
				<table>
					<tr>
						<td width='125'>Nama Pasangan</td>
						<td width='6'>:</td>
						<td>$dataIndividu[pasangan_id]</td>
					</tr>
					<tr>
						<td>Tanggal Pernikahan</td>
						<td>:</td>
						<td>$tanggal_nikah</td>
					</tr>
					<tr>
						<td>Status Pernikahan</td>
						<td>:</td>
						<td>$status_nikah</td>
					</tr>
				</table>
				<br><br>
				Ket: 
				<p>&nbsp;</p><p>&nbsp;</p>
				<table width='100%'>
					<tr>
						<td width='250'></td>
						<td width='350' align='center'>
						Arjawinangun, $date_now<br><br>
						CV. ASFA SOLUTION<br>ARJAWINANGUN<br><br><p>&nbsp;</p><br><u>Agus Saputra, A.Md., S.Kom.</u><br>Ketua</td>
					</tr>
				</table>
				";
	ob_end_clean();
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15',array(10, 7, 12, 15)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>