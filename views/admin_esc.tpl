<div class="admin">

<h1 class="title"><i class="fa fa-book"></i> Resultados</h1>

<?php 
	
?>


<?php if($params) : ?>

	<?php $excel = $params['excel']; unset($params['excel']); ?>
	
	

	<div class="results">

	<?php if($excel) : ?>
		<a class="excel" href="<?php echo URL; ?>assets/upload/<?php echo $excel; ?>" download><i class="fa fa-download"></i>
			Descargar excel</a>
	<?php endif; ?>
	<div class="table-responsive">

	<table class="table table-striped">
			
		<thead>
				
			<tr>
				
				<th>Nombre deportista - Equipo</th>
				<th>Escuela</th>
				<th>Posicion - Medalla</th>
				<th>Disiplina</th>
				<th>Competencia</th>
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
					<td>
						<?php 

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
					?>
					</td>
					<td><?php echo $winner['modalidad']; ?></td>
					<td><?php echo $winner['competencia']; ?></td>
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