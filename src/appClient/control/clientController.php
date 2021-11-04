<?php

namespace appClient\control;

class clientController extends \mf\control\AbstractController {


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
    
    public function viewCategorie(){

        $categorie = \appClient\model\Categorie::select();
        $lignes = $categorie->get(); 
        $vues = new \appClient\view\ClientView($lignes);
        return $vues->render('Categorie');
        }

    public function viewProduit(){
        $id_categorie=$_GET['id_categorie'];
        $produits = \appClient\model\Produits::where('ID_categorie',"=",$id_categorie);
        $lignes = $produits->get(); 
        $vues = new \appClient\view\ClientView($lignes);
        return $vues->render('Produit');
    }

    public function viewUser(){ 
        //retourne les infos de la table user
        $user = \appClient\model\User::where('id',"=",1);
        $lignes=$user->first();
        $vues = new \appClient\view\ClientView($lignes);
        return $vues->render('User');

        //Jonction des tables user et produit grace a la table production
        $produits = User::where('id' ,'=', 1);          //Selection du producteur avec l'id "1"
        $var=$produits->ProducteurProduits()->get();    //On recupere ses produits
        return $var->render('User');


        
    }
}