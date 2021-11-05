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
        $user = \appClient\model\User::where('id',"=",$_GET['id_producteur']);
        $lignes=$user->first();
        $vues = new \appClient\view\ClientView($lignes);
        return $vues->render('User');
       
    }

    public function viewproduitpage(){ 
        //retourne les infos de la table user
        $produit = \appClient\model\Produits::where('id',"=",$_GET['id_produit']);
        $lignes=$produit->first();
        $vues = new \appClient\view\ClientView($lignes);
        return $vues->render('produitpage');
    }

    public function viewPanier(){
       
        $this->setPanier();
        //print_r($_SESSION['panier']);
        $vues = new \appClient\view\ClientView(null);
        return $vues->render('Panier');
        
        
        
    }
    public function setPanier(){
        if(empty($_SESSION['panier'])){
            $_SESSION['panier']=[];
        }else{
            $_SESSION['panier']=$_SESSION['panier'];
        }
       
    }
    public function addPanier($id_produit=null,$quantite=null){
            $this->setPanier();
            if($id_produit==null && $quantite==null){
                $id_produit=$_GET['id_produit'];
                $quantite=$_GET['quantite'];
            }
            array_push($_SESSION['panier'],[$id_produit=>$quantite]);
            $router = new \mf\router\Router();
            header("Location: ".$router->urlFor('panier'));
        
    }

    public function validationPanier(){
            $nom=$_GET['nom'];
            $montant=$_GET['montant'];
            $mail=$_GET['mail'];
            $tel=$_GET['tel'];
            $commande = new \appClient\model\Commande;
            $commande->Nom_client=$nom;
            $commande->Mail_client=$mail;
            $commande->Tel_client=$tel;
            $commande->Etat="en_cours";
            $commande->Montant=$montant;
            $commande->save();
            $les_commandes = \appClient\model\Commande::orderBy('id','desc');
            $la_commande=$les_commandes->first();
            
            foreach($_SESSION['panier'] as $tab_produit){
                foreach($tab_produit as $id_produit=>$quant){
                    $quantite = new \appClient\model\Quantite;
                    $quantite->PRODUIT_ID=$id_produit;
                    $quantite->COMMANDE_ID=$la_commande->id;
                    $quantite->Quantite=$quant;
                    $quantite->save();
                }
            }
     
            unset($_SESSION['panier']);
            $router = new \mf\router\Router();
            header("Location: ".$router->urlFor('categorie'));
            
    }
    public function annulationPanier(){

        $vues = new \appClient\view\ClientView(null);
        return $vues->render('annulationPanier');
    }
    public function updateQuantite(){
        $produits=$_GET['id_produit'];
        $quantite=$_GET['quantite'];
        $lignes=0;
        while ($lignes<count($_SESSION['panier'])){


                foreach($_SESSION['panier'][$lignes] as $session_produit=>$session_quantite){
                    if($session_produit==$produits){
                        $arrayReplace=array($produits=>$quantite);
                        $_SESSION['panier'][$lignes]=$arrayReplace;
                        $this->viewPanier();
                        
                    }
                }
            
            
            //print_r($_SESSION['panier'][$lignes]);
            $lignes=$lignes+1;
        }
       /* foreach($_SESSION['panier'][$produits] as $session_produit=>$session_quantite){

            if($session_produit==$produits){
                print_r($_SESSION['panier'][$lignes]);
                unset($_SESSION['panier'][$lignes][$produits]);
            }
            $lignes=$lignes+1;
        }*/

        /*if($quantite>0){
            $this->addPanier( $produits, $quantite);
        }else{
            $this->viewPanier();
        }*/
        
    }
}
