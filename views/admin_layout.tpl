<?php require_once 'admin_head.tpl'; ?>

<aside id="sidebar">

	<?php self::add_widget('menu_admin'); ?>	

</aside>	

<section id="admincontent">
	
	<?php require_once $content; ?> 


</section>

	



	

<?php  require_once 'admin_footer.tpl'; ?>    