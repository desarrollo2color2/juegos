<div class="admin_user">

	<a class="user_icon" href="#"><i class="fa fa-user"></i></a>
	<div class="user_interface">
		
		<?php 

		echo '<span><b>Nombre  </b> '.$_SESSION['user']['nombre_usuario'].'</span>
		<a class="logout" href="'.URL.'logout">Cerrar seccion</a>';	


		 ?>
		

	</div>	

</div>
