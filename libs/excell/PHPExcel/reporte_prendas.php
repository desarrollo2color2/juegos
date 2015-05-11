<?php
 include ("../../php/acceso_color.php");


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


	
	
	
	   
			$q = "SELECT 
					prendas.dibujo, 
					prendas.color,
					categoria.nombre,  
					(select nombre from categoria where categoria.id = dibujo.categoria) AS categoria, 
					(select nombre from categoria where categoria.id = dibujo.categoria_2) AS categoria_2 ,
					(select nombre from categoria where categoria.id = dibujo.categoria_3) AS categoria_3 ,
					(select nombre from categoria where categoria.id = dibujo.categoria_4) AS categoria_4 ,
					(select nombre from categoria where categoria.id = dibujo.categoria_5) AS categoria_5 ,
					(select nombre from categoria where categoria.id = dibujo.categoria_6) AS categoria_6	,
					prendas.fecha,  
					prendas.img_prenda 
				FROM prendas 
				INNER JOIN categoria 
					ON categoria.id = prendas.id_tipo_prenda 
				INNER JOIN dibujo 
					ON dibujo.codigo = prendas.dibujo
			
			";
					
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "Codigo dibujo");
			$objPHPExcel->getActiveSheet()->setCellValue('B1', "Codigo color");
			$objPHPExcel->getActiveSheet()->setCellValue('C1', "Tipo de prenda");
			$objPHPExcel->getActiveSheet()->setCellValue('D1', "Categoria 1");
			$objPHPExcel->getActiveSheet()->setCellValue('E1', "Categoria 2");			
			$objPHPExcel->getActiveSheet()->setCellValue('F1', "Categoria 3");
			$objPHPExcel->getActiveSheet()->setCellValue('G1', "Categoria 4");
			$objPHPExcel->getActiveSheet()->setCellValue('H1', "Categoria 5");
			$objPHPExcel->getActiveSheet()->setCellValue('I1', "Fecha de creación");
			$objPHPExcel->getActiveSheet()->setCellValue('J1', "Imagen de prenda");
			
			
	 $qq = mysql_query($q);
	 $cont = 2;
	 while($row = mysql_fetch_assoc($qq)){
		 $objPHPExcel->getActiveSheet()->setCellValue('A'.$cont, $row["dibujo"])
										->setCellValue('B'.$cont, $row["color"])
										->setCellValue('C'.$cont, $row["categoria"])
										->setCellValue('D'.$cont, $row["categoria_2"])
										->setCellValue('E'.$cont, $row["categoria_3"])			
										->setCellValue('F'.$cont, $row["categoria_4"])
										->setCellValue('G'.$cont, $row["categoria_5"])
										->setCellValue('H'.$cont, $row["categoria_6"])
										->setCellValue('I'.$cont, $row["fecha"])
										->setCellValue('J'.$cont, $row["img_prenda"])	;							

			$cont++;
								  
		 }
	   	
     
	 
	 
	 

		
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);




// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="resultados_dibujos_prendas.xls"');
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