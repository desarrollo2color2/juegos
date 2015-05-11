

<div class="admin">

<h1 class="title"><i class="fa fa-user"></i>Usuario</h1>

<form id="add_winner" action="<?php echo URL; ?>admin/insert_winner" method="POST" enctype="multipart/form-data">

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Escuelas</label>
				<select  id="escuela" class="form-control" name="escuela" required>
					<option value="" selected="" disabled="">Selecciona una escuela</option>
					
					
					<option value="ejercito">Escuela Militar de Suboficiales "Sargento Inocencio Chinca"</option>
					<option value="naval">Escuela Naval de Suboficiales "ARC Barranquilla"</option>
					<option value="marina">Escuela de Formación de Infanteria de Marina</option>
					<option value="aerea"> Escuela de Suboficiales de la Fuerza Aérea "Andrés M. Diaz"</option>
					<option value="ejecutivo">Escuela de Suboficiales y Nivel Ejecutivo "Gonzalo Jiménez de Quesada"</option>	

				
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group" id="delegado">
				<label>Deportistas</label>
				<div></div>
			</div>
		</div>
	</div>				
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Modalidades</label>
				<select style="height:inherit;" name="modalidad" class="form-control" onchange="get_comp(this)" required>
				<option value="" selected="" disabled="">Selecciona una modalidad</option>
				<?php 

					foreach($params['modalidades'] as $k => $v) :
						if(is_array($v)) :
							echo  ' <optgroup label="'.$k.'">';
								foreach($v as $k1 => $v1) :
									if(!is_array($v1)):
										echo  '<option value="'.$v1.'">'.$v1.'</option>';
									else :
										echo  ' <optgroup label="'.$k1.'">';
										foreach($v1 as $v2) :
											echo  '<option value="'.$v2.'">'.$v2.'</option>';	
										endforeach;
										echo '</optgroup>';
									endif;
								endforeach;
						  	echo '</optgroup>';
						else :
							echo '<option value="'.$k.'">'.$v.'</option>';
						endif;
					endforeach;
				?>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group" id="competencias">
				<label>Competencias</label>
				<div></div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label>Medalla</label>
				<input name="medalla" class="form-control" placeholder="Medalla o Posicion" type="number" min="1" required />			
			</div>
		</div>
	</div>


	<div class="form_group">
		<input type="submit" value="Enviar" disabled />

	</div>
</form>
</div>

<script type="text/javascript">
	
	function get_del(nip){
    	var value = $(nip).val();

    	
    }

    function get_comp(nip){
    	var value = $(nip).val();
    	var nop   = $('#escuela').val();

    

    	if(nop.length > 1) {
    		$.ajax({
				url: '<?php echo URL; ?>ajax_dele',
				cache: false,
				type: 'POST',
				data: {escuela: nop, competencia : value},
				success: function(html){
				$('#delegado div').html(html);
				}
			});

			$.ajax({
				url: '<?php echo URL; ?>ajax_comp_',
				cache: false,
				type: 'POST',
				data: {value: value},
				success: function(html){
				$('#competencias div').html(html);
				}
			});	

			$('#add_winner input[type="submit"]').removeAttr('disabled');

    	} 
    	else {
    		alert('Debe seleccionar una escuela');
    	}
    	


    	
    }


</script>