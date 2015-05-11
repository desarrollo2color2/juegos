<div class="mensajes" style="position: relative;
top: 0;
width: 100%;
z-index: 10000000;">
	<?php if(isset($_SESSION['message'])) : echo $_SESSION['message']; unset($_SESSION['message']); endif; ?>
</div>
