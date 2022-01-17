<?php
require_once('CBdd.php');
require_once('CMagazine.php');

class CCollectionMagazines {
    private $collection;

    public function __construct()
    {
        $cnx = new CBdd();
        $requete = 'SELECT id_mag FROM magazine';
        $result = $cnx->lireTousLesEnregistrements($requete);
        
        $tab_magazines = array();
        foreach($result as $magazine) {
           $tab_magazines[]= new CMagazine($magazine[0]);
        }
        
        $this->collection = $tab_magazines;
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