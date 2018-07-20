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
	$filename="print_staff.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = tgl_indo($now);
	
	$content = "<table width='100%' align='center' style='border-bottom: #000; padding-bottom: 10px;'>
					<tr valign='top'>
						<td width='80' align='right' valign='middle'><img src='images/logo.jpg' width='70'></td>
						<td width='610' style='padding-left: 10px;' valign='middle'>
							<div style='font-size: 20px; font-weight: bold; padding-bottom: 5px;'>
								Gereja Bethel Indonesia Arjawinangun
							</div>
							Jl. Kantor Pos No. 191 Arjawinangun - Cirebon 45162, Jawa Barat - Indonesia <br>
							Telp. (0231) 357216, Fax. (0231) 357216, 
							Website: http://www.gbiawn.org, Email: info@gbiawn.org
						</td>
					</tr>
				</table>
				<br>
				<h4><u>DATA STAFF (PASTORY)</u></h4>
				<table border='1' cellpadding='0' cellspacing='0'>
					<tr>
						<th width='15' align='center' style='padding: 5px;'>No.</th>
						<th width='50' align='center' style='padding: 5px;'>No. Ind</th>
						<th width='190' align='center' style='padding: 5px;'>Nama Lengkap</th>
						<th width='15' align='center' style='padding: 5px;'>JK</th>
						<th width='80' align='center' style='padding: 5px;'>Jabatan</th>
						<th width='110' align='center' style='padding: 5px;'>Tanggal Mulai</th>
						<th width='110' align='center' style='padding: 5px;'>Tanggal Keluar</th>
					</tr>";
					
					$queryStaff = "SELECT A.jabatan, A.staff_id, B.gender, A.tanggal_mulai, A.tanggal_keluar, A.status, B.no_induk, B.full_name FROM as_staffs A INNER JOIN as_individu B ON A.anggota_id=B.individu_id ORDER BY A.staff_id ASC";
					$sqlStaff = mysqli_query($connect, $queryStaff);
					$i = 1;
					
					while ($dataStaff = mysqli_fetch_array($sqlStaff)){
						$date_in = tgl_indo($dataStaff['tanggal_mulai']);
						$date_out = tgl_indo($dataStaff['tanggal_keluar']);
							
						$content .= "<tr>
										<td style='padding: 5px;'>$i</td>
										<td style='padding: 5px;' align='center'>$dataStaff[no_induk]</td>
										<td style='padding: 5px;'>$dataStaff[full_name]</td>
										<td style='padding: 5px;' align='center'>$dataStaff[gender]</td>
										<td style='padding: 5px;'>$dataStaff[jabatan]</td>
										<td style='padding: 5px;'>$date_in</td>
										<td style='padding: 5px;'>$date_out</td>
									</tr>";
						$i++;
					}
		$content .= "</table>
				<p></p>
				<table width='100%'>
					<tr>
						<td width='200'>Ket :</td>
						<td width='500' align='right'>Arjawinangun, $date_now</td>
					</tr>
				</table>
				<p>&nbsp;</p>
				
				<table width='100%'>
					<tr>
						<td width='350' align='center'></td>
						<td width='350' align='center'>GEREJA BETHEL INDONESIA<br>ARJAWINANGUN<br><br><p>&nbsp;</p><br><u>Pdt. Steve Mardianto, M.Th.</u><br>Gembala Jemaat</td>
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