<div class="usuarios">
	

	<form id="search" method="post" class="search_form">
		
	<div class="form-group">
		<label> Tipo </label>
		<select class="form-control" id="tipo_usuario" name="usuarios-tipo">
			<option valuue="" disabled selected>Selecciona una opcion</option>
			<option value="deportista">Deportistas</option>
			<option value="entrenador">Entrenador</option>
			<option value="asistente">Asistente</option>			
		</select>
	</div>

	<?php if($_SESSION['user']['tipo'] == 'admin' or $_SESSION['user']['tipo'] == 'delegado') : ?>
	<div class="form-group">
		<label>Escuela</label>
		<select name="usuarios-escuela" class="form-control escuela">
			<option selected disabled> Selecciona una opcion</option>
			<option  value="ejercito">Escuela Militar de Suboficiales "Sargento Inocencio Chinca"</option>
			<option  value="naval">Escuela Naval de Suboficiales "ARC Barranquilla"</option>
			<option  value="marina">Escuela de Formación de Infanteria de Marina</option>
			<option  value="aerea"> Escuela de Suboficiales de la Fuerza Aérea "Andrés M. Diaz"</option>
			<option  value="ejecutivo">Escuela de Suboficiales y Nivel Ejecutivo "Gonzalo Jiménez de Quesada"</option>	

		</select>
	</div>

	<?php else : ?>

		<input type="hidden" name="usuarios-escuela" value="<?php echo $_SESSION['user']['escuela']; ?>"/>

	<?php endif; ?>	

	<div class="form-group">
	<label>Modalidad</label>
		<select class="form-control" name="delegados-modalidad">
			<option selected disabled> Selecciona una opcion</option>
			<?php foreach($params['modalidades'] as $modalidad) : ?>
				<option value="<?php echo $modalidad['modalidad']; ?>"><?php echo ucfirst($modalidad['modalidad']); ?></option>
			<?php endforeach; ?>
		</select>
	</div>		

	<div class="form-group">
		<button type="submit">
			<i class="fa fa-search"></i>
			Filtrar
		</button>
	</div>

	</form>

	

	<div class="full" style="display:none;">
		<a style="color: #fff;
			display: block;
			font-size: 40px;
			position: absolute;
			right: 30px;" href="#" onclick="$(this).parent().children('.container').empty();$(this).parent().fadeOut('slow');">
			<i class="fa fa-times"></i>

		</a>
		<div class="container">
			
		</div>

	</div>
	<div class="results"></div>

	<div class="list_usuarios">
		
		<?php $excel = $params['excel'];
			  unset($params['excel']);
		 ?>		

		 <a class="excel" href="<?php echo URL; ?>assets/upload/<?php echo $excel; ?>" download><i class="fa fa-download"></i>
																					Descargar excel</a>

		<?php foreach($params['tipo'] as $delegado) : ?>

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

		

	</div>
</div>

<script type="text/javascript">

	function see_more(nip, e) {
		e.preventDefault();

		var full = $(nip).parent().html();

		$('.full .container').html(full);
		$('.full').fadeIn('slow');
	}

	$('.search_form').submit(function(e){
		e.preventDefault();

		$('.list_usuarios').fadeOut('slow').remove();

		var form = $(this);
		$.ajax({
			url: "<?php echo URL.'ajax_search'; ?>",
			cache: false,
			type: 'POST',
			data: form.serialize(),
			success: function(html){
			$('.results').html(html);
			}
		}); 
	});
</script>