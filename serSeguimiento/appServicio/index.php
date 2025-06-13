<?php



// Kickstart the framework
//equire_once 'vendor/autoload.php';
require_once("middleware/Auth.php");
$f3 = require('lib/base.php');


$f3->set('DEBUG', 1);

if ((float)PCRE_VERSION < 8.0)

	trigger_error('PCRE version is out of date');



// Load configuration
$f3->set('CORS.origin', '*');

$f3->config('config.ini');

$f3->config('routes.ini');




$f3->set(

	'DB',

	new \DB\SQL('mysql:host=' . $f3->get('database.host')  . ';port=3306;dbname=' . $f3->get('database.dbname'), $f3->get('database.user'), $f3->get('database.pass')),

	$options = array(

		\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, // generic attribute

		\PDO::ATTR_PERSISTENT => TRUE,  // we want to use persistent connections

		\PDO::MYSQL_ATTR_COMPRESS => TRUE, // MySQL-specific attribute

	)

);



$f3->route('POST /ValidaUser', '_Dav_Ctrol->ValidaUser');
$f3->route('POST /davprocedure', '_Dav_Ctrol->davprocedure');
$f3->route('POST /Cambiarpassword', '_Dav_Ctrol->Cambiarpassword');
$f3->route('POST /Creapassword', '_Dav_Ctrol->Creapassword');
// $f3->route('GET /getproducto/@id', 'Productos_Ctrl->getProducto');

// $f3->route('POST /delproducto/@id', 'Productos_Ctrl->delProducto');

// $f3->route('POST /listado', 'Productos_Ctrl->listado');



 $f3->route('GET /fecha', function ($f3) {
	echo "<pre>";
	print_r(date("Y-m-d H:i:s"));
	echo "</pre>";
});





$f3->route('GET /api/prueba', function ($f3) {

	// echo "<pre>";

	// print_r($f3->get('DB'));

	// echo "</pre>";

	//echo json_encode('hola david todo ok');
	$usuario  = 'eduardo';
	$password = '123456';

	$token =Auth::SignIn([
		'id' => 1,
		'name' => 'Eduardo'
	]);
	echo $token;
	print_r(Auth::GetData($token));
});









// $f3->route('GET /prueba-1', function ($f3) {



// 	echo "<pre>";

// 	print_r($f3->get('POST'));

// 	print_r($f3->get('GET'));

// 	print_r($f3->get('REQUEST'));

// 	print_r($f3->get('SERVER'));

// 	 print_r($_SERVER);

// 	echo "</pre>";

// });







$f3->route(

	'GET /',

	function ($f3) {

		$classes = array(

			'Base' =>

			array(

				'hash',

				'json',

				'session',

				'mbstring'

			),

			'Cache' =>

			array(

				'apc',

				'apcu',

				'memcache',

				'memcached',

				'redis',

				'wincache',

				'xcache'

			),

			'DB\SQL' =>

			array(

				'pdo',

				'pdo_dblib',

				'pdo_mssql',

				'pdo_mysql',

				'pdo_odbc',

				'pdo_pgsql',

				'pdo_sqlite',

				'pdo_sqlsrv'

			),

			'DB\Jig' =>

			array('json'),

			'DB\Mongo' =>

			array(

				'json',

				'mongo'

			),

			'Auth' =>

			array('ldap', 'pdo'),

			'Bcrypt' =>

			array(

				'openssl'

			),

			'Image' =>

			array('gd'),

			'Lexicon' =>

			array('iconv'),

			'SMTP' =>

			array('openssl'),

			'Web' =>

			array('curl', 'openssl', 'simplexml'),

			'Web\Geo' =>

			array('geoip', 'json'),

			'Web\OpenID' =>

			array('json', 'simplexml'),

			'Web\OAuth2' =>

			array('json'),

			'Web\Pingback' =>

			array('dom', 'xmlrpc'),

			'CLI\WS' =>

			array('pcntl')

		);

		$f3->set('classes', $classes);

		$f3->set('content', 'welcome.htm');

		echo View::instance()->render('layout.htm');
	}

);



$f3->route(

	'GET /userref',

	function ($f3) {

		$f3->set('content', 'userref.htm');

		echo View::instance()->render('layout.htm');
	}

);

// Ruta para la subida de la imagen
$f3->route('POST /upload', function() {
  // Verificar que se haya enviado el archivo con el campo 'image'
  if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
      header('Content-Type: application/json');
      echo json_encode(['error' => 'No se recibió ningún archivo o hubo un error al subirlo.']);
      return;
  }

  // Datos del archivo
  $file = $_FILES['image'];

  // Validación: permitir solo archivos con extensión .jpg
  $allowed_extensions = ['jpg'];
  $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  if (!in_array($file_extension, $allowed_extensions)) {
      header('Content-Type: application/json');
      echo json_encode(['error' => 'Solo se permiten archivos con extensión .jpg']);
      return;
  }

  // Validar el tamaño del archivo: máximo 2 MB (2 * 1024 * 1024 bytes)
  $maxSize = 2 * 1024 * 1024; // 2 MB en bytes
  if ($file['size'] > $maxSize) {
      header('Content-Type: application/json');
      echo json_encode(['error' => 'El archivo supera el tamaño máximo permitido de 2 MB.']);
      return;
  }

  // Directorio de destino (asegúrate de que exista y tenga permisos de escritura)
  $targetDir = 'img/';
  if (!is_dir($targetDir)) {
      mkdir($targetDir, 0777, true);
  }

  // Generar un nombre único para el archivo (puedes personalizarlo)
  $targetFile = $targetDir . time() . '-' . basename($file['name']);

  // Mover el archivo subido a la carpeta destino
  if (move_uploaded_file($file['tmp_name'], $targetFile)) {
      header('Content-Type: application/json');
      echo json_encode([
          'message' => 'Archivo subido correctamente',
          'file'    => $targetFile
      ]);
  } else {
      header('Content-Type: application/json');
      echo json_encode(['error' => 'Error al mover el archivo.']);
  }
});

$f3->route('GET /image/@filename', function($f3, $params) {
  $targetDir = 'img/';  // Carpeta donde se guardan las imágenes
  $file = $targetDir . basename($params['filename']);

  // Verificar si el archivo existe
  if (!file_exists($file)) {
      header('Content-Type: application/json');
      echo json_encode(['error' => 'Imagen no encontrada']);
      return;
  }

  // Obtener el tipo MIME del archivo
  $mimeType = mime_content_type($file);
  header('Content-Type: ' . $mimeType);
  readfile($file);
});

$f3->run();
