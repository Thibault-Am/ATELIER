<?php
namespace appClient\model;
use appClient\model\Produits;

class User extends \Illuminate\Database\Eloquent\Model {

    protected $table      = 'user';  /* le nom de la table */
    protected $primaryKey = 'id';     /* le nom de la clé primaire */
    public    $timestamps = false;    /* si vrai la table doit contenir
                                     les deux colonnes updated_at,
                                     created_at */

    public function ProducteurProduits(){
    return $this->belongsToMany('\appClient\model\Produits', 'production', 'ID_PRODUCTEUR', 'ID_PRODUIT');

           /* 'Clubs'          : le nom de la classe du model lié */
       /* 'usagers_clubs ' : le nom de la table pivot */

       /* 'usagers_id'     : la clé étrangère de ce modèle dans la table pivot */
       /* 'club_id'        : la clé étrangère du modèle lié dans la table pivot */


    }
}
?>