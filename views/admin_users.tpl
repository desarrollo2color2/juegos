<div class="admin">

<h1 class="title"><i class="fa fa-book"></i> Usuarios</h1>

<a class="add_button" href="<?php echo URL; ?>admin/add_user"><i class="fa fa-plus"></i> Añadir usuario</a>


<?php if($params) : ?>

	<div class="results"></div>
	
	<div class="table-responsive">

	<table class="table table-striped">
			
		<thead>
				
			<tr>
				
				<th>Nombre usuario</th>
				<th>Tipo</th>
			
				<th></th>
				<th></th>	

			</tr>	


		</thead>	

		<tbody>
			
			<?php  foreach($params as $user) : ?>

				<tr>
						
					<td><?php echo $user['nombre_usuario']; ?></td>
					<td><?php echo $user['tipo']; ?></td>
		
					<td><a class="edit" href="<?php echo URL.'admin/update_user/id/'.$user['id']; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
					<?php if($_SESSION['user']['tipo'] == 'admin') : ?>	
					<td><a class="delete_user delete" href="<?php echo $user['id']; ?>"><i class="fa fa-trash"></i></a></td>
				<?php endif; ?>
				</tr>

			<?php endforeach; ?>

		</tbody>


	</table>

	</div>

<?php endif; ?>

<script type="text/javascript">
	
	$('.delete_user').click(function(e){

		e.preventDefault();

		var id = $(this).attr('href');
		$(this).parent().parent().remove();

		$.ajax({
			
			url: "<?php echo URL.'admin/delete_user'; ?>",
			cache: false,
			type: 'POST',
			data: {id: id},		
			success: function(html){
			$(".results").fadeIn(100, 'fold').html(html);
			}
			}); 

		});
	

</script>
</div>