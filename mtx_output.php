<?php
	header("Content-Type: Text/html; charset=utf-8");
	session_start();
	
	if(!preg_match("/".getenv("HTTP_HOST")."/",getenv("HTTP_REFERER"))) {
		echo "<script>alert('비정상적인 접근입니다.'); history.go(-1);</script>";
		exit;
	} else {
		$dom = $_SESSION["dom"];
		$file_name = $_SESSION["file_name"];
		
		$file_name = $file_name.".xml";
		$xml_file = fopen($file_name, "w");
		
		fwrite($xml_file, $dom);
		fclose($xml_file);
		
		$filepath = "./".$file_name;
		$filesize = filesize($filepath);
		$path_parts = pathinfo($filepath);
		$filename = $path_parts["basename"];
		$extension = $path_parts["extension"];
		
		header("Pragma: public");
		header("Expires: 0");
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: $filesize");
		
		ob_clean();
		flush();
		readfile($filepath);
		unlink($filepath);
	}
?>