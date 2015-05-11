<?php

	use \model\UserModel as u;
	use \model\WinnerModel as w;
	use \model\DelegadoModel as d;
	use \app\App as app;

	

	Class Winner extends app
	{


		public static $modalidades = array(
			'futbol'       => 'futbol',
			'micro_futbol' => 'micro futbol',
			'baloncesto'   => 'baloncesto',
			'voleibol'     => 'voleibol',
			'natacion'     => 'natación',
			'atletismo' => 'atletismo',
			'atletismo_campo' => 'atletismo de campo',
			'ajedrez' => 'ajedrez',
			'pentatlon' => 'pentatlon militar',
			'tenis_mesa' => 'tenis de mesa',
			'taewondo' => array(
				'poomse',
				'combate',
			),
			'tiro' => array(
				'armas cortas',
				'armas largas'
			),
			'orientacion' => 'orientacion militar'
		);

	public static $competencias = array(
		// Natacion
		'natacion' => array (
			'50 metros libre',
			'100 metros libre',
			'100 metros pecho',
			'100 metros espalda',
			'100 metros mariposa',
			'400 metros libre',
			'200 metros combinado individual',
			'relevos combinados por 50 metros',
			'relevo libre por 50 metros'
		),
		// Atletismo
		'atletismo' => array(
			'100 mts planos',
			'200 mts planos',
			'400 mts planos',
			'800 mts planos',
			'1500 mts planos',
			'3000 mts planos',
			'5000 mts planos',
			'10000 mts planos',
			'110 mts vallas',
			'400 mts vallas',
			'relevos 4 por 100 mts',
			'relevos 4 por 400 mts',
		),
		// Atletismo de campo
		'atletismo_campo' => array(
			'salto triple',
			'salto alto',
			'lanzamiento de disco',
			'impulso bala',
			'lanzamiento jabalina'
		),
		// Ajedrez
		'ajedrez' => array(
			'individual Clásico (90 min, c/u con un incremento de 30 seg por jugada',
			'individual Activo 15 min, c/u con un incremento 10 seg por jugada',
			'individual Blitz 3 minutos, por c/u con un incremento de 02 seg por jugada'
		),
		// Pentatlon militar
		'pentatlon' => array(
			'tiro 200 metros',
			'Lanzamiento de granada',
			'Cross country',
			'natación Utilitaria',
			'pista cruce de obstáculos',
			'relevo pista cruce de obstáculos'
		),
		// Tenis de mesa
		'tenis_mesa' => array(
			'individual',
			'dobles',
			'equipos'
		),
		// Taewondo
		'poomse' => array(
			'individual (PRINCIPIANTE)', 
			'Pareja (PRINCIPIANTE)', 
			'Equipos (PRINCIPIANTE)',
			'individual (AVANZADO)',
			'pareja (AVANZADO)', 
			'Equipos (AVANZADO)'
		),
		'combate' => array(
			'principiante',
			'avanzado',
			'tk-5'
		),
		//tiro
		'armas cortas' => array(

			'60 disparos en 4 series de 5 disparos en 10, 8, y 6 segundos cada una',
			'25 metros, 10 disparos en 40 segundos con cambio de proveedor',
			'25 metros, 10 disparos en 40 segundos con cambio de proveedor',
			'25 metros tiro rápido'

		),
		'armas largas' => array(
			
			'Carabina tendido calibre 22 ir: 50 metros, 60 disparos',
			'Carabina 3*40 cal 22 ir:  50 metros',
			'40 disparos tendido, 40 disparo pie, 40 disparos rodillas',
			'100 Mts, 20 disparos posición tendido en 30 minutos',
			'100 Mts, 20 disparo posición pie en 60 minutos',
			'100 Mts, 20 disparo posición rodillas en 45 minutos'
		),
		'orientacion' => array(
			'Prueba larga',
			'Prueba corta',
			'Prueba sprint',
			'Prueba relevos',
			'Prueba nocturna'
		),
	);
	


		public static function all_winners()
		{

			/*$winners = w::find_by_attr(
				array('usuarios.tipo' => 'deportista'),
				'delegados.nombre_completo, ganadores.modalidad, ganadores.competencia',
				'LEFT JOIN usuarios ON usuarios.id = ganadores.id_delegado
				LEFT JOIN delegados ON delegados.id_usuario= ganadores.id_delegado'
			);*/
			
			$winners['modalidades'] = self::$modalidades;

			parent::__view('admin_winners:admin_layout', $winners);	


		}

		public static function winner_form()
		{

			
			$winner['modalidades'] = self::$modalidades;


			return parent::__view('admin_winner:admin_layout', $winner);	
		}

		public static function ajax_dele()
		{
			

			$nd = array(

				'futbol',
				'micro_futbol',
				'baloncesto',
				'voleibol',

			);


			if(is_numeric(array_search($_POST['competencia'], $nd))) :
				echo '<input type="text" name="nombre_equipo" class="form-control" required placeholder="Nombre del equipo" />';
			else :
		
				$delegados = u::find_by_attr(
					array('usuarios.escuela' => $_POST['escuela'], 'usuarios.tipo' => 'deportista'),
					'usuarios.id, delegados.nombre_completo',
					'LEFT JOIN delegados ON delegados.id_usuario=usuarios.id'
				);

				if($delegados) :
					echo '<select name="id_delegado"  class="form-control" required>';
					foreach($delegados as $delegado) :
						echo '<option value="'.$delegado['id'].'">'.$delegado['nombre_completo'].'</option>';
					endforeach;
					echo '</select>';
				endif;
				
			endif;
			

		}

		public static function ajax_com_()
		{
			

			
			if (isset(self::$competencias[$_POST['value']])) :


			$html = '<select style="height:inherit;" name="competencia" class="form-control" required>';
			
				
					if(is_array(self::$competencias[$_POST['value']])) :
						foreach(self::$competencias[$_POST['value']] as $val) :
							$html .= '<option value="'.$val.'">'.$val.'</option>';
						endforeach;
					else :
						$html .= '<option value="'.self::$competencias[$_POST['value']].'">'.self::$competencias[$_POST['value']].'</option>';
					endif;
					
				
			
			$html .= '</select>';

			echo $html;

			endif;

		}


		

		private static function validar_delegado($modalidad, $competencia, $id_usuario)
		{

			$delegado = d::find_by_attr(array('id_usuario' => $id_usuario), 'modalidad, competencia');
			$delegado = $delegado[0];

			$modalidades = json_decode($delegado['modalidad'], true); 

			$aviable_modalidad = is_numeric(array_search($modalidad, $modalidades));

			$competencias = json_decode($delegado['competencia'], true); 

			if(!is_null($competencia)) :
				$aviable_comp = (!is_null($competencias) && is_numeric(array_search($competencia, $competencias))) ? true : false;

				return ($aviable_modalidad == true && $aviable_comp == true) ? true : false;

			else :
				return $aviable_modalidad;

			endif;


		}

		private static function get_modalidad ($modalidad, $competencia)
		{

			if(is_null($competencia)) :

				return 'conjunto';
			else :

			$ind = array(

				'relevos combinados por 50 metros',
				'relevo libre por 50 metros',
				'relevos 4 por 100 mts',
				'relevos 4 por 400 mts',
				'relevo pista cruce de obstáculos',
				'dobles',
				'equipos',
				'Pareja (PRINCIPIANTE)', 
				'Equipos (PRINCIPIANTE)',
				'pareja (AVANZADO)', 
				'Equipos (AVANZADO)',
				'Prueba relevos',

			);

			return (is_numeric(array_search($competencia, $ind))) ? 'conjunto' : 'individual';


			endif;

		}



		public static function insert_winner()
		{
			

			// validar en caso d ser equipo o deportista

			if(isset($_POST['nombre_equipo'])) :

				$is_exist = array(
					'nombre_equipo' => $_POST['nombre_equipo'],
					'modalidad'    => $_POST['modalidad'],

				);

				$_POST['modo'] = 'conjunto';

			else :


				$puff = (isset($_POST['competencia'])) ? $_POST['competencia'] : null;

				if(!self::validar_delegado($_POST['modalidad'], $puff, $_POST['id_delegado'])) :
					$_SESSION['message'] = '<div class="alert alert-danger" role="alert">Este deportista no tiene permitido ganar esta modalidad</div>';
					$url = URL."admin";
					parent::url_redirect($url);
				endif;

				if(!isset($_POST['competencia'])) :
					$is_exist = array(
						'modalidad'    => $_POST['modalidad'],
						'id_delegado'  => $_POST['id_delegado'],

					);
				else :
					$is_exist = array(
						'modalidad'    => $_POST['modalidad'],
						'id_delegado'  => $_POST['id_delegado'],
						'competencia'  => $_POST['competencia'],

					);
				endif;

				$_POST['modo'] = self::get_modalidad($_POST['modalidad'], $puff);


			endif;


			
			if(!w::find_by_attr($is_exist) && !w::find_by_attr(array('modalidad' => $_POST['modalidad'], 'medalla' => $_POST['medalla'])) && $ganador = w::save($_POST)) :

				$_SESSION['message'] = '<div class="alert alert-success" role="alert">Ganador registrado</div>';
				$url = URL."admin";
				parent::url_redirect($url);

			else : 
				$_SESSION['message'] = '<div class="alert alert-danger" role="alert">Ya hay existe este registro</div>';
				$url = URL."admin";
				parent::url_redirect($url);
			endif;
		}

		public static function mod_winners($array)
		{
			
			$nd = array(

				'futbol',
				'micro_futbol',
				'baloncesto',
				'voleibol',

			);
			// Si hay equipos
			if(is_numeric(array_search($array['modalidad'], $nd))) :

				$winners['comp'] =  false;
				$more  = ' ORDER BY medalla';
				$where = array(
					
					'ganadores.modalidad' => $array['modalidad']
				);
				$left = '';
				$select = 'modalidad, competencia, escuela, medalla, modo, nombre_equipo';
					

			else :

				$ind = array(

				'natacion',
				'atletismo',
				'atletismo_campo',
				'ajedrez',
				'pentlaton',
				'tenis_mesa',
				'taewondo',
				'tiro',
				'orientacion'

				); 

				if (is_numeric(array_search($array['modalidad'], $ind))) :

					$winners['comp']        =  true;
					if($array['modalidad'] != 'tiro' && $array['modalidad'] != 'taewondo') :
						$winners['competencias'] = self::$competencias[$array['modalidad']];
						$more  = ' ORDER BY medalla';
						$where = array(
							'usuarios.tipo' => 'deportista', 
							'ganadores.modalidad' => $array['modalidad']
						);
						$left = 'LEFT JOIN usuarios ON usuarios.id = ganadores.id_delegado
						LEFT JOIN delegados ON delegados.id_usuario= ganadores.id_delegado';
						$select = 'delegados.nombre_completo, ganadores.modalidad, ganadores.competencia, ganadores.escuela, ganadores.medalla, ganadores.modo, ganadores.nombre_equipo';
					
					else :
						switch ($array['modalidad']) {
							case 'taewondo':
								$winners['competencias'] = array(
									'poomse' => array(
										'individual (PRINCIPIANTE)', 
										'Pareja (PRINCIPIANTE)', 
										'Equipos (PRINCIPIANTE)',
										'individual (AVANZADO)',
										'pareja (AVANZADO)', 
										'Equipos (AVANZADO)'
									),
									'combate' => array(
										'principiante',
										'avanzado',
										'tk-5'
									)
								);
								$more  = ' AND (ganadores.modalidad = "poomse" OR ganadores.modalidad = "combate") ORDER BY medalla';
								$where = array(
									'usuarios.tipo' => 'deportista'
									
								);
								$left = 'LEFT JOIN usuarios ON usuarios.id = ganadores.id_delegado
								LEFT JOIN delegados ON delegados.id_usuario= ganadores.id_delegado';
								$select = 'delegados.nombre_completo, ganadores.modalidad, ganadores.competencia, ganadores.escuela, ganadores.medalla, ganadores.modo, ganadores.nombre_equipo';
						
							break;
							
							case 'tiro' :
								$winners['competencias'] = array(
									'armas cortas' => array(
										'60 disparos en 4 series de 5 disparos en 10, 8, y 6 segundos cada una',
										'25 metros, 10 disparos en 40 segundos con cambio de proveedor',
										'25 metros, 10 disparos en 40 segundos con cambio de proveedor',
										'25 metros tiro rápido'

									),
									'armas largas' => array(
										
										'Carabina tendido calibre 22 ir: 50 metros, 60 disparos',
										'Carabina 3*40 cal 22 ir:  50 metros',
										'40 disparos tendido, 40 disparo pie, 40 disparos rodillas',
										'100 Mts, 20 disparos posición tendido en 30 minutos',
										'100 Mts, 20 disparo posición pie en 60 minutos',
										'100 Mts, 20 disparo posición rodillas en 45 minutos'
									)
								);
								$more  = ' AND (ganadores.modalidad = "armas cortas" OR ganadores.modalidad = "armas cortas") ORDER BY medalla';
								$where = array(
									'usuarios.tipo' => 'deportista'
									
								);
								$select = 'delegados.nombre_completo, ganadores.modalidad, ganadores.competencia, ganadores.escuela, ganadores.medalla, ganadores.modo, ganadores.nombre_equipo';
					
								$left = 'LEFT JOIN usuarios ON usuarios.id = ganadores.id_delegado
								LEFT JOIN delegados ON delegados.id_usuario= ganadores.id_delegado';	
							break;
						}
					endif;

				else :
					$winners['comp'] =  false;
					$select = 'delegados.nombre_completo, ganadores.modalidad, ganadores.competencia, ganadores.escuela, ganadores.medalla, ganadores.modo, ganadores.nombre_equipo';
					$more   = ' ORDER BY medalla';
					$where  = array(
						'usuarios.tipo' => 'deportista', 
						'ganadores.modalidad' => $array['modalidad']
					);
					$left = 'LEFT JOIN usuarios ON usuarios.id = ganadores.id_delegado
					LEFT JOIN delegados ON delegados.id_usuario= ganadores.id_delegado';
				endif;

			endif;


			
			

			$winners['ganadores'] = w::find_by_attr(
				$where,
				$select,
				$left,
				$more
			);

			 $winners['excel']  = ($winners['ganadores']) ? self::excel($winners['ganadores']) : false;

			parent::__view('admin_mod:admin_layout', $winners);	
		}



		public static function mod_winners_escuelas($array)
		{
			
			$where = array(
				'ganadores.escuela' => $array['escuela']
			);
			$more  = ' ORDER BY medalla';

			$winners['ganadores'] = w::find_by_attr(
				$where,
				'delegados.nombre_completo, ganadores.modalidad, ganadores.competencia, ganadores.escuela, ganadores.medalla, ganadores.modo, ganadores.nombre_equipo',
				'LEFT JOIN usuarios ON usuarios.id = ganadores.id_delegado
				LEFT JOIN delegados ON delegados.id_usuario= ganadores.id_delegado',
				$more
			);

			 $winners['excel']  = ($winners['ganadores']) ? self::excel($winners['ganadores']) : false;

			parent::__view('admin_esc:admin_layout', $winners);	
		}


		public static function fil_comp()
		{
			$winners = w::find_by_attr(
				array('usuarios.tipo' => 'deportista', 'ganadores.competencia' => $_POST['comp']),
				'delegados.nombre_completo, ganadores.modalidad, ganadores.competencia, ganadores.escuela, ganadores.medalla, ganadores.modo, ganadores.nombre_equipo',
				'LEFT JOIN usuarios ON usuarios.id = ganadores.id_delegado
				LEFT JOIN delegados ON delegados.id_usuario= ganadores.id_delegado'
			);
			

		?>

			<?php $excel    = self::excel($winners); ?>
			 <a class="excel" href="<?php echo URL; ?>assets/upload/<?php echo $excel; ?>" download><i class="fa fa-download"></i>
			Descargar excel</a>

			<div class="table-responsive">

			<table class="table table-striped">
			
			<thead>
					
				<tr>
					
					<th>Nombre</th>
					<th>Escuela</th>
					<th>Puesto</th>
					<th>Competencia</th>
					<th>Modalidad</th>
				
				
					

				</tr>	


			</thead>	

		<tbody>
			
			<?php  if($winners) :
			foreach($winners as $winner) : ?>

				<tr>
						
					<td><?php echo $winner['nombre_completo']; ?></td>
					<td>
						
						 <?php echo ($winner['escuela'] == 'ejercito') ? 'Escuela Militar de Suboficiales "Sargento Inocencio Chinca' : ''; ?> 
						<?php echo ($winner['escuela'] == 'naval') ? 'Escuela Naval de Suboficiales "ARC Barranquilla' : ''; ?> 
					    <?php echo ($winner['escuela'] == 'marina') ? 'Escuela de Formación de Infanteria de Marina' : ''; ?> 
					    <?php echo ($winner['escuela'] == 'aerea') ? 'Escuela de Suboficiales de la Fuerza Aérea "Andrés M. Diaz' : ''; ?>
					 	<?php echo ($winner['escuela'] == 'ejecutivo') ? 'Escuela de Suboficiales y Nivel Ejecutivo "Gonzalo Jiménez de Quesada' : ''; ?>

					</td>
					<td><?php echo $winner['medalla']; ?></td>
					<td><?php echo $winner['competencia']; ?></td>
					<td><?php echo $winner['modo']; ?></td>
					
				
				</tr>

			<?php endforeach; endif; ?>

		</tbody>


	</table>

	</div>	

	<?php


		}


	public static function excel($data)
	{

		require_once PATH.'libs/excell/PHPExcel.php';

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

	 	$alfabeto = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","U","V","W","X","Y","Z"
		,"AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AU","AV","AW","AX","AY","AZ");

	 	$objPHPExcel->getActiveSheet()->freezePane('A2');


		// Rows to repeat at top

		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);


		$keys = array_keys($data[0]);
		
		foreach($keys as $k => $v) :
			$objPHPExcel->getActiveSheet()->setCellValue($alfabeto[$k].'1', $v);
		endforeach;

		$i = 2;
		foreach($data as $k1 => $v1) :
			foreach($keys as $k2 => $v2) :
			
				$objPHPExcel->getActiveSheet()->setCellValue($alfabeto[$k2].$i, $v1[$v2]);
			endforeach;
			$i++;
		endforeach;

		$objPHPExcel->setActiveSheetIndex(0);

		//$fecha = 'resultados.xls';

		// Redirect output to a client’s web browser (Excel5)
		/*header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$fecha.'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0*/

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save(PATH.'assets/upload/resultados.xls');
		

		return 'resultados.xls';
	}





	}


?>