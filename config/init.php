<?php

/*
|--------------------------------------------------------------------------
| Configuracion General
|--------------------------------------------------------------------------
|
|
 */

ini_set('display_errors', true);
error_reporting(E_ALL); 

define('URL', 'http://juegosinterescuelas.com/');
define('PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
// LOCAL variable que define si el sitio esta local o en linea, si esta en linea el valor debe ser null sino debe ser /sitio/
define('LOCAL', null);
define('SITENAME', '.::EMSUB 2015::.');
define('ERROR', true);
define('DATABASE', true);
define('DBNAME', 'juegosi1_db');
define('HOST', 'localhost');
define('USER', 'juegosi1_usu');
define('PASSWORD','aXi;ns9eqF)@');
define('SESSION', true);
define('LANG', 'es');



?>