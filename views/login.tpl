<?php if(!isset($_SESSION['user'])) : ?>


<div class="container">
	<form action="<?php echo URL.'login'; ?>" method="POST">
		<!--<h3>Ingresar</h3>-->
		<div><i class="fa fa-user"></i><input type="email" placeholder="Usuario" name="nombre_usuario" required /></div>
		<div><i class="fa fa-lock"></i><input type="password" placeholder="Contraseña" name="pass" required /></div>
		
		<input type="submit" value="Iniciar sesion" />

		<!--<a style="color:#fff" href="<?php //echo URL.'olvido'; ?>">Has olvidado tu contraseña</a>-->

	</form>	
</div>	




<?php endif; ?>
