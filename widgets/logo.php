<div class="logo">
	<img src="<?php echo URL.'assets/img/dragon.jpg' ?>" alt="Logo" />
	
	<?php if(!isset($_SESSION['user'])) : ?>

	<a href="#" class="ingresar">juegos interescuelas emsub 2015  <br/><small>INGRESAR</small></a>

<?php else : ?>

		<?php if($_SESSION['user']['tipo'] == 'deportista') : ?>
			<span>Esta inscrito en los juegos</span>
		<?php else : ?>
				<a class="panel_" href="<?php echo URL; ?>admin"><i class="fa fa-unlock"></i> Ir al panel de administracion</a>
				<a class="logout_" href="<?php echo URL;  ?>logout"><i class="fa fa-sign-out"></i> Cerrar sesión</a>

		<?php endif; ?>

<?php endif; ?>

</div>