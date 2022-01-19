<?php
require_once('CBdd.php');
require_once('CMagazine.php');

class CCollectionMagazines
{
    private $collection;

    public function __construct()
    {
       $this->chargerTable();
    }


    public function ajouterMagazine($nom_mag, $nb_pages)
    {
        $mag = new CMagazine();
        if (!$mag->inserer($nom_mag, $nb_pages)) {
            echo "Insertion du magazine impossible <br>";
            return false;
        }
        $this->chargerTable();
        return true;
    }


    public function modifierMagazine($id_mag, $nom_mag, $nb_pages)
    {
        $mag = new CMagazine($id_mag);
        $mag->setNom_mag($nom_mag);
        $mag->setNb_pages($nb_pages);

        if (!$mag->modifier()) {
            echo "Modification du magazine impossible <br>";
            return false;
        }
        $this->chargerTable();
        return true;
    }


    public function supprimerMagazine($id_mag)
    {
        $mag = new CMagazine($id_mag);
        if (!$mag->supprimer()) {
            echo "Suppression du magazine impossible <br>";
            return false;
        }
        $this->chargerTable();
        return true;
    }


    private function chargerTable()
    {
        $cnx = new CBdd();
        $requete = 'SELECT id_mag FROM magazine';
        $result = $cnx->lireTousLesEnregistrements($requete);

        $tab_magazines = array();
        foreach ($result as $magazine) {
            $tab_magazines[] = new CMagazine($magazine[0]);
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
