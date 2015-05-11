<?php
 include ("../conexion.php");

//////////////////////////
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('America/Bogota');

/** Include PHPExcel */
require_once 'PHPExcel.php';

$objPHPExcel = new PHPExcel();

// Set document properties

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
		 
// Freeze panes

$objPHPExcel->getActiveSheet()->freezePane('A2');


// Rows to repeat at top

$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

/////////////////////////

 	$field = implode(",", $_GET['field']);

	if(isset($_GET['where'])){
		$where =$_GET['where'];
	}else{
		$where ="";
	}
			  $q = "SELECT ".$field." FROM ".$_GET['table']." ".stripslashes($where)." ";
					
			$objPHPExcel->setActiveSheetIndex(0);
			$alfabeto = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","U","V","W","X","Y","Z"
								,"AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AU","AV","AW","AX","AY","AZ");
			
			foreach ($_GET['field'] as $key => $value) {
				$objPHPExcel->getActiveSheet()->setCellValue($alfabeto[$key].'1', $value);
			}

			
	$qq = mysql_query($q);
	$cont = 2;
	while($row = mysql_fetch_assoc($qq)){

 		foreach ($_GET['field'] as $key => $value) {
 				$objPHPExcel->getActiveSheet() ->setCellValue($alfabeto[$key].$cont, $row[$value]);
		}
		$cont++;
								  
	}

		
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);




// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="resultados_datagrid.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

 
	
	

?>