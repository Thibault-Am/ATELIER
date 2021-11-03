<?php

namespace appAdmin\control;

class AdminController extends \mf\control\AbstractController {


    /* Constructeur :
     * 
     * Appelle le constructeur parent
     *
     * c.f. la classe \mf\control\AbstractController
     * 
     */
    
    public function __construct(){
        parent::__construct();
        
    }


    /* Méthode viewHome : 
     * 
     * Réalise la fonctionnalité : afficher la liste des catalogue
     * 
     */
    
    public function viewHome(){

        $categorie = \appClient\model\Categorie::select();
        $lignes = $categorie->get(); 
        $vues = new \appClient\view\ClientView($lignes);
        return $vues->render('Home');
        }

    public function viewLogin(){
        $vue= new \appAdmin\view\AdminView(null);
        return $vue->render('Login');
    }

    public function checkLogin(){
        // echo "test";
        $username=$_POST['user_name'];
        $mdp=$_POST['password'];
        $auth=new \appAdmin\auth\AdminAuthentification;
        // echo $username;
        $auth->loginUser($username, $mdp);

        //Vérification incorrect
        //header("Location: ".$router->urlFor('login'));
    }
}
