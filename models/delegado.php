<?php

	namespace model;

	require_once PATH.'vendor/db.php';

	use \app\Db as db;


	Class DelegadoModel extends db {

		protected static $table_name = 'delegados';

		public static function delete_($id) {

				$query = "DELETE FROM " . static::$table_name . " WHERE id_usuario =" . $id . " ";

				$db = parent::__connect();

				$result = $db->query($query);

				$db->close();

				return $result;
		}

	}

?>