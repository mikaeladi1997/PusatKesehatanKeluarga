<?php
$uploaddir = 'images/photo_nikah/'; 
$file = $uploaddir ."gbiawn_".date('Ymdhis').basename($_FILES['uploadfile']['name']); 
$file_name= "gbiawn_".date('Ymdhis').$_FILES['uploadfile']['name']; 
 
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
	echo "$file_name"; 
} 
else {
	echo "error";
}
?>