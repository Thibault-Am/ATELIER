<?php

namespace appAdmin\auth;


class AdminAuthentification extends \mf\auth\Authentification {

    /*
     * Classe TweeterAuthentification qui définie les méthodes qui dépendent
     * de l'application (liée à la manipulation du modèle User) 
     *
     */

    /* niveaux d'accès de TweeterApp 
     *
     * Le niveau USER correspond a un utilisateur inscrit avec un compte
     * Le niveau ADMIN est un plus haut niveau (non utilisé ici)
     * 
     * Ne pas oublier le niveau NONE un utilisateur non inscrit est hérité 
     * depuis AbstractAuthentification 
     */
    const ACCESS_LEVEL_USER  = 100;
    const ACCESS_LEVEL_ADMIN = 200;
    public function __construct(){
        parent::__construct();
    }


    public function loginUser($username, $password){
        $obj=\appAdmin\model\User::where('Mail' ,'=', $username)->get('Mail');
        if (!$obj->count()){
            $emess = "l'utilisateur $username n'existe pas";

            \mf\router\Router::executeRoute('login');
            throw new \mf\auth\exception\AuthentificationException($emess);
            // return($emess);
        }else{
            $user=\appAdmin\model\User::where('mail' ,'=', $username)->first();
            $this->login($username, $user->Password, $password, $user->level);
            $vue=new \appAdmin\control\AdminController;
            $vue->viewHome();
        }
    }
}