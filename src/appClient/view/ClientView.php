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

        $resultat=$resultat."<a href='".$router->urlFor('panier')."'><img class='panier' src='../../html/img/panier.jpg'/></a>
        <a href='".$router->urlFor('categorie')."'>Catégorie</a> ";

        
       
         
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
                $resultat =$resultat."<article><form action='".$router->urlFor('addPanier')."'><img src='".$produit->Image."'/><div>
                <h2>Produit:</h2><a href='".$router->urlFor('produitpage', ['id_produit'=>$produit->id])."'>".$produit->nom."</a>
                <h2>Producteur:</h2><br/><a href='".$router->urlFor('user', ['id_producteur'=>$nom_producteur->id])."'>".$nom_producteur->Nom."</a></div>";
                $resultat=$resultat."<span><h2>Pix unitaire:</h2>".$produit->tarif_unitaire.".00€ </span><input type='number' required=required  name='quantite' min='0'/><button type='submit' name='id_produit' value='".$produit->id."'> AJOUTER AU PANIER</button></form>"."</article>";
            }
            
        
         $resultat=$resultat."</section>";
         return $resultat;        
         
     }
     private function renderUser(){
        $router = new \mf\router\Router();
        //Affichage des infos du producteur
        $resultat="<section id='Producteur'>
        <article>
        <div>
            <h1>Producteur :</h1>
            <img src='".$this->data->Image."'/>".$this->data->ID_PRODUIT."<h2><a href='".$router->urlFor('user', ['id_producteur'=>$this->data->id])."'>".$this->data->Nom."</a></h2>
        </div>
        <div><h1>Description</h1>".$this->data->Description.
        
        "</div>";
    
       


        //Affichage produits producteur
           $produits=\appClient\model\Production::where('ID_PRODUCTEUR',"=",$this->data->id)->get();  //recherche du bon id dans la table pivot
        
        foreach($produits as $id_produit){  
            
            $produit=\appClient\model\Produits::where('id',"=",$id_produit->ID_PRODUIT)->first();  //recherche dans la table produit

            $resultat=
            $resultat."<div><h2><a href='".$router->urlFor('produitpage', ['id_produit'=>$produit->id])."'>$produit->nom :</a></h2>
            <img src='".$produit->Image."'/>
            <h3>$produit->tarif_unitaire €</h3></div>";
            
            
        }
                $resultat=$resultat."</article></section>";
        
        return $resultat;
        
     }





     private function renderproduitpage(){
        $router = new \mf\router\Router();
        //Affichage des infos du producteur
        $resultat="<section id='Produitpage'>
        <article>
        <div>
            <span>
            <h1>Test :</h1>
            <img src='".$this->data->Image."'/><h2><a href='".$router->urlFor('produitpage', ['id_produit'=>$this->data->id])."'>".$this->data->nom."</a></h2>
            </span>
            <div><div><h1>Description </h1>".$this->data->description."</div>
            <form action='".$router->urlFor('addPanier')."'>
            <label for='quantite'>Quantité :</label>
            <input type='number' name='quantite' required min='0'/>
            
            <button type='submit' name='id_produit' value='".$this->data->id."'>Ajouter au panier</button></form></div>".

        "</div>";
    
       


        //Affichage produits producteur
           $produits=\appClient\model\Production::where('ID_PRODUIT',"=",$this->data->id)->get();  //recherche du bon id dans la table pivot
        
           foreach($produits as $id_produit){  
                $producteur=\appClient\model\User::where('id',"=",$id_produit->ID_PRODUCTEUR)->first();  //recherche dans la table produit

                $resultat=
                $resultat."<div><h2><a href='".$router->urlFor('user', ['id_producteur'=>$producteur->id])."'>$producteur->Nom :</a></h2>
                <img src='".$producteur->Image."'/>'
            
                <h6>Description :</h6><h4>$producteur->Description</h4></div>";
                
           }
        
            $resultat=$resultat."</article></section>";
            
        return $resultat;
     }







     private function renderPanier(){
        $router = new \mf\router\Router();
        $resultat="<section id='panier'>";
        $montant_cumul = 0;
        foreach($_SESSION['panier'] as $tab_produit){
            foreach($tab_produit as $id_produit=>$quantite){
                $produit=\appClient\model\Produits::where('id',"=",$id_produit)->first();
                
                $id_producteur=\appClient\model\Production::where('ID_PRODUIT',"=",$produit->id)->first();
                $producteur=\appClient\model\User::where('id',"=",$id_producteur->ID_PRODUCTEUR)->first();
                $resultat=$resultat."<div id='listPanier'><span><img src='".$produit->Image."'/></span>
                <span><h1>Produit :</h1><h2>".$produit->nom."</h2></span>
                <span><h1>Quantité :</h1><h2><form action='".$router->urlFor('updateQuantite')."'><input type='number' value='".$quantite."' min='0' name='quantite'/></br>
                <label for='id_produit'>Identifiant du produit</label>
                <input type='text' readonly value='".$produit->id."' min='0' name='id_produit'/>
                <button type='submit'>Mettre à jour la quantité</button></form></h2></span>
                <span><h1>Tarif pour $quantite lot(s) ".$produit->nom."(s) :</h1><h2>".$produit->tarif_unitaire*$quantite.".00€</h2></span>
                <span><h1>Producteur :</h1><h2>$producteur->Nom</h2></span>
                
                </div>";
                $montant_cumul=$montant_cumul+($produit->tarif_unitaire*$quantite);
            }
        }
        $resultat=$resultat."<div id='valid'><form action='".$router->urlFor('validationPanier')."'>
        <h1>VALIDATION DE LA COMANDE</h1></br>
        <input type='text' required=required name='nom' placeholder='Nom'/>
        <input type='text' required=required name='mail' placeholder='Mail'/>
        <input type='text' required=required name='tel' placeholder='Tel'/>
        <label for='montant'>Montant Total :</label>
        <input type='text' required=required name='montant' readonly value='".$montant_cumul."'/> ";
       $resultat=$resultat."<button type='submit'>Valider mon panier</button>
       </form></br><a href='".$router->urlFor('annulationPanier')."' >Annuler mon panier</a></div></section>";

        return $resultat;
     }

    public function renderannulationPanier(){
        $router = new \mf\router\Router();
        unset($_SESSION['panier']);
        header("Location: ".$router->urlFor('categorie'));
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
        if($selector == 'annulationPanier'){
            $section = $this->renderannulationPanier();
        }
        if($selector == 'produitpage'){
            $section = $this->renderproduitpage();
        }
        return "<header>${header}</header><section>${section}</section><footer>${footer}</footer>";
    }

    








    
}

