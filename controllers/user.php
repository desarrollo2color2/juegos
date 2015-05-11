<?php

	use \model\UserModel as u;
	use \model\DelegadoModel as d;
	use \app\App as app;

	

	Class User extends app
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
		'orientacion' => 'orientacion deportiva'
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




	public static function logout()
	{
		session_destroy();
		parent::url_redirect(URL);
	}


	public static function login()
	{


		$login = u::authenticate_user($_POST['nombre_usuario'],sha1(md5($_POST['pass'])));


		if($login == false) :

			$_SESSION['message'] = '<div class="alert alert-danger" role="alert"> Datos erroneos </ div>';
			parent::url_redirect(URL);

			else : 

			parent::url_redirect(URL.'admin');

		endif;


	}

	public static function all_users()
	{

		$users = u::find_all();
		parent::__view('admin_users:admin_layout', $users);	


	}

	private static function keyas($array)
	{

		foreach($array as $k => $v) :

			$new_array[str_replace('-', '.', $k)] = $v;

		endforeach;

		return $new_array;

	}

	public static function search()
	{
		
	
		if(empty($_POST)) :

			echo '<div class="alert alert-danger" role="alert"><strong>Error</strong> Debe seleccionar algun filtro</div>';

		else :

			$_POST = self::keyas($_POST);

			if($_SESSION['user']['tipo'] != 'admin') :

				$more = ' AND usuarios.tipo != "delegado" AND usuarios.escuela="'.$_SESSION['user']['escuela'].'"';

				else :

				$more = '';

			endif;


			$datos = d::find_by_attr(
				$_POST,
				 'usuarios.tipo, usuarios.escuela, delegados.nombre_completo, delegados.foto, delegados.modalidad,
					delegados.tipo_doc, delegados.num_doc, delegados.cod_militar, delegados.edad, delegados.rh, delegados.telefono, delegados.fecha_nacimiento,
					delegados.lugar_nacimiento, delegados.alergico_a',
				 'INNER JOIN usuarios ON delegados.id_usuario = usuarios.id',
				 $more
		 	);

			if(!$datos) :

				echo '<div class="alert alert-danger" role="alert"><strong>Error</strong> No se encontraron resultados</div>';

			else :

			echo '<div class="list_usuarios">';
			$excel    = self::excel($datos);
				 ?>
				 <a class="excel" href="<?php echo URL; ?>assets/upload/<?php echo $excel; ?>" download><i class="fa fa-download"></i>
				Descargar excel</a>
				<?php foreach($datos as $delegado) : ?>

				<div class="<?php echo $delegado['tipo'] ?>">

				<span class="nombre"> <strong>Nombre : </strong>	<?php echo $delegado['nombre_completo']; ?></span>
				<small class="tipo" style="font-style:italic;"> <strong>Tipo : </strong>  <?php echo ucfirst($delegado['tipo']) ?></small>

				<?php echo ($delegado['foto'] == '') ? '<i class="fa fa-user"></i>' : 
				'<img src="'.URL.'/assets/upload/fotos/'.$delegado['foto'].'" />';  ?>

				

				<div class="hidden_content" style="display:none">
					
					<span class="tipo_doc">
						<strong>Tipo de documento :</strong><?php echo $delegado['tipo_doc']; ?>
					</span>
					<span class="num_doc">
						<strong>Numero de documento :</strong> <?php echo $delegado['num_doc']; ?>
					</span>
					<span class="edad"><strong>Edad :</strong><?php echo $delegado['edad']; ?></span>
					<span class="cod_militar"><strong>Codigo Militar</strong><?php echo $delegado['cod_militar']; ?></span>
					<span class="rh"><strong>RH :</strong><?php echo $delegado['rh']; ?></span>
					<span class="telefono"><strong>Telefono</strong><?php echo $delegado['telefono']; ?> </span>
					
						<?php echo ($delegado['fecha_nacimiento'] != '0000-00-00') ? 
						'<span class="fecha_nacimiento"><strong>Fecha nacimiento : </strong>'.$delegado['fecha_nacimiento'].'<span>' : ''; ?> 
					</span>
					<span class="lugar_nacimiento">
						<?php echo ($delegado['lugar_nacimiento'] != '') ? 
						'<span class="fecha_nacimiento"><strong>Lugar nacimiento : </strong>'.$delegado['lugar_nacimiento'].'</span>' : ''; ?>
					</span>
					<span class="alergico_a">
						<?php echo ($delegado['alergico_a'] != '') ? 
						'<span class="fecha_nacimiento"><strong>Alergico a : </strong>'.$delegado['alergico_a'].'</span>' : ''; ?>
					</span>
				</div>

				 <span class="escuela">	
				     <strong>Escuela: </strong>
				     <?php echo ($delegado['escuela'] == 'ejercito') ? 'Escuela Militar de Suboficiales "Sargento Inocencio Chinca"' : ''; ?> 
					 <?php echo ($delegado['escuela'] == 'naval') ? 'Escuela Naval de Suboficiales "ARC Barranquilla"' : ''; ?>
					 <?php echo ($delegado['escuela'] == 'marina') ? 'Escuela de Formación de Infanteria de Marina' : ''; ?>
					 <?php echo ($delegado['escuela'] == 'aerea') ? 'Escuela de Suboficiales de la Fuerza Aérea "Andrés M. Diaz"' : ''; ?>
					 <?php echo ($delegado['escuela'] == 'ejecutivo') ? 'Escuela de Suboficiales y Nivel Ejecutivo "Gonzalo Jiménez de Quesada"' : ''; ?>	
				 </span>
				 <span class="modalidad">
				 	<strong>Modalidad</strong> <?php echo ucfirst($delegado['modalidad']) ?>
				 </span>

				 <a href="#" class="see_more" onclick="see_more(this, event)">Ver mas</a>

			</div>

		<?php endforeach; ?>
			
			<?php echo '</div>';
			endif;

		endif;
	}

	public static function dashboard()
	{


		$data['tipo']     = u::dashboard();

		$data['excel']    = self::excel($data['tipo']);
		$data['modalidades'] = d::find_all('modalidad', 'GROUP BY modalidad');


		parent::__view('dashboard:admin_layout', $data);
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

	public static function insert_user()
	{

		$_POST['pass'] = sha1(md5($_POST['pass']));

		if (isset($_POST['delegado'])) : $delegado = $_POST['delegado']; unset($_POST['delegado']); endif; 

		$delegado['modalidad'] = json_encode($delegado['modalidad'], JSON_UNESCAPED_UNICODE);
		$delegado['competencia'] = json_encode($delegado['competencia'], JSON_UNESCAPED_UNICODE);



		if($usuario = u::save($_POST)) :

			if(isset($delegado)) :

				$delegado['id_usuario'] = $usuario['db']->insert_id;

				
				$foto = parent::__upload_file(PATH.'assets/upload/fotos/', $_FILES['foto']);
				if($foto != null) : $delegado['foto'] = $foto; endif; 



				u::insert_delegado($delegado);

				

			endif;	


			$_SESSION['message'] = '<div class="alert alert-success" role="alert">Usuario creado</div>';
			$url = URL."admin";
			parent::url_redirect($url);

		else :

			$_SESSION['message'] = '<div class="alert alert-danger" role="alert">No ce puedo crear el usuario</div>';
			$url = URL."admin";
			parent::url_redirect($url);

		endif;


	}

	private static function  random($length = 8) {

	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';

	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }

	    return $randomString;
	}

	public static function forgot(){

		if(isset($_POST)) :

			$user = u::find_by_attr(array('email' => $_POST['email']));

			if($user) :

				$email        = $user[0]['email'];
				$new_password = self::random();



				u::update(array('pass_usuario' => sha1(md5($new_password))), 'WHERE email="'.$email.'" ');

				$_SESSION['message'] = '<div class="alert alert-success" role="alert">Contraseña actualizadada '.$new_password.'</div>';
				parent::url_redirect(URL);


			else :
			$_SESSION['message'] = '<div class="alert alert-danger" role="alert">Este correo no esta registrado</div>';
			parent::url_redirect(URL);

			endif;

		endif;
	}

	public static function update_user($array)
	{

		 $user = u::find_by_attr(array('id' => $array['id']));

		 if($user) :
		 	$user = $user[0];

	

		 	if($user['tipo'] != 'admin') :


	 			$user['delegado'] = u::get_delegado(array('id_usuario' => $user['id']));
	 			$user['delegado'] = $user['delegado'][0];

	 			$user['modalidades']  = self::$modalidades;
	 			$_SESSION['competencias'] = $user['delegado']['competencia'];


	 			if($user['delegado']['id_asistente'] != '0' && $user['delegado']['id_entrenador'] != '0') :

	 				$nombre_asistente = u::get_delegado(array('id_usuario' => $user['delegado']['id_asistente']));
	 				$nombre_asistente = $nombre_asistente[0]['nombre_completo'];

	 				$nombre_entrenador  = u::get_delegado(array('id_usuario' => $user['delegado']['id_entrenador']));
	 				$nombre_entrenador  = $nombre_entrenador[0]['nombre_completo'];


	 				$user['delegado']['nombre_asistente']  = $nombre_asistente;
	 				$user['delegado']['nombre_entrenador'] = $nombre_entrenador;

	 			endif;	

		 	endif;	

		 	$user['action'] = URL.'admin/update_by_user';

		 	else :

		 	parent::url_redirect(URL.'admin/user');

		 endif;

		parent::__view('admin_user:admin_layout', $user);


	}

	public static function update_by_user ()
	{
		if(isset($_POST['pass_usuario']) && $_POST['pass_usuario'] != '') :

			$_POST['pass_usuario'] = sha1(md5($_POST['pass_usuario']));


			else :

			unset($_POST['pass_usuario']);

		endif;

		if(isset($_POST['delegado'])) :

			$delegado = $_POST['delegado'];
			$delegado['modalidad'] = json_encode($delegado['modalidad'], JSON_UNESCAPED_UNICODE);
			$delegado['competencia'] = json_encode($delegado['competencia'], JSON_UNESCAPED_UNICODE);

			
			
			if(!isset($_POST['foto'])):	
				$foto = parent::__upload_file(PATH.'assets/upload/fotos/', $_FILES['foto']);
				if($foto != null) : $delegado['foto'] = $foto; endif;  
			endif;

			unset($_POST['foto']);
			unset($_POST['delegado']);


			u::update_delegado($delegado, ' WHERE id_usuario = '.$_POST['id'].' ');

		endif;

		if(isset($_POST['id']) && u::update($_POST, ' WHERE id = '.$_POST['id'].' ')) :

			$url = URL."admin/users";
			parent::url_redirect($url);

		endif;


	}

	public static function delete_user()
	{

		if( isset($_POST['id']) &&  u::delete_by_id($_POST['id']) && u::delete_delegado($_POST['id'])) :
			echo 'Usuario eliminado';
		endif;


	}

	private static function form_delegado()
	{

		$delegado = '

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="tipo_doc">Tipo documento</label>
					<select name="delegado[tipo_doc]" class="form-control" required>
										
						<option selected="" disabled="">Seleccione una opcion</option>
						<option value="CE">CEDULA DE EXTRANJERIA</option>
						<option value="CED">CÉDULA DE CIUDADANÍA</option>
						<option value="TI">TARGETA DE INDENTIDAD</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="num_doc">Numero documento</label>
					<input	type="text" name="delegado[num_doc]" class="form-control" required />	
				</div>
			</div>
		</div>	

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="cod_militar">Codigo militar</label>
					<input type="text" name="delegado[cod_militar]" class="form-control" required />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="nombre_completo">Nombre completo</label>
					<input type="text" name="delegado[nombre_completo]" class="form-control" required />
				</div>
			</div>
		</div>	

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="edad">Edad</label>
					<input type="number" name="delegado[edad]" min="18" class="form-control" required />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="rh">RH</label>
					<input type="text" name="delegado[rh]" class="form-control" required />
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label for="telefono">Telefono</label>
					<input type="text" name="delegado[telefono]" class="form-control" required />
				</div>
			</div>
		</div>

		

		<div class="row">

			<div class="col-md-12">
				<div class="form-group">
					<img class="file_image" src="#" />
					<input  onchange="readURL(this)" type="file" name="foto"  accept="image/x-png, image/gif, image/jpeg" class="file" />
				</div>
			</div>

		</div>';

		$delegado.= '<div class="row">
			<div class="col-md-6">
			<div class="form-group">
				<label>Modalidad</label>
				<select style="height:inherit;" name="delegado[modalidad][]" class="form-control" onchange="get_comp(this)" required multiple>
		';

		foreach(self::$modalidades as $k => $v) :
			if(is_array($v)) :
				$delegado .= ' <optgroup label="'.$k.'">';
					foreach($v as $k1 => $v1) :
						if(!is_array($v1)):
							$delegado .= '<option value="'.$v1.'">'.$v1.'</option>';
						else :
							$delegado .= ' <optgroup label="'.$k1.'">';
							foreach($v1 as $v2) :
								$delegado .= '<option value="'.$v2.'">'.$v2.'</option>';	
							endforeach;
							$delegado .='</optgroup>';
						endif;
					endforeach;
			  	$delegado .='</optgroup>';
			else :
				$delegado .='<option value="'.$k.'">'.$v.'</option>';
			endif;
		endforeach;


		$delegado .= '</select></div></div>
			<div class="col-md-6">
				<div class="form-group" id="competencias">
					<label>Competencias</label>
					<div></div>
				</div>
			</div>
		</div>';


		return $delegado;

	}

	public static function get_comp()
	{
		
		if(isset($_SESSION['competencias'])) :
			$comps = json_decode($_SESSION['competencias'], true);
			unset($_SESSION['competencias']);
			$html = '<select style="height:inherit;" name="delegado[competencia][]" class="form-control" multiple>';
			foreach($_POST['value'] as $k => $comp) :
				if(isset(self::$competencias[$comp])) :
					$html .= '<optgroup label="'.$comp.'">';
					if(is_array(self::$competencias[$comp])) :
						
						foreach(self::$competencias[$comp] as $val) :
							
							if(is_null($comps)) :
								$selected = '';
							else :
								$selected = (is_numeric(array_search($val, $comps))) ? 'selected' : '';
							endif;

							
							$html .= '<option '.$selected.' value="'.$val.'">'.$val.'</option>';
						endforeach;
					else :
						$selected = (is_numeric(array_search(self::$competencias[$comp], $comps))) ? 'selected' : '';
						$html .= '<option '.$selected.' value="'.self::$competencias[$comp].'">'.self::$competencias[$comp].'</option>';
					endif;
					$html .= '</optgroup>';
				endif;
			endforeach;
			$html .= '</select>';


		else :
			$html = '<select style="height:inherit;" name="delegado[competencia][]" class="form-control" multiple>';
			foreach($_POST['value'] as $k => $comp) :
				if(isset(self::$competencias[$comp])) :
					$html .= '<optgroup label="'.$comp.'">';
					if(is_array(self::$competencias[$comp])) :
						foreach(self::$competencias[$comp] as $val) :
							$html .= '<option value="'.$val.'">'.$val.'</option>';
						endforeach;
					else :
						$html .= '<option value="'.self::$competencias[$comp].'">'.self::$competencias[$comp].'</option>';
					endif;
					$html .= '</optgroup>';
				endif;
			endforeach;
			$html .= '</select>';

		endif;

		
		
		echo $html;

		//<select style="height:inherit;" name="delegado[competencia][]" class="form-control" required multiple></select>
	}

	private static function form_deportista()
	{

		
		$asistentes = u::find_by_attr(array('usuarios.tipo' => 'asistente'), 
						'usuarios.id, delegados.nombre_completo',
						'INNER JOIN delegados ON delegados.id_usuario = usuarios.id ');

		$entrenadores = u::find_by_attr(array('usuarios.tipo' => 'entrenador'), 
						'usuarios.id, delegados.nombre_completo',
						'INNER JOIN delegados ON delegados.id_usuario = usuarios.id ');

		if($entrenadores != false) :

		$deportista = '

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="tipo_doc">Tipo documento</label>
					<select name="delegado[tipo_doc]" class="form-control" required>
										
						<option selected="" disabled="">Seleccione una opcion</option>
						<option value="CE">CEDULA DE EXTRANJERIA</option>
						<option value="CED">CÉDULA DE CIUDADANÍA</option>
						<option value="TI">TARGETA DE INDENTIDAD</option>
						
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="num_doc">Numero documento</label>
					<input	type="text" name="delegado[num_doc]" class="form-control" required />	
				</div>
			</div>
		</div>	

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="cod_militar">Codigo militar</label>
					<input type="text" name="delegado[cod_militar]" class="form-control" required />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="nombre_completo">Nombre completo</label>
					<input type="text" name="delegado[nombre_completo]" class="form-control" required />
				</div>
			</div>
		</div>	

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="edad">Edad</label>
					<input type="number" name="delegado[edad]" min="18" class="form-control" required />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="rh">RH</label>
					<input type="text" name="delegado[rh]" class="form-control" required />
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label for="telefono">Telefono</label>
					<input type="text" name="delegado[telefono]" class="form-control" required />
				</div>
			</div>
		</div>

		

		<div class="row">

			<div class="col-md-12">
				<div class="form-group">
					<img class="file_image" src="#" />
					<input  onchange="readURL(this)" type="file" name="foto"  accept="image/x-png, image/gif, image/jpeg" class="file" />
				</div>
			</div>

		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="eps">Eps</label>
					<input type="text" name="delegado[eps]" class="form-control" required />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="fecha_nacimiento">Fecha nacimiento</label>
					<input id="date" type="text" onclick="dater()" name="delegado[fecha_nacimiento]" class="form-control" required />
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="lugar_nacimiento">Lugar nacimiento</label>
					<input type="text" name="delegado[lugar_nacimiento]" class="form-control" required />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="alergico_a">Alergico a</label>
					<input type="text" name="delegado[alergico_a]" class="form-control" required />
				</div>
			</div>
		</div>

		
		';

		
		$deportista.= '<div class="row">
			<div class="col-md-6">
			<div class="form-group">
				<label>Modalidad</label>
				<select style="height:inherit;" name="delegado[modalidad][]" class="form-control" onchange="get_comp(this)" required multiple>
		';

		foreach(self::$modalidades as $k => $v) :
			if(is_array($v)) :
				$deportista .= ' <optgroup label="'.$k.'">';
					foreach($v as $k1 => $v1) :
						if(!is_array($v1)):
							$deportista .= '<option value="'.$v1.'">'.$v1.'</option>';
						else :
							$deportista .= ' <optgroup label="'.$k1.'">';
							foreach($v1 as $v2) :
								$deportista .= '<option value="'.$v2.'">'.$v2.'</option>';	
							endforeach;
							$deportista .='</optgroup>';
						endif;
					endforeach;
			  	$deportista .='</optgroup>';
			else :
				$deportista .='<option value="'.$k.'">'.$v.'</option>';
			endif;
		endforeach;


		$deportista .= '</select></div></div>
			<div class="col-md-6">
				<div class="form-group" id="competencias">
					<label>Competencias</label>
					<div></div>
				</div>
			</div>
		</div>';

		// Entrenadores

		$deportista .= '

		<div class="row">
			
			<div class="col-md-6">
		<div class="form-group">
						<label for="id_entrenador">Entrenadores</label>
						<select name="delegado[id_entrenador] class="form-control" required">';



		foreach($entrenadores as $entrenador) :
				
				$deportista .= '<option value="'.$entrenador['id'].'">'.$entrenador['nombre_completo'].'</option>';

		endforeach;	

		$deportista .= '</select></div></div><div class="col-md-6">';


		// Asistentes

		if($asistentes) :
		$deportista .= '<div class="form-group">
						<label for="id_asistente">Asistentes</label>
						<select name="delegado[id_asistente] class="form-control" required">';

	
		foreach($asistentes as $asistente) :
				
				$deportista .= '<option value="'.$asistente['id'].'">'.$asistente['nombre_completo'].'</option>';

		endforeach;	

		$deportista .= '</select></div>';

		endif;

		$deportista .= '</div></div>';


		return $deportista;

		else :

		return false;

		endif;	

	}



	public static function form_dele()
	{

		if($_POST['tipo'] == 'deportista') :

			echo (self::form_deportista() != false) ? self::form_deportista() : 'Debe tener entrenadores y asistentes creados';

		elseif($_POST['tipo'] == 'admin') : 

			echo '';

		else :

			echo self::form_delegado();

		endif;	

	}


}


?>