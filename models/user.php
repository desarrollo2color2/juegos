<?php

	namespace model;

	require_once PATH.'models/delegado.php';

	use \app\Db as db;
	use \model\DelegadoModel as d;

	Class UserModel extends db {



		protected static $table_name = 'usuarios';




		public static function authenticate_user($username="", $password="")
		{	// Método que valida el username y la clave de un usuario
		     // Traer el objeto $db_obj al método
			/*echo "<script language = JavaScript> alert (' 1 Clase user \\n Método authenticate_user(\$usuario = {$username}, clave = {$password}) \\n y pasa al método query_prepary()')</script>";*/

			// Crear un alert para verificar la infomación antes de redirigir al usuario
			/*echo "<script language = JavaScript> alert (' 2 Clase user \\n Método authenticate_user() \\n RETORNOS DE query_prepary \\n \$usuario = {$username} \\n \$clave = {$password}')</script>";*/
			$query = "SELECT * FROM ".static::$table_name." WHERE nombre_usuario = '{$username}' AND pass = '{$password}'";

			$users_array = static::__query($query);



			if($users_array) :

				$user =  $users_array;

				unset($user[0]['pass']);
				$_SESSION['user'] = $user[0];

				return $user;

				else :

				return false;	

			endif;	

		
			
		} 	// Fin del método authenticate_user()

		public static function insert_delegado($array)
		{
			return d::save($array);
		}

		public static function delete_delegado($id)
		{
			return d::delete_($id);
		}

		public static function get_delegado($array)
		{
			return d::find_by_attr($array);
		}

		public static function update_delegado($array , $where)
		{

			return d::update($array, $where);
		}

		public static function dashboard()
		{


			if($_SESSION['user']['tipo'] != 'admin') :

				$more = ' AND usuarios.tipo != "delegado" AND usuarios.escuela="'.$_SESSION['user']['escuela'].'"';

				else :

				$more = '';

			endif;



			$query = 'SELECT usuarios.tipo, usuarios.escuela, delegados.nombre_completo, delegados.foto, delegados.modalidad,
			delegados.tipo_doc, delegados.num_doc, delegados.cod_militar, delegados.edad, delegados.rh, delegados.telefono, delegados.fecha_nacimiento,
			delegados.lugar_nacimiento, delegados.alergico_a
			FROM '.static::$table_name.' 
			INNER JOIN delegados ON delegados.id_usuario = usuarios.id WHERE usuarios.tipo !="admin"  '.$more.'  ';

			

			return parent::__query($query);


		}

	}

?>