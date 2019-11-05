<?php
/**
* photo uploading
* @return 1 on upload success, 0 on fail
* @todo make array for error messages then return all of them
*/
function upload_photos($dir = "", $files = array()){	
	foreach ($files as $photo => $data) {
		// file info is missing or empty
		if(empty($data)){
			//Messages::set_message('No file selected', 'error');
			continue;
		}
		else {
			$filename = $dir . "/" . bin2hex(random_bytes(20)) . ".gif";
			$file_type = pathinfo($filename, PATHINFO_EXTENSION);
			if($data['error'] === '0'){
				// file is too large
				if($data['size'] > 10000000){
					// echo "<br />Sorry, file too large.";
					//Messages::set_message('File is too large', 'error');
					continue;
				}
				// file type is allowed
				if($file_type !== "jpg" && $file_type !== "png" && $file_type !== "gif"){
					//Messages::set_message('Sorry, the file type \'' . $file_type . '\' is not supported. Please upload either a jpg, png, or gif', 'error');
					continue;
				}
				// no errors, so upload file
				move_uploaded_file($data['tmp_name'], $filename);
			}
		}
	}
	return 1;
}
?>