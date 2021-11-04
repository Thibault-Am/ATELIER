<?php

namespace appAdmin\model;

class Commandes extends xtends \Illuminate\Database\Eloquent\Model {
    protected $table      = 'commande';  /* le nom de la table */
    protected $primaryKey = 'id';     /* le nom de la clé primaire */
    public    $timestamps = false;    /* si vrai la table doit contenir
                                     les deux colonnes updated_at,
                                     created_at */
}