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

$router->addRoute('categorie',
    '/categorie/',
    '\appClient\control\clientController',
    'viewCategorie',
    \appClient\auth\ClientAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('produits',
    '/produits/',
    '\appClient\control\clientController',
    'viewProduit',
    \appClient\auth\ClientAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('user',
    '/user/',
    '\appClient\control\clientController',
    'viewUser',
    \appClient\auth\ClientAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('panier',
    '/panier/',
    '\appClient\control\clientController',
    'viewPanier',
    \appClient\auth\ClientAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('setClient',
    '/setClient/',
    '\appClient\control\clientController',
    'setClient',
    \appClient\auth\ClientAuthentification::ACCESS_LEVEL_NONE);
$router->setDefaultRoute('/categorie/');
$router->run();
