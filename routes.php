<?php



return array(

	''                       => array('view' => 'home:layout', 'perm' => array('admin', 'delegado', 'deportista', 'asistente', 'entrenador')),
	'404'                    => array('view' => '404:no_layout'),
	'acceso_denegado'        => array('view' => 'perm:layout'),
	'admin'                  => array('controller' => 'dashboard:user', 'perm' => array('admin', 'delegado', 'entrenador', 'asistente')),
	// User urls
	'login_form'             => array('view'       => 'login:layout'),
	'login'                  => array('controller' => 'login:user'),
	'logout'                 => array('controller' => 'logout:user'),
	'admin/users'            => array('controller' => 'all_users:user', 'perm' => array('admin', 'delegado')),
	'admin/add_user'         => array('view'       => 'admin_user:admin_layout', 'perm' => array('admin', 'delegado')),
	'admin/insert_user'      => array('controller' => 'insert_user:user',    'perm' => array('admin', 'delegado')),
	'admin/update_user/$1'   => array('controller' => 'update_user:user',    'perm' => array('admin', 'delegado')),
	'admin/delete_user'      => array('controller' => 'delete_user:user',    'perm' => array('admin')),
	'admin/update_by_user'   => array('controller' => 'update_by_user:user', 'perm' => array('admin', 'delegado')),
	'olvido'                 => array('view'       => 'forgot:layout'),
	'forgot'                 => array('controller' => 'forgot:user'),
	'form_dele'              => array('controller' => 'form_dele:user',  'perm' => array('admin', 'delegado')),
	'ajax_search'            => array('controller' => 'search:user',     'perm' => array('admin', 'delegado','entrenador', 'asistente')),
	'ajax_comp'              => array('controller' => 'get_comp:user',    'perm' => array('admin', 'delegado','entrenador', 'asistente')),
	'ajax_comp_'             => array('controller' => 'ajax_com_:winner',  'perm' => array('admin')),

	'admin/winners'            => array('controller'  => 'all_winners:winner', 'perm' => array('admin', 'delegado')),
	'admin/add_winner'         => array('controller'  => 'winner_form:winner', 'perm' => array('admin')),
	'admin/insert_winner'      => array('controller'  => 'insert_winner:winner',  'perm' => array('admin')),
	'admin_winners/$1'         => array('controller'  => 'mod_winners:winner', 'perm' => array('admin', 'delegado')),
	'admin_escuelas'           => array('view'        => 'admin_escuela:admin_layout', 'perm' => array('admin', 'delegado')),
	'admin_winners_/$1'        => array('controller'  => 'mod_winners_escuelas:winner', 'perm' => array('admin', 'delegado')),
	'ajax_dele'                => array('controller' => 'ajax_dele:winner', 'perm' => array('admin', 'delegado')),
	'fil_comp'                 => array('controller' => 'fil_comp:winner', 'perm' => array('admin', 'delegado')),
	

	
	

);

?>