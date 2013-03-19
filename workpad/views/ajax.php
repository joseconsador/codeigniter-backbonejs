<?php
	
	//prevent data being cached since this is ajax request 
	header("Expires: Sun, 19 Nov 1978 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	// json
	if( isset($json) ){
		header('Content-type: application/json');
		echo json_encode($json);
	}
	
	// string/html 
	if( isset($html) ){
		header("Content-type: text/html;"); 
		echo $html;
	}
	
	// xml
	if( isset($xml) ){
		header("Content-type: text/xml; charset=utf-8"); 
		echo $xml;
	}
	
	// excel
	if( isset($excel) ){
		$filename = $this->listview_title.'_'.date('d_F_Y');
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$filename.".xls");
		echo $excel;
	}
	
?>