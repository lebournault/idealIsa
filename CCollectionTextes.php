<?php
require_once('CBdd.php');
require_once('CTexte.php');

class CCollectionTextes {
    private $collection;

    public function __construct()
    {
        $this->chargerTable();
    }


    public function supprimerTexte($id_txt)
{
   $txt = new CTexte($id_txt);
   if (!$txt->supprimer()){
      echo "Suppression du texte impossible <br>";
      return false;
   }
   $this->chargerTable();
   return true;
   
}


public function ajouterTexte($texte, $titre){
   
   $txt = new CTexte();
   if (!$txt->inserer($titre, $texte)){
      echo "Insertion du texte impossible <br>";
      return false;
   }
   $this->chargerTable();
   return true;

}


public function modifierTexte($id_txt, $titre, $texte)
{
   $txt = new CTexte($id_txt);
   $txt->settitre($titre);
   $txt->setTexte($texte);

   if (!$txt->modifier()){
      echo "Modification du texte impossible <br>";
      return false;
   }
   $this->chargerTable();
   return true;

}

private function chargerTable()
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
