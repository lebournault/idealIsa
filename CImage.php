<?php

require_once('CBdd.php');

class CImage
{
    private $img_id;
    private $id_contenu;
    private $img_nom;
    private $img_taille;
    private $img_type;
    private $img_desc;
    private $img_blob;

    /* constructeur 
        arguments acceptés : aucun ou $id_img
    */
    public function __construct()
    {

        $nb = func_num_args();
        $args = func_get_args();
        $init = "constructeur$nb"; // méthode de construction appelée an fonction du nombre d'arguments

        if (method_exists(__CLASS__, $init)) {
            $this->$init($args);
        } else {
            echo "nombre d'arguments incorrects (0 ou id_img acceptés)";
        }
    }

    /* constructeur sans paramètres */
    private function constructeur0($args)
    {
    }

    /* constructeur avec $im_img comme paramètre */
    /*initialise tous les attributs à partir de la BDD grâce à id_img */
    /* @arg = id_img */
    private function constructeur1($args)
    {
        $this->img_id = $args[0];

        $cnx = new CBdd();

        $requete = "SELECT 'id_contenu', img_nom, 'img_taille', `img_type`, 'img_desc', `img_blob` FROM `images` WHERE img_id = ?";
        $row = $cnx->lireEnregistrementParId($requete, $this->img_id);

        if ($row == null) {
            echo "image inconnue";
        } else {
            $this->id_contenu = $row["id_contenu"];
            $this->im_nom = $row["img_nom"];
            $this->img_taille = $row["img_taille"];
            $this->img_type = $row["img_type"];
            $this->img_desc = $row["img_desc"];
            $this->img_blob = $row["img_blob"];
            
        }
    }

    
    /* lire l'image au format Jpg, png, etc.*/
    /* @return = image au format jpg, png, etc en fonction du type d'image */
    public function lire()
    {
        //convert a blob into an image file
        $image = imagecreatefromstring($this->img_blob);

        ob_start(); //You could also just output the $image via header() and bypass this buffer capture.
        if ($this->img_type == "image/jpeg" || $this->img_type  == "image/jpg") {
            imagejpeg($image, null, 80);
        }
        $data = ob_get_contents();
        ob_end_clean();

        $image = "data:" . $this->img_type  . ";base64," .  base64_encode($data);
        //echo '<img src="' . $image  . '" width="40%"/>';
        return $image;
    }


    /* supprimer l'image de la BDD*/
    public function supprimer()
    {
        // on supprime l'image à partir de id_img
        $cnx = new CBdd();

        $requete = "DELETE FROM `images` WHERE img_id = ?";
        if (!$cnx->supprimerUnEnregistrementParId($requete, $this->img_id)){
            echo "Impossible de supprimer l'image " . $this->img_id;
            return false;
        }

        return true;
    }


    /**
     * Get the value of img_id
     */
    public function getImg_id()
    {
        return $this->img_id;
    }

    /**
     * Set the value of img_id
     *
     * @return  self
     */
    public function setImg_id($img_id)
    {
        $this->img_id = $img_id;

        return $this;
    }
}
