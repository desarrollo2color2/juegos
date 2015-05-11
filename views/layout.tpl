<?php require_once 'head.tpl'; ?>

<div class="mensajes"><?php if(isset($_SESSION['message'])) : echo $_SESSION['message']; unset($_SESSION['message']); endif; ?></div>
<div class="maincontent">


		<section>
			
			<?php require_once $content; ?> 

		</section>
	

</div>	


	

<?php  require_once 'footer.tpl'; ?>    