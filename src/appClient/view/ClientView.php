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
       $resultat="<section class='categorie'>";
       $router = new \mf\router\Router();  
            //var_dump($categorie);
            foreach($this->data as $cat){
                $resultat =$resultat."<article><a href=".$router->urlFor('produits', ['id_categorie'=>$cat->id]).">".$cat->Nom."</a></article>";
            }
           
        
        $resultat=$resultat."</section>";
        return $resultat;        
        
    }

    private function renderProduit(){
        $id_categorie=$_GET['id_categorie'];
        $categorie=\appClient\model\Categorie::where('id',"=",$id_categorie)->first();
        $resultat="<section class='produit'> <h1>$categorie->Nom</h1>";
        $router = new \mf\router\Router();  
             //var_dump($categorie);
             foreach($this->data as $produit){
                $resultat =$resultat."<article><img><a>".$produit->nom."</a></article>";
            }
            
         
         $resultat=$resultat."</section>";
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
        }
        return "<header>${header}</header><section>${section}</section><footer>${footer}</footer>";
    }

    









    
}
