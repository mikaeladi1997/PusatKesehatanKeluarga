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
	$filename="print_kartu_keluarga.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	
	// get the family id
	$fid = $_GET['fid'];
	
	// get data based on family id
	$queryFamily = "SELECT A.full_name, A.telepon, B.nik, B.alamat, B.family_id FROM as_individu A INNER JOIN as_family B ON A.individu_id=B.kepala_keluarga WHERE B.family_id = '$fid'";
	$sqlFamily = mysqli_query($connect, $queryFamily);
	$dataFamily = mysqli_fetch_array($sqlFamily);
	
	$content = "<table width='100%' align='center' style='background: #6da4cf;'>
					<tr valign='top'>
						<td width='75' align='center' valign='middle'><img src='images/logo.jpg' width='70'></td>
						<td width='940' align='center'>
							<span style='font-size: 20px; font-weight: bold;'>K A R T U K E L U A R G A<br>
								CV. ASFA Solution
							</span><br>
							Sultan Residence H-9, Jl. Nyimas Gandasari - Kel. Jungjang - Kec. Arjawinangun - Kab. Cirebon <br>
							Telp. (0231) 8830633, Hp. 08562121141,
							Website: http://www.asfasolution.co.id, Email: info@asfasolution.co.id
							
						</td>
					</tr>
				</table>
				
				<p>&nbsp;</p>
				
				<table>
					<tr>
						<td width='160'>NIK</td>
						<td>:</td>
						<td>$dataFamily[nik]</td>
					</tr>
					<tr>
						<td>Nama Kepala Keluarga</td>
						<td>:</td>
						<td>$dataFamily[full_name]</td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td>$dataFamily[alamat]</td>
					</tr>
					<tr>
						<td>No. Telepon</td>
						<td>:</td>
						<td>$dataFamily[telepon]</td>
					</tr>
				</table>
				
				<p>&nbsp;</p>
				<table border='1' cellpadding='0' cellspacing='0'>
					<tr>
						<th width='15' align='center' style='padding: 5px;'>No.</th>
						<th width='300' align='center' style='padding: 5px;'>Nama Lengkap</th>
						<th width='30' align='center' style='padding: 5px;'>JK</th>
						<th width='70' align='center' style='padding: 5px;'>No. Induk</th>
						<th width='220' align='center' style='padding: 5px;'>Tempat, Tanggal Lahir</th>
						<th width='150' align='center' style='padding: 5px;'>Pekerjaan</th>
						<th width='70' align='center' style='padding: 5px;'>Gol. Darah</th>
					</tr>";
					
					$queryChild = "SELECT B.full_name, B.gender, A.family_id, A.family_child_id, B.no_induk, B.place_of_birth, B.date_of_birth, C.job_name, B.blood_type, A.status FROM as_family_child A INNER JOIN as_individu B ON B.individu_id=A.child_id LEFT JOIN as_jobs C ON C.job_id=B.job_id
					WHERE A.family_id = '$_GET[fid]' ORDER BY A.family_child_id ASC";
					$sqlChild = mysqli_query($connect, $queryChild);
					$i = 1;
					
					while ($dataChild = mysqli_fetch_array($sqlChild)){
						$date_of_birth = tgl_indo($dataChild['date_of_birth']);
							
						$content .= "<tr>
										<td style='padding: 5px;'>$i</td>
										<td style='padding: 5px;'>$dataChild[full_name]</td>
										<td style='padding: 5px;' align='center'>$dataChild[gender]</td>
										<td style='padding: 5px;' align='center'>$dataChild[no_induk]</td>
										<td style='padding: 5px;'>$dataChild[place_of_birth], $date_of_birth</td>
										<td style='padding: 5px;'>$dataChild[job_name]</td>
										<td style='padding: 5px;' align='center'>$dataChild[blood_type]</td>
									</tr>";
						$i++;
					}
		$content .= "</table>
				<p></p>
				<table width='100%'>
					<tr>
						<td width='500'>Ket :</td>
						<td width='500' align='right'>Arjawinangun, $date_now</td>
					</tr>
				</table>
				<p>&nbsp;</p>
				
				<table width='100%'>
					<tr>
						<td width='500' align='center'>CV. ASFA SOLUTION<br>ARJAWINANGUN<br><br><p>&nbsp;</p><br><u>Agus Saputra, A.Md., S.Kom.</u><br>Ketua</td>
						<td width='500' align='center'><br><br><br><p>&nbsp;</p><br><u>$dataFamily[full_name]</u><br>Kepala Keluarga</td>
					</tr>
				</table>
				";
	ob_end_clean();
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('L','A4','fr', false, 'ISO-8859-15',array(10, 7, 12, 12)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>