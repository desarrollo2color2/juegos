<div class="admin" style="background:none;">

<h1 class="title"><i class="fa fa-book"></i> Escuelas</h1>


<?php 

	$escuelas = array(


		'ejercito' => 'Escuela Militar de Suboficiales "Sargento Inocencio Chinca',
		'naval'    => 'Escuela Naval de Suboficiales "ARC Barranquilla',
		'marina'   => 'Escuela de Formación de Infanteria de Marina',
		'aerea'    => 'Escuela de Suboficiales de la Fuerza Aérea "Andrés M. Diaz',
		'ejecutivo' => 'Escuela de Suboficiales y Nivel Ejecutivo "Gonzalo Jiménez de Quesada',

	);


 ?>



	<div class="results"></div>
	<div class="ganadores_modalidades">
		<?php foreach($escuelas as $k => $escuela) : ?>
			<div class="modalidad <?php echo $k; ?>">
				<!--<img src="<?php //echo URL; ?>assets/img/<?php //echo $k; ?>.jpg" /> -->
				<a href="<?php echo URL; ?>admin_winners_/escuela/<?php echo $k; ?>" class="nombre"><?php echo $escuela; ?> </a>
			</div>
		<?php endforeach; ?>
	</div>


</div>