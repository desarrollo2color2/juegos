<div class="admin" style="background:none;">

<h1 class="title"><i class="fa fa-book"></i> Disciplinas</h1>


<?php if($params) : ?>

	<div class="results"></div>
	<div class="ganadores_modalidades">
		<?php foreach($params['modalidades'] as $k => $modalidad) : ?>
			<div class="modalidad <?php echo $k; ?>">
				<img src="<?php echo URL; ?>assets/img/<?php echo $k; ?>.jpg" />
				<a href="<?php echo URL; ?>admin_winners/modalidad/<?php echo $k; ?>" class="nombre"><?php echo str_replace('_', ' ', $k); ?> </a>
			</div>
		<?php endforeach; ?>
	</div>
	<!--<div class="table-responsive">

	<table class="table table-striped">
			
		<thead>
				
			<tr>
				
				<th>Nombre</th>
				<th>Modalidad</th>
				<th>Competencia</th>
			
				

			</tr>	


		</thead>	

		<tbody>
			
			<?php  /*foreach($params as $winner) : ?>

				<tr>
						
					<td><?php echo $winner['nombre_completo']; ?></td>
					<td><?php echo $winner['modalidad']; ?></td>
					<td><?php echo $winner['competencia']; ?></td>
					
				
				</tr>

			<?php endforeach;*/ ?>

		</tbody>


	</table>

	</div>-->

<?php endif; ?>


</div>