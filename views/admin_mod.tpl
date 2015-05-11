<div class="admin">

<h1 class="title"><i class="fa fa-book"></i> Resultados</h1>

<?php 
	
?>


<?php if($params) : ?>

	<?php $excel = $params['excel']; unset($params['excel']); ?>
	
	<?php if($params['comp'])  :
		$co = $params['comp']; $competencias = $params['competencias'];
		unset($params['comp']);
		unset($params['competencias']);

	 ?>
	<form id="fil_comp" action="<?php echo URL; ?>fil_comp" method="post">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Competencias</label>
					<select name="comp" class="form-control" required>
						<?php foreach($competencias as $k =>  $comp) : ?>
							<?php if(!is_array($comp)): ?>
								<option value="<?php echo $comp ?>"><?php echo $comp ?></option>	
							<?php else : ?>
								 <optgroup label="<?php echo $k; ?>">
							 		<?php foreach($comp as $v) : ?>
							 			<option value="<?php echo $v ?>"><?php echo $v ?></option>
						 			<?php endforeach; ?>
								 </optgroup>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<button type="submit">
						<i class="fa fa-search"></i>
						Filtrar
					</button>
				</div>
			</div>
		</div>
	</form>

	<?php else : $co = false; ?>

	<?php endif; ?>

	<div class="results">

	<?php if($excel) : ?>
		<a class="excel" href="<?php echo URL; ?>assets/upload/<?php echo $excel; ?>" download><i class="fa fa-download"></i>
			Descargar excel</a>
	<?php endif; ?>
	<div class="table-responsive">

	<table class="table table-striped">
			
		<thead>
				
			<tr>
				
				<th>Nombre</th>
				<th>Escuela</th>
				<th><?php echo ($co) ? 'Posicion' : 'Medalla' ?></th>
				<?php if($co)  : ?>
					<th>Competencia</th>
				<?php endif; ?>
				<th>Modalidad</th>
				

			</tr>	


		</thead>	

		<tbody>
			
			<?php  if($params['ganadores']) :
				foreach($params['ganadores'] as $winner) : ?>

				<tr>
						
					<td><?php echo ($winner['nombre_equipo'] !="") ? $winner['nombre_equipo'] : $winner['nombre_completo']; ?></td>
					<td>
						
						 <?php echo ($winner['escuela'] == 'ejercito') ? 'Escuela Militar de Suboficiales "Sargento Inocencio Chinca' : ''; ?> 
						<?php echo ($winner['escuela'] == 'naval') ? 'Escuela Naval de Suboficiales "ARC Barranquilla' : ''; ?> 
					    <?php echo ($winner['escuela'] == 'marina') ? 'Escuela de Formación de Infanteria de Marina' : ''; ?> 
					    <?php echo ($winner['escuela'] == 'aerea') ? 'Escuela de Suboficiales de la Fuerza Aérea "Andrés M. Diaz' : ''; ?>
					 	<?php echo ($winner['escuela'] == 'ejecutivo') ? 'Escuela de Suboficiales y Nivel Ejecutivo "Gonzalo Jiménez de Quesada' : ''; ?>

					</td>
					<td><?php 

					switch ($winner['medalla']) {
						case '1':
							echo 'oro';
						break;
						case '2':
							echo 'plata';
						break;
						case '3':
							echo 'bronce';
						break;
						
						default:
							echo $winner['medalla'];
						break;
					}
					?></td>
					<?php if($co)  : ?>
						<td><?php echo $winner['competencia']; ?></td>
					<?php endif; ?>
					<td><?php echo $winner['modo']; ?></td>
				
				</tr>

			<?php endforeach; endif; ?>

		</tbody>


	</table>

	</div>

	</div>

	<script type="text/javascript">

		$('#fil_comp').submit(function(e){
			e.preventDefault();

			var form = $(this);


			$.ajax({

				url: "<?php echo URL ?>fil_comp",
				cache: false,
				type: 'POST',
				data: form.serialize(),
				success: function(html){
				$('.results').html(html);
				}
				

			});
		});

	</script>

<?php endif; ?>


</div>