<?php
session_start();
ini_set("display_errors", 1);

require_once 'vendor/autoload.php';
require_once 'src/mf/utils/AbstractClassLoader.php';
require_once 'src/mf/utils/ClassLoader.php';

$config = parse_ini_file("conf/config.ini");

/* une instance de connexion  */
$db = new \Illuminate\Database\Capsule\Manager();

$db->addConnection( $config ); /* configuration avec nos paramètres */
$db->setAsGlobal();            /* rendre la connexion visible dans tout le projet */
$db->bootEloquent();           /* établir la connexion */
use \appClient\model\Categorie;
use \appClient\model\Produits;

$loader = new \mf\utils\ClassLoader('src');
$loader->register();
mf\view\AbstractView::addStyleSheet('html/style.css');
$router = new \mf\router\Router();

////////////////////////////application client///////////////////////////////////

$router->addRoute('categorie','/categorie/','\appClient\control\clientController','viewCategorie');
$router->addRoute('produits','/produits/','\appClient\control\clientController','viewProduit');
$router->addRoute('login','/login/','\appAdmin\control\AdminController','viewLogin');
$router->addRoute('checklogin',
    '/checklogin/',
    '\appAdmin\control\AdminController',
    'checkLogin');
$router->addRoute('checklogin',
    '/checklogin/',
    '\appAdmin\control\AdminController',
    'checkLogin');
$router->addRoute('logout',
    '/logout/',
    '\appAdmin\control\AdminController',
    'log_out');
$router->run();
