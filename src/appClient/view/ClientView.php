<?php

namespace appClient\view;

class ClientView extends \mf\view\AbstractView {
  
    /* Constructeur 
    *
    * Appelle le constructeur de la classe parent
    */
    public function __construct( $data ){
        parent::__construct($data);
    }

    /* Méthode renderHeader
     *
     *  Retourne le fragment HTML de l'entête (unique pour toutes les vues)
     */ 
    public function renderHeader(){
       
        
        return "<h1>LeHangar</h1> ";
        
    }
    
    /* Méthode renderFooter
     *
     * Retourne le fragment HTML du bas de la page (unique pour toutes les vues)
     */
    public function renderFooter(){
        return 'L\'application a été créée en Licence Pro &copy;2021';
    }

    /* Méthode renderHome
     *
     * Vue de la fonctionalité afficher tous les Tweets. 
     *  
     */
    
    private function renderCategorie(){
       $resultat="<section id='categorie'>";
       $router = new \mf\router\Router();

            foreach($this->data as $cat){
                $resultat =$resultat."<article><img src='$cat->Image'/><a href=".$router->urlFor('produits', ['id_categorie'=>$cat->id]).">".$cat->Nom."</a></article>";
            }
           
        
        $resultat=$resultat."</section>";
        return $resultat;        
        
    }

    private function renderProduit(){
        $id_categorie=$_GET['id_categorie'];
        $categorie=\appClient\model\Categorie::where('id',"=",$id_categorie)->first();
        $resultat="<section id='produit'> <h1>$categorie->Nom</h1>";
        
        $router = new \mf\router\Router();  
             //var_dump($categorie);
             foreach($this->data as $produit){
               // $id_producteur=\appClient\model\Production::where('ID_PRODUIT',"=",$produit->id)->first();
               $id_producteur=1;
                $nom_producteur=\appClient\model\User::where('id',"=",$id_producteur/*->ID_PRODUCTEUR*/)->first();
                $resultat =$resultat."<article><img src=".$produit->Image."/><div><a>".$produit->nom."</a><br/>".$nom_producteur->Nom."</div>";
                $resultat=$resultat."<span>".$produit->tarif_unitaire.".00€ </span><input type='number'/><button type='submit'> AJOUTER AU PANIER</button>"."</article>";
            }
            
         
         $resultat=$resultat."</section>";
         return $resultat;        
         
     }


     private function renderUser(){
        $router = new \mf\router\Router();
        $resultat="<div>".$user->Nom."</div>";
        $resultat=$resultat."test"."</div>";
        return $resultat;
     }
    
    public function renderBody($selector){

        /*
         * voire la classe AbstractView
         * 
         */
        $header = $this->renderHeader();
        $footer = $this->renderFooter();
        if($selector == 'Categorie'){
            $section = $this->renderCategorie();
        }if($selector == 'Produit'){
            $section = $this->renderProduit();
        }if($selector == 'User'){
            $section = $this->renderUser();
        }
        return "<header>${header}</header><section>${section}</section><footer>${footer}</footer>";
    }


    









    
}
