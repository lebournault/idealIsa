<?php
require_once('CBdd.php');
require_once('CImage.php');

class CCollectionImages {
    private $collection;

    public function __construct()
    {
        $cnx = new CBdd();
        $requete = 'SELECT img_id FROM image';
        $result = $cnx->lireTousLesEnregistrements($requete);
        
        $tab_images = array();
        foreach($result as $image) {
           $tab_images[]= new CImage($image[0]);
        }
        
        $this->collection = $tab_images;
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