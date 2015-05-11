<?php

	namespace model;

	require_once PATH.'models/user.php';

	use \app\Db as db;
	use \model\UserModel as d;

	Class WinnerModel extends db {



		protected static $table_name = 'ganadores';



	}

?>