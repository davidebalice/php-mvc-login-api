<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
$config = include '../app/config/config.php';
$conn = require_once '../app/database.php';
require_once '../app/auth.php';
require_once '../app/Models/Product.php';
require_once '../app/Controllers/ProductController.php';
require_once '../app/Controllers/AuthController.php';
require_once '../app/routes.php';

use App\Controllers\ProductController;
use Auth;

$auth = new Auth($conn, $config['jwt_secret']);
$controller = new ProductController($conn, $auth);






handleRequest($controller);
