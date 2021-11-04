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
        $router = new \mf\router\Router();  
        $resultat="<h1>LeHangar.local</h1>";
        if (!empty($_SESSION['client_name'])){
            $resultat=$resultat."<a href='".$router->urlFor('panier')."'><img src='../../html/img/panier.jpg'/></a> ";
        }else{
            $resultat=$resultat."<a href='".$router->urlFor('panier',['nom_client'=>$_SESSION['client_name']])."'><img src='../../html/img/panier.jpg'/></a> ";
        }
         
        return $resultat;
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
                $resultat =$resultat."<article><a href=".$router->urlFor('produits', ['id_categorie'=>$cat->id])."><img src='$cat->Image'/><div class=\"centered\">".$cat->Nom."</div></a></article>";
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
                $id_producteur=\appClient\model\Production::where('ID_PRODUIT',"=",$produit->id)->first();
        
                $nom_producteur=\appClient\model\User::where('id',"=",$id_producteur->ID_PRODUCTEUR)->first();
                $resultat =$resultat."<article><form action='".$router->urlFor('addPanier', ['id_produit'=>$produit->id])."'><img src='".$produit->Image."'/><div><a>".$produit->nom."</a><br/>".$nom_producteur->Nom."</div>";
                $resultat=$resultat."<span>".$produit->tarif_unitaire.".00€ </span><input type='number' min='0'/><button type='submit'> AJOUTER AU PANIER</button></form>"."</article>";
            }
            
         
         $resultat=$resultat."</section>";
         return $resultat;        
         
     }
     private function renderUser(){
        $router = new \mf\router\Router();
        //Affichage des infos du producteur
        $resultat="<article><h1>Producteur</h1><div>".$this->data->Nom.
        "<img src=".$this->data->image."/>".$this->data->ID_PRODUIT.
        "</article><h1>Description</h1>".$this->data->Description."</div><br>";
    
       


        //Affichage produits producteur
           $produits=\appClient\model\Production::where('ID_PRODUCTEUR',"=",$this->data->id)->get();  //recherche du bon id dans la table pivot
        
        foreach($produits as $id_produit){  
            
            $produit=\appClient\model\Produits::where('id',"=",$id_produit->ID_PRODUIT)->first();  //recherche dans la table produit
            $resultat="<section id='produitsProducteur'><h1>$produit->nom</h1><img src='".$produit->Image."'/></section>";
            
            
        }

        return $resultat;
     }
     private function renderPanier(){
        $router = new \mf\router\Router();
         if ($_SESSION['client_name']==null){
            $resultat="<form action='".$router->urlFor('setClient')."'>
            <label for='name'>Votre nom:</label><input name='name' type='text'/>
            <label for='mail'>Votre mail:</label><input name='mail' type='text'/>
            <label for='tel'>Votre Tel:</label><input name 'tel' type='text'/>
            <button type='submit'>Créer mon panier</button></form>";
         }else{
            $resultat=$_SESSION['client_name'];
         }
        
        
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
        }if($selector == 'Panier'){
            $section = $this->renderPanier();
        }
        return "<header>${header}</header><section>${section}</section><footer>${footer}</footer>";
    }

    









    
}

