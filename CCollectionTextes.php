<?php
require_once('CBdd.php');
require_once('CTexte.php');

class CCollectionTextes {
    private $collection;

    public function __construct()
    {
        $cnx = new CBdd();
        $requete = 'SELECT id_txt FROM texte';
        $result = $cnx->lireTousLesEnregistrements($requete);
        
        $tab_textes = array();
        foreach($result as $texte) {
           $tab_textes[]= new CTexte($texte[0]);
        }
        
        $this->collection = $tab_textes;
    }

    /**
     * Get the value of collection
     */ 
    public function getCollection()
    {
        return $this->collection;
    }
}
?>