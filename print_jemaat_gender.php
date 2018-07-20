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
	$filename="print_jemaat_gender.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	$day = 7;
	$nextN = mktime(0, 0, 0, date('m'), date('d') + $day, date('Y'));
	$nextDay = date('Y-m-d', $nextN);
	$noww = tgl_indo($now);
	$nextnow = tgl_indo($nextDay);
	
	if ($_GET['id'] == 'L'){
		$kategori = "Laki-Laki";
		$queryJemaat = "SELECT no_induk, full_name, gender, place_of_birth, date_of_birth FROM as_individu WHERE status = 'Y' AND gender = 'L' ORDER BY full_name ASC";
	}
	elseif ($_GET['id'] == 'P'){
		$kategori = "Perempuan";
		$queryJemaat = "SELECT no_induk, full_name, gender, place_of_birth, date_of_birth FROM as_individu WHERE status = 'Y' AND gender = 'P' ORDER BY full_name ASC";
	}
	elseif ($_GET['id'] == 'A'){
		$kategori = "Semua Gender";
		$queryJemaat = "SELECT no_induk, full_name, gender, place_of_birth, date_of_birth FROM as_individu WHERE status = 'Y' ORDER BY full_name ASC";
	}
	
	$content = "<table width='100%' align='center' style='border-bottom: #000; padding-bottom: 10px;'>
					<tr valign='top'>
						<td width='80' align='right' valign='middle'><img src='images/logo.jpg' width='70'></td>
						<td width='610' style='padding-left: 10px;' valign='middle'>
							<div style='font-size: 20px; font-weight: bold; padding-bottom: 5px;'>
								CV. ASFA SOLUTION
							</div>
							Sultan Residence H-9, Jl. Nyimas Gandasari - Kel. Jungjang, Kec. Arjawinangun - Kab. Cirebon<br>
							Telp. (0231) 8830633, Hp. 08562121141<br> 
							Website: http://www.asfasolution.co.id, Email: info@asfasolution.co.id
						</td>
					</tr>
				</table>
				<br>
				<h4><u>DATA WARGA</u> <br><br>Kategori Gender : $kategori </h4>
				<table border='1' cellpadding='0' cellspacing='0'>
					<tr>
						<th width='15' align='center' style='padding: 5px;'>No.</th>
						<th width='60' align='center' style='padding: 5px;'>No Induk</th>
						<th width='250' align='center' style='padding: 5px;'>Nama Lengkap</th>
						<th width='25' align='center' style='padding: 5px;'>JK</th>
						<th width='250' align='center' style='padding: 5px;'>Tempat, Tanggal Lahir</th>
					</tr>";
					
					$i = 1;
					$sqlJemaat = mysqli_query($connect, $queryJemaat);
					while ($dataJemaat = mysqli_fetch_array($sqlJemaat))
					{
						$date_of_birth = tgl_indo($dataJemaat['date_of_birth']);
						
						$content .= "<tr>
										<td style='padding: 5px;'>$i</td>
										<td style='padding: 5px;' align='center'>$dataJemaat[no_induk]</td>
										<td style='padding: 5px;'>$dataJemaat[full_name]</td>
										<td style='padding: 5px;' align='center'>$dataJemaat[gender]</td>
										<td style='padding: 5px;'>$dataJemaat[place_of_birth], $date_of_birth</td>
									</tr>";
						$i++;
					}
		$content .= "</table>
				<br>
				<table width='100%'>
					<tr>
						<td width='300'>Ket :</td>
						<td width='400' align='right'>Arjawinangun, $date_now</td>
					</tr>
				</table>
				<p>&nbsp;</p>
				
				<table width='100%'>
					<tr>
						<td width='350' align='center'></td>
						<td width='350' align='center'>CV. ASFA SOLUTION<br>ARJAWINANGUN<br><br><p>&nbsp;</p><br><u>Agus Saputra, A.Md., S.Kom.</u><br>Ketua</td>
					</tr>
				</table>
				";
	ob_end_clean();
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15',array(10, 7, 12, 12)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>