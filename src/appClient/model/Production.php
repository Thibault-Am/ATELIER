<?php
namespace appClient\model;

class Production extends \Illuminate\Database\Eloquent\Model {

    protected $table      = 'production';  /* le nom de la table */   
    public    $timestamps = false;    /* si vrai la table doit contenir
                                     les deux colonnes updated_at,
                                     created_at */
}
?>