
<ul>
	<li><a href="<?php echo URL; ?>admin"> <i class="fa fa-home"></i>Inicio</a></li>
	<!-- Usuario -->
	
	<?php if($_SESSION['user']['tipo'] == 'admin' or $_SESSION['user']['tipo'] == 'delegado') : ?>
	<li class="submenu"><a href="#"><i class="fa fa-user"></i> Usuarios<i class="fa fa-plus"></i></a>
		<ul>

			<li><a href="<?php echo URL; ?>admin/users"> Todos los usuarios </a></li>
			<li><a href="<?php echo URL; ?>admin/add_user"> Añadir usuario </a></li>

		</ul>
	</li>
	<li class="submenu"><a href="#"><i class="fa fa-user"></i> Resultados<i class="fa fa-plus"></i></a>
		<ul>

			<li><a href="<?php echo URL; ?>admin/winners"> Ganadores por disiplina </a></li>
			<li><a href="<?php echo URL; ?>admin_escuelas"> Ganadores por escuelas </a></li>
			<?php if($_SESSION['user']['tipo'] == 'admin') : ?>
			<li><a href="<?php echo URL; ?>admin/add_winner"> Añadir ganador </a></li>
			<?php endif; ?>
		</ul>
	</li>
	<?php endif; ?>
	
	
	
</ul>

