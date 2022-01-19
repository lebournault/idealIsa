<?php
require_once('CBdd.php');
require_once('CImage.php');

class CCollectionImages
{
    private $collection;

    public function __construct()
    {
        $this->chargerTable();
    }


    public function supprimerImage($id)
    {
        $img = new CImage($id);
        if (!$img->supprimer()) {
            echo "Suppression de l'image impossible <br>";
            return false;
        }
        $this->chargerTable();
        return true;
    }

    public function ajouterImage($image, $description)
    {
        $img = new CImage();
        if (!$img->inserer($image, $description)) {
            echo "Insertion de l'image impossible <br>";
            return false;
        }
        $this->chargerTable();
        return true;
    }

    public function modifierImage($id, $nom, $description)
    {
        $img = new CImage($id);
        $img->setImg_nom($nom);
        $img->setImg_desc($description);

        if (!$img->modifier()) {
            echo "Modification de l'image impossible <br>";
            return false;
        }
        $this->chargerTable();
        return true;
    }

    private function chargerTable()
    {
        $cnx = new CBdd();
        $requete = 'SELECT id_img FROM image';
        $result = $cnx->lireTousLesEnregistrements($requete);

        $tab_images = array();
        foreach ($result as $image) {
            $tab_images[] = new CImage($image[0]);
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
