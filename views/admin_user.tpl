<?php $delegado = (isset($params['delegado'])) ? $params['delegado'] : false; unset($params['delegado']); ?>

<?php 
	
	if(isset($params['modalidades'])) :
		$modalidades  = $params['modalidades'];
		unset($params['modalidades']);
		
	endif;
	
 ?>

<div class="admin">

<h1 class="title"><i class="fa fa-user"></i>Usuario</h1>

<form action="<?php  if(isset($params['action'])) :  echo $params['action']; unset($params['action']); else : echo URL.'admin/insert_user'; endif; ?>" method="POST" enctype="multipart/form-data">

	<?php echo isset($params['id']) ? '<input type="hidden" name="id" value="'.$params['id'].'"/>'  : ''; ?>

	<div class="row">
		
		<div class="col-md-6">
			<div class="form-group">

			<label>Email</label>
			<input class="form-control" value="<?php echo isset($params['nombre_usuario']) ? $params['nombre_usuario'] : ''; ?>" type="text" placeholder="Nombre Usuario" name="nombre_usuario" required />

		</div>
	</div>
	
		<div class="col-md-6">
		<div class="form-group">
				<label for="password">Password</label>
				<input class="form-control" type="password" placeholder="Password" name="pass" <?php echo isset($params['pass']) ? '' : 'required'; ?> />

			</div>
		</div>

	</div>


	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="tipo">Tipo de usuario</label>

				<select name="tipo" class="form-control tipo" <?php echo (isset($params['tipo'])) ? 'disabled' : ''; ?> required>

					<?php $value = (isset($params['tipo'])) ? $params['tipo'] : ''; ?>
					<?php echo (!isset($params['tipo'])) ? '<option selected disabled> Selecciona una opcion</option>' : ''; ?>
					
					<?php if( $_SESSION['user']['tipo'] == 'admin') : ?>

					<option <?php echo ($value == 'admin') ? 'selected' : ''; ?> value="admin">Administrador</option>
					<option <?php echo ($value == 'delegado') ? 'selected' : ''; ?> value="delegado">Delegado</option>

					<?php endif; ?>


					<option <?php echo ($value == 'deportista') ? 'selected' : ''; ?> value="deportista">Deportista</option>
					<option <?php echo ($value == 'asistente') ? 'selected' : ''; ?> value="asistente">Asistente</option>
					<option <?php echo ($value == 'entrenador') ? 'selected' : ''; ?> value="entrenador">Entrenador</option>
					
				</select>

			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="escuela">Escuela</label>
				<select name="escuela" class="form-control escuela" required>
					<?php $escuela = (isset($params['escuela'])) ? $params['escuela'] : ''; ?>
					<?php echo (!isset($params['escuela'])) ? '<option selected disabled> Selecciona una opcion</option>' : ''; ?>

					<option <?php echo ($escuela == 'ejercito') ? 'selected' : ''; ?> value="ejercito">Escuela Militar de Suboficiales "Sargento Inocencio Chinca"</option>
					<option <?php echo ($escuela == 'naval') ? 'selected' : ''; ?> value="naval">Escuela Naval de Suboficiales "ARC Barranquilla"</option>
					<option <?php echo ($escuela == 'marina') ? 'selected' : ''; ?> value="marina">Escuela de Formación de Infanteria de Marina</option>
					<option <?php echo ($escuela == 'aerea') ? 'selected' : ''; ?> value="aerea"> Escuela de Suboficiales de la Fuerza Aérea "Andrés M. Diaz"</option>
					<option <?php echo ($escuela == 'ejecutivo') ? 'selected' : ''; ?> value="ejecutivo">Escuela de Suboficiales y Nivel Ejecutivo "Gonzalo Jiménez de Quesada"</option>	

				</select>
			</div>
		</div>
	</div>


	


	

	

	<!-- Delegado -->
	<?php if($delegado) : ?>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="tipo_doc">Tipo documento</label>
					<select name="delegado[tipo_doc]" class="form-control" required>
						
						<option <?php echo ($delegado['tipo_doc'] == 'CE') ? 'selected' : ''; ?> value="CE">CEDULA DE EXTRANJERIA</option>
						<option <?php echo ($delegado['tipo_doc'] == 'CED') ? 'selected' : ''; ?> value="CED">CÉDULA DE CIUDADANÍA</option>
						<option <?php echo ($delegado['tipo_doc'] == 'TI') ? 'selected' : ''; ?> value="TI">TARGETA DE IDENTIDAD</option>
						
					</select>
				</div>	
			</div>
		</div>

		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="foto">Foto</label>

					<?php if($delegado['foto'] != '') : ?>
					
					<input type="hidden" name="foto" value="<?php echo $delegado['foto'];?>" />
					<img class="file_image"  height="200" alt="Foto" 
					src="<?php echo URL.'assets/upload/fotos/'.$delegado['foto']; ?> "  />
					<a class="change_foto" href="#"><i class="fa fa-pencil-square-o"></i> Editar Foto</a>


					<?php else : ?>

						<img class="file_image" src="#" />
						<input  type="file" name="foto" onchange="readURL(this)"  accept="image/x-png, image/gif, image/jpeg"  />


					<?php endif; ?>

				</div>		
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="num_doc">Numero documento</label>
					<input	type="text" name="delegado[num_doc]" class="form-control" value="<?php echo $delegado['num_doc']; ?>" required />	
				</div>
			</div>
		
		</div>

		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="cod_militar">Codigo militar</label>
					<input type="text" name="delegado[cod_militar]" class="form-control" value="<?php echo $delegado['cod_militar'] ?>" required />
				</div>	
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="nombre_completo">Nombre completo</label>
					<input type="text" name="delegado[nombre_completo]" class="form-control" value="<?php echo $delegado['nombre_completo'] ?>" required />
				</div>
			</div>
		
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="edad">Edad</label>
					<input type="number" name="delegado[edad]" min="18" class="form-control" value="<?php echo $delegado['edad'] ?>" required />
				</div>	
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="rh">RH</label>
					<input type="text" name="delegado[rh]" class="form-control" value="<?php echo $delegado['rh'] ?>" required />
				</div>
			</div>
		
		</div>
		

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="telefono">Telefono</label>
					<input type="text" name="delegado[telefono]" class="form-control" value="<?php echo $delegado['telefono'] ?>" required />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="modalidad">Modalidad</label>
					<select id="modalidad" multiple="" required="" onchange="get_comp(this)" class="form-control" name="delegado[modalidad][]" style="height:inherit;">
						<?php $mods = json_decode($delegado['modalidad'], true); ?>
						<option 
						<?php echo (is_numeric(array_search('futbol', $mods))) ? 'selected' : '';  ?>
						value="futbol">futbol</option>
						<option 
						<?php echo (is_numeric(array_search('micro_futbol', $mods))) ? 'selected' : '';  ?>
						value="micro_futbol">micro futbol</option>
						<option 
						<?php echo (is_numeric(array_search('baloncesto', $mods))) ? 'selected' : '';  ?>
						value="baloncesto">baloncesto</option>
						<option 
						<?php echo (is_numeric(array_search('voleibol', $mods))) ? 'selected' : '';  ?>
						value="voleibol">voleibol</option>
						<option 
						<?php echo (is_numeric(array_search('natacion', $mods))) ? 'selected' : '';  ?>
						value="natacion">natación</option>
						<option 
						<?php echo (is_numeric(array_search('atletismo', $mods))) ? 'selected' : '';  ?>
						value="atletismo">atletismo</option>
						<option 
						<?php echo (is_numeric(array_search('atletismo_campo', $mods))) ? 'selected' : '';  ?>
						value="atletismo_campo">atletismo de campo</option>
						<option 
						<?php echo (is_numeric(array_search('ajedrez', $mods))) ? 'selected' : '';  ?>
						value="ajedrez">ajedrez</option>
						<option 
						<?php echo (is_numeric(array_search('pentatlon', $mods))) ? 'selected' : '';  ?>
						value="pentlaton">pentatlon militar</option>
						<option 
						<?php echo (is_numeric(array_search('tenis_mesa', $mods))) ? 'selected' : '';  ?>
						value="tenis_mesa">tenis de mesa</option> 
						<optgroup label="taewondo">
							<option 
							<?php echo (is_numeric(array_search('poomse', $mods))) ? 'selected' : '';  ?>
							value="poomse">poomse</option>
							<option 
							<?php echo (is_numeric(array_search('combate', $mods))) ? 'selected' : '';  ?>
							value="combate">combate</option>
						</optgroup> 
						<optgroup label="tiro">
							<option 
							<?php echo (is_numeric(array_search('armas cortas', $mods))) ? 'selected' : '';  ?>
							value="armas cortas">armas cortas</option>
							<option 
							<?php echo (is_numeric(array_search('armas largas', $mods))) ? 'selected' : '';  ?>
							value="armas largas">armas largas</option>
						</optgroup>
						<option 
						<?php echo (is_numeric(array_search('orientacion', $mods))) ? 'selected' : '';  ?>
						value="orientacion">orientacion deportiva</option>
						</select>
			
				</div>
			</div>
		
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group" id="competencias">
					<label>Competencias</label>
					<div></div>
				</div>
			</div>
		</div>			

		<!-- deportista -->
		<div class="row">
			<div class="col-md-6">
				<?php if($delegado['eps'] != '') : ?>
					<div class="form-group">
						<label for="eps">Eps</label>
						<input type="text" name="delegado[eps]" class="form-control" value="<?php echo $delegado['eps']; ?>" required />
					</div>
				<?php endif; ?>	
			</div>
			<div class="col-md-6">
				<?php if($delegado['fecha_nacimiento'] != '0000-00-00') : ?>
					<div class="form-group">
						<label for="fecha_nacimiento">Fecha nacimiento</label>
						<input type="text" name="delegado[fecha_nacimiento]" class="form-control" value="<?php echo $delegado['fecha_nacimiento'];  ?>" required />
					</div>
				<?php endif; ?>
			</div>
		
		</div>

		<div class="row">
			<div class="col-md-6">
				<?php if($delegado['lugar_nacimiento'] != '') : ?>
					<div class="form-group">
						<label for="lugar_nacimiento">Lugar nacimiento</label>
						<input type="text" name="delegado[lugar_nacimiento]" class="form-control" value="<?php echo $delegado['lugar_nacimiento']; ?>" required />
					</div>
				<?php endif; ?>	
			</div>
			<div class="col-md-6">
				<?php if($delegado['alergico_a'] != '') : ?>
					<div class="form-group">
						<label for="alergico_a">Alergico a</label>
						<input type="text" name="delegado[alergico_a]" class="form-control" value="<?php echo $delegado['alergico_a']; ?>" required />
					</div>
				<?php endif; ?>	
			</div>
		
		</div>

		<div class="row">
			<div class="col-md-6">
				<?php if(isset($delegado['nombre_asistente'])) : ?>
					<div class="form-group">
						<label for="nombre_asistente">Nombre asistente</label>
						<input type="text"  class="form-control" value="<?php echo $delegado['nombre_asistente']; ?>" disabled />
					</div>
				<?php endif; ?>	
			</div>
			<div class="col-md-6">
				<?php if(isset($delegado['nombre_entrenador'])) : ?>
					<div class="form-group">
						<label for="nombre_entrenador">Nombre asistente</label>
						<input type="text"  class="form-control" value="<?php echo $delegado['nombre_entrenador']; ?>" disabled />
					</div>
				<?php endif; ?>
			</div>
		
		</div>

	<?php endif; ?>	

	<div class="ajax"></div>

	<div class="form_group">
		<input type="submit" value="Enviar" />

	</div>
</form>
</div>

<script type="text/javascript">
	
	function dater(){
		$('#date').datepicker({ dateFormat: 'yy-mm-dd' });
	}

	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                	

                $('.file_image')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function get_comp(nip){
    	var value = $(nip).val();

    	$.ajax({
			url: '<?php echo URL; ?>ajax_comp',
			cache: false,
			type: 'POST',
			data: {value: value},
			success: function(html){
			$('#competencias div').html(html);
			}
		});
    }

    $('.change_foto').click(function(e){

		e.preventDefault();

		$(this).parent().children('input[type="hidden"]').remove();
	
		$(this).parent().append('<input class="file" onChange="readURL(this);" type="file"'
		  +'accept="image/x-png, image/gif, image/jpeg" name="foto"  />');	
		$(this).remove();

	});


	$('.tipo').change(function(e){

		e.preventDefault();

		var tipo = $(this).val();

	
		$.ajax({
			url: '<?php echo URL; ?>form_dele',
			cache: false,
			type: 'POST',
			data: {tipo: tipo},
			success: function(html){
			$('.ajax').html(html);
			}
		});
		
	});

	$(document).ready(function(){

		$('#modalidad').trigger('change');

	});

</script>